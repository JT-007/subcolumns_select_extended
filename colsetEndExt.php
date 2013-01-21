<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * Class colsetEndExt
 *
 * @copyright  Johannes Tober
 * @author     Johannes Tober
 * @package    subcolumns_select_extended
 */
class colsetEndExt extends colsetEnd
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
			$objTemplate = new BackendTemplate('be_wildcard');
                        $objTemplate->wildcard = '<img src="system/modules/subcolumns_select_extended/html/images/end.gif" alt="Beispiel für Spaltensets" style="vertical-align:middle;" />  '.$GLOBALS['TL_LANG']['MSCE']['endofSubcolumsExt'];
			
			return $objTemplate->parse();
		}

		return parent::generate();
	}
}

?>