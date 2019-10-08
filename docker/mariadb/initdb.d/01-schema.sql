CREATE TABLE IF NOT EXISTS `adhoc_alerting` (
  `id_alerting` int(11) NOT NULL AUTO_INCREMENT,
  `id_contact` int(11) NOT NULL,
  `created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `active` tinyint(1) NOT NULL,
  `type` char(1) NOT NULL,
  `id_content` int(11) NOT NULL,
  PRIMARY KEY (`id_alerting`)
);

CREATE TABLE IF NOT EXISTS `adhoc_appartient_a` (
  `id_contact` int(11) NOT NULL DEFAULT '0',
  `id_groupe` int(11) NOT NULL DEFAULT '0',
  `id_type_musicien` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_contact`,`id_groupe`,`id_type_musicien`)
);

CREATE TABLE IF NOT EXISTS `adhoc_audio` (
  `id_audio` int(11) NOT NULL AUTO_INCREMENT,
  `id_contact` int(11) NOT NULL DEFAULT '1',
  `id_groupe` int(11) NOT NULL DEFAULT '0',
  `id_lieu` int(11) NOT NULL DEFAULT '0',
  `id_event` int(11) NOT NULL DEFAULT '0',
  `id_structure` int(11) NOT NULL DEFAULT '0',
  `name` varchar(250) NOT NULL,
  `created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_on` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `online` tinyint(1) NOT NULL DEFAULT '0',
  `mime` varchar(100) NOT NULL,
  PRIMARY KEY (`id_audio`),
  KEY `id_groupe` (`id_groupe`),
  KEY `id_lieu` (`id_lieu`),
  KEY `id_structure` (`id_structure`),
  KEY `id_contact` (`id_contact`),
  KEY `hash` (`mime`),
  KEY `id_event` (`id_event`)
);

CREATE TABLE IF NOT EXISTS `adhoc_cms` (
  `id_cms` int(11) NOT NULL AUTO_INCREMENT,
  `alias` varchar(64) NOT NULL,
  `menuselected` varchar(16) NOT NULL,
  `breadcrumb` varchar(250) NOT NULL,
  `title` varchar(100) NOT NULL,
  `created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_on` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `content` longtext NOT NULL,
  `online` tinyint(1) NOT NULL,
  `auth` int(11) NOT NULL,
  PRIMARY KEY (`id_cms`),
  UNIQUE KEY `alias` (`alias`)
);

CREATE TABLE IF NOT EXISTS `adhoc_comment` (
  `id_comment` int(11) NOT NULL AUTO_INCREMENT,
  `type` char(1) NOT NULL,
  `id_content` int(11) NOT NULL,
  `created_on` datetime DEFAULT CURRENT_TIMESTAMP,
  `modified_on` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `online` tinyint(1) NOT NULL,
  `id_contact` int(11) NOT NULL,
  `pseudo` varchar(50) DEFAULT NULL,
  `email` varchar(80) DEFAULT NULL,
  `text` text NOT NULL,
  PRIMARY KEY (`id_comment`)
);

CREATE TABLE IF NOT EXISTS `adhoc_contact` (
  `id_contact` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(150) DEFAULT NULL,
  `lastnl` datetime DEFAULT NULL,
  PRIMARY KEY (`id_contact`),
  UNIQUE KEY `email` (`email`)
);

CREATE TABLE IF NOT EXISTS `adhoc_event` (
  `id_event` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `date` datetime DEFAULT NULL,
  `text` text NOT NULL,
  `price` text NOT NULL,
  `online` tinyint(1) NOT NULL DEFAULT '0',
  `id_lieu` int(11) NOT NULL DEFAULT '0',
  `id_contact` int(11) NOT NULL DEFAULT '0',
  `facebook_event_id` char(20) NOT NULL,
  `facebook_event_attending` int(11) NOT NULL DEFAULT '0',
  `created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_on` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_event`),
  KEY `id_lieu` (`id_lieu`),
  KEY `id_contact` (`id_contact`)
);

CREATE TABLE IF NOT EXISTS `adhoc_event_style` (
  `id_event` int(11) NOT NULL DEFAULT '0',
  `id_style` int(11) NOT NULL DEFAULT '0',
  `ordre` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_event`,`id_style`)
);

CREATE TABLE IF NOT EXISTS `adhoc_exposant` (
  `id_exposant` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `site` varchar(100) NOT NULL,
  `type` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `description` mediumtext NOT NULL,
  `state` mediumtext NOT NULL,
  `created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_on` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_exposant`)
);

CREATE TABLE IF NOT EXISTS `adhoc_faq` (
  `id_faq` int(11) NOT NULL AUTO_INCREMENT,
  `id_category` int(11) NOT NULL,
  `question` varchar(255) NOT NULL,
  `answer` text NOT NULL,
  `created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_on` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_faq`),
  KEY `id_category` (`id_category`)
);

CREATE TABLE IF NOT EXISTS `adhoc_featured` (
  `id_featured` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `description` varchar(100) NOT NULL,
  `link` varchar(100) NOT NULL,
  `label` varchar(50) DEFAULT NULL,
  `datdeb` datetime NOT NULL,
  `datfin` datetime NOT NULL,
  `slot` int(11) NOT NULL,
  `online` tinyint(1) NOT NULL,
  PRIMARY KEY (`id_featured`)
);

CREATE TABLE IF NOT EXISTS `adhoc_forum_prive_info` (
  `id_forum` char(1) NOT NULL,
  `title` varchar(50) NOT NULL,
  `description` tinytext NOT NULL,
  `nb_messages` int(11) NOT NULL DEFAULT '0',
  `nb_threads` int(11) NOT NULL DEFAULT '0',
  `id_thread` int(11) DEFAULT NULL,
  `id_contact` int(11) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id_forum`)
);

CREATE TABLE IF NOT EXISTS `adhoc_forum_prive_message` (
  `id_message` int(11) NOT NULL AUTO_INCREMENT,
  `id_thread` int(11) NOT NULL,
  `created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_on` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `text` text NOT NULL,
  PRIMARY KEY (`id_message`),
  KEY `id_thread` (`id_thread`)
);

CREATE TABLE IF NOT EXISTS `adhoc_forum_prive_subscriber` (
  `id_forum` char(1) NOT NULL,
  `id_contact` int(11) NOT NULL,
  UNIQUE KEY `id_forum` (`id_forum`,`id_contact`)
);

CREATE TABLE IF NOT EXISTS `adhoc_forum_prive_thread` (
  `id_forum` char(1) NOT NULL,
  `id_thread` int(11) NOT NULL,
  `created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_on` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `nb_messages` int(11) NOT NULL DEFAULT '0',
  `nb_views` int(11) NOT NULL DEFAULT '0',
  `subject` varchar(200) NOT NULL,
  `online` tinyint(1) NOT NULL DEFAULT '0',
  `closed` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_thread`),
  KEY `id_forum` (`id_forum`)
);

CREATE TABLE IF NOT EXISTS `adhoc_groupe` (
  `id_groupe` int(11) NOT NULL AUTO_INCREMENT,
  `alias` varchar(50) DEFAULT NULL,
  `name` varchar(250) NOT NULL,
  `style` varchar(250) NOT NULL DEFAULT '',
  `influences` varchar(250) NOT NULL DEFAULT '',
  `lineup` text NOT NULL,
  `mini_text` tinytext NOT NULL,
  `text` text NOT NULL,
  `_email` varchar(250) NOT NULL DEFAULT '',
  `site` varchar(250) NOT NULL DEFAULT '',
  `myspace` varchar(100) DEFAULT NULL,
  `facebook_page_id` char(20) DEFAULT NULL,
  `twitter_id` varchar(50) NOT NULL,
  `id_departement` char(3) NOT NULL DEFAULT '',
  `online` tinyint(1) NOT NULL DEFAULT '0',
  `created_on` datetime DEFAULT CURRENT_TIMESTAMP,
  `modified_on` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `datdeb` date DEFAULT NULL,
  `datfin` date DEFAULT NULL,
  `comment` text NOT NULL,
  `etat` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_groupe`),
  UNIQUE KEY `alias` (`alias`),
  KEY `id_departement` (`id_departement`),
  KEY `facebook_page_id` (`facebook_page_id`)
);

CREATE TABLE IF NOT EXISTS `adhoc_groupe_style` (
  `id_groupe` int(11) NOT NULL DEFAULT '0',
  `id_style` int(11) NOT NULL DEFAULT '0',
  `ordre` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_groupe`,`id_style`)
);

CREATE TABLE IF NOT EXISTS `adhoc_lieu` (
  `id_lieu` int(11) NOT NULL AUTO_INCREMENT,
  `id_type` int(11) NOT NULL DEFAULT '1',
  `name` varchar(250) NOT NULL,
  `address` varchar(100) NOT NULL,
  `cp` varchar(10) NOT NULL DEFAULT '',
  `city` varchar(250) NOT NULL,
  `tel` varchar(50) NOT NULL DEFAULT '',
  `id_city` int(11) NOT NULL,
  `id_departement` char(3) NOT NULL DEFAULT '0',
  `id_region` char(2) NOT NULL,
  `text` text NOT NULL,
  `site` varchar(250) NOT NULL DEFAULT '',
  `email` varchar(250) NOT NULL DEFAULT '',
  `id_country` char(2) NOT NULL DEFAULT 'FR',
  `created_on` datetime DEFAULT CURRENT_TIMESTAMP,
  `modified_on` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `id_contact` int(11) NOT NULL DEFAULT '0',
  `online` tinyint(1) NOT NULL DEFAULT '0',
  `lat` float DEFAULT NULL,
  `lng` float DEFAULT NULL,
  `facebook_page_id` char(20) DEFAULT NULL,
  PRIMARY KEY (`id_lieu`),
  KEY `id_departement` (`id_departement`),
  KEY `id_pays` (`id_country`),
  KEY `lat` (`lat`,`lng`),
  KEY `id_region` (`id_region`)
);

CREATE TABLE IF NOT EXISTS `adhoc_log_action` (
  `datetime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `action` bigint(20) NOT NULL,
  `id_contact` int(11) NOT NULL,
  `ip` varchar(40) NOT NULL,
  `host` varchar(100) NOT NULL,
  `extra` tinytext
);

CREATE TABLE IF NOT EXISTS `adhoc_membre` (
  `id_contact` int(11) NOT NULL,
  `pseudo` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `last_name` varchar(250) NOT NULL,
  `first_name` varchar(250) NOT NULL,
  `address` varchar(250) NOT NULL,
  `cp` varchar(8) NOT NULL DEFAULT '',
  `city` varchar(50) NOT NULL,
  `country` varchar(30) NOT NULL,
  `id_city` int(11) NOT NULL,
  `id_departement` varchar(3) NOT NULL DEFAULT '0',
  `id_region` char(2) NOT NULL,
  `id_country` char(2) NOT NULL DEFAULT 'FR',
  `tel` varchar(20) NOT NULL DEFAULT '',
  `port` varchar(20) NOT NULL DEFAULT '',
  `site` varchar(80) NOT NULL DEFAULT '',
  `text` text NOT NULL,
  `_msn` varchar(50) NOT NULL DEFAULT '',
  `mailing` char(1) NOT NULL DEFAULT '1',
  `level` tinyint(4) NOT NULL DEFAULT '1',
  `created_on` datetime DEFAULT CURRENT_TIMESTAMP,
  `modified_on` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `visited_on` datetime DEFAULT NULL,
  PRIMARY KEY (`id_contact`),
  CONSTRAINT `fk_membre_contact`
    FOREIGN KEY (id_contact) REFERENCES adhoc_contact (id_contact)
    ON DELETE CASCADE
    ON UPDATE RESTRICT
);

CREATE TABLE IF NOT EXISTS `adhoc_membre_adhoc` (
  `id_contact` int(11) NOT NULL,
  `function` varchar(50) NOT NULL,
  `birth_date` date DEFAULT NULL,
  `datdeb` date DEFAULT NULL,
  `datfin` date DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `rank` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_contact`),
  CONSTRAINT `fk_membre_adhoc_membre`
    FOREIGN KEY (id_contact) REFERENCES adhoc_membre (id_contact)
    ON DELETE CASCADE
    ON UPDATE RESTRICT
);

CREATE TABLE IF NOT EXISTS `adhoc_messagerie` (
  `id_pm` int(11) NOT NULL AUTO_INCREMENT,
  `from` int(11) NOT NULL DEFAULT '0',
  `to` int(11) NOT NULL DEFAULT '0',
  `text` text NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `read` tinyint(1) NOT NULL DEFAULT '0',
  `del_from` tinyint(1) NOT NULL DEFAULT '0',
  `del_to` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_pm`),
  KEY `from` (`from`),
  KEY `to` (`to`),
  KEY `del_from` (`del_from`),
  KEY `del_to` (`del_to`)
);

CREATE TABLE IF NOT EXISTS `adhoc_newsletter` (
  `id_newsletter` tinyint(4) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `content` text NOT NULL,
  `html` text NOT NULL,
  PRIMARY KEY (`id_newsletter`)
);

CREATE TABLE IF NOT EXISTS `adhoc_newsletter_hit` (
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_newsletter` int(11) NOT NULL,
  `id_contact` int(11) NOT NULL,
  `url` varchar(150) NOT NULL,
  `ip` varchar(50) NOT NULL,
  `host` varchar(100) NOT NULL,
  `useragent` varchar(100) NOT NULL
);

CREATE TABLE IF NOT EXISTS `adhoc_organise_par` (
  `id_event` int(11) NOT NULL,
  `id_structure` int(11) NOT NULL,
  PRIMARY KEY (`id_event`,`id_structure`)
);

CREATE TABLE IF NOT EXISTS `adhoc_participe_a` (
  `id_event` int(11) NOT NULL,
  `id_groupe` int(11) NOT NULL,
  PRIMARY KEY (`id_event`,`id_groupe`)
);

CREATE TABLE IF NOT EXISTS `adhoc_photo` (
  `id_photo` int(11) NOT NULL AUTO_INCREMENT,
  `id_contact` int(11) NOT NULL DEFAULT '1',
  `id_groupe` int(11) NOT NULL DEFAULT '0',
  `id_lieu` int(11) NOT NULL DEFAULT '0',
  `id_event` int(11) NOT NULL DEFAULT '0',
  `id_structure` int(11) NOT NULL DEFAULT '0',
  `name` varchar(250) NOT NULL,
  `_height` int(11) NOT NULL DEFAULT '0',
  `_width` int(11) NOT NULL DEFAULT '0',
  `created_on` datetime DEFAULT CURRENT_TIMESTAMP,
  `modified_on` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `online` tinyint(1) NOT NULL DEFAULT '0',
  `credits` varchar(200) NOT NULL DEFAULT '',
  PRIMARY KEY (`id_photo`),
  KEY `id_groupe` (`id_groupe`),
  KEY `id_lieu` (`id_lieu`),
  KEY `id_structure` (`id_structure`),
  KEY `id_contact` (`id_contact`),
  KEY `id_event` (`id_event`)
);

CREATE TABLE IF NOT EXISTS `adhoc_statsnl` (
  `id_contact` int(11) NOT NULL,
  `email` varchar(100) NOT NULL DEFAULT '',
  `pseudo` varchar(50) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ip` varchar(30) NOT NULL DEFAULT '',
  `host` varchar(100) NOT NULL DEFAULT '',
  `useragent` varchar(100) NOT NULL DEFAULT '',
  `id_newsletter` int(11) NOT NULL
);

CREATE TABLE IF NOT EXISTS `adhoc_structure` (
  `id_structure` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  `address` tinytext NOT NULL,
  `cp` varchar(10) NOT NULL DEFAULT '',
  `city` varchar(250) NOT NULL,
  `tel` varchar(30) NOT NULL DEFAULT '',
  `id_departement` char(3) NOT NULL DEFAULT '0',
  `text` text NOT NULL,
  `site` varchar(250) NOT NULL DEFAULT '',
  `email` varchar(250) NOT NULL DEFAULT '',
  `id_country` char(2) NOT NULL DEFAULT 'FR',
  PRIMARY KEY (`id_structure`),
  KEY `id_departement` (`id_departement`),
  KEY `id_pays` (`id_country`)
);

CREATE TABLE IF NOT EXISTS `adhoc_style` (
  `id_style` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  PRIMARY KEY (`id_style`)
);

CREATE TABLE IF NOT EXISTS `adhoc_subscription` (
  `id_subscription` int(11) NOT NULL AUTO_INCREMENT,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `subscribed_at` date NOT NULL,
  `adult` tinyint(1) DEFAULT NULL,
  `amount` float NOT NULL DEFAULT '0',
  `first_name` varchar(250) DEFAULT NULL,
  `last_name` varchar(250) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `cp` varchar(10) DEFAULT '',
  `id_contact` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_subscription`),
  KEY `id_contact` (`id_contact`)
);

CREATE TABLE IF NOT EXISTS `adhoc_type_musicien` (
  `id_type_musicien` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  PRIMARY KEY (`id_type_musicien`)
);

CREATE TABLE IF NOT EXISTS `adhoc_video` (
  `id_video` int(11) NOT NULL AUTO_INCREMENT,
  `id_contact` int(11) NOT NULL DEFAULT '1',
  `id_host` tinyint(4) NOT NULL DEFAULT '1',
  `reference` varchar(50) NOT NULL DEFAULT '',
  `id_groupe` int(11) NOT NULL DEFAULT '0',
  `id_lieu` int(11) NOT NULL DEFAULT '0',
  `id_event` int(11) NOT NULL DEFAULT '0',
  `id_structure` int(11) NOT NULL DEFAULT '0',
  `name` varchar(250) NOT NULL,
  `text` mediumtext NOT NULL,
  `created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_on` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `online` tinyint(1) NOT NULL DEFAULT '0',
  `width` mediumint(9) NOT NULL DEFAULT '0',
  `height` mediumint(9) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_video`),
  KEY `id_groupe` (`id_groupe`),
  KEY `id_lieu` (`id_lieu`),
  KEY `id_structure` (`id_structure`),
  KEY `id_contact` (`id_contact`),
  KEY `id_event` (`id_event`)
);

CREATE TABLE IF NOT EXISTS `geo_fr_city` (
  `id_city` int(11) NOT NULL COMMENT 'code insee',
  `id_departement` char(3) NOT NULL,
  `cp` char(5) NOT NULL,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id_city`)
);

CREATE TABLE IF NOT EXISTS `geo_fr_departement` (
  `id_departement` char(3) NOT NULL,
  `id_world_region` char(2) NOT NULL,
  `id_region_insee` char(2) NOT NULL,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id_departement`),
  KEY `id_region_old` (`id_region_insee`)
);

CREATE TABLE IF NOT EXISTS `geo_world_country` (
  `id_country` char(2) NOT NULL,
  `name_fr` varchar(100) NOT NULL,
  `name_en` varchar(100) NOT NULL,
  `capname_fr` varchar(100) NOT NULL,
  `capname_en` varchar(100) NOT NULL,
  PRIMARY KEY (`id_country`)
);

CREATE TABLE IF NOT EXISTS `geo_world_region` (
  `id_country` char(2) NOT NULL,
  `id_region` char(2) NOT NULL,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id_country`,`id_region`)
);
