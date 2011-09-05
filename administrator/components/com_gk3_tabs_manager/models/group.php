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
 * Group model.
 * 
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

class ModelGroup
{	
	var $_db;
	
	/**
	 * ModelGroup::__construct()
	 * 
	 * @return null
	 */
	 
	function ModelGroup()
	{
		$this->_db =& JFactory::getDBO();
	}
	
	/**
	 * ModelGroup::getGroups()
	 * 
	 * @return DBO
	 */
	 
	function getGroups()
	{
		// SQL query
		$query = '
		SELECT 
			`g`.`id` AS `id`, 
			`g`.`name` AS `name`, 
			`g`.`desc` AS `desc`,
			COUNT( DISTINCT `s`.`id` ) AS `amount` 
		FROM 
			#__gk3_tabs_manager_groups AS `g` 
		LEFT JOIN 
			#__gk3_tabs_manager_tabs AS `s` 
			ON 
			`s`.`group_id` = `g`.`id`  
		GROUP BY 
			`g`.`id`
		LIMIT 100;';
		// run SQL query	
		$this->_db->setQuery($query);
		// return results of SQL query
		return $this->_db->loadObjectList();
	}
	
	/**
	 * ModelGroup::addGroup()
	 * 
	 * @return DBO
	 */
	 
	function addGroup()
	{
		$query = '
		INSERT INTO 
			#__gk3_tabs_manager_groups
		VALUES(
			DEFAULT,
			\''.htmlspecialchars(addslashes($_POST['name'])).'\',
			\''.htmlspecialchars(addslashes($_POST['desc'])).'\'
		);';
		//
		$this->_db->setQuery($query);
		//
		return $this->_db->query();
	}
	
	/**
	 * ModelGroup::getGroupData()
	 * 
	 * @param mixed $id
	 * @return bool or DBO
	 */
	 
	function getGroupData($id)
	{
		$query = "
			SELECT 
				`id` AS `id`, 
				`name` AS `name`, 
				`desc` AS `desc` 
			FROM 
				#__gk3_tabs_manager_groups 
			WHERE 
				`id` = ".$id."
			LIMIT 100;";
				
		$this->_db->setQuery($query);
		$this->_db->query();
		//	
		if($this->_db->getNumRows() > 0)
		{
			$row = $this->_db->loadRow();
			return $row;			
		}
		else
		{
			return FALSE;
		}		
	}
	
	/**
	 * ModelGroup::editGroup()
	 * 
	 * @return DBO
	 */
	 
	function editGroup()
	{
		$query = '
		UPDATE
			#__gk3_tabs_manager_groups
		SET
			`name` = \''.htmlspecialchars(addslashes($_POST['name'])).'\',
			`desc` = \''.htmlspecialchars(addslashes($_POST['desc'])).'\'
		WHERE
			`id` = '.$_POST['id'].'
		;';
		//
		$this->_db->setQuery($query);
		//
		return $this->_db->query();		
	}
	
	/**
	 * ModelGroup::removeGroup()
	 * 
	 * @param mixed $id
	 * @return bool
	 */
	 
	function removeGroup($id)
	{
		foreach($id as $item)
		{
			$query = '
			DELETE FROM
				#__gk3_tabs_manager_groups
			WHERE
				`id` = '.$item.'
			;';
			//
			$this->_db->setQuery($query);
			//
			if($this->_db->query())
			{
				$query = '
				DELETE FROM
					#__gk3_tabs_manager_tabs
				WHERE
					`group_id` = '.$item.'
				;';
				//
				$this->_db->setQuery($query);
				
				if($this->_db->query() === FALSE) return FALSE; 
			}	
			else
			{
				return FALSE;
			}			
		}
		
		return TRUE;
	}
}

/* End of file group.php */
/* Location: ./models/group.php */