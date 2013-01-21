<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * Fields
**/
$GLOBALS['TL_DCA']['tl_form_field']['fields']['fsc_type']['inputType'] = 'radioTableExt';
$GLOBALS['TL_DCA']['tl_form_field']['fields']['fsc_type']['options_callback'] = array('tl_form_subcols_ext', 'getOptionFields');
$GLOBALS['TL_DCA']['tl_form_field']['fields']['fsc_type']['load_callback'] = array('tl_form_subcols_ext', 'getOptionFields');
$GLOBALS['TL_DCA']['tl_form_field']['fields']['fsc_type']['eval'] = array('includeBlankOption'=>false, 'mandatory'=>true);

$GLOBALS['TL_DCA']['tl_form_field']['fields']['fsc_col_count']  = array (
    'label'             => &$GLOBALS['TL_LANG']['tl_form_field']['fsc_col_count'],
    'inputType'         => 'select',
    'options'           => array('2', '3', '4', '5'),
    'eval'              => array('submitOnChange'=>true, 'maxlength'=>'255', 'spaceToUnderscore'=>true, 'mandatory'=>true, 'tl_class'=>'w50')		
);

$GLOBALS['TL_DCA']['tl_form_field']['fields']['fsc_name']['eval'] = array('maxlength'=>'255','unique'=>true,'spaceToUnderscore'=>true,'tl_class'=>'w50');

$GLOBALS['TL_DCA']['tl_form_field']['palettes']['formcolstart'] = '{type_legend},type;{colsettings_legend},fsc_name,fsc_col_count,fsc_type,fsc_equalize,fsc_gapuse';

/**
 * Erweiterung für die tl_form_subcols-Klasse
 */
class tl_form_subcols_ext extends tl_form_subcols
{
    public function getOptionFields(DataContainer $dc){
        
        $options = array();
        $column_number = $dc->activeRecord->fsc_col_count;
        
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