CREATE TABLE IF NOT EXISTS `banners` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `theme` varchar(255) COLLATE utf8_bin NOT NULL,
  `code` text COLLATE utf8_bin NOT NULL,
  `protect` varchar(3) COLLATE utf8_bin NOT NULL,
  `lang` varchar(3) COLLATE utf8_bin NOT NULL,
  `time` varchar(50) COLLATE utf8_bin NOT NULL,
  `author` varchar(255) COLLATE utf8_bin NOT NULL,
  `side` varchar(50) COLLATE utf8_bin NOT NULL,
  `position` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=0;

CREATE TABLE IF NOT EXISTS `config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_bin NOT NULL,
  `keyword` text COLLATE utf8_bin NOT NULL,
  `description` text COLLATE utf8_bin NOT NULL,
  `enable` varchar(1) COLLATE utf8_bin NOT NULL,
  `ajax` varchar(2) COLLATE utf8_bin NOT NULL,
  `backup_email` varchar(255) COLLATE utf8_bin NOT NULL,
  `admin_email` varchar(255) COLLATE utf8_bin NOT NULL,
  `registered_user_mail` varchar(1) COLLATE utf8_bin NOT NULL,
  `items_onpage` int(2) NOT NULL,
  `main_page` varchar(255) COLLATE utf8_bin NOT NULL,
  `auto_backup` int(2) NOT NULL,
  `copyright` varchar(255) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=0;


CREATE TABLE IF NOT EXISTS `menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_bin NOT NULL,
  `protect` varchar(6) COLLATE utf8_bin NOT NULL,
  `lang` varchar(6) COLLATE utf8_bin NOT NULL,
  `type` varchar(255) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=0;


CREATE TABLE IF NOT EXISTS `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `theme` varchar(255) COLLATE utf8_bin NOT NULL,
  `short_text` text COLLATE utf8_bin NOT NULL,
  `full_text` text COLLATE utf8_bin NOT NULL,
  `protect` varchar(3) COLLATE utf8_bin NOT NULL,
  `lang` varchar(3) COLLATE utf8_bin NOT NULL,
  `author` varchar(255) COLLATE utf8_bin NOT NULL,
  `time` varchar(50) COLLATE utf8_bin NOT NULL,
  `comment` varchar(3) COLLATE utf8_bin NOT NULL,
  `url` varchar(255) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=0;

CREATE TABLE IF NOT EXISTS `pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `theme` varchar(255) COLLATE utf8_bin NOT NULL,
  `text` text COLLATE utf8_bin NOT NULL,
  `protect` varchar(3) COLLATE utf8_bin NOT NULL,
  `lang` varchar(3) COLLATE utf8_bin NOT NULL,
  `time` varchar(50) COLLATE utf8_bin NOT NULL,
  `author` varchar(255) COLLATE utf8_bin NOT NULL,
  `comment` varchar(3) COLLATE utf8_bin NOT NULL,
  `url` varchar(255) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=0;

CREATE TABLE IF NOT EXISTS `route` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_bin NOT NULL,
  `desc` varchar(255) COLLATE utf8_bin NOT NULL,
  `menu_id` int(11) NOT NULL,
  `route` varchar(255) COLLATE utf8_bin NOT NULL,
  `position` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=0;

CREATE TABLE IF NOT EXISTS `statistic` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(100) COLLATE utf8_bin NOT NULL,
  `date` varchar(40) COLLATE utf8_bin NOT NULL,
  `referer` varchar(255) COLLATE utf8_bin NOT NULL,
  `country` varchar(255) COLLATE utf8_bin NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=0;

CREATE TABLE IF NOT EXISTS `updates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `message` text COLLATE utf8_bin NOT NULL,
  `protect` varchar(30) COLLATE utf8_bin NOT NULL,
  `time` varchar(80) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=0;

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(255) COLLATE utf8_bin NOT NULL,
  `password` varchar(255) COLLATE utf8_bin NOT NULL,
  `email` varchar(255) COLLATE utf8_bin NOT NULL,
  `name` varchar(255) COLLATE utf8_bin NOT NULL,
  `sename` varchar(255) COLLATE utf8_bin NOT NULL,
  `country` varchar(255) COLLATE utf8_bin NOT NULL,
  `city` varchar(255) COLLATE utf8_bin NOT NULL,
  `phone` varchar(255) COLLATE utf8_bin NOT NULL,
  `online` varchar(80) COLLATE utf8_bin NOT NULL,
  `code_user` varchar(255) COLLATE utf8_bin NOT NULL,
  `status` varchar(30) COLLATE utf8_bin NOT NULL,
  `hash` varchar(255) COLLATE utf8_bin NOT NULL,
  `last_login` varchar(80) COLLATE utf8_bin NOT NULL,
  `date_register` varchar(80) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=0;
