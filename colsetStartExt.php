<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * Class colsetStartExt
 *
 * @copyright  Johannes Tober
 * @author     Johannes Tober
 * @package    subcolumns_select_extended
 */
class colsetStartExt extends colsetStart
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
                        $type_label = str_replace('system/modules/subcolumns_select_extended/html/images/', '', $this->sc_type);
                        $percentage = str_replace(strstr($type_label, 'x'), '', $type_label). '%';
			$this->Template = new BackendTemplate('be_wildcard');
			$this->Template->wildcard = '<img src="system/modules/subcolumns_select_extended/html/images/'.$type_label.'_1.gif" alt="Beispiel für Spaltensets" style="vertical-align:middle;" />  ' . sprintf($GLOBALS['TL_LANG']['MSCE']['contentAfter'],$GLOBALS['TL_LANG']['MSC']['sc_first'], $percentage);
			
			return $this->Template->parse();
		}
		
		return parent::generate();
	}
}

?>