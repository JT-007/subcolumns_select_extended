<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * Class FormColEndExt
 *
 * @copyright  Johannes Tober
 * @author     Johannes Tober
 * @package    subcolumns_select_extended
 */
class FormColEndExt extends FormColEnd
{

	/**
	 * Generate the widget and return it as string
	 * @return string
	 */
	public function generate()
	{
		if (TL_MODE == 'BE')
		{
                        $type_label = str_replace('system/modules/subcolumns_select_extended/html/images/', '', $this->fsc_type);
                    
			$objTemplate = new BackendTemplate('be_wildcard');
			$objTemplate->wildcard = '<img src="system/modules/subcolumns_select_extended/html/images/end.gif" alt="Beispiel für Spaltensets" style="vertical-align:middle;" />  '.$GLOBALS['TL_LANG']['MSCE']['endofSubcolumsExt'];
			
			return $objTemplate->parse();
		}
		
		$objTemplate = new FrontendTemplate($this->strColTemplate);
		return $objTemplate->parse();
	}
}

?>