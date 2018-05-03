<table class="table table-condensed tablesorter" id="table_Palazzetti_info">
	<thead>
		<tr>
			<th>{{Nom}}</th>
			<th>{{Valeur}}</th>
		</tr>
	</thead>
	<tbody>
<?php

	$eqLogic = eqLogic::byId($_GET['id']);

	echo '<tr><td colspan="2" style="background-color:#555">Equipement '.$eqLogic->getName().'</td></tr>';

	$value = json_decode($eqLogic->getCmd('info','ITime')->getCache()['value']);
	echo '<tr><td>Heure du poêle</td><td>'. $value->STOVE_DATETIME.'</td></tr>';
	echo '<tr><td>Jour de la semaine</td><td>'. Palazzetti::getWeekDay($value->STOVE_WDAY).'</td></tr>';

	$value = $eqLogic->getCmd('info','IConsigne');
	echo '<tr><td>Température de consigne</td><td>'. $value->getCache()['value'].' °C</td></tr>';

	$value = $eqLogic->getCmd('info','ITemp');
	echo '<tr><td>Température ambiance</td><td>'. $value->getCache()['value'].' °C</td></tr>';

	$value = $eqLogic->getCmd('info','IFan');
	echo '<tr><td>Force ventilateur</td><td>'. Palazzetti::getFanState($value->getCache()['value']).'</td></tr>';

	$value = $eqLogic->getCmd('info','IPower');
	echo '<tr><td>Force du feu</td><td>'. $value->getCache()['value'].'</td></tr>';

	$value = $eqLogic->getCmd('info','IStatus');
	echo '<tr><td>Etat poêle</td><td>'.  Palazzetti::getStoveState($value->getCache()['value']).'</td></tr>';

	$value = $eqLogic->getCmd('info','INbAllumage');
	echo '<tr><td>Nombre d\'allumages</td><td>';
	if($value) { echo $value->getCache()['value']; }
	echo '</td></tr>';

	$value = $eqLogic->getCmd('info','IHeuresAlimElec');
	echo '<tr><td>Nombre d\'heures alimentation électrique</td><td>';
	if($value) { echo $value->getCache()['value']; }
	echo '</td></tr>';

	$value = $eqLogic->getCmd('info','IHeuresChauffe');
	echo '<tr><td>Nombre d\'heures de chauffe</td><td>';
	if($value) { echo $value->getCache()['value']; }
	echo '</td></tr>';

	$value = $eqLogic->getCmd('info','IHeuresSurChauffe');
	echo '<tr><td>Nombre d\'heures de surchauffe</td><td>';
	if($value) { echo $value->getCache()['value']; }
	echo '</td></tr>';

	$value = $eqLogic->getCmd('info','IHeuresDepuisEntretien');
	echo '<tr><td>Nombre d\'heures depuis entretien</td><td>';
	if($value) { echo $value->getCache()['value']; }
	echo '</td></tr>';

	$value = $eqLogic->getCmd('info','INbAllumageFailed');
	echo '<tr><td>Nombre d\'allumages échoués</td><td>';
	if($value) { echo $value->getCache()['value']; }
	echo '</td></tr>';

	$value = json_decode($eqLogic->getCmd('info','ISnap')->getCache()['value']);
	echo '<tr><td>Quantité pellets consommés (unité ?)</td><td>';
	if($value) { echo $value->PELLET_QTUSED; }
	echo '</td></tr>';

	// NETWORK
	$value = json_decode($eqLogic->getCmd('info','INetwork')->getCache()['value']);

	echo '<tr><td colspan="2" style="background-color:#444">Connection box</td></tr>';
	echo '<tr><td>Version plzbridge</td><td>'. $value->{'Gateway Version'}->plzbridge.'</td></tr>';
	echo '<tr><td>Version "sendmsg"</td><td>'. $value->{'Gateway Version'}->sendmsg.'</td></tr>';
	echo '<tr><td>Version SYSTEM</td><td>'. $value->{'Gateway Version'}->SYSTEM.'</td></tr>';	

	echo '<tr><td colspan="2" style="background-color:#333">Local ethernet</td></tr>';
	echo '<tr><td>Serveur DNS</td><td>'. $value->{'DNS Data'}->DNS_ADDR.'</td></tr>';
	echo '<tr><td>Adresse IP</td><td>'. $value->{'ETH0 Data'}->ETH0_ADDR.'</td></tr>';
	echo '<tr><td>Broadcast</td><td>'. $value->{'ETH0 Data'}->ETH0_BCAST.'</td></tr>';	
	echo '<tr><td>Masque sous-réseau</td><td>'. $value->{'ETH0 Data'}->ETH0_MASK.'</td></tr>';
	echo '<tr><td>Adresse mac</td><td>'. $value->{'ETH0 Data'}->ETH0_MAC.'</td></tr>';
	echo '<tr><td>Mode</td><td>'. $value->{'ETH0 Data'}->ETH0_PROTO.'</td></tr>';	
	echo '<tr><td>Passerelle</td><td>'. $value->{'ETH0 Data'}->ETH0_GW.'</td></tr>';	

	echo '<tr><td colspan="2" style="background-color:#333">Local wifi</td></tr>';	
	echo '<tr><td>Adresse IP</td><td>'. $value->{'WLAN0 Data'}->WLAN0_ADDR.'</td></tr>';
	echo '<tr><td>Broadcast</td><td>'. $value->{'WLAN0 Data'}->WLAN0_BCAST.'</td></tr>';
	echo '<tr><td>Masque sous-réseau</td><td>'. $value->{'WLAN0 Data'}->WLAN0_MASK.'</td></tr>';	
	echo '<tr><td>Adresse mac</td><td>'. $value->{'WLAN0 Data'}->WLAN0_MAC.'</td></tr>';
	echo '<tr><td>Mode</td><td>'. $value->{'WLAN0 Data'}->WLAN0_PROTO.'</td></tr>';
	echo '<tr><td>Passerelle</td><td>'. $value->{'WLAN0 Data'}->WLAN0_GW.'</td></tr>';	
	echo '<tr><td>Mode wifi</td><td>'. $value->{'WLAN0 Data'}->WLAN0_MODE.'</td></tr>';
	echo '<tr><td>Canal</td><td>'. $value->{'WLAN0 Data'}->WLAN0_CH.'</td></tr>';	
	echo '<tr><td>SSID</td><td>'. $value->{'WLAN0 Data'}->WLAN0_SSID.'</td></tr>';
	echo '<tr><td>Type de cryptage</td><td>'. $value->{'WLAN0 Data'}->WLAN0_ENC.'</td></tr>';
	
?>
	</tbody>
</table>


