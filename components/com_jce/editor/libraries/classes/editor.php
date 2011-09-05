<?php
/**
 * @version		$Id: editor.php 221 2011-06-11 17:30:33Z happy_noodle_boy $
 * @package      JCE
 * @copyright    Copyright (C) 2005 - 2009 Ryan Demmer. All rights reserved.
 * @author		Ryan Demmer
 * @license      GNU/GPL
 * JCE is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 */

defined('_JEXEC') or die('RESTRICTED');

wfimport('editor.libraries.classes.utility');
wfimport('editor.libraries.classes.token');
wfimport('editor.libraries.classes.document');
wfimport('editor.libraries.classes.view');
wfimport('editor.libraries.classes.tabs');
wfimport('editor.libraries.classes.request');

/**
 * JCE class
 *
 * @static
 * @package		JCE
 * @since	1.5
 */

class WFEditor extends JObject
{
	/**
	 * @var varchar
	 */
	var $_version 	= '2.0.9';

	/**
	 *  @var boolean
	 */
	var $_debug 	= false;
	/**
	 * Constructor activating the default information of the class
	 *
	 * @access	protected
	 */
	function __construct($config = array())
	{
		$this->setProperties($config);
	}
	/**
	 * Returns a reference to a editor object
	 *
	 * This method must be invoked as:
	 * 		<pre>  $browser =JContentEditor::getInstance();</pre>
	 *
	 * @access	public
	 * @return	JCE  The editor object.
	 * @since	1.5
	 */
	function &getInstance()
	{
		static $instance;

		if (!is_object($instance)) {
			$instance = new WFEditor();
		}
		return $instance;
	}
	/**
	 * Get the current version
	 * @return Version
	 */
	function getVersion()
	{
		return $this->get('_version');
	}

	/**
	 * Get the Super Administrator status
	 *
	 * Determine whether the user is a Super Administrator
	 *
	 * @return boolean
	 */
	function isSuperAdmin()
	{
		$user = JFactory::getUser();

		if (WF_JOOMLA15) {
			return (strtolower($user->usertype) == 'superadministrator' || strtolower($user->usertype) == 'super administrator' || $user->gid == 25) ? true : false;
		}
		return false;
	}

	/**
	 * Get an appropriate editor profile
	 * @return $profile Object
	 */
	public function getProfile()
	{
		static $profile;

		if (!is_object($profile)) {
			$mainframe =JFactory::getApplication();

			$db		= JFactory::getDBO();
			$user	= JFactory::getUser();
			$option = $this->getComponentOption();
				
			$query = 'SELECT *'
			. ' FROM #__wf_profiles'
			. ' WHERE published = 1'
			. ' ORDER BY ordering ASC'
			;
			$db->setQuery($query);
			$profiles = $db->loadObjectList();	
				
			if ($option == 'com_jce') {
				$component_id = JRequest::getInt('component_id');

				if ($component_id) {
					$component 	= WFExtensionHelper::getComponent($component_id);
					$option 	= isset($component->element) ? $component->element : $component->option;
				}
			}
				
			$area = $mainframe->isAdmin() ? 2 : 1;
				
			foreach ($profiles as $item) {
				// check if option is in list - always true if option is com_jce
				$isComponent = ($option == 'com_jce') ? true : in_array($option, explode(',', $item->components));
				
				// Set area default as Front-end / Back-end
				if (!isset($item->area) || $item->area == '') {
					$item->area = 0;
				}

				if ($item->area == $area || $item->area == 0) {
					// Check user
					if (in_array($user->id, explode(',', $item->users))) {
						if ($item->components) {
							if ($isComponent) {
								$profile = $item;
								return $profile;
							}
						} else {
							$profile = $item;
							return $profile;
						}
					}
					
					// Joomla! 1.6+
					if (method_exists('JUser', 'getAuthorisedGroups')) {
						$keys = $user->getAuthorisedGroups();
					} else {
						$keys = array($user->gid);
					}
						
					if ($item->types) {
						$groups = array_intersect($keys, explode(',', $item->types));

						if (!empty($groups)) {
							// Check components
							if ($item->components) {
								if ($isComponent) {
									$profile = $item;
									return $profile;
								}
							} else {	
								$profile = $item;
								return $profile;
							}
						}
					}

					// Check components only
					if ($item->components && $isComponent) {
						$profile = $item;
						return $profile;
					}
				}
			}
			
			return null;
		}

		return $profile;
	}

	function getComponentOption()
	{
		$option = JRequest::getCmd('option', '');

		switch ($option) {
			case 'com_section':
				$option = 'com_content';
				break;
			case 'com_categories':
				$section = JRequest::getVar('section');
				if ($section) {
					$option = $section;
				}
				break;
		}

		return $option;
	}

	public function getParams($options = array())
	{
		static $params;

		if (!isset( $params )) {
			$params = array();
		}
		
		// set blank key if not set
		if (!isset($options['key'])) {
			$options['key'] = '';
		}
		// set blank path if not set
		if (!isset($options['path'])) {
			$options['path'] = '';
		}
		
		$signature 	= serialize($options);

		if (empty($params[$signature])) {		
			wfimport('admin.helpers.extension');
			// get component
			$component = WFExtensionHelper::getComponent();
			// get params data for this profile
			$profile = $this->getProfile();
			
			if (!$component->params) {
				$component->params = '{}';
			}
			
			if (!$profile || !$profile->params) {
				$profile_params = '{}';
			} else {
				$profile_params = $profile->params;
			}
			
			// merge data and convert to json string
			$data = WFParameter::array_to_object(array_merge_recursive(json_decode($component->params, true), json_decode($profile_params, true)));
			
			$params[$signature] = new WFParameter($data, $options['path'], $options['key']);
		}

		return $params[$signature];
	}

	/**
	 * Remove linebreaks and carriage returns from a parameter value
	 *
	 * @return The modified value
	 * @param string	The parameter value
	 */
	function cleanParam($param)
	{
		if (is_array($param)) {
			$param = implode('|', $param);
		}
		return trim(preg_replace('/\n|\r|\t(\r\n)[\s]+/', '', $param));
	}
	
	/**
	 * Get a parameter by key
	 * @param $key Parameter key eg: editor.width
	 * @param $fallback Fallback value
	 * @param $default Default value
	 */
	public function getParam($key, $fallback = '', $default = '')
	{
		// get all keys
		$keys = explode('.', $key);

		// remove base key eg: 'editor'
		$base = array_shift($keys);
		// get params for base key
		$params = self::getParams(array('key' => $base));			
		// get a parameter
		$param = $params->get($keys, $fallback);
	
		if (is_string($param)) {
			$param = self::cleanParam($param);
		}
		
		if (is_numeric($default)) {
			$default = intval($default);
		}
		
		if (is_numeric($param)) {
			$param = intval($param);
		}

		return ($param === $default) ? '' : $param;
	}
	
	function checkLanguage($tag)
	{
		$file = JPATH_SITE .DS. 'language' .DS. $tag .DS. $tag .'.com_jce.xml';
		
		if (file_exists($file)) {
			wfimport('admin.helpers.xml');
				
			$xml = WFXMLHelper::getXML($file);	
			
			if ($xml) {
				$version = WFXMLHelper::getAttribute($xml, 'version');
				
				if ($version == '2.0') {
					return true;
				}
			}
		}
		
		return false;
	}

	/**
	 * Load a language file
	 *
	 * @param string $prefix Language prefix
	 * @param object $path[optional] Base path
	 */
	function loadLanguage($prefix, $path = JPATH_SITE)
	{
		$language 	= JFactory::getLanguage();
		$tag		= $this->getLanguageTag();

		$language->load($prefix, $path, $tag, true);
	}
	
	/**
	 * Return the curernt language code
	 *
	 * @access public
	 * @return language code
	 */
	function getLanguageDir()
	{
		$language 	= JFactory::getLanguage();
		$tag		= $this->getLanguageTag();
	
		if ($language->getTag() == $tag) {
			return $language->isRTL() ? 'rtl' : 'ltr';
		}
		
		return 'ltr';
	}
	
	/**
	 * Return the curernt language code
	 *
	 * @access public
	 * @return language code
	 */
	function getLanguageTag()
	{
		$language 	= JFactory::getLanguage();
		$tag		= $language->getTag();
		
		static $_language;
		
		if (!isset($_lanugage)) {
			if ($this->checkLanguage($tag)) {
				$_language = $tag;	
			} else {
				$_language = 'en-GB';
			}
		}
		
		return $_language;
	}
	
	/**
	 * Return the curernt language code
	 *
	 * @access public
	 * @return language code
	 */
	function getLanguage()
	{
		$tag = $this->getLanguageTag();	

		return substr($tag, 0, strpos($tag, '-'));
	}

	/**
	 * Named wrapper to check access to a feature
	 *
	 * @access 			public
	 * @param string	The feature to check, eg: upload
	 * @param string	The defalt value
	 * @return 			string
	 */
	function checkUser()
	{
		return $this->getProfile();
	}
	/**
	 * XML encode a string.
	 *
	 * @access	public
	 * @param 	string	String to encode
	 * @return 	string	Encoded string
	 */
	function xmlEncode($string)
	{
		return preg_replace(array('/&/', '/</', '/>/', '/\'/', '/"/'), array('&amp;', '&lt;', '&gt;', '&apos;', '&quot;'), $string);
	}
	/**
	 * XML decode a string.
	 *
	 * @access	public
	 * @param 	string	String to decode
	 * @return 	string	Decoded string
	 */
	function xmlDecode($string)
	{
		return preg_replace(array('&amp;', '&lt;', '&gt;', '&apos;', '&quot;'), array('/&/', '/</', '/>/', '/\'/', '/"/'), $string);
	}

	function log($file, $msg)
	{
		jimport('joomla.error.log');
		$log =JLog::getInstance($file);
		$log->addEntry(array('comment' => 'LOG: '.$msg));
	}
}
?>