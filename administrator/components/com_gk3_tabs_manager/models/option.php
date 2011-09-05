<?php

/**
 * 
 * @version		3.0.0
 * @package		Joomla
 * @subpackage	Tabs Manager GK3
 * @copyright	Copyright (C) 2008 - 2009 GavickPro. All rights reserved.
 * @license		GNU/GPL
 * 
 * ==========================================================================
 * 
 * Option model.
 * 
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

class ModelOption
{
	var $_db;
	
	/**
	 * ModelOption::__construct()
	 * 
	 * @return null
	 */
	 
	function ModelOption()
	{
		$this->_db =& JFactory::getDBO();
	}
	
	/**
	 * ModelOption::getOptions()
	 * 
	 * @return null
	 */
	 
	function getOptions()
	{
		$query = "SELECT * FROM #__gk3_tabs_manager_options;";
		$this->_db->setQuery($query);
		$this->_db->query();
		//	
		if($this->_db->getNumRows() > 0)
		{
			return $this->_db->loadAssocList('name');				
		}
		else
		{
			return FALSE;
		}
	}
	
	/**
	 * ModelOption::getOption()
	 * 
	 * @param mixed $name
	 * @return bool or DBO
	 */
	 
	function getOption($name)
	{
		$query = "SELECT `value` AS value FROM #__gk3_tabs_manager_options WHERE name = '".$name."';";
		$this->_db->setQuery($query);
		$this->_db->query();
		//	
		if($this->_db->getNumRows() > 0)
		{
			$row = $this->_db->loadRow();
			return $row[0];			
		}
		else
		{
			return FALSE;
		}
	}
	
	/**
	 * ModelOption::setOptions()
	 * 
	 * @return bool or DBO
	 */
	function setOptions()
	{
		$query = "UPDATE #__gk3_tabs_manager_options SET value = '".$_POST['modal_news']."' WHERE name = 'modal_news';";
		$this->_db->setQuery($query);
		if($this->_db->query())
		{
			$query = "UPDATE #__gk3_tabs_manager_options SET value = '".$_POST['modal_settings']."' WHERE name = 'modal_settings';";
			$this->_db->setQuery($query);
			if($this->_db->query())
			{
				$query = "UPDATE #__gk3_tabs_manager_options SET value = '".$_POST['group_shortcuts']."' WHERE name = 'group_shortcuts';";
				$this->_db->setQuery($query);
				if($this->_db->query())
				{
					$query = "UPDATE #__gk3_tabs_manager_options SET value = '".$_POST['tab_shortcuts']."' WHERE name = 'tab_shortcuts';";
					$this->_db->setQuery($query);
					if($this->_db->query())
					{
						$query = "UPDATE #__gk3_tabs_manager_options SET value = '".$_POST['wysiwyg']."' WHERE name = 'wysiwyg';";
						$this->_db->setQuery($query);
						if($this->_db->query())
						{
							$query = "UPDATE #__gk3_tabs_manager_options SET value = '".$_POST['gavick_news']."' WHERE name = 'gavick_news';";
							$this->_db->setQuery($query);
							if($this->_db->query())
							{
								$query = "UPDATE #__gk3_tabs_manager_options SET value = '".$_POST['article_id']."' WHERE name = 'article_id';";
								$this->_db->setQuery($query);
								return $this->_db->query();	
							}
							else
							{
								return FALSE;
							}	
						}
						else
						{
							return FALSE;
						}		
					}
					else
					{
						return FALSE;
					}	
				}
				else
				{
					return FALSE;
				}	
			}
			else
			{
				return FALSE;
			}			
		}
		else
		{
			return FALSE;
		}
	}
}

/* End of file option.php */
/* Location: ./models/option.php */