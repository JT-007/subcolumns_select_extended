<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');


/**
 * Class RadioTableExt
 *
 * Provide methods to handle radio button tables with spezial title tag.
 * @copyright  Johannes Tober
 * @author     Johannes Tober
 * @package    subcolumns_select_extended
 */
class RadioTableExt extends Widget
{

	/**
	 * Submit user input
	 * @var boolean
	 */
	protected $blnSubmitInput = true;

	/**
	 * Columns
	 * @var integer
	 */
	protected $intCols = 4;

	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'be_widget';

	/**
	 * Options
	 * @var integer
	 */
	protected $arrOptions = array();


	/**
	 * Add specific attributes
	 * @param string
	 * @param mixed
	 */
	public function __set($strKey, $varValue)
	{
		switch ($strKey)
		{
			case 'cols':
				if ($varValue > 0)
				{
					$this->intCols = $varValue;
				}
				break;

			case 'options':
				$this->arrOptions = deserialize($varValue);
				break;

			default:
				parent::__set($strKey, $varValue);
				break;
		}
	}


	/**
	 * Generate the widget and return it as string
	 * @return string
	 */
	public function generate()
	{
		if (!is_array($this->arrOptions) || empty($this->arrOptions))
		{
			return '';
		}

		$rows = ceil(count($this->arrOptions) / $this->intCols);
		$return = '<table id="ctrl_'.$this->strName.'" class="tl_radio_table_ext'.(strlen($this->strClass) ? ' ' . $this->strClass : '').'">';

		for ($i=0; $i<$rows; $i++)
		{
			$return .= '
    <tr>';

			// Add cells
			for ($j=($i*$this->intCols); $j<(($i+1)*$this->intCols); $j++)
			{
				$value = $this->arrOptions[$j]['value'];
				$label = $this->arrOptions[$j]['label'];
                                
                                $own_label_text = explode('/',$value);
                                $own_label_text = end($own_label_text);
                                $own_label_text = str_replace('x', '%-', $own_label_text). '%';
                                
                                
				if (strlen($value))
				{
					$label = $this->generateImage($value.'.gif', $label, 'title="'.specialchars($label).'"');
					$return .= '
      <td><input type="radio" name="'.$this->strName.'" id="'.$this->strField.'_'.$i.'_'.$j.'" class="tl_radio" value="'.specialchars($value).'" onfocus="Backend.getScrollOffset()"'.$this->isChecked($this->arrOptions[$j]).$this->getAttributes().'> <label for="'.$this->strField.'_'.$i.'_'.$j.'">'.$label.'<span>' . $own_label_text . '</span></label></td>';
				}

				// Else return an empty cell
				else $return .= '
      <td></td>';
			}

			// Close row
			$return .= '
    </tr>';
		}

		return $return . '
  </table>';
	}
}

?>