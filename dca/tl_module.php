<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

$GLOBALS['TL_DCA']['tl_module']['fields']['sc_col_count']  = array (
    'label'             => &$GLOBALS['TL_LANG']['tl_module']['sc_col_count'],
    'inputType'         => 'select',
    'options'           => array('2', '3', '4', '5'),
    'eval'              => array('submitOnChange'=>true, 'maxlength'=>'255', 'spaceToUnderscore'=>true, 'mandatory'=>true)		
);

$GLOBALS['TL_DCA']['tl_module']['fields']['sc_type']['inputType'] = 'radioTableExt';
$GLOBALS['TL_DCA']['tl_module']['fields']['sc_type']['options_callback'] = array('tl_module_sc_extend', 'getOptionFields');
$GLOBALS['TL_DCA']['tl_module']['fields']['sc_type']['load_callback'] = array('tl_module_sc_extend', 'getOptionFields');
$GLOBALS['TL_DCA']['tl_module']['fields']['sc_type']['eval'] = array('submitOnChange'=>true, 'includeBlankOption'=>false, 'mandatory'=>true);

$GLOBALS['TL_DCA']['tl_module']['fields']['sc_modules']['inputType'] = 'extendedModuleWizardExt';

$GLOBALS['TL_DCA']['tl_module']['palettes']['subcolumns'] = '{title_legend},name,headline,type;{subcolumns_legend},sc_col_count,sc_type,sc_modules;{subcolumns_settings_legend},sc_gap,sc_gapdefault,sc_equalize;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space';

/**
 * Erweiterung für die tl_module-Klasse
 */
class tl_module_sc_extend extends tl_module
{        
    public function getOptionFields(DataContainer $dc){
        
        $options = array();
        $column_number = $dc->activeRecord->sc_col_count;
        
        if($column_number == 0)
        {
            $column_number = 2;
        }
        
        foreach($GLOBALS['TL_SUBCL'] as $cur_key => $cur_val){
            
            $type_parameters = explode('/',$cur_key);
            $cur_count = count(explode('x',end($type_parameters)));            
            if($cur_count == ($column_number)){
                $options[$cur_key] = $cur_val;
            }            
            
        }
        return array_keys($options);
    }

}


?>
