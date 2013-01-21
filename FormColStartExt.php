<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * Class FormColStartExt
 *
 * @copyright  Johannes Tober
 * @author     Johannes Tober
 * @package    subcolumns_select_extended
 */
class FormColStartExt extends FormColStart
{

	public function generate()
	{
		if (TL_MODE == 'BE')
		{
                        $type_label = str_replace('system/modules/subcolumns_select_extended/html/images/', '', $this->fsc_type);
                        $percentage = str_replace(strstr($type_label, 'x'), '', $type_label). '%';
			$objTemplate = new BackendTemplate('be_wildcard');
			$objTemplate->wildcard = '<img src="system/modules/subcolumns_select_extended/html/images/'.$type_label.'_1.gif" alt="Beispiel für Spaltensets" style="vertical-align:middle;" />  ' . sprintf($GLOBALS['TL_LANG']['MSCE']['contentAfter'],$GLOBALS['TL_LANG']['MSC']['sc_first'], $percentage);
                        
			
			return $objTemplate->parse();
		}
		
		/**
		 * CSS Code in das Pagelayout einfügen
		 */
		$mainCSS = $GLOBALS['TL_CONFIG']['subcolumns_altcss'] ? 'system/modules/subcolumns/html/subcols_extended.css' : 'system/modules/subcolumns/html/subcols.css';
		$IEHacksCSS = $GLOBALS['TL_CONFIG']['subcolumns_altcss'] ? 'system/modules/subcolumns/html/subcolsIEHacks_extended.css' : 'system/modules/subcolumns/html/subcolsIEHacks.css';
		$GLOBALS['TL_CSS']['subcolumns'] = $mainCSS;
		$GLOBALS['TL_HEAD']['subcolumns'] = '<!--[if lte IE 7]><link href="'.$IEHacksCSS.'" rel="stylesheet" type="text/css" /><![endif]--> ';
		
		$container = $GLOBALS['TL_SUBCL'][$this->fsc_type];
		
		$objTemplate = new FrontendTemplate($this->strColTemplate);
		
		if($this->fsc_gapuse == 1)
		{
			$gap_value = $this->fsc_gap != "" ? $this->fsc_gap : '12';
			$gap_unit = 'px';
			
			if(count($container) == 2)
			{
				$objTemplate->gap = array('right'=>ceil(0.5*$gap_value).$gap_unit);
			}
			elseif (count($container) == 3)
			{
				$objTemplate->gap = array('right'=>ceil(0.666*$gap_value).$gap_unit);

			}
			elseif (count($container) == 4)
			{
				$objTemplate->gap = array('right'=>ceil(0.75*$gap_value).$gap_unit);
			}
			elseif (count($container) == 5)
			{
				$objTemplate->gap = array('right'=>ceil(0.8*$gap_value).$gap_unit);
			}
		}
		
		$objTemplate->column = $container[0][0] . ' first';
		$objTemplate->inside = $container[0][1];
		$objTemplate->scclass = ($this->fsc_equalize ? 'equalize ' : '') . 'subcolumns';
		$objTemplate->cssID = ' id="formcolset_' . $this->id . '"';
		return $objTemplate->parse();
	}
}

?>