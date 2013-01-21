<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

$GLOBALS['TL_CTE']['subcolumn'] = array(
	'colsetStart' => 'colsetStartExt',
	'colsetPart' => 'colsetPartExt',
	'colsetEnd' => 'colsetEndExt'
);

if (TL_MODE == 'BE'){
    $GLOBALS['TL_CSS'][] = 'system/modules/subcolumns_select_extended/html/css/subcolumns_ext.css';
}


/**
 * Form fields
 */
$GLOBALS['TL_FFL']['formcolstart'] = 'FormColStartExt';
$GLOBALS['TL_FFL']['formcolpart'] = 'FormColPartExt';
$GLOBALS['TL_FFL']['formcolend'] = 'FormColEndExt';

$GLOBALS['BE_FFL']['extendedModuleWizardExt'] = 'ExtendedModuleWizardExt';
$GLOBALS['BE_FFL']['radioTableExt'] = 'RadioTableExt';

foreach($GLOBALS['TL_SUBCL'] as $cur_key => $cur_val){
    $GLOBALS['TL_SUBCL']['system/modules/subcolumns_select_extended/html/images/' . $cur_key] = $cur_val;
    unset($GLOBALS['TL_SUBCL'][$cur_key]);
}

?>