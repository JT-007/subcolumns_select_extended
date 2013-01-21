<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * Class FormColPartExt 
 *
 * @copyright  Johannes Tober
 * @author     Johannes Tober
 * @package    subcolumns_select_extended
 */
class FormColPartExt extends FormColPart
{

	/**
	 * Generate the widget and return it as string
	 * @return string
	 */
	public function generate()
	{
		$arrCounts = array('1'=>'sc_second','2'=>'sc_third','3'=>'sc_fourth','4'=>'sc_fifth');
		
		
		if (TL_MODE == 'BE')
		{
			$type_label = str_replace('system/modules/subcolumns_select_extended/html/images/', '', $this->fsc_type);
                        $percentage = str_replace(strstr($type_label, 'x'), '', $type_label). '%';
                        $column_counter = intval($this->fsc_sortid)+1;
                        
			$objTemplate = new BackendTemplate('be_wildcard');
			$objTemplate->wildcard = '<img src="system/modules/subcolumns_select_extended/html/images/'.$type_label.'_'.$column_counter.'.gif" alt="Beispiel für Spaltensets" style="vertical-align:middle;" />  ' . sprintf($GLOBALS['TL_LANG']['MSCE']['contentAfter'], $colID, $percentage);
			
			return $objTemplate->parse();
		}
		
		$container = $GLOBALS['TL_SUBCL'][$this->fsc_type];
		
		$objTemplate = new FrontendTemplate($this->strColTemplate);
		
		if($this->fsc_gapuse == 1)
		{
			$gap_value = $this->fsc_gap != "" ? $this->fsc_gap : '12';
			$gap_unit = 'px';
			
			if(count($container) == 2)
			{
				$objTemplate->gap = array('left'=>floor(0.5*$gap_value).$gap_unit);
			}
			elseif (count($container) == 3)
			{
				switch($this->fsc_sortid)
				{
					case 1:
						$objTemplate->gap = array('right'=>floor(0.333*$gap_value).$gap_unit,'left'=>floor(0.333*$gap_value).$gap_unit);
						break;
					case 2:
						$objTemplate->gap = array('left'=>ceil(0.666*$gap_value).$gap_unit);
						break;
				}
			}
			elseif (count($container) == 4)
			{
				switch($this->fsc_sortid)
				{
					case 1:
						$objTemplate->gap = array('right'=>floor(0.5*$gap_value).$gap_unit,'left'=>floor(0.25*$gap_value).$gap_unit);
						break;
					case 2:
						$objTemplate->gap = array('right'=>floor(0.25*$gap_value).$gap_unit,'left'=>ceil(0.5*$gap_value).$gap_unit);
						break;
					case 3:
						$objTemplate->gap = array('left'=>ceil(0.75*$gap_value).$gap_unit);
						break;
				}
			}
			elseif (count($container) == 5)
			{
				switch($this->fsc_sortid)
				{
					case 1:
						$objTemplate->gap = array('right'=>floor(0.6*$gap_value).$gap_unit,'left'=>floor(0.2*$gap_value).$gap_unit);
						break;
					case 2:
						$objTemplate->gap = array('right'=>floor(0.4*$gap_value).$gap_unit,'left'=>ceil(0.4*$gap_value).$gap_unit);
						break;
					case 3:
						$objTemplate->gap = array('right'=>floor(0.2*$gap_value).$gap_unit,'left'=>ceil(0.6*$gap_value).$gap_unit);
						break;
					case 4:
						$objTemplate->gap = array('left'=>ceil(0.8*$gap_value).$gap_unit);
						break;
				}
			}
		}
		
		$objTemplate->column = $container[$this->fsc_sortid][0] . ' ' . $arrCounts[$this->fsc_sortid];
		$objTemplate->inside = $container[$this->fsc_sortid][1];
		return $objTemplate->parse();
	}
}

?>