<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

$GLOBALS['TL_DCA']['tl_content']['fields']['sc_name']['eval'] = array('maxlength'=>'255','unique'=>true,'spaceToUnderscore'=>true);

$GLOBALS['TL_DCA']['tl_content']['fields']['sc_col_count']  = array (
    'label'             => &$GLOBALS['TL_LANG']['tl_content']['sc_col_count'],
    'inputType'         => 'select',
    'options'           => array('2', '3', '4', '5'),
    'eval'              => array('submitOnChange'=>true, 'maxlength'=>'255', 'spaceToUnderscore'=>true, 'mandatory'=>true, 'tl_class'=>'w50')		
);


//$GLOBALS['TL_DCA']['tl_content']['config']['onload_callback'][] = array('tl_content_sc_extend','createPaletteExtended');

$GLOBALS['TL_DCA']['tl_content']['fields']['sc_type']['inputType'] = 'radioTableExt';
$GLOBALS['TL_DCA']['tl_content']['fields']['sc_type']['options_callback'] = array('tl_content_sc_extend', 'getOptionFields');
$GLOBALS['TL_DCA']['tl_content']['fields']['sc_type']['load_callback'] = array('tl_content_sc_extend', 'getOptionFields');
$GLOBALS['TL_DCA']['tl_content']['fields']['sc_type']['eval'] = array('includeBlankOption'=>false, 'mandatory'=>true);

$GLOBALS['TL_DCA']['tl_content']['fields']['sc_name']['eval'] = array('maxlength'=>'255','unique'=>true,'spaceToUnderscore'=>true, 'tl_class'=>'w50');


$GLOBALS['TL_DCA']['tl_content']['palettes']['colsetStart'] = '{type_legend},type;{colset_legend},sc_name,sc_col_count,sc_type,sc_gapdefault,sc_gap;{colheight_legend:hide},sc_equalize;{protected_legend:hide},protected;{expert_legend:hide},guests,invisible,cssID,space';

/**
 * Erweiterung für die tl_content_sc-Klasse
 */
class tl_content_sc_extend extends tl_content_sc
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
