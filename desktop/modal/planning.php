<?php
	$eqLogic = eqLogic::byId($_GET['id']);
	// recuperation des informations
	$PH = json_decode($eqLogic->getCmd('info','IPH')->getCache()['value']);
?>
<div id="Palazzetti_PH">
<div>
    <legend style="height: 40px;">
        <span class="objectName"></span>
        	<?php echo ($PH->CHRSTATUS == 0) ? '<a class="btn btn-info" id="Palazzetti_ph_onoff" title="Activer/désactiver">INACTIF</a>':'<a class="btn btn-success" id="Palazzetti_ph_onoff" title="Activer/désactiver">ACTIF</a>';  ?>
    </legend>
</div>

<table class="table table-condensed tablesorter" id="table_Palazzetti_ph">
	<thead>
		<tr><td colspan="4" style="background-color:#444">CONFIGURATION DE LA SEMAINE</td></tr>
		<tr>
			<th>{{Jour}}</th>
			<th>{{Programme 1}}</th>
			<th>{{Programme 2}}</th>
			<th>{{Programme 3}}</th>
		</tr>
	</thead>
	<tbody>
	 <?php
	 	$OPTION = '';
	 	for($d = 1; $d < 8; $d++) {
	 		echo '<tr><td>'.Palazzetti::getWeekDay($d).'</td>';
	 		echo '<td><select data-jour="'.$d.'" data-programme="1"><option value="0">OFF</option>';
		 	for($i = 1; $i < 7; $i++) {
		 			echo '<option value="'.$i.'" '.(($PH->{'D'.$d}->{'M1'} == 'P'.$i) ? ' selected':'' ).'>T'.$i.'</option>';
		 	}
	 		echo '</select></td>';
	 		echo '<td><select data-jour="'.$d.'" data-programme="2"><option value="0">OFF</option>';
		 	for($i = 1; $i < 7; $i++) {
		 			echo '<option value="'.$i.'" '.(($PH->{'D'.$d}->{'M2'} == 'P'.$i) ? ' selected':'' ).'>T'.$i.'</option>';
		 	}
	 		echo '</select></td>';
	 		echo '<td><select data-jour="'.$d.'" data-programme="3"><option value="0">OFF</option>';
		 	for($i = 1; $i < 7; $i++) {
		 			echo '<option value="'.$i.'" '.(($PH->{'D'.$d}->{'M3'} == 'P'.$i) ? ' selected':'' ).'>T'.$i.'</option>';
		 	}
	 		echo '</select></td>';
	 		echo '</tr>';
	 	}
?>
	</tbody>
</table>

<table class="table table-condensed tablesorter" id="table_Palazzetti_tranche">
	<thead>
		<tr><td colspan="4" style="background-color:#444">CONFIGURATION DES TRANCHES</td></tr>
		<tr>
			<th>{{Numéro tranche}}</th>
			<th>{{Début tranche}}</th>
			<th>{{Fin tranche}}</th>
			<th>{{Température tranche}}</th>
		</tr>
	</thead>
	<tbody>
	 <?php

	 	for($i = 1; $i < 7; $i++) {
	 		echo '<tr data-numero="'.$i.'"><td>Tranche '.$i.'</td>';
	 		echo '<td><input class="form-control input-sm" data-type="start" value="'.$PH->{'P'.$i}->{'START'}.'" /></td>';
	 		echo '<td><input class="form-control input-sm" data-type="end" value="'.$PH->{'P'.$i}->{'STOP'}.'" /></td>';
	 		echo '<td><input type="text" data-type="temperature" value="'.$PH->{'P'.$i}->{'CHRSETP'}.'" />°C</td>';
	 		echo '</tr>';
	 	}
?>
	</tbody>
</table>

</div>
<?php
	// recuperation des commandes
	$PHToggleID		= $eqLogic->getCmd('action','WPH')->getId();
	$PHDayID 		= $eqLogic->getCmd('action','WPHtoDay')->getId();
	$PHTrancheID 	= $eqLogic->getCmd('action','WPHtranche')->getId();
	$PHRefresh		= $eqLogic->getCmd('action','RPH')->getId();
?>
<script>
		// nettoyage multiples ouvertures
		$("#Palazzetti_PH").find("*").off();
 		$("#table_Palazzetti_tranche input[data-type='start'], #table_Palazzetti_tranche input[data-type='end']").datetimepicker({
 			timepicker:true,
 			datepicker:false,
 			format:'H:i',
 			step:05,
 			theme:'dark'
 		});
 		// activation / desactivation
 		$('#Palazzetti_ph_onoff').on('click',function() {
			if($(this).text() == 'ACTIF') {
				jeedom.cmd.execute({id: <?php echo $PHToggleID; ?>, value: 0});
				$(this).removeClass('btn-success').addClass('btn-info');
				$(this).text('INACTIF');
			} else if($(this).text() == 'INACTIF') {
				jeedom.cmd.execute({id: <?php echo $PHToggleID; ?>, value: 1});
				$(this).removeClass('btn-info').addClass('btn-success');
				$(this).text('ACTIF');
			}
 			setTimeout(jeedom.cmd.execute({id: <?php echo $PHRefresh; ?>}), 1500);
 		});
 		// enregistrement des tranches
		$('#table_Palazzetti_ph select').on('change',function() {
			var J = $(this).data("jour");
			var T = $(this).data("programme");
			var P = $(this).find('option:selected').val();
			jeedom.cmd.execute({id: <?php echo $PHDayID; ?>, value :{jour: J, tranche: T, programme: P}});
			setTimeout(jeedom.cmd.execute({id: <?php echo $PHRefresh; ?>}), 1500);
		});	
 			

 		// enregistement du planning
 		$('#table_Palazzetti_tranche input').on('change',function() {
 			var tr = $(this).parent().parent();
 			var numero 		= tr.data("numero");
 			var temperature = tr.find("td input[data-type='temperature']").val(); 
 			var start = tr.find("td input[data-type='start']").val().split(':');
 			var end = tr.find("td input[data-type='end']").val().split(':');
			jeedom.cmd.execute({id: <?php echo $PHTrancheID; ?>, value :{numero: numero, temperature: temperature, h1: parseInt(start[0]), m1: parseInt(start[1]), h2: parseInt(end[0]), m2: parseInt(end[1])}});
			setTimeout(jeedom.cmd.execute({id: <?php echo $PHRefresh; ?>}), 1500);
 		});
</script>