<?php
/* 
 */
/* * ***************************Includes********************************* */
require_once dirname(__FILE__) . '/../../../../core/php/core.inc.php';

class Palazzetti extends eqLogic {

	// tache automatique 15 minutes
    public static function cron15() {
		foreach (eqLogic::byType('Palazzetti') as $Palazzetti) {
			$Palazzetti->getInformations();
			$mc = cache::byKey('PalazzettiWidgetmobile' . $Palazzetti->getId());
			$mc->remove();
			$mc = cache::byKey('PalazzettiWidgetdashboard' . $Palazzetti->getId());
			$mc->remove();
			$Palazzetti->toHtml('mobile');
			$Palazzetti->toHtml('dashboard');
			$Palazzetti->refreshWidget();

			// mise à jour horloge 
			$date = date("Y-m-d H:i:s");
			$DATA = $Palazzetti->makeRequest($cmdString) ;
		}
	}


	// apres creation equipement
	public function postInsert () {

		// ********* TIME DE L'EQUIPEMENT
		// heure du poêle
		$PalazzettiCmd = $this->getCmd(null, 'Time');
		if (!is_object($PalazzettiCmd)) {
			$PalazzettiCmd = new PalazzettiCmd();
		}
			$PalazzettiCmd->setName(__('Time', __FILE__));
			$PalazzettiCmd->setEqLogic_id($this->getId());
			$PalazzettiCmd->setLogicalId('ITime');
			$PalazzettiCmd->setType('info');
			$PalazzettiCmd->setSubType('string');
			$PalazzettiCmd->setIsVisible(1);
			$PalazzettiCmd->save();

		// lecture nom du poêle
		$PalazzettiCmd = $this->getCmd(null, 'RTime');
		if (!is_object($PalazzettiCmd)) {
			$PalazzettiCmd = new PalazzettiCmd();
		}
			$PalazzettiCmd->setName(__('Lire horodatage', __FILE__));
			$PalazzettiCmd->setConfiguration('actionCmd','GET+TIME');
			$PalazzettiCmd->setConfiguration('updateLogicalId','ITime');
			$PalazzettiCmd->setEqLogic_id($this->getId());
			$PalazzettiCmd->setLogicalId('RTime');
			$PalazzettiCmd->setType('action');
			$PalazzettiCmd->setSubType('other');
			$PalazzettiCmd->setIsVisible(0);
			$PalazzettiCmd->save();	

		// ********* RESUME INFORMATIONS DU POELE
		// snap informations poele
		$PalazzettiCmd = $this->getCmd(null, 'Snap');
		if (!is_object($PalazzettiCmd)) {
			$PalazzettiCmd = new PalazzettiCmd();
		}
			$PalazzettiCmd->setName(__('Informations', __FILE__));
			$PalazzettiCmd->setEqLogic_id($this->getId());
			$PalazzettiCmd->setLogicalId('ISnap');
			$PalazzettiCmd->setType('info');
			$PalazzettiCmd->setSubType('string');
			$PalazzettiCmd->setIsVisible(0);
			$PalazzettiCmd->save();

		// ********* RESUME INFORMATIONS RESEAU
		// snap informations reseau
		$PalazzettiCmd = $this->getCmd(null, 'Network');
		if (!is_object($PalazzettiCmd)) {
			$PalazzettiCmd = new PalazzettiCmd();
		}
			$PalazzettiCmd->setName(__('Réseau', __FILE__));
			$PalazzettiCmd->setEqLogic_id($this->getId());
			$PalazzettiCmd->setLogicalId('INetwork');
			$PalazzettiCmd->setType('info');
			$PalazzettiCmd->setSubType('string');
			$PalazzettiCmd->setIsVisible(0);
			$PalazzettiCmd->save();

		// ********* ETAT DE MARCHE / STATUS
		// on poêle
		$PalazzettiCmd = $this->getCmd(null, 'WOn');
		if (!is_object($PalazzettiCmd)) {
			$PalazzettiCmd = new PalazzettiCmd();
		}
			$PalazzettiCmd->setName(__('Allumage poêle', __FILE__));
			$PalazzettiCmd->setConfiguration('actionCmd','CMD+ON');
			$PalazzettiCmd->setConfiguration('updateLogicalId','IStatus');
			$PalazzettiCmd->setEqLogic_id($this->getId());
			$PalazzettiCmd->setLogicalId('WOn');
			$PalazzettiCmd->setType('action');
			$PalazzettiCmd->setSubType('other');
			$PalazzettiCmd->setIsVisible(1);
			$PalazzettiCmd->save();

		// off poêle
		$PalazzettiCmd = $this->getCmd(null, 'WOff');
		if (!is_object($PalazzettiCmd)) {
			$PalazzettiCmd = new PalazzettiCmd();
		}
			$PalazzettiCmd->setName(__('Extinction poêle', __FILE__));
			$PalazzettiCmd->setConfiguration('actionCmd','CMD+OFF');
			$PalazzettiCmd->setConfiguration('updateLogicalId','IStatus');
			$PalazzettiCmd->setEqLogic_id($this->getId());
			$PalazzettiCmd->setLogicalId('WOff');
			$PalazzettiCmd->setType('action');
			$PalazzettiCmd->setSubType('other');
			$PalazzettiCmd->setIsVisible(0);
			$PalazzettiCmd->save();	

		// lecture status poêle
		$PalazzettiCmd = $this->getCmd(null, 'RStatus');
		if (!is_object($PalazzettiCmd)) {
			$PalazzettiCmd = new PalazzettiCmd();
		}
			$PalazzettiCmd->setName(__('Lecture état poêle', __FILE__));
			$PalazzettiCmd->setConfiguration('actionCmd','GET+STAT');
			$PalazzettiCmd->setConfiguration('updateLogicalId','IStatus');
			$PalazzettiCmd->setEqLogic_id($this->getId());
			$PalazzettiCmd->setLogicalId('RStatus');
			$PalazzettiCmd->setType('action');
			$PalazzettiCmd->setSubType('other');
			$PalazzettiCmd->setIsVisible(0);
			$PalazzettiCmd->save();	

		// informations poêle
		$PalazzettiCmd = $this->getCmd(null, 'Status');
		if (!is_object($PalazzettiCmd)) {
			$PalazzettiCmd = new PalazzettiCmd();
		}
			$PalazzettiCmd->setName(__('Etat poêle', __FILE__));
			$PalazzettiCmd->setEqLogic_id($this->getId());
			$PalazzettiCmd->setLogicalId('IStatus');
			$PalazzettiCmd->setType('info');
			$PalazzettiCmd->setSubType('string');
			$PalazzettiCmd->setIsVisible(1);
			$PalazzettiCmd->save();

		// ********* NOM DE L'EQUIPEMENT
		// nom du poêle
		$PalazzettiCmd = $this->getCmd(null, 'Name');
		if (!is_object($PalazzettiCmd)) {
			$PalazzettiCmd = new PalazzettiCmd();
		}
			$PalazzettiCmd->setName(__('Nom', __FILE__));
			$PalazzettiCmd->setEqLogic_id($this->getId());
			$PalazzettiCmd->setLogicalId('IName');
			$PalazzettiCmd->setType('info');
			$PalazzettiCmd->setSubType('string');
			$PalazzettiCmd->setIsVisible(1);
			$PalazzettiCmd->save();

		// ecriture nom du poêle
		$PalazzettiCmd = $this->getCmd(null, 'WName');
		if (!is_object($PalazzettiCmd)) {
			$PalazzettiCmd = new PalazzettiCmd();
		}
			$PalazzettiCmd->setName(__('Ecrire nom', __FILE__));
			$PalazzettiCmd->setConfiguration('actionCmd','SET+LABL+');
			$PalazzettiCmd->setConfiguration('updateLogicalId','IName');
			$PalazzettiCmd->setEqLogic_id($this->getId());
			$PalazzettiCmd->setLogicalId('WName');
			$PalazzettiCmd->setType('action');
			$PalazzettiCmd->setSubType('other');
			$PalazzettiCmd->setIsVisible(1);
			$PalazzettiCmd->save();

		// lecture nom du poêle
		$PalazzettiCmd = $this->getCmd(null, 'RName');
		if (!is_object($PalazzettiCmd)) {
			$PalazzettiCmd = new PalazzettiCmd();
		}
			$PalazzettiCmd->setName(__('Lire nom', __FILE__));
			$PalazzettiCmd->setConfiguration('actionCmd','GET+LABL');
			$PalazzettiCmd->setConfiguration('updateLogicalId','IName');
			$PalazzettiCmd->setEqLogic_id($this->getId());
			$PalazzettiCmd->setLogicalId('RName');
			$PalazzettiCmd->setType('action');
			$PalazzettiCmd->setSubType('other');
			$PalazzettiCmd->setIsVisible(0);
			$PalazzettiCmd->save();		

		// ********* FORCE DU FEU
		// ecriture force du feu
		$PalazzettiCmd = $this->getCmd(null, 'WPower');
		if (!is_object($PalazzettiCmd)) {
			$PalazzettiCmd = new PalazzettiCmd();
		}
			$PalazzettiCmd->setName(__('Ecrire force du feu', __FILE__));
			$PalazzettiCmd->setConfiguration('actionCmd','SET+POWR+');
			$PalazzettiCmd->setConfiguration('updateLogicalId','IPower');
			$PalazzettiCmd->setEqLogic_id($this->getId());
			$PalazzettiCmd->setLogicalId('WPower');
			$PalazzettiCmd->setType('action');
			$PalazzettiCmd->setSubType('other');
			$PalazzettiCmd->setIsVisible(1);
			$PalazzettiCmd->save();

		// informations force du feu
		$PalazzettiCmd = $this->getCmd(null, 'Power');
		if (!is_object($PalazzettiCmd)) {
			$PalazzettiCmd = new PalazzettiCmd();
		}
			$PalazzettiCmd->setName(__('Force du feu', __FILE__));
			$PalazzettiCmd->setEqLogic_id($this->getId());
			$PalazzettiCmd->setLogicalId('IPower');
			$PalazzettiCmd->setType('info');
			$PalazzettiCmd->setSubType('string');
			$PalazzettiCmd->setIsVisible(1);
			$PalazzettiCmd->save();

		// ********* TEMPERATURE CONSIGNE
		// ecriture consigne
		$PalazzettiCmd = $this->getCmd(null, 'WConsigne');
		if (!is_object($PalazzettiCmd)) {
			$PalazzettiCmd = new PalazzettiCmd();
		}
			$PalazzettiCmd->setName(__('Ecrire température de consigne', __FILE__));
			$PalazzettiCmd->setConfiguration('actionCmd','SET+SETP+');
			$PalazzettiCmd->setConfiguration('updateLogicalId','IConsigne');
			$PalazzettiCmd->setEqLogic_id($this->getId());
			$PalazzettiCmd->setLogicalId('WConsigne');
			$PalazzettiCmd->setType('action');
			$PalazzettiCmd->setSubType('other');
			$PalazzettiCmd->setIsVisible(1);
			$PalazzettiCmd->save();

		// lecture consigne
		$PalazzettiCmd = $this->getCmd(null, 'RConsigne');
		if (!is_object($PalazzettiCmd)) {
			$PalazzettiCmd = new PalazzettiCmd();
		}
			$PalazzettiCmd->setName(__('Lire température de consigne', __FILE__));
			$PalazzettiCmd->setConfiguration('actionCmd','GET+SETP');
			$PalazzettiCmd->setConfiguration('updateLogicalId','IConsigne');
			$PalazzettiCmd->setEqLogic_id($this->getId());
			$PalazzettiCmd->setLogicalId('RConsigne');
			$PalazzettiCmd->setType('action');
			$PalazzettiCmd->setSubType('other');
			$PalazzettiCmd->setIsVisible(0);
			$PalazzettiCmd->save();	

		// informations consigne
		$PalazzettiCmd = $this->getCmd(null, 'Consigne');
		if (!is_object($PalazzettiCmd)) {
			$PalazzettiCmd = new PalazzettiCmd();
		}
			$PalazzettiCmd->setName(__('Température de consigne', __FILE__));
			$PalazzettiCmd->setEqLogic_id($this->getId());
			$PalazzettiCmd->setLogicalId('IConsigne');
			$PalazzettiCmd->setType('info');
			$PalazzettiCmd->setUnite('°C');
			$PalazzettiCmd->setSubType('string');
			$PalazzettiCmd->setIsVisible(1);
			$PalazzettiCmd->save();

		// ********* VENTILATEUR
		// ecriture force ventilateur
		$PalazzettiCmd = $this->getCmd(null, 'WFan');
		if (!is_object($PalazzettiCmd)) {
			$PalazzettiCmd = new PalazzettiCmd();
		}
			$PalazzettiCmd->setName(__('Ecriture force ventilateur', __FILE__));
			$PalazzettiCmd->setConfiguration('actionCmd','SET+RFAN+');
			$PalazzettiCmd->setConfiguration('updateLogicalId','IFan');
			$PalazzettiCmd->setEqLogic_id($this->getId());
			$PalazzettiCmd->setLogicalId('WFan');
			$PalazzettiCmd->setType('action');
			$PalazzettiCmd->setSubType('other');
			$PalazzettiCmd->setIsVisible(1);
			$PalazzettiCmd->save();

		// lecture force ventilateur
		$PalazzettiCmd = $this->getCmd(null, 'RFan');
		if (!is_object($PalazzettiCmd)) {
			$PalazzettiCmd = new PalazzettiCmd();
		}
			$PalazzettiCmd->setName(__('Lire force ventilateur', __FILE__));
			$PalazzettiCmd->setConfiguration('actionCmd','GET+FAND');
			$PalazzettiCmd->setConfiguration('updateLogicalId','IFan');
			$PalazzettiCmd->setEqLogic_id($this->getId());
			$PalazzettiCmd->setLogicalId('RFan');
			$PalazzettiCmd->setType('action');
			$PalazzettiCmd->setSubType('other');
			$PalazzettiCmd->setIsVisible(0);
			$PalazzettiCmd->save();	

		// informations force ventilateur
		$PalazzettiCmd = $this->getCmd(null, 'Fan');
		if (!is_object($PalazzettiCmd)) {
			$PalazzettiCmd = new PalazzettiCmd();
		}
			$PalazzettiCmd->setName(__('Force ventilateur', __FILE__));
			$PalazzettiCmd->setEqLogic_id($this->getId());
			$PalazzettiCmd->setLogicalId('IFan');
			$PalazzettiCmd->setType('info');
			$PalazzettiCmd->setSubType('string');
			$PalazzettiCmd->setIsVisible(1);
			$PalazzettiCmd->save();

		// ********* TEMPERATURES
		// lecture températures
		$PalazzettiCmd = $this->getCmd(null, 'RTemp');
		if (!is_object($PalazzettiCmd)) {
			$PalazzettiCmd = new PalazzettiCmd();
		}
			$PalazzettiCmd->setName(__('Lire température ambiance', __FILE__));
			$PalazzettiCmd->setConfiguration('actionCmd','GET+TMPS');
			$PalazzettiCmd->setConfiguration('updateLogicalId','ITemp');
			$PalazzettiCmd->setEqLogic_id($this->getId());
			$PalazzettiCmd->setLogicalId('RTemp');
			$PalazzettiCmd->setType('action');
			$PalazzettiCmd->setSubType('other');
			$PalazzettiCmd->setIsVisible(0);
			$PalazzettiCmd->save();	

		// informations températures
		$PalazzettiCmd = $this->getCmd(null, 'Temp');
		if (!is_object($PalazzettiCmd)) {
			$PalazzettiCmd = new PalazzettiCmd();
		}
			$PalazzettiCmd->setName(__('Température ambiance', __FILE__));
			$PalazzettiCmd->setEqLogic_id($this->getId());
			$PalazzettiCmd->setLogicalId('ITemp');
			$PalazzettiCmd->setType('info');
			$PalazzettiCmd->setUnite('°C');
			$PalazzettiCmd->setSubType('numeric');
			$PalazzettiCmd->setIsVisible(1);
			$PalazzettiCmd->setIsHistorized(1);
			$PalazzettiCmd->save();

		// ********* PROGRAMMES HORAIRES
		// PH on/off
		$PalazzettiCmd = $this->getCmd(null, 'WPH');
		if (!is_object($PalazzettiCmd)) {
			$PalazzettiCmd = new PalazzettiCmd();
		}
			$PalazzettiCmd->setName(__('On/Off Programmes horaires', __FILE__));
			$PalazzettiCmd->setConfiguration('actionCmd','SET+CSST+');
			$PalazzettiCmd->setEqLogic_id($this->getId());
			$PalazzettiCmd->setLogicalId('WPH');
			$PalazzettiCmd->setType('action');
			$PalazzettiCmd->setSubType('other');
			$PalazzettiCmd->setIsVisible(1);
			$PalazzettiCmd->save();

		// lecture tous les PH
		$PalazzettiCmd = $this->getCmd(null, 'RPH');
		if (!is_object($PalazzettiCmd)) {
			$PalazzettiCmd = new PalazzettiCmd();
		}
			$PalazzettiCmd->setName(__('Lecture programmes horaires', __FILE__));
			$PalazzettiCmd->setConfiguration('actionCmd','GET+CHRD');
			$PalazzettiCmd->setConfiguration('updateLogicalId','IPH');
			$PalazzettiCmd->setEqLogic_id($this->getId());
			$PalazzettiCmd->setLogicalId('RPH');
			$PalazzettiCmd->setType('action');
			$PalazzettiCmd->setSubType('other');
			$PalazzettiCmd->setIsVisible(0);
			$PalazzettiCmd->save();	

		// informations PH
		$PalazzettiCmd = $this->getCmd(null, 'IPH');
		if (!is_object($PalazzettiCmd)) {
			$PalazzettiCmd = new PalazzettiCmd();
		}
			$PalazzettiCmd->setName(__('Programmes horaires', __FILE__));
			$PalazzettiCmd->setEqLogic_id($this->getId());
			$PalazzettiCmd->setLogicalId('IPH');
			$PalazzettiCmd->setType('info');
			$PalazzettiCmd->setSubType('string');
			$PalazzettiCmd->setIsVisible(1);
			$PalazzettiCmd->save();

		// Affectation programme
		$PalazzettiCmd = $this->getCmd(null, 'WPHtoDay');
		if (!is_object($PalazzettiCmd)) {
			$PalazzettiCmd = new PalazzettiCmd();
		}
			$PalazzettiCmd->setName(__('Affectation programme horaire', __FILE__));
			$PalazzettiCmd->setConfiguration('actionCmd','SET+CDAY+');
			$PalazzettiCmd->setEqLogic_id($this->getId());
			$PalazzettiCmd->setLogicalId('WPHtoDay');
			$PalazzettiCmd->setType('action');
			$PalazzettiCmd->setSubType('other');
			$PalazzettiCmd->setIsVisible(1);
			$PalazzettiCmd->save();

		// Configuration tranche horaire
		$PalazzettiCmd = $this->getCmd(null, 'WPHtranche');
		if (!is_object($PalazzettiCmd)) {
			$PalazzettiCmd = new PalazzettiCmd();
		}
			$PalazzettiCmd->setName(__('Configuration tranche horaire', __FILE__));
			$PalazzettiCmd->setConfiguration('actionCmd','SET+CPRD+');
			$PalazzettiCmd->setEqLogic_id($this->getId());
			$PalazzettiCmd->setLogicalId('WPHtranche');
			$PalazzettiCmd->setType('action');
			$PalazzettiCmd->setSubType('other');
			$PalazzettiCmd->setIsVisible(1);
			$PalazzettiCmd->save();

		// Information utilisation
		$PalazzettiCmd = $this->getCmd(null, 'RNbAllumage');
		if (!is_object($PalazzettiCmd)) {
			$PalazzettiCmd = new PalazzettiCmd();
		}
			$PalazzettiCmd->setName(__('Lecture nombre d\'allumages', __FILE__));
			$PalazzettiCmd->setConfiguration('actionCmd','EXT+ADRD+2066+1');
			$PalazzettiCmd->setConfiguration('updateLogicalId','INbAllumage');
			$PalazzettiCmd->setEqLogic_id($this->getId());
			$PalazzettiCmd->setLogicalId('RNbAllumage');
			$PalazzettiCmd->setType('action');
			$PalazzettiCmd->setSubType('other');
			$PalazzettiCmd->setIsVisible(1);
			$PalazzettiCmd->save();

		$PalazzettiCmd = $this->getCmd(null, 'INbAllumage');
		if (!is_object($PalazzettiCmd)) {
			$PalazzettiCmd = new PalazzettiCmd();
		}
			$PalazzettiCmd->setName(__('Nombre d\'allumages', __FILE__));
			$PalazzettiCmd->setEqLogic_id($this->getId());
			$PalazzettiCmd->setLogicalId('INbAllumage');
			$PalazzettiCmd->setType('info');
			$PalazzettiCmd->setSubType('string');
			$PalazzettiCmd->setIsVisible(1);
			$PalazzettiCmd->save();

		// Information utilisation
		$PalazzettiCmd = $this->getCmd(null, 'RNbAllumageFailed');
		if (!is_object($PalazzettiCmd)) {
			$PalazzettiCmd = new PalazzettiCmd();
		}
			$PalazzettiCmd->setName(__('Lecture nombre d\'allumages échoués', __FILE__));
			$PalazzettiCmd->setConfiguration('actionCmd','EXT+ADRD+207C+1');
			$PalazzettiCmd->setConfiguration('updateLogicalId','INbAllumageFailed');
			$PalazzettiCmd->setEqLogic_id($this->getId());
			$PalazzettiCmd->setLogicalId('RNbAllumageFailed');
			$PalazzettiCmd->setType('action');
			$PalazzettiCmd->setSubType('other');
			$PalazzettiCmd->setIsVisible(1);
			$PalazzettiCmd->save();

		$PalazzettiCmd = $this->getCmd(null, 'INbAllumageFailed');
		if (!is_object($PalazzettiCmd)) {
			$PalazzettiCmd = new PalazzettiCmd();
		}
			$PalazzettiCmd->setName(__('Nombre d\'allumages échoués', __FILE__));
			$PalazzettiCmd->setEqLogic_id($this->getId());
			$PalazzettiCmd->setLogicalId('INbAllumageFailed');
			$PalazzettiCmd->setType('info');
			$PalazzettiCmd->setSubType('string');
			$PalazzettiCmd->setIsVisible(1);
			$PalazzettiCmd->save();

		// Information utilisation
		$PalazzettiCmd = $this->getCmd(null, 'RHeuresAlimElec');
		if (!is_object($PalazzettiCmd)) {
			$PalazzettiCmd = new PalazzettiCmd();
		}
			$PalazzettiCmd->setName(__('Lecture heures alimentation électrique', __FILE__));
			$PalazzettiCmd->setConfiguration('actionCmd','EXT+ADRD+206A+1');
			$PalazzettiCmd->setConfiguration('updateLogicalId','IHeuresAlimElec');
			$PalazzettiCmd->setEqLogic_id($this->getId());
			$PalazzettiCmd->setLogicalId('RHeuresAlimElec');
			$PalazzettiCmd->setType('action');
			$PalazzettiCmd->setSubType('other');
			$PalazzettiCmd->setIsVisible(1);
			$PalazzettiCmd->save();

		$PalazzettiCmd = $this->getCmd(null, 'IHeuresAlimElec');
		if (!is_object($PalazzettiCmd)) {
			$PalazzettiCmd = new PalazzettiCmd();
		}
			$PalazzettiCmd->setName(__('Nombre d\'heures alimentation électrique', __FILE__));
			$PalazzettiCmd->setEqLogic_id($this->getId());
			$PalazzettiCmd->setLogicalId('IHeuresAlimElec');
			$PalazzettiCmd->setType('info');
			$PalazzettiCmd->setSubType('string');
			$PalazzettiCmd->setIsVisible(1);
			$PalazzettiCmd->save();

		// information
		/* non identifié, AXT+ADRD+2068+1 */

		// Information utilisation
		$PalazzettiCmd = $this->getCmd(null, 'RHeuresChauffe');
		if (!is_object($PalazzettiCmd)) {
			$PalazzettiCmd = new PalazzettiCmd();
		}
			$PalazzettiCmd->setName(__('Lecture heures de chauffe', __FILE__));
			$PalazzettiCmd->setConfiguration('actionCmd','EXT+ADRD+2070+1');
			$PalazzettiCmd->setConfiguration('updateLogicalId','IHeuresChauffe');
			$PalazzettiCmd->setEqLogic_id($this->getId());
			$PalazzettiCmd->setLogicalId('RHeuresChauffe');
			$PalazzettiCmd->setType('action');
			$PalazzettiCmd->setSubType('other');
			$PalazzettiCmd->setIsVisible(1);
			$PalazzettiCmd->save();

		$PalazzettiCmd = $this->getCmd(null, 'IHeuresChauffe');
		if (!is_object($PalazzettiCmd)) {
			$PalazzettiCmd = new PalazzettiCmd();
		}
			$PalazzettiCmd->setName(__('Nombre d\'heures de chauffe', __FILE__));
			$PalazzettiCmd->setEqLogic_id($this->getId());
			$PalazzettiCmd->setLogicalId('IHeuresChauffe');
			$PalazzettiCmd->setType('info');
			$PalazzettiCmd->setSubType('string');
			$PalazzettiCmd->setIsVisible(1);
			$PalazzettiCmd->save();

		// information
		/* non identifié, AXT+ADRD+206E+1 */

		// Information utilisation
		$PalazzettiCmd = $this->getCmd(null, 'RHeuresSurChauffe');
		if (!is_object($PalazzettiCmd)) {
			$PalazzettiCmd = new PalazzettiCmd();
		}
			$PalazzettiCmd->setName(__('Lecture heures de surchauffe', __FILE__));
			$PalazzettiCmd->setConfiguration('actionCmd','EXT+ADRD+207A+1');
			$PalazzettiCmd->setConfiguration('updateLogicalId','IHeuresSurChauffe');
			$PalazzettiCmd->setEqLogic_id($this->getId());
			$PalazzettiCmd->setLogicalId('RHeuresSurChauffe');
			$PalazzettiCmd->setType('action');
			$PalazzettiCmd->setSubType('other');
			$PalazzettiCmd->setIsVisible(1);
			$PalazzettiCmd->save();

		$PalazzettiCmd = $this->getCmd(null, 'IHeuresSurChauffe');
		if (!is_object($PalazzettiCmd)) {
			$PalazzettiCmd = new PalazzettiCmd();
		}
			$PalazzettiCmd->setName(__('Nombre d\'heures de surchauffe', __FILE__));
			$PalazzettiCmd->setEqLogic_id($this->getId());
			$PalazzettiCmd->setLogicalId('IHeuresSurChauffe');
			$PalazzettiCmd->setType('info');
			$PalazzettiCmd->setSubType('string');
			$PalazzettiCmd->setIsVisible(1);
			$PalazzettiCmd->save();

		// Information utilisation
		$PalazzettiCmd = $this->getCmd(null, 'RHeuresDepuisEntretien');
		if (!is_object($PalazzettiCmd)) {
			$PalazzettiCmd = new PalazzettiCmd();
		}
			$PalazzettiCmd->setName(__('Lecture heures depuis entretien', __FILE__));
			$PalazzettiCmd->setConfiguration('actionCmd','EXT+ADRD+2076+1');
			$PalazzettiCmd->setConfiguration('updateLogicalId','IHeuresDepuisEntretien');
			$PalazzettiCmd->setEqLogic_id($this->getId());
			$PalazzettiCmd->setLogicalId('RHeuresDepuisEntretien');
			$PalazzettiCmd->setType('action');
			$PalazzettiCmd->setSubType('other');
			$PalazzettiCmd->setIsVisible(1);
			$PalazzettiCmd->save();

		$PalazzettiCmd = $this->getCmd(null, 'IHeuresDepuisEntretien');
		if (!is_object($PalazzettiCmd)) {
			$PalazzettiCmd = new PalazzettiCmd();
		}
			$PalazzettiCmd->setName(__('Nombre d\'heures depuis entretien', __FILE__));
			$PalazzettiCmd->setEqLogic_id($this->getId());
			$PalazzettiCmd->setLogicalId('IHeuresDepuisEntretien');
			$PalazzettiCmd->setType('info');
			$PalazzettiCmd->setSubType('string');
			$PalazzettiCmd->setIsVisible(1);
			$PalazzettiCmd->save();

		// parametres
		/* non identifié, jusqu'à 105 GET+PARM+X*/

	}

	public function preUpdate() {
// verification url disponible!!
	}

	public function postUpdate() {
		foreach (eqLogic::byType('Palazzetti') as $Palazzetti) {
			$Palazzetti->getInformations();
		}
	}

	public static $_widgetPossibility = array('custom' => array(
      'visibility' => true,
      'displayName' => true,
      'displayObjectName' => true,
      'optionalParameters' => true,
      'background-color' => true,
      'text-color' => true,
      'border' => true,
      'border-radius' => true,
      'background-opacity' => true,
	));

	// methode requete
	public function makeRequest($cmd) {
		$url = 'http://' . $this->getConfiguration('addressip') . '/sendmsg.php?cmd=' . $cmd;
		log::add('Palazzetti', 'debug','('.__LINE__.') ' . __FUNCTION__.' - '. 'get URL '. $url);
		$request_http = new com_http($url);
		$return = $request_http->exec(5);
		$return = json_decode($return);
		if($return->Info->RSP != 'OK') {
			log::add('Palazzetti', 'error','('.__LINE__.') ' . __FUNCTION__.' - '. ' réponse erreur ' . $cmd);
			return false;
		} else {
			return $return;
		}
	}

	// interpretation valeur ventilateur
	public function getFanState($num) {
		switch($num) {
			case 0:
			case 6:
				$value = 'AUTO';
				break;
			case 7:
				$value = 'OFF';
				break;
			default:
				$value = $num;
		}
		return $value;
	}

	// interpretation valeur status poele
	public function getStoveState($num) {
		$lib[0] = 'OFF';
		$lib[1] = 'OFF TIMER';
		$lib[2] = 'TESTFIRE';
		$lib[3] = 'HEATUP';
		$lib[4] = 'FUELIGN';
		$lib[5] = 'IGNTEST';
		$lib[6] = 'BURNING';
		$lib[9] = 'COOLFLUID';
		$lib[10] = 'FIRESTOP';
		$lib[11] = 'CLEANFIRE';
		$lib[12] = 'COOL';
		$lib[241] = 'CHIMNEY ALARM';
		$lib[243] = 'GRATE ERROR';
		$lib[244] = 'NTC2 ALARM';
		$lib[245] = 'NTC3 ALARM';
		$lib[247] = 'DOOR ALARM';
		$lib[248] = 'PRESS ALARM';
		$lib[249] = 'NTC1 ALARM';
		$lib[250] = 'TC1 ALARM';
		$lib[252] = 'GAS ALARM';
		$lib[253] = 'NOPELLET ALARM';
		if(isset($lib[$num])) {
			return $lib[$num];
		} else {
			return $num;
		}
	}

	// methode jour de la semaine
	public function getWeekDay($num) {
		$lib[1] = 'Lundi';
		$lib[2] = 'Mardi';
		$lib[3] = 'Mercredi';
		$lib[4] = 'Jeudi';
		$lib[5] = 'Vendredi';
		$lib[6] = 'Samedi';
		$lib[7] = 'Dimanche';
		if(isset($lib[$num])) {
			return $lib[$num];
		} else {
			return 'Jour #'.$num;
		}
	}
	// methode traitement commande
	public function sendCommand($CMD, $_options) {

			// requete http
			$cmdString = $CMD->getConfiguration('actionCmd');
			// si option value ajout dans la requete
			if(isset($_options) && $_options!='') {
				if(is_array($_options)) {
					// cas ph
					if(isset($_options['jour']) && isset($_options['tranche']) && isset($_options['programme'])) {
						$cmdString = $cmdString . $_options['jour'] . '+' . $_options['tranche'] . '+' . $_options['programme'];	
					} else if(isset($_options['numero']) && isset($_options['temperature']) && isset($_options['h1']) && isset($_options['m1']) && isset($_options['h2']) && isset($_options['m2'])) {
						$cmdString = $cmdString . $_options['numero'] . '+' . $_options['temperature'] . '+' . $_options['h1']. '+' . $_options['m1']. '+' . $_options['h2']. '+' . $_options['m2'];
					}
				} else {
						$cmdString = $cmdString . $_options;					
				}
				log::add('Palazzetti', 'debug','('.__LINE__.') ' . __FUNCTION__.' - '. ' commande ' . $cmdString);
				log::add('Palazzetti', 'debug','('.__LINE__.') ' . __FUNCTION__.' - '. ' commande ' . json_encode($_options));
			}
			$DATA = $this->makeRequest($cmdString) ;
			if($DATA == false) { return 'ERROR'; }
			// verification succes du traitement
			if($DATA->Info->RSP != 'OK') {
				log::add('Palazzetti', 'error','('.__LINE__.') ' . __FUNCTION__.' - '. ' réponse erreur ' . $DATA->Info->RSP);
				return false;
			} 
			// definition patern de comparaison
			$expl = explode('+',$cmdString);
			$pattern = $expl[0] . '+' . $expl[1];

			// traitement suivant commande
			switch($pattern) {
				// allumage, extinction, status
				case 'CMD+ON': 
				case 'CMD+OFF': 
				case 'GET+STAT': 
					$value = $this->getStoveState($DATA->Status->STATUS);
				break;
				// nom poele
				case 'GET+LABL': 
				case 'SET+LABL':
					$value = $DATA->StoveData->LABEL;
				break;
				// force du feu
				case 'SET+POWR':
					$value = $DATA->Power->POWER;
				break;
				// température de consigne
				case 'GET+SETP': 
				case 'SET+SETP':
					$value = $DATA->Setpoint->SETP;
				break;
				// force du ventilateur
				case 'GET+FAND': 
					$value = $this->getFanState($DATA->Fans->FAN_FAN2LEVEL);
				break;
				case 'SET+RFAN':
					$value = $this->getFanState($DATA->RoomFan->FAN_FAN2LEVEL);
				break;
				// température ambiance
				case 'GET+TMPS': 
					$value = $DATA->Temperatures->TMP_ROOM_WATER;
				break;
				// programmes horaires
				case 'GET+CHRD': 
					$value = json_encode($DATA->{'Chrono Info'});
				break;
				// programmes horaires
				case 'SET+CSST': 
				break;
				// affectation programme
				// options +JOUR+TRANCHE+PH 
				case 'SET+CDAY':
				break;
				// informations automate
				case 'EXT+ADRD':
					$value = $DATA->Data->{'ADDR_'+ $expl[2]};
					log::add('Palazzetti', 'debug','('.__LINE__.') ' . __FUNCTION__.' - '. 'response '. $value);
				break;
			}
			// mise a jour variables info
			if($CMD->getConfiguration('updateLogicalId')) {
				$INFO = $this->getCmd(null, $CMD->getConfiguration('updateLogicalId'));
				$INFO->event($value);
				$INFO->save();
				log::add('Palazzetti', 'debug','('.__LINE__.') ' . __FUNCTION__.' - '. 'response '. $value);
				log::add('Palazzetti', 'debug','('.__LINE__.') ' . __FUNCTION__.' - '. 'updatelogicalId '.  $CMD->getConfiguration('updateLogicalId') . ' = ' . $value);
			}
			// mise à jour lastvalue commande
			$CMD->setConfiguration('lastCmdValue',$value);
			$CMD->save();
			return 'OK';
	}

 	public function toHtml($_version = 'dashboard')	{
		$replace = $this->preToHtml($_version);
		if (!is_array($replace)) {
			return $replace;
		}

		$temps = $this->getCmd(null,'ITemp');
		$replace ['#temperature#'] = $temps->execCmd();

		$status = $this->getCmd(null,'IStatus');
		$replace ['#status#'] = $this->getStoveState($status->execCmd());
		$WOn = $this->getCmd(null,'WOn');
	    $replace['#on_id#'] = is_object($WOn) ? $WOn->getId() : '';
		$WOff = $this->getCmd(null,'WOff');
	    $replace['#off_id#'] = is_object($WOff) ? $WOff->getId() : '';

		$consigne = $this->getCmd(null,'IConsigne');
		$replace ['#consigne#'] = $consigne->execCmd();
		$Wconsigne = $this->getCmd(null,'WConsigne');
	    $replace['#consigne_id#'] = is_object($Wconsigne) ? $Wconsigne->getId() : '';

		$fan = $this->getCmd(null,'IFan');
		$replace ['#fan#'] = $this->getFanState($fan->execCmd());
		$Wfan = $this->getCmd(null,'WFan');
	    $replace['#fan_id#'] = is_object($Wfan) ? $Wfan->getId() : '';

		$power = $this->getCmd(null,'IPower');
		$replace ['#power#'] = $power->execCmd();
		$Wpower = $this->getCmd(null,'Wpower');
	    $replace['#power_id#'] = is_object($Wpower) ? $Wpower->getId() : '';	

	    $refresh = $this->getCmd(null, 'ISnap');
	    $replace['#refresh_id#'] = is_object($refresh) ? $refresh->getId() : '';

		$html = template_replace($replace, getTemplate('core', $_version, 'Palazzetti','Palazzetti'));
		cache::set('PalazzettiWidget' . $_version . $this->getId(), $html, 0);
		return $html;

	}

	// recuperation automatique des informations
    public function getInformations() {

    	// recuperation del'heure
    	$DATA = $this->makeRequest('GET+TIME');
		if($DATA == false) { return; }
		// mise à jour nom du poêle
		$TIME = $this->getCmd(null, 'ITime');
		$TIME->event(json_encode($DATA->{'DateTime'}));
		$TIME->save();

    	// recuperation de toutes les informations réseau
    	$DATA = $this->makeRequest('GET+STDT');
		if($DATA == false) { return; }
		// mise à jour nom du poêle
		$LABL = $this->getCmd(null, 'IName');
		$LABL->event($DATA->StoveData->LABEL);
		$LABL->save();
		// mise à jour force du feu
		$POWR = $this->getCmd(null, 'INetwork');
		$POWR->event(json_encode($DATA));
		$POWR->save();

    	// recuperation des programmes horaires
    	$DATA = $this->makeRequest('GET+CHRD');
		if($DATA == false) { return; }
		// mise à jour programmes horaires
		$PH = $this->getCmd(null, 'IPH');
		$PH->event(json_encode($DATA->{'Chrono Info'}));
		$PH->save();

    	// recuperation des infos autoamte
    	$DATA = $this->makeRequest('EXT+ADRD+2066+1');
		if($DATA == false) { return; }
		$EXT = $this->getCmd(null, 'INbAllumage');
		$EXT->event($DATA->Data->ADDR_2066);
		$EXT->save();

    	$DATA = $this->makeRequest('EXT+ADRD+207C+1');
		if($DATA == false) { return; }
		$EXT = $this->getCmd(null, 'INbAllumageFailed');
		$EXT->event($DATA->Data->ADDR_207C);
		$EXT->save();

    	$DATA = $this->makeRequest('EXT+ADRD+206A+1');
		if($DATA == false) { return; }
		$EXT = $this->getCmd(null, 'IHeuresAlimElec');
		$EXT->event($DATA->Data->ADDR_206A);
		$EXT->save();

    	$DATA = $this->makeRequest('EXT+ADRD+2070+1');
		if($DATA == false) { return; }
		$EXT = $this->getCmd(null, 'IHeuresChauffe');
		$EXT->event($DATA->Data->ADDR_2070);
		$EXT->save();

    	$DATA = $this->makeRequest('EXT+ADRD+207A+1');
		if($DATA == false) { return; }
		$EXT = $this->getCmd(null, 'IHeuresSurChauffe');
		$EXT->event($DATA->Data->ADDR_207A);
		$EXT->save();

    	$DATA = $this->makeRequest('EXT+ADRD+2076+1');
		if($DATA == false) { return; }
		$EXT = $this->getCmd(null, 'IHeuresDepuisEntretien');
		$EXT->event($DATA->Data->ADDR_2076);
		$EXT->save();

    	// recuperation de toutes les informations
    	$DATA = $this->makeRequest('GET+ALLS');
		if($DATA == false) { return; }
		// mise à jour force du feu
		$POWR = $this->getCmd(null, 'IPower');
		$POWR->event($DATA->{'All Data'}->POWER);
		$POWR->save();
		// mise à jour température de consigne
		$TCON = $this->getCmd(null, 'IConsigne');
		$TCON->event($DATA->{'All Data'}->SETP);
		$TCON->save();
		// mise à jour force du ventilateur
		$FAN = $this->getCmd(null, 'IFan');
		$FAN->event($DATA->{'All Data'}->FAN_FAN2LEVEL);
		$FAN->save();
		// mise à jour force du ventilateur
		$TMP = $this->getCmd(null, 'ITemp');
		$TMP->event($DATA->{'All Data'}->TMP_ROOM_WATER);
		$TMP->save();
		// mise à jour status poele
		$STA = $this->getCmd(null, 'IStatus');
		$STA->event($DATA->{'All Data'}->STATUS);
		$STA->save();

		// mise a jour variables snap
		$SNAP = $this->getCmd(null, 'ISnap');
		$SNAP->event(json_encode($DATA->{'All Data'}));
		$SNAP->save();

	}

}

class PalazzettiCmd extends cmd {


/*     * *************************Attributs****************************** 
	public static $_widgetPossibility = array('custom' => false);

/*     * *********************Methode d'instance************************* */


	public function execute($_options = null) {
		
		$eqLogic 	= $this->getEqLogic();
		$idCmd 		= $this->getLogicalId();

		log::add('Palazzetti', 'debug','('.__LINE__.') ' . __FUNCTION__.' - '. 'options '. json_encode($this->getConfiguration('options')));
		log::add('Palazzetti', 'debug','('.__LINE__.') ' . __FUNCTION__.' - '. '$_options '. json_encode($_options));

		$eqLogic->sendCommand($this,$_options);
		$eqLogic->refreshWidget();
	}

}
?>
