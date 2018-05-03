<?php
if (!isConnect('admin')) {
    throw new Exception('{{401 - Accès non autorisé}}');
}
?>
<legend>{{Aide}}</legend>
Pour obtenir de l'aide au paramétrage du plugin, merci de consulter la documentation : <a href="http://doc.jeedom.fr/" target="_blank">Plugin Palazzetti</a>



