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
 * Tab model.
 * 
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

class ModelTab
{
	var $_db;
	
	/**
	 * ModelTab::__construct()
	 * 
	 * @return null
	 */
	 
	function ModelTab()
	{
		$this->_db =& JFactory::getDBO();
	}
	
	/**
	 * ModelTab::getTabs()
	 * 
	 * @param mixed $id
	 * @return DBO
	 */ 
	 
	function getTabs($id)
	{
		// SQL query
		$query = '
		SELECT 
			`t`.`id` AS `id`, 
			`t`.`group_id` AS `gid`, 
			`t`.`name` AS `name`,
			`t`.`type` AS `type`,
			`t`.`content` AS `content`,
			`t`.`published` AS `published`,
			`t`.`access` AS `access`,
			`t`.`order` AS `order` 
		FROM 
			#__gk3_tabs_manager_tabs AS `t` 
		WHERE
			`t`.`group_id` = '.$id.'	
		ORDER BY 
			`t`.`order`
		LIMIT 100;';
		// run SQL query	
		$this->_db->setQuery($query);
		// return results of SQL query
		return $this->_db->loadObjectList();
	}
	
	/**
	 * ModelTab::addTab()
	 * 
	 * @return DBO
	 */
	 
	function addTab()
	{
		$query = '
		SELECT 
			MAX( `order` ) + 1 AS max 
		FROM 
			#__gk3_tabs_manager_tabs
		LIMIT 100;';
		$this->_db->setQuery($query);
		$row = $this->_db->loadRow();
		$max_order = (isset($row[0])) ? $row[0] : 1;
		
		$query = '
		INSERT INTO
			#__gk3_tabs_manager_tabs
		VALUES (
			DEFAULT,
			'.$_POST['gid'].',
			\''.htmlspecialchars(addslashes($_POST['name'])).'\',
			\''.htmlspecialchars(addslashes($_POST['type'])).'\',
			\''.htmlspecialchars(addslashes($_POST['content'])).'\',
			'.$_POST['published'].',
			'.$_POST['access'].',
			'.$max_order.'
		);';
		//
		$this->_db->setQuery($query);
		//
		return $this->_db->query();
	}
	
	/**
	 * ModelTab::editTab()
	 * 
	 * @param mixed $id
	 * @return DBO
	 */
	 
	function editTab($id)
	{
		$query = '
		UPDATE
			#__gk3_tabs_manager_tabs
		SET 
			name = \''.htmlspecialchars(addslashes($_POST['name'])).'\',
			type = \''.htmlspecialchars(addslashes($_POST['type'])).'\',
			content = \''.htmlspecialchars(addslashes($_POST['content'])).'\',
			published = '.$_POST['published'].',
			access = '.$_POST['access'].'
		WHERE 
			id = '.$id.'	
		LIMIT 1;';
		//
		$this->_db->setQuery($query);
		//
		return $this->_db->query();		
	}
	
	/**
	 * ModelTab::removeTab()
	 * 
	 * @param mixed $id
	 * @return DBO
	 */
	 
	function removeTab($id)
	{
		foreach($id as $item)
		{
			$query = '
			DELETE FROM
				#__gk3_tabs_manager_tabs
			WHERE
				id = '.$item.'
			;';
			//
			$this->_db->setQuery($query);
			//
			if($this->_db->query() === FALSE) return FALSE;		
		}		
		
		return TRUE;
	}
	
	/**
	 * ModelTab::publishTab()
	 * 
	 * @param mixed $id
	 * @return DBO
	 */
	 
	function publishTab($id)
	{
		foreach($id as $item)
		{	
			$query = '
			UPDATE
				#__gk3_tabs_manager_tabs
			SET 
				published = 1
			WHERE
				id = '.$item.'
			;';
			//
			$this->_db->setQuery($query);
			//
			if($this->_db->query() === FALSE) return FALSE;
		}			
		
		return TRUE;
	}
	
	/**
	 * ModelTab::unpublishTab()
	 * 
	 * @param mixed $id
	 * @return DBO
	 */
	 
	function unpublishTab($id)
	{
		foreach($id as $item)
		{
			$query = '
			UPDATE
				#__gk3_tabs_manager_tabs
			SET 
				published = 0
			WHERE
				id = '.$item.'
			;';
			//
			$this->_db->setQuery($query);
			//
			if($this->_db->query() === FALSE) return FALSE;	
		}
		
		return TRUE;	
	}
	
	/**
	 * ModelTab::orderTab()
	 * 
	 * @param mixed $order
	 * @param mixed $gid
	 * @return DBO
	 */
	 
	function orderTab($order, $gid)
	{
		$query = '
		SELECT 
			* 
		FROM 
			#__gk3_tabs_manager_tabs 
		WHERE 
			group_id = '.$gid.' 
		ORDER BY 
			`order` ASC
		LIMIT 100;';
		$this->_db->setQuery($query);
		// creating array of query results
		$rows = array();
		// storage query results in $rows variable
		foreach($this->_db->loadObjectList() as $row) array_push($rows, $row->id);
		// for each array element mak
		for($j = 0; $j < count($rows); $j++){
			// actualization of tab
			$query = '
			UPDATE 
				#__gk3_tabs_manager_tabs 
			SET 
				`order` = '.$order[$j].' 
			WHERE 
				id = '.$rows[$j].';';
			// make query
			$this->_db->setQuery($query);
			$this->_db->query();
		}	
	}
	
	/**
	 * ModelTab::accessTab()
	 * 
	 * @param mixed $level
	 * @param mixed $id
	 * @return DBO
	 */
	 
	function accessTab($level, $id)
	{
		$query = '
		UPDATE
			#__gk3_tabs_manager_tabs
		SET 
			access = '.$level.'
		WHERE
			id = '.$id.'
		;';
		//
		$this->_db->setQuery($query);
		//
		return $this->_db->query();		
	}
	
	/**
	 * ModelTab::getTab()
	 * 
	 * @param mixed $id
	 * @return bool or DBO
	 */ 
	 
	function getTab($id)
	{
		// SQL query
		$query = '
		SELECT 
			`t`.`id` AS `id`, 
			`t`.`group_id` AS `gid`, 
			`t`.`name` AS `name`,
			`t`.`type` AS `type`,
			`t`.`content` AS `content`,
			`t`.`published` AS `published`,
			`t`.`access` AS `access`,
			`t`.`order` AS `order` 
		FROM 
			#__gk3_tabs_manager_tabs AS `t` 
		WHERE
			`t`.`id` = '.$id.'	
		LIMIT 100;';
		// run SQL query	
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
}

/* End of file tab.php */
/* Location: ./models/tab.php */