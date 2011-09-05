<?php
/**
 * @version   $Id: file.php 252 2011-06-29 13:28:00Z happy_noodle_boy $
 * @package      JCE
 * @copyright    Copyright (C) 2005 - 2009 Ryan Demmer. All rights reserved.
 * @author    Ryan Demmer
 * @license      GNU/GPL
 * JCE is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 */

defined('_JEXEC') or die('ERROR_403');

wfimport('editor.libraries.classes.extensions.browser');
wfimport('editor.libraries.classes.extensions.filesystem');

class WFFileBrowser extends WFBrowserExtension 
{
	/*
	 *  @var varchar
	 */
	//var $_base = null;

	/*
	 *  @var array
	 */
	var $_buttons = array();
	/*
	 *  @var array
	 */
	var $_actions = array();
	/*
	 *  @var array
	 */
	var $_events = array();
	/*
	 *  @var array
	 */
	var $_result = array('error' => array(), 'files' => array(), 'folders' => array());
	/**
	 * @access  protected
	 */
	function __construct($config = array())
	{

		$default = array(
			'dir'						=> 'images',
			'filesystem' 				=> 'joomla',
			'filetypes'					=> 'images=jpg,jpeg,png,gif',
			'upload'					=> array(
				'runtimes'			=> 'html5,flash,silverlight',
				'chunk_size' 		=> null,
				'max_size'			=> 1024,
				'validate_mimetype'	=> 0
			),
			'folder_tree'		=> 1,
			'list_limit'		=> 'all',
			'features'		=> array(
				'upload' 	=> 1,
				'folder'	=> array(
					'create' => 1,
					'delete' => 1,
					'rename' => 1,
					'move'	 => 1	
				),
				'file'		=> array(
					'rename' => 1,
					'delete' => 1,
					'move' 	 => 1
				)
			)
		);
		
		$config = array_merge($default, $config);		

		// Call parent
		parent::__construct($config);

		// Setup XHR callback funtions
		$this->setRequest(array($this, 'getItems'));
        $this->setRequest(array($this, 'getFileDetails'));
		$this->setRequest(array($this, 'getFolderDetails'));
		$this->setRequest(array($this, 'getTree'));
		$this->setRequest(array($this, 'getTreeItem'));

		// Get actions
		$this->getStdActions();
		// Get buttons
		$this->getStdButtons();
	}

	/**
	 * Display the browser
	 */
	function display()
	{		
		parent::display();
		
		// Get the Document instance
		$document = WFDocument::getInstance();

		$document->addScript(array(
			'tree',
			'upload'
		), 'libraries');
		
		$document->addScript(array(
			'plupload.full',
		), 'jce.libraries.plupload');
		
		$document->addScript(array(
			'file',
			'sort',
			'search',
			'manager'
		), 'extensions.browser.js');
	
		//$document->addStyleSheet(array('files', 'tree', 'upload'), 'libraries');
		$document->addStyleSheet(array('manager'), 'extensions.browser.css');
		
		// file browser options
		$document->addScriptDeclaration('WFFileBrowser.settings='.json_encode($this->getSettings()).';');
	}
	
	function render()
	{
		$session = JFactory::getSession();
		// create file view
		$view = $this->getView('file');
		// assign session data
		$view->assignRef('session', $session);
		// assign form action
		$view->assign('action', $this->getFormAction());		
		// return view output
		$view->display();
	}
	
	function setRequest($request)
	{
		$xhr = WFRequest::getInstance();		
		$xhr->setRequest($request);
	}
	
	/**
	 * Upload form action url
	 *
	 * @access	public
	 * @param	string 	The target action file eg: upload.php
	 * @return	Joomla! component url
	 * @since	1.5
	 */
	function getFormAction() 
	{		
		$wf = WFEditorPlugin::getInstance();
		
		$component_id = JRequest::getInt('component_id');
		
		$query = '';
		
		$args = array(
			'plugin' => $wf->getName()
		);
		
		if ($component_id) {
			$args['component_id'] = $component_id;
		}
		
		foreach($args as $k => $v) {
			$query .= '&' . $k . '=' . $v;
		}
				
		return JURI::base(true) .'/index.php?option=com_jce&view=editor&layout=plugin' . $query; 
	}

	function getFileSystem()
	{
		static $filesystem;

		if (!is_object($filesystem)) {
			$wf = WFEditorPlugin::getInstance();
			
			$config = array(
				'dir' 				=> $this->get('dir'),
				'upload_conflict' 	=> $wf->getParam('editor.upload_conflict', 'overwrite')
			);
			
			$filesystem = WFFileSystem::getInstance($this->get('filesystem'), $config);
		}

		return $filesystem;
	}
	
	function getViewable()
	{
		return 'jpeg,jpg,gif,png,avi,wmv,wm,asf,asx,wmx,wvx,mov,qt,mpg,mp3,mp4,m4v,mpeg,ogg,ogv,webm,swf,flv,f4v,xml,dcr,rm,ra,ram,divx,html,htm,txt,rtf,pdf,doc,docx,xls,xlsx,ppt,pptx';
	}

	/**
	 * Return a list of allowed file extensions in selected format
	 *
	 * @access public
	 * @return extension list
	 */
	function getFileTypes($format = 'map')
	{
		$list = $this->get('filetypes');

		// Remove excluded file types (those that have a - prefix character) from the list
		$data 	= array();
		
		foreach(explode(';', $list) as $group) {	
			if (substr(trim($group), 0, 1) === '-') {
				continue;
			}
			
			$data[] = $group;
		}
		
		$list = implode(';', $data);

		switch ($format) {
			case 'list':
				return $this->listFileTypes($list);
				break;
			case 'array':
				return explode(',', $this->listFileTypes($list));
				break;
			default:
			case 'map':
				return $list;
				break;
		}
	}
	
	function setFileTypes($list = 'images=jpg,jpeg,png,gif')
	{		
		$this->set('filetypes', $list);
	}

	/**
	 * Converts the extensions map to a list
	 * @param string $map The extensions map eg: images=jpg,jpeg,gif,png
	 * @return string jpg,jpeg,gif,png
	 */
	function listFileTypes($map)
	{
		return preg_replace(array('/([\w]+)=([\w]+)/', '/;/'), array('$2', ','), $map);
	}
	
	function addFileTypes($types)
	{
		$list = explode(';', $this->get('filetypes'));
			
		foreach($types as $group => $extensions) {
			$list[] = $group . '=' . $extensions;
		}	

		$this->set('filetypes', implode(';', $list));
	}
	
	/**
	 * Maps upload file types to an upload dialog list, eg: 'images', 'jpeg,jpg,gif,png'
	 * @return json encoded list
	 */
	function mapUploadFileTypes()
	{
		$map = array();
		
		// Get the filetype map
		$list = $this->getFileTypes();
		
		if ($list) {
			$items = explode(';', $list);
			
			// [images=jpeg,jpg,gif,png]
			foreach ($items as $item) {
				// ['images', 'jpeg,jpg,gif,png']
				$kv                                               = explode('=', $item);
				$extensions                                       = implode(';', preg_replace('/(\w+)/i', '*.$1', explode(',', $kv[1])));
				$map[WFText::_('WF_FILEGROUP_' . $kv[0], WFText::_($kv[0])) . ' (' . $extensions . ')'] = $kv[1];
			}
		}		

		// All file types
		//$map[WFText::_('WF_FILEGROUP_ALL') . ' (*.*)'] = '*.*';
		
		return $map;
	}
	/**
	 * Returns the result variable
	 * @return var $_result
	 */
	function getResult()
	{
		return $this->_result;
	}

	function setResult($value, $key = null)
	{
		if ($key) {
			if (is_array($this->_result[$key])) {
				$this->_result[$key][] = $value;
			} else {
				$this->_result[$key] = $value;
			}
		} else {
			$this->_result = $value;
		}
	}

	function getBaseDir()
	{
		$filesystem = $this->getFileSystem();
		return $filesystem->getBaseDir();
	}

	/**
	 * Get the list of files in a given folder
	 * @param string $relative The relative path of the folder
	 * @param string $filter A regex filter option
	 * @return File list array
	 */
	function getFiles($relative, $filter = '.')
	{
		$filesystem = $this->getFileSystem();
		$list = $filesystem->getFiles($relative, $filter);

		return $list;
	}
	/**
	 * Get the list of folder in a given folder
	 * @param string $relative The relative path of the folder
	 * @return Folder list array
	 */
	function getFolders($relative)
	{
		$filesystem = $this->getFileSystem();
		$list = $filesystem->getFolders($relative);

		return $list;
	}
	/**
	 * Get file and folder lists
	 * @return array Array of file and folder list objects
	 * @param string $relative Relative or absolute path based either on source url or current directory
	 * @param int $limit List limit
	 * @param int $start list start point
	 */
	function getItems($path, $limit = 25, $start = 0)
	{
		$filesystem = $this->getFileSystem();	
			
		clearstatcache();
		
		// decode path
		$path = rawurldecode($path);
		
		// get source dir from path eg: images/stories/fruit.jpg = images/stories
		$dir = $filesystem->getSourceDir($path);
	
		// get file list by filter
		$files   	= self::getFiles($dir, '\.(?i)(' . str_replace(',', '|', $this->getFileTypes('list')) . ')$');
		// get folder list
		$folders 	= self::getFolders($dir);

		$folderArray = array();
		$fileArray   = array();

		$items = array_merge($folders, $files);

		if ($items) {
			if (is_numeric($limit)) {
				$items = array_slice($items, $start, $limit);
			}

			foreach ($items as $item) {
				$item['classes'] = '';

				if ($item['type'] == 'folders') {
					$folderArray[] 	= $item;
				} else {
					// check for selected item
					$item['selected'] 	= $filesystem->isMatch($item['url'], $path);	
							
					$fileArray[] 		= $item;
				}
			}
		}
		
		$result = array(
            'folders' 	=> $folderArray,
            'files' 	=> $fileArray,
            'total' 	=> array(
                'folders' 	=> count($folders),
                'files' 	=> count($files)
			)
		);
		
		// Fire Event passing result as reference
		$this->fireEvent('onGetItems', array(&$result));

		return $result;
	}
	/**
	 * Get a tree node
	 * @param string $dir The relative path of the folder to search
	 * @return Tree node array
	 */
	function getTreeItem($dir)
	{			
		$folders = $this->getFolders(rawurldecode($dir));
		$array   = array();
		if (!empty($folders)) {
			foreach ($folders as $folder) {
				$array[] = array(
                    'id' 	=> $folder['id'],
                    'name' 	=> $folder['name'],
                    'class' => 'folder'
                );
			}
		}
		$result = array(
            'folders' => $array
		);
		return $result;
	}
	/**
	 * Escape a string
	 *
	 * @return string Escaped string
	 * @param string $string
	 */
	function escape($string)
	{
		return preg_replace(array(
            '/%2F/',
            '/%3F/',
            '/%40/',
            '/%2A/',
            '/%2B/'
            ), array(
            '/',
            '?',
            '@',
            '*',
            '+'
            ), rawurlencode($string));
	}
	/**
	 * Build a tree list
	 * @param string $dir The relative path of the folder to search
	 * @return Tree html string
	 */
	function getTree($path)
	{
		$filesystem = $this->getFileSystem();

		// decode path
		$path = rawurldecode($path);
		
		// get source dir from path eg: images/stories/fruit.jpg = images/stories
		$dir = $filesystem->getSourceDir($path);	
			
		$result = $this->getTreeItems($dir);
		return $result;
	}
	/**
	 * Get Tree list items as html list
	 *
	 * @return Tree list html string
	 * @param string $dir Current directory
	 * @param boolean $root[optional] Is root directory
	 * @param boolean $init[optional] Is tree initialisation
	 */
	function getTreeItems($dir, $root = true, $init = true)
	{
		$result = '';
		if ($init) {
			$this->treedir = $dir;
			if ($root) {
				$result = '<ul><li id="/" class="open"><div class="tree-row"><div class="tree-image"></div><span class="root"><a href="javascript:;">' . WFText::_('WF_LABEL_ROOT') . '</a></span></div>';
				$dir    = '/';
			}
		}
		$folders = $this->getFolders($dir);

		if ($folders) {
			$result .= '<ul class="tree-node">';
			foreach ($folders as $folder) {
				$open = strpos($this->treedir, $folder['id']) !== false ? ' open' : '';
				$result .= '<li id="' . $this->escape($folder['id']) . '" class="' . $open . '"><div class="tree-row"><div class="tree-image"></div><span class="folder"><a href="javascript:;">' . $folder['name'] . '</a></span></div>';
				if ($open) {
					if ($h = $this->getTreeItems($folder['id'], false, false)) {
						$result .= $h;
					}
				}
				$result .= '</li>';
			}
			$result .= '</ul>';
		}
		if ($init && $root) {
			$result .= '</li></ul>';
		}
		$init = false;
		return $result;
	}
	/**
	 * Get a folders properties
	 *
	 * @return array Array of properties
	 * @param string $dir Folder relative path
	 */
	function getFolderDetails($dir)
	{
		$filesystem = $this->getFileSystem();
		// get array with folder date and content count eg: array('date'=>'00-00-000', 'folders'=>1, 'files'=>2);
		return $filesystem->getFolderDetails($dir);
	}
	/**
	 * Get a files properties
	 *
	 * @return array Array of properties
	 * @param string $file File relative path
	 */
	function getFileDetails($file)
	{
		$filesystem = $this->getFileSystem();
		// get array with folder date and content count eg: array('date'=>'00-00-000', 'folders'=>1, 'files'=>2);
		return $filesystem->getFileDetails($file);
	}
	/**
	 * Create standard actions based on access
	 */
	function getStdActions()
	{
		$this->addAction('help', '', '', WFText::_('WF_BUTTON_HELP'));

		$features = $this->get('features');
		
		if ($features['upload']) {
			$this->addAction('upload');
			$this->setRequest(array($this, 'upload'));
		}
		
		if ($features['folder']['create']) {
			$this->addAction('folder_new');
			$this->setRequest(array($this, 'folderNew'));
		}
	}
	/**
	 * Add an action to the list
	 *
	 * @param string $name Action name
	 * @param array  $options Array of options
	 */
	function addAction($name, $options = array())
	{
		/* TODO */
		// backwards compatability (remove in stable)
		$args = func_get_args();
		
		if (count($args) == 4) {
			$options['icon'] 	= $args[1];
			$options['action'] 	= $args[2];
			$options['title'] 	= $args[3];
		}	
			
		$options = array_merge(array('name' => $name), $options);	
		
		// set some defaults
		if (!array_key_exists('icon', $options)) {
			$options['icon'] = ''; 
		}
		
		if (!array_key_exists('action', $options)) {
			$options['action'] = ''; 
		}
		
		if (!array_key_exists('title', $options)) {
			$options['title'] = WFText::_('WF_BUTTON_' . strtoupper($name));
		}
			
		$this->_actions[$name] = $options;
	}
	/**
	 * Get all actions
	 * @return object
	 */
	function getActions()
	{
		return array_reverse($this->_actions);
	}
	/**
	 * Remove an action from the list by name
	 * @param string $name Action name to remove
	 */
	function removeAction($name)
	{
		if (array_key_exists($this->_actions[$name])) {
			unset($this->_actions[$name]);
		}
	}

	/**
	 * Create all standard buttons based on access
	 */
	function getStdButtons()
	{
		$features = $this->get('features');
		
		if ($features['folder']['delete']) {
			$this->addButton('folder', 'delete', array('multiple' => true));

			$this->setRequest(array($this,'deleteItem'));
		}
		if ($features['folder']['rename']) {
			$this->addButton('folder', 'rename');

			$this->setRequest(array($this, 'renameItem'));
		}
		if ($features['folder']['move']) {
			$this->addButton('folder', 'copy', array('multiple' => true));
			$this->addButton('folder', 'cut', array('multiple' => true));

			$this->addButton('folder', 'paste', array('multiple' => true, 'trigger' => true));

			$this->setRequest(array($this,'copyItem'));
            $this->setRequest(array($this,'moveItem'));
		}
		if ($features['file']['rename']) {
			$this->addButton('file', 'rename');

			$this->setRequest(array($this, 'renameItem'));
		}
		if ($features['file']['delete']) {
			$this->addButton('file', 'delete', array('multiple' => true));

			$this->setRequest(array($this, 'deleteItem'));
		}
		if ($features['file']['move']) {
			$this->addButton('file', 'copy', array('multiple' => true));
			$this->addButton('file', 'cut', array('multiple' => true));

			$this->addButton('file', 'paste', array('multiple' => true, 'trigger' => true));

			$this->setRequest(array($this, 'copyItem'));
            $this->setRequest(array($this, 'moveItem'));
		}
		$this->addButton('file', 'view', array('restrict' => $this->getViewable()));
		$this->addButton('file', 'insert');
	}

	/**
	 * Add a button
	 *
	 * @param string $type[optional] Button type (file or folder)
	 * @param string $name Button name
	 * @param string $icon[optional] Button icon
	 * @param string $action[optional] Button action / function
	 * @param string $title Button title
	 * @param boolean $multiple[optional] Supports multiple file selection
	 * @param boolean $trigger[optional]
	 */
	function addButton($type = 'file', $name, $options = array())
	{			
		$options = array_merge(array('name' => $name), $options);	
		
		// set some defaults
		if (!array_key_exists('icon', $options)) {
			$options['icon'] = ''; 
		}
		
		if (!array_key_exists('action', $options)) {
			$options['action'] = ''; 
		}
		
		if (!array_key_exists('title', $options)) {
			$options['title'] = WFText::_('WF_BUTTON_' . strtoupper($name)); 
		}
		
		if (!array_key_exists('multiple', $options)) {
			$options['multiple'] = false; 
		}
		
		if (!array_key_exists('trigger', $options)) {
			$options['trigger'] = false; 
		}

		if (!array_key_exists('restrict', $options)) {
			$options['restrict'] = ''; 
		}
			
		$this->_buttons[$type][$name] = $options;
	}
	/**
	 * Return an object list of all buttons
	 * @return object
	 */
	function getButtons()
	{
		return $this->_buttons;
	}
	/**
	 * Remove a button
	 * @param string $type Button type
	 * @param string $name Button name
	 */
	function removeButton($type, $name)
	{
		if (array_key_exists($name, $this->_buttons[$type])) {
			unset($this->_buttons[$type][$name]);
		}
	}
	/**
	 * Change a buttons properties
	 * @param string $type Button type
	 * @param string $name Button name
	 * @param string $keys Button keys
	 */
	function changeButton($type, $name, $keys)
	{
		foreach ($keys as $key => $value) {
			if (isset($this->_buttons[$type][$name][$key])) {
				$this->_buttons[$type][$name][$key] = $value;
			}
		}
	}
	/**
	 * Add an event
	 * @param string $name Event name
	 * @param string $function Event function name
	 */
	function addEvent($name, $function)
	{
		$this->_events[$name] = $function;
	}
	/**
	 * Execute an event
	 * @return Evenet result
	 * @param object $name Event name
	 * @param array $args[optional] Optional arguments
	 */
	function fireEvent($name, $args = null)
	{
		if (array_key_exists($name, $this->_events)) {
			$event = $this->_events[$name];
			
			if (is_array($event)) {
				return call_user_func_array($event, $args);
			} else {
				return call_user_func($event, $args);	
			}

		}
		return $this->_result;
	}
	/**
	 * Get a file icon based on extension
	 * @return string Path to file icon
	 * @param string $ext File extension
	 */
	function getFileIcon($ext)
	{
		if (JFile::exists(WF_EDITOR_LIBRARIES . '/img/icons/' . $ext . '.gif')) {
			return $this->image('libraries.icons/' . $ext . '.gif');
		} elseif (JFile::exists($this->getPluginPath() . '/img/icons/' . $ext . '.gif')) {
			return $this->image('plugins.icons/' . $ext . '.gif');
		} else {
			return $this->image('libraries.icons/def.gif');
		}
	}

	function getFileSuffix()
	{
		$suffix = WFText::_('WF_MANAGER_FILE_SUFFIX');
		return str_replace('WF_MANAGER_FILE_SUFFIX', '_copy', $suffix);
	}

	function validateUploadedFile($file)
	{
		$chunks = JRequest::getInt('chunks', 1);
		
		if (!in_array(strtolower(JFile::getExt($file['name'])), $this->getFileTypes('array'))) {
			JError::raiseError(406, WFText::_('WF_MANAGER_UPLOAD_INVALID_EXT_ERROR'));
		}

		if (preg_match('#\.(jpeg|jpg|jpe|png|gif|wbmp|bmp|tiff|tif)$#i', $file['name'])) {
			if (@getimagesize($file['tmp_name']) === false) {
				JError::raiseError(403, WFText::_('WF_MANAGER_UPLOAD_INVALID_IMAGE_ERROR'));
			}
		}
		$upload = $this->get('upload');
				
		// validate if set and only if chunking disabled
		if ($upload['validate_mimetype'] && $chunks == 1) {
			wfimport('editor.libraries.classes.mime');	
				
			if (!WFMimeType::check($file['name'], $file['tmp_name'], $file['type'])) {
				JError::raiseError(403, WFText::_('WF_MANAGER_UPLOAD_INVALID_IMAGE_ERROR'));
			}
		}

		/** check for XSS
		 * From MediaHelper::canUpload
		 * @copyright Copyright (C) 2005 - 2010 Open Source Matters. All rights reserved.
		 **/

		$xss_check = JFile::read($file['tmp_name'], false, 256);

		// check for hidden php tags
		if (stristr($xss_check, '<?php')) {
			JError::raiseError(403, WFText::_('WF_MANAGER_UPLOAD_RESTRICTED_ERROR'));
		}

		$html_tags = array(
            'abbr',
            'acronym',
            'address',
            'applet',
            'area',
            'audioscope',
            'base',
            'basefont',
            'bdo',
            'bgsound',
            'big',
            'blackface',
            'blink',
            'blockquote',
            'body',
            'bq',
            'br',
            'button',
            'caption',
            'center',
            'cite',
            'code',
            'col',
            'colgroup',
            'comment',
            'custom',
            'dd',
            'del',
            'dfn',
            'dir',
            'div',
            'dl',
            'dt',
            'em',
            'embed',
            'fieldset',
            'fn',
            'font',
            'form',
            'frame',
            'frameset',
            'h1',
            'h2',
            'h3',
            'h4',
            'h5',
            'h6',
            'head',
            'hr',
            'html',
            'iframe',
            'ilayer',
            'img',
            'input',
            'ins',
            'isindex',
            'keygen',
            'kbd',
            'label',
            'layer',
            'legend',
            'li',
            'limittext',
            'link',
            'listing',
            'map',
            'marquee',
            'menu',
            'meta',
            'multicol',
            'nobr',
            'noembed',
            'noframes',
            'noscript',
            'nosmartquotes',
            'object',
            'ol',
            'optgroup',
            'option',
            'param',
            'plaintext',
            'pre',
            'rt',
            'ruby',
            's',
            'samp',
            'script',
            'select',
            'server',
            'shadow',
            'sidebar',
            'small',
            'spacer',
            'span',
            'strike',
            'strong',
            'style',
            'sub',
            'sup',
            'table',
            'tbody',
            'td',
            'textarea',
            'tfoot',
            'th',
            'thead',
            'title',
            'tr',
            'tt',
            'ul',
            'var',
            'wbr',
            'xml',
            'xmp',
            '!DOCTYPE',
            '!--'
            );

            foreach ($html_tags as $tag) {
            	// A tag is '<tagname ', so we need to add < and a space or '<tagname>'
            	if (stristr($xss_check, '<' . $tag . ' ') || stristr($xss_check, '<' . $tag . '>')) {
            		JError::raiseError(403, WFText::_('WF_MANAGER_UPLOAD_RESTRICTED_ERROR'));
            	}
            }

            return true;
	}

	/**
	 * Upload a file.
	 * @return array $error on failure or uploaded file name on success
	 */
	function upload()
	{
		// Check for request forgeries
		WFToken::checkToken() or die();
		
		$wf = WFEditor::getInstance();

		jimport('joomla.filesystem.file');

		// HTTP headers for no cache etc
		//header('Content-type: text/plain; charset=UTF-8');
		header("Expires: Wed, 4 Apr 1984 13:00:00 GMT");
		header("Last-Modified: " . gmdate("D, d M_Y H:i:s") . " GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");

		// get uploaded file
		$file = JRequest::getVar('file', '', 'files', 'array');

		// get file name
		$name 	= JRequest::getVar('name', $file['name']);
		$ext 	= JFile::getExt($name);

		// check for extension in file name
		if (preg_match('#\.(php|php(3|4|5)|phtml|pl|py|jsp|asp|htm|shtml|sh|cgi)#i', basename($name, '.' . $ext))) {
			JError::raiseError(403, 'RESTRICTED');
		}

		// get chunks
		$chunk  = JRequest::getInt('chunk', 0);
		$chunks = JRequest::getInt('chunks', 1);

		// create a filesystem result object
		$result = new WFFileSystemResult();

		$filesystem = $this->getFileSystem();
		$complete    = false;
		$contentType = JRequest::getVar('CONTENT_TYPE', '', 'SERVER');

		// Only multipart uploading is supported for now
		if ($contentType && strpos($contentType, "multipart") !== false) {
			if (isset($file['tmp_name']) && is_uploaded_file($file['tmp_name'])) {
				// validate file before continuing (first chunk only)
				if ($chunk == 0 && $wf->getParam('validate_mimetype', 0) && !preg_match('#(htm|html|txt)#', $ext)) {
					$this->validateUploadedFile($file);
				}				
				
				// make file name 'web safe'
				$name = WFUtility::makeSafe($name);

				// get current dir
				$dir  = JRequest::getVar('upload-dir', '');

				// Normal upload
				if ($chunks == 1) {
					$result = $filesystem->upload('multipart', trim($file['tmp_name']), $dir, $name);

					if (!$result->state) {
						$result->message = WFText::_('WF_MANAGER_UPLOAD_ERROR');
						$result->code = 103;
					}

					$complete = true;
					// Chunk uploading
				} else {
					$result = $filesystem->upload('multipart-chunking', trim($file['tmp_name']), $dir, $name, $chunks, $chunk);

					if (!$result->state) {
						$result->message = WFText::_('WF_MANAGER_UPLOAD_ERROR');
						$result->code = 103;
					}
					$complete = ($chunk == $chunks - 1);
				}
			}
		} else {
			$result->state   	= false;
			$result->code   	= 103;
			$result->message 	= WFText::_('WF_MANAGER_UPLOAD_ERROR');

			$complete = true;
		}
		// upload finished
		if ($complete) {
			
			if (is_a($result, 'WFFileSystemResult')) {
				if ($result->state === true) {										
					$this->setResult($this->fireEvent('onUpload', array($result->path)));					
					$this->setResult(basename($result->path), 'files');	
				}
			}

			die(json_encode($this->getResult()));
		}
	}

	/**
	 * Delete the relative file(s).
	 * @param $files the relative path to the file name or comma seperated list of multiple paths.
	 * @return string $error on failure.
	 */
	function deleteItem($items)
	{
		$filesystem = $this->getFileSystem();
		$items 		= explode(",", rawurldecode($items));

		foreach ($items as $item) {
			$result = $filesystem->delete($item);

			if (is_a($result, 'WFFileSystemResult')) {
				if (!$result->state) {
					if ($result->message) {
						$this->setResult($result->message, 'error');
					} else {
						$this->setResult(JText::sprintf('WF_MANAGER_DELETE_' . strtoupper($result->type) . '_ERROR', basename($item)), 'error');
					}
				} else {
					$this->setResult($this->fireEvent('on' . ucfirst($result->type) . 'Delete', array($item)));
					$this->setResult($item, $result->type);
				}
			}
		}

		return $this->getResult();
	}

	/**
	 * Rename a file.
	 * @param string $src The relative path of the source file
	 * @param string $dest The name of the new file
	 * @return string $error
	 */
	function renameItem()
	{
		$args 			= func_get_args();
		
		$source 		= array_shift($args);
		$destination	= array_shift($args);	
			
		$filesystem = $this->getFileSystem();
		$result 	= $filesystem->rename($source, trim($destination), $args);

		if (is_a($result, 'WFFileSystemResult')) {
			if (!$result->state) {
				$this->setResult(WFText::sprintf('WF_MANAGER_RENAME_' . strtoupper($result->type) . '_ERROR', basename($source)), 'error');
				if ($result->message) {
					$this->setResult($result->message, 'error');
				}
			} else {
				$this->setResult($this->fireEvent('on' . ucfirst($result->type) . 'Rename', array($destination)));
				$this->setResult($destination, $result->type);
			}
		}

		return $this->getResult();
	}

	/**
	 * Copy a file.
	 * @param string $files The relative file or comma seperated list of files
	 * @param string $dest The relative path of the destination dir
	 * @return string $error on failure
	 */
	function copyItem($items, $destination)
	{
		$filesystem = $this->getFileSystem();

		$items = explode(",", rawurldecode($items));

		foreach ($items as $item) {
			$result = $filesystem->copy($item, $destination);

			if (is_a($result, 'WFFileSystemResult')) {
				if (!$result->state) {
					if ($result->message) {
						$this->setResult($result->message, 'error');
					} else {
						$this->setResult(JText::sprintf('WF_MANAGER_COPY_' . strtoupper($result->type) . '_ERROR', basename($item)), 'error');
					}
				} else {
					$this->setResult($this->fireEvent('on' . ucfirst($result->type) . 'Copy', array($item)));
					$this->setResult($destination, $result->type);
				}
			}
		}
		return $this->getResult();
	}

	/**
	 * Copy a file.
	 * @param string $files The relative file or comma seperated list of files
	 * @param string $dest The relative path of the destination dir
	 * @return string $error on failure
	 */
	function moveItem($items, $destination)
	{
		$filesystem = $this->getFileSystem();

		$items = explode(",", rawurldecode($items));

		foreach ($items as $item) {
			$result = $filesystem->move($item, $destination);

			if (is_a($result, 'WFFileSystemResult')) {
				if (!$result->state) {
					if ($result->message) {
						$this->setResult($result->message, 'error');
					} else {
						$this->setResult(JText::sprintf('WF_MANAGER_MOVE_' . strtoupper($result->type) . '_ERROR', basename($item)), 'error');
					}
				} else {
					$this->setResult($this->fireEvent('on' . ucfirst($result->type) . 'Move', array($item)));
					$this->setResult($destination, $result->type);
				}
			}
		}
		return $this->getResult();
	}

	/**
	 * New folder base function. A wrapper for the JFolder::create function
	 * @param string $folder The folder to create
	 * @return boolean true on success
	 */
	function folderCreate($folder)
	{
		$filesystem = $this->getFileSystem();
		return $filesystem->folderCreate($folder);
	}

	/**
	 * New folder
	 * @param string $dir The base dir
	 * @param string $new_dir The folder to be created
	 * @return string $error on failure
	 */
	function folderNew()
	{
		$args 	= func_get_args();
		
		$dir 	= array_shift($args);
		$new	= array_shift($args);
			
		$filesystem = $this->getFileSystem();

		$result = $filesystem->createFolder($dir, trim($new), $args);

		if (is_a($result, 'WFFileSystemResult')) {
			if (!$result->state) {
				if ($result->message) {
					$this->setResult($result->message, 'error');
				} else {
					$this->setResult(JText::sprintf('WF_MANAGER_NEW_FOLDER_ERROR', basename($new)), 'error');
				}
			} else {
				$this->setResult($this->fireEvent('onFolderNew', array($new)));
			}
		}

		return $this->getResult();
	}
	
	function getUploadValue() {
		$upload = trim(ini_get('upload_max_filesize'));
		$post 	= trim(ini_get('post_max_size'));	
			
		$upload = $this->convertSize($upload);
		$post 	= $this->convertSize($post);
		
		if (intval($upload) <= intval($post)) {
			return $upload;
		}
		
		return $post;
	}
	
	/**
	 * Convert size value to bytes
	 */
	function convertSize($value)
	{		
		// Convert to bytes
		switch(strtolower($value{strlen($value)-1})) {
			case 'g':
				$value *= 1073741824;
				break;
			case 'm':
				$value *= 1048576;
				break;
			case 'k':
				$value *= 1024;
				break;
		}
		
		return $value;
	}

	function getUploadDefaults()
	{
		$filesystem = $this->getFileSystem();
		$features 	= $filesystem->get('upload');

		$upload_max	= $this->getUploadValue();
		
		$upload 	= $this->get('upload');

		$chunk_size = $upload_max ? $upload_max / 1024 . 'KB' : '1MB';
		$chunk_size = isset($upload['chunk_size']) ? $upload['chunk_size'] : $chunk_size;

		// chunking not yet supported in safe_mode, check base directory is writable and chunking supported by filesystem
		if (!$features['chunking']) {
			$chunk_size = 0;
		}
		
		// get upload size
		$size = intval(preg_replace('/[^0-9]/', '', $upload['max_size'])) . 'kb';
		
		// must not exceed server maximum
		if ((int)$size * 1024 > (int)$upload_max) {
			$size = $upload_max / 1024 . 'kb';
		}
		
		$runtimes = array();
		
		if (is_string($upload['runtimes'])) {
			$runtimes = explode(',', $upload['runtimes']);
		} else {
			foreach($upload['runtimes'] as $k => $v) {
				$runtimes[] = $v;
			}
		}
		
		// add html4
		$runtimes[] = 'html4';

		// remove flash runtime if $chunk_size is 0 (no chunking)
		if (!$chunk_size) {
			unset($runtimes[array_search('flash', $runtimes)]);
		}

		$defaults = array(
            'runtimes' 		=> implode(',', $runtimes),
            'size' 			=> $size,
            'filter' 		=> $this->mapUploadFileTypes(true),
            'chunk_size' 	=> $chunk_size
		);
		
		if (isset($features['dialog'])) {
			$defaults['dialog'] = $features['dialog'];
 		}

		return $defaults;
	}

	function getDimensions($file)
	{
		$filesystem = $this->getFileSystem();
		return $filesystem->getDimensions($file);
	}

	function getSettings($settings = array())
	{
		$filesystem = $this->getFileSystem();

		$default = array(
            'dir'		=> $filesystem->getRootDir(),
			'actions' 	=> $this->getActions(),
            'buttons' 	=> $this->getButtons(),
            'upload' 	=> $this->getUploadDefaults(),
            'tree' 		=> $this->get('folder_tree'),
            'listlimit' => $this->get('list_limit')
		);
		
		$properties = array('base', 'delete', 'rename', 'folder_new', 'copy', 'move');
		
		foreach($properties as $property) {
			if ($filesystem->get($property)) {
				$default[$property] = $filesystem->get($property);
			}
		}

		$settings = array_merge_recursive($default, $settings);

		return $settings;
	}
}
?>