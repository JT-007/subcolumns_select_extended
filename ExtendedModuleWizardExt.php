<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * Class ExtendedModuleWizardExt
 *
 * @copyright  Johannes Tober
 * @author     Johannes Tober
 * @package    subcolumns_select_extended
 */
class ExtendedModuleWizardExt extends ExtendedModuleWizard
{
    
	/**
	 * Generate the widget and return it as string
	 * @return string
	 */
	public function generate()
	{
		$this->import('Database');

		$arrButtons = array('copy', 'up', 'down', 'delete');
		$strCommand = 'cmd_' . $this->strField;

		// Change the order
		if ($this->Input->get($strCommand) && is_numeric($this->Input->get('cid')) && $this->Input->get('id') == $this->currentRecord)
		{
			switch ($this->Input->get($strCommand))
			{
				case 'copy':
					$this->varValue = array_duplicate($this->varValue, $this->Input->get('cid'));
					break;

				case 'up':
					$this->varValue = array_move_up($this->varValue, $this->Input->get('cid'));
					break;

				case 'down':
					$this->varValue = array_move_down($this->varValue, $this->Input->get('cid'));
					break;

				case 'delete':
					$this->varValue = array_delete($this->varValue, $this->Input->get('cid'));
					break;
			}
		}

		// Get all modules from DB
		$objModules = $this->Database->execute("SELECT id, name FROM tl_module ORDER BY name");
		$modules = array();

		if ($objModules->numRows)
		{
			$modules = array_merge($modules, $objModules->fetchAllAssoc());
		}

		$objRow = $this->Database->prepare("SELECT * FROM " . $this->strTable . " WHERE id=?")
								 ->limit(1)
								 ->execute($this->currentRecord);

		// Columns
		if ($objRow->numRows)
		{
			$cols = array();
                        $type_parameters = explode('/',$objRow->sc_type);

			$count = count(explode('x',end($type_parameters)));

			switch ($count)
			{
				case '2':
					$cols[] = 'first';
					$cols[] = 'second';
					break;

				case '3':
					$cols[] = 'first';
					$cols[] = 'second';
					$cols[] = 'third';
					break;

				case '4':
					$cols[] = 'first';
					$cols[] = 'second';
					$cols[] = 'third';
					$cols[] = 'fourth';
					break;
				
				case '5':
					$cols[] = 'first';
					$cols[] = 'second';
					$cols[] = 'third';
					$cols[] = 'fourth';
					$cols[] = 'fifth';
					break;
			}

			
		}

		// Get new value
		if ($this->Input->post('FORM_SUBMIT') == $this->strTable)
		{
			$this->varValue = $this->Input->post($this->strId);
		}

		// Make sure there is at least an empty array
		if (!is_array($this->varValue) || !$this->varValue[0])
		{
			$this->varValue = array('');
		}

		else
		{
                        $arrCols = array();
                    
			// Initialize sorting order
			foreach ($cols as $col)
			{
				$arrCols[$col] = array();
			}
                       
			foreach ($this->varValue as $v)
			{
				// Add only modules of an active section
				if (in_array($v['col'], $cols))
				{
					$arrCols[$v['col']][] = $v;
				}
			}

			$this->varValue = array();
                        
			foreach ($arrCols as $arrCol)
			{
				$this->varValue = array_merge($this->varValue, $arrCol);
			}
		}

		// Save the value
		if ($this->Input->get($strCommand) || $this->Input->post('FORM_SUBMIT') == $this->strTable)
		{
			$this->Database->prepare("UPDATE " . $this->strTable . " SET " . $this->strField . "=? WHERE id=?")
						   ->execute(serialize($this->varValue), $this->currentRecord);

			// Reload the page
			if (is_numeric($this->Input->get('cid')) && $this->Input->get('id') == $this->currentRecord)
			{
				$this->redirect(preg_replace('/&(amp;)?cid=[^&]*/i', '', preg_replace('/&(amp;)?' . preg_quote($strCommand, '/') . '=[^&]*/i', '', $this->Environment->request)));
			}
		}

		// Add label and return wizard
		$return .= '<table cellspacing="0" cellpadding="0" id="ctrl_'.$this->strId.'" class="tl_modulewizard" summary="Module wizard">
  <thead>
  <tr>
    <td>'.$GLOBALS['TL_LANG'][$this->strTable]['module'].'</td>
    <td>'.$GLOBALS['TL_LANG'][$this->strTable]['column'].'</td>
    <td>&nbsp;</td>
  </tr>
  </thead>
  <tbody>';

		// Load tl_article language file
		$this->loadLanguageFile('tl_article');

		// Add input fields
		for ($i=0; $i<count($this->varValue); $i++)
		{
			$options = '';

			// Add modules
			foreach ($modules as $v)
			{
				$options .= '<option value="'.specialchars($v['id']).'"'.$this->optionSelected($v['id'], $this->varValue[$i]['mod']).'>'.$v['name'].'</option>';
			}

			$return .= '
  <tr>
    <td><select name="'.$this->strId.'['.$i.'][mod]" class="tl_select" onfocus="Backend.getScrollOffset();">'.$options.'</select></td>';

			$options = '';

			// Add column
			foreach ($cols as $v)
			{
				$options .= '<option value="'.specialchars($v).'"'.$this->optionSelected($v, $this->varValue[$i]).'>'. ((isset($GLOBALS['TL_LANG']['CTE'][$v]) && !is_array($GLOBALS['TL_LANG']['CTE'][$v])) ? $GLOBALS['TL_LANG']['CTE'][$v] : $v) .'</option>';
			}

			$return .= '
    <td><select name="'.$this->strId.'['.$i.'][col]" class="tl_select_column" onfocus="Backend.getScrollOffset();">'.$options.'</select></td>
    <td>';

			foreach ($arrButtons as $button)
			{
				$return .= '<a href="'.$this->addToUrl('&amp;'.$strCommand.'='.$button.'&amp;cid='.$i.'&amp;id='.$this->currentRecord).'" title="'.specialchars($GLOBALS['TL_LANG'][$this->strTable]['wz_'.$button]).'" onclick="Backend.moduleWizard(this, \''.$button.'\',  \'ctrl_'.$this->strId.'\'); return false;">'.$this->generateImage($button.'.gif', $GLOBALS['TL_LANG'][$this->strTable]['wz_'.$button], 'class="tl_listwizard_img"').'</a> ';
			}

			$return .= '</td>
  </tr>';
		}

		return $return.'
  </tbody>
  </table>';
	}
}

?>