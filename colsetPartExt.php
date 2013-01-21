<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * Class colsetPartExt 
 *
 * @copyright  Johannes Tober
 * @author     Johannes Tober
 * @package    subcolumns_select_extended
 */
class colsetPartExt extends colsetPart
{
	/**
	 * Display a wildcard in the back end
	 * @return string
	 */
	public function generate()
	{
		$this->strSet = $GLOBALS['TL_CONFIG']['subcolumns'] ? $GLOBALS['TL_CONFIG']['subcolumns'] : 'yaml3';
		
		if (TL_MODE == 'BE')
		{
			
			switch($this->sc_sortid)
			{
				case 1:
					$colID = $GLOBALS['TL_LANG']['MSC']['sc_second'];
					break;
				case 2:
					$colID = $GLOBALS['TL_LANG']['MSC']['sc_third'];
					break;
				case 3:
					$colID = $GLOBALS['TL_LANG']['MSC']['sc_fourth'];
					break;
				case 4:
					$colID = $GLOBALS['TL_LANG']['MSC']['sc_fifth'];
					break;
			}
			
                        $type_label = str_replace('system/modules/subcolumns_select_extended/html/images/', '', $this->sc_type);
                        $percentage_values = explode('x', $type_label);
                        $percentage = $percentage_values[$this->sc_sortid] . '%';
                        
                        $column_counter = intval($this->sc_sortid)+1;
                        
			$this->Template = new BackendTemplate('be_wildcard');
			$this->Template->wildcard = '<img src="system/modules/subcolumns_select_extended/html/images/'.$type_label.'_'.$column_counter.'.gif" alt="Beispiel für Spaltensets" style="vertical-align:middle;" />  ' . sprintf($GLOBALS['TL_LANG']['MSCE']['contentAfter'], $colID, $percentage);
			
			return $this->Template->parse();
		}

		return parent::generate();
	}
	
}

?>