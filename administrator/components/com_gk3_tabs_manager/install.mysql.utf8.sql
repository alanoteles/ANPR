DROP TABLE IF EXISTS `#__gk3_tabs_manager_groups`;
DROP TABLE IF EXISTS `#__gk3_tabs_manager_tabs`;
DROP TABLE IF EXISTS `#__gk3_tabs_manager_options`;

CREATE TABLE `#__gk3_tabs_manager_groups` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(128) NOT NULL,
  `desc` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE `#__gk3_tabs_manager_tabs` (
  `id` int(11) NOT NULL auto_increment,
  `group_id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `type` varchar(32) NOT NULL,
  `content` text NOT NULL,
  `published` int(2) NOT NULL,
  `access` int(1) NOT NULL,
  `order` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE `#__gk3_tabs_manager_options` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(128) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

INSERT INTO `#__gk3_tabs_manager_options` (`id`, `name`, `value`) VALUES
(1, 'modal_news', '0'),
(2, 'modal_settings', '1'),
(3, 'group_shortcuts', '1'),
(4, 'tab_shortcuts', '1'),
(5, 'wysiwyg', '1'),
(6, 'gavick_news', '1'),
(7, 'article_id', '0');