CREATE TABLE IF NOT EXISTS `geo_fr_city` (
  `id_city` int(10) UNSIGNED NOT NULL COMMENT 'code insee',
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

CREATE TABLE `adhoc_lieu_type` (
  `id_lieu_type` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  PRIMARY KEY (`id_lieu_type`)
);

CREATE TABLE IF NOT EXISTS `adhoc_style` (
  `id_style` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  PRIMARY KEY (`id_style`)
);

CREATE TABLE IF NOT EXISTS `adhoc_type_musicien` (
  `id_type_musicien` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  PRIMARY KEY (`id_type_musicien`)
);

CREATE TABLE IF NOT EXISTS `adhoc_contact` (
  `id_contact` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `email` varchar(150) NOT NULL,
  `lastnl` datetime DEFAULT NULL,
  PRIMARY KEY (`id_contact`),
  UNIQUE KEY `email` (`email`)
);

CREATE TABLE IF NOT EXISTS `adhoc_membre` (
  `id_contact` int(10) UNSIGNED NOT NULL,
  `pseudo` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `last_name` varchar(250) NOT NULL,
  `first_name` varchar(250) NOT NULL,
  `address` varchar(250) DEFAULT NULL,
  `cp` varchar(8) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `country` varchar(30) DEFAULT NULL,
  `id_city` int(10) UNSIGNED DEFAULT NULL,
  `id_departement` varchar(3) DEFAULT NULL,
  `id_region` char(2) DEFAULT NULL,
  `id_country` char(2) DEFAULT NULL,
  `tel` varchar(20) DEFAULT NULL,
  `port` varchar(20) DEFAULT NULL,
  `site` varchar(80) DEFAULT NULL,
  `text` mediumtext DEFAULT NULL,
  `mailing` char(1) NOT NULL DEFAULT '1',
  `level` tinyint(4) NOT NULL DEFAULT '1',
  `created_on` datetime DEFAULT CURRENT_TIMESTAMP,
  `modified_on` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `visited_on` datetime DEFAULT NULL,
  PRIMARY KEY (`id_contact`),
  UNIQUE KEY `pseudo` (`pseudo`),
  CONSTRAINT `fk_membre_contact` FOREIGN KEY (`id_contact`) REFERENCES `adhoc_contact` (`id_contact`)
);

CREATE TABLE IF NOT EXISTS `adhoc_membre_adhoc` (
  `id_contact` int(10) UNSIGNED NOT NULL,
  `function` varchar(50) NOT NULL,
  `birth_date` date DEFAULT NULL,
  `datdeb` date DEFAULT NULL,
  `datfin` date DEFAULT NULL,
  `active` tinyint(1) UNSIGNED NOT NULL DEFAULT '1',
  `rank` tinyint(4) UNSIGNED NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_contact`),
  CONSTRAINT `fk_membre_adhoc_membre` FOREIGN KEY (`id_contact`) REFERENCES `adhoc_membre` (`id_contact`)
);

CREATE TABLE IF NOT EXISTS `adhoc_log_action` (
  `datetime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `action` int(10) UNSIGNED NOT NULL,
  `id_contact` int(10) UNSIGNED DEFAULT NULL,
  `ip` varchar(40) NOT NULL,
  `host` varchar(100) NOT NULL,
  `extra` mediumtext DEFAULT NULL,
  KEY `id_contact` (`id_contact`),
  CONSTRAINT `fk_log_action_contact` FOREIGN KEY (`id_contact`) REFERENCES `adhoc_contact` (`id_contact`)
);

CREATE TABLE IF NOT EXISTS `adhoc_subscription` (
  `id_subscription` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `subscribed_at` date NOT NULL,
  `adult` tinyint(1) UNSIGNED DEFAULT NULL,
  `amount` float UNSIGNED NOT NULL DEFAULT '0',
  `first_name` varchar(250) DEFAULT NULL,
  `last_name` varchar(250) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `cp` varchar(10) DEFAULT '',
  `id_contact` int(10) UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`id_subscription`),
  KEY `id_contact` (`id_contact`)
);

CREATE TABLE IF NOT EXISTS `adhoc_newsletter` (
  `id_newsletter` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `content` mediumtext NOT NULL,
  `html` mediumtext NOT NULL,
  PRIMARY KEY (`id_newsletter`)
);

CREATE TABLE IF NOT EXISTS `adhoc_newsletter_hit` (
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_newsletter` smallint(5) UNSIGNED NOT NULL,
  `id_contact` int(10) UNSIGNED NOT NULL,
  `url` varchar(150) NOT NULL,
  `ip` varchar(50) NOT NULL,
  `host` varchar(100) NOT NULL,
  `useragent` varchar(100) NOT NULL,
  KEY `id_newsletter` (`id_newsletter`),
  KEY `id_contact` (`id_contact`),
  CONSTRAINT `fk_newsletter_hit_newsletter` FOREIGN KEY (`id_newsletter`) REFERENCES `adhoc_newsletter` (`id_newsletter`),
  CONSTRAINT `fk_newsletter_hit_contact` FOREIGN KEY (`id_contact`) REFERENCES `adhoc_contact` (`id_contact`)
);

CREATE TABLE IF NOT EXISTS `adhoc_statsnl` (
  `id_contact` int(10) UNSIGNED NOT NULL,
  `email` varchar(100) NOT NULL DEFAULT '',
  `pseudo` varchar(50) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ip` varchar(30) NOT NULL DEFAULT '',
  `host` varchar(100) NOT NULL DEFAULT '',
  `useragent` varchar(100) NOT NULL DEFAULT '',
  `id_newsletter` smallint(5) UNSIGNED NOT NULL,
  KEY `id_contact` (`id_contact`),
  KEY `id_newsletter`(`id_newsletter`),
  CONSTRAINT `fk_statsnl_contact` FOREIGN KEY (`id_contact`) REFERENCES `adhoc_contact` (`id_contact`),
  CONSTRAINT `fk_statsnl_newsletter` FOREIGN KEY (`id_newsletter`) REFERENCES `adhoc_newsletter` (`id_newsletter`)
);

CREATE TABLE IF NOT EXISTS `adhoc_groupe` (
  `id_groupe` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `alias` varchar(50) NOT NULL,
  `name` varchar(250) NOT NULL,
  `style` varchar(250) NOT NULL DEFAULT '',
  `influences` varchar(250) NOT NULL DEFAULT '',
  `lineup` mediumtext NOT NULL,
  `mini_text` tinytext NOT NULL,
  `text` mediumtext NOT NULL,
  `_email` varchar(250) NOT NULL DEFAULT '',
  `site` varchar(250) NOT NULL DEFAULT '',
  `myspace` varchar(100) DEFAULT NULL,
  `facebook_page_id` char(20) DEFAULT NULL,
  `twitter_id` varchar(50) NOT NULL,
  `id_departement` char(3) NOT NULL DEFAULT '',
  `datdeb` date DEFAULT NULL,
  `datfin` date DEFAULT NULL,
  `comment` mediumtext NOT NULL,
  `etat` tinyint(3) UNSIGNED NOT NULL DEFAULT '1',
  `online` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `created_on` datetime DEFAULT CURRENT_TIMESTAMP,
  `modified_on` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_groupe`),
  UNIQUE KEY `alias` (`alias`),
  KEY `id_departement` (`id_departement`),
  KEY `facebook_page_id` (`facebook_page_id`),
  KEY `online` (`online`)
);

CREATE TABLE IF NOT EXISTS `adhoc_structure` (
  `id_structure` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
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

CREATE TABLE IF NOT EXISTS `adhoc_alerting` (
  `id_alerting` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_contact` int(10) UNSIGNED NOT NULL,
  `created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `active` tinyint(1) UNSIGNED NOT NULL,
  `type` char(1) NOT NULL,
  `id_content` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id_alerting`),
  KEY `id_contact` (`id_contact`),
  KEY `active` (`active`),
  CONSTRAINT `fk_alerting_contact` FOREIGN KEY (`id_contact`) REFERENCES `adhoc_membre` (`id_contact`)
);

CREATE TABLE IF NOT EXISTS `adhoc_cms` (
  `id_cms` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `alias` varchar(64) NOT NULL,
  `menuselected` varchar(16) NOT NULL,
  `breadcrumb` varchar(250) NOT NULL,
  `title` varchar(100) NOT NULL,
  `content` longtext NOT NULL,
  `auth` int(10) UNSIGNED NOT NULL,
  `online` tinyint(1) UNSIGNED NOT NULL,
  `created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_on` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_cms`),
  UNIQUE KEY `alias` (`alias`),
  KEY `online` (`online`)
);

CREATE TABLE IF NOT EXISTS `adhoc_comment` (
  `id_comment` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `type` char(1) NOT NULL,
  `id_content` int(10) UNSIGNED NOT NULL,
  `id_contact` int(10) UNSIGNED NOT NULL,
  `pseudo` varchar(50) DEFAULT NULL,
  `email` varchar(80) DEFAULT NULL,
  `text` mediumtext NOT NULL,
  `online` tinyint(1) UNSIGNED NOT NULL DEFAULT '1',
  `created_on` datetime DEFAULT CURRENT_TIMESTAMP,
  `modified_on` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_comment`),
  KEY `id_contact` (`id_contact`),
  KEY `online` (`online`),
  CONSTRAINT `fk_comment_membre` FOREIGN KEY (`id_contact`) REFERENCES `adhoc_membre` (`id_contact`)
);

CREATE TABLE IF NOT EXISTS `adhoc_lieu` (
  `id_lieu` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_type` int(10) UNSIGNED DEFAULT NULL,
  `name` varchar(250) NOT NULL,
  `address` varchar(100) NOT NULL,
  `cp` varchar(10) NOT NULL DEFAULT '',
  `city` varchar(250) NOT NULL,
  `tel` varchar(50) NOT NULL DEFAULT '',
  `id_city` int(10) UNSIGNED NOT NULL,
  `id_departement` char(3) NOT NULL DEFAULT '0',
  `id_region` char(2) NOT NULL,
  `text` mediumtext NOT NULL,
  `site` varchar(250) NOT NULL DEFAULT '',
  `email` varchar(250) NOT NULL DEFAULT '',
  `id_country` char(2) NOT NULL DEFAULT 'FR',
  `id_contact` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `lat` float DEFAULT NULL,
  `lng` float DEFAULT NULL,
  `facebook_page_id` char(20) DEFAULT NULL,
  `online` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `created_on` datetime DEFAULT CURRENT_TIMESTAMP,
  `modified_on` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_lieu`),
  KEY `id_departement` (`id_departement`),
  KEY `id_pays` (`id_country`),
  KEY `lat` (`lat`,`lng`),
  KEY `id_region` (`id_region`),
  KEY `online` (`online`),
  KEY `id_type` (`id_type`),
  CONSTRAINT `fk_lieu_lieu_type` FOREIGN KEY (`id_type`) REFERENCES `adhoc_lieu_type` (`id_lieu_type`),
);

CREATE TABLE IF NOT EXISTS `adhoc_event` (
  `id_event` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `date` datetime DEFAULT NULL,
  `text` text NOT NULL,
  `price` text NOT NULL,
  `id_lieu` int(10) UNSIGNED NOT NULL,
  `id_contact` int(10) UNSIGNED NOT NULL,
  `facebook_event_id` char(20) DEFAULT NULL,
  `facebook_event_attending` int(10) UNSIGNED DEFAULT NULL,
  `online` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_on` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_event`),
  KEY `id_lieu` (`id_lieu`),
  KEY `id_contact` (`id_contact`),
  KEY `online` (`online`),
  CONSTRAINT `fk_event_membre` FOREIGN KEY (`id_contact`) REFERENCES `adhoc_membre` (`id_contact`),
  CONSTRAINT `fk_event_lieu` FOREIGN KEY (`id_lieu`) REFERENCES `adhoc_lieu` (`id_lieu`)
);

CREATE TABLE IF NOT EXISTS `adhoc_exposant` (
  `id_exposant` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `site` varchar(100) NOT NULL,
  `type` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `description` mediumtext NOT NULL,
  `state` mediumtext NOT NULL,
  `online` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_on` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_exposant`),
  KEY `online` (`online`)
);

CREATE TABLE IF NOT EXISTS `adhoc_faq` (
  `id_faq` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_category` int(10) UNSIGNED NOT NULL,
  `question` varchar(255) NOT NULL,
  `answer` text NOT NULL,
  `online` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_on` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_faq`),
  KEY `id_category` (`id_category`),
  KEY `online` (`online`)
);

CREATE TABLE IF NOT EXISTS `adhoc_featured` (
  `id_featured` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `description` varchar(100) NOT NULL,
  `link` varchar(100) NOT NULL,
  `label` varchar(50) DEFAULT NULL,
  `datdeb` datetime NOT NULL,
  `datfin` datetime NOT NULL,
  `slot` int(10) UNSIGNED NOT NULL,
  `online` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_on` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_featured`),
  KEY `online` (`online`)
);

CREATE TABLE IF NOT EXISTS `adhoc_forum_prive_info` (
  `id_forum` char(1) NOT NULL,
  `title` varchar(50) NOT NULL,
  `description` tinytext NOT NULL,
  `nb_messages` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `nb_threads` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `id_thread` int(10) UNSIGNED DEFAULT NULL,
  `id_contact` int(10) UNSIGNED DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  PRIMARY KEY (`id_forum`),
  CONSTRAINT `fk_forum_membre` FOREIGN KEY (`id_contact`) REFERENCES `adhoc_membre` (`id_contact`)
);

CREATE TABLE IF NOT EXISTS `adhoc_forum_prive_thread` (
  `id_thread` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_forum` char(1) NOT NULL,
  `nb_messages` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `nb_views` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `subject` varchar(200) NOT NULL,
  `online` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `closed` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `modified_on` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(10) UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`id_thread`),
  KEY `id_forum` (`id_forum`),
  KEY `online` (`online`),
  CONSTRAINT `fk_forum_thread_forum` FOREIGN KEY (`id_forum`) REFERENCES `adhoc_forum_prive_info` (`id_forum`),
  CONSTRAINT `fk_forum_thread_created_by` FOREIGN KEY (`created_by`) REFERENCES `adhoc_membre` (`id_contact`),
  CONSTRAINT `fk_forum_thread_modified_by` FOREIGN KEY (`modified_by`) REFERENCES `adhoc_membre` (`id_contact`)
);

ALTER TABLE `adhoc_forum_prive_info`
  ADD CONSTRAINT `fk_forum_thread` FOREIGN KEY (`id_thread`) REFERENCES `adhoc_forum_prive_thread` (`id_thread`);

CREATE TABLE IF NOT EXISTS `adhoc_forum_prive_message` (
  `id_message` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_thread` int(10) UNSIGNED NOT NULL,
  `text` text NOT NULL,
  `created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `modified_on` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(10) UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`id_message`),
  KEY `id_thread` (`id_thread`),
  CONSTRAINT `fk_forum_message_thread` FOREIGN KEY (`id_thread`) REFERENCES `adhoc_forum_prive_thread` (`id_thread`),
  CONSTRAINT `fk_forum_message_created_by` FOREIGN KEY (`created_by`) REFERENCES `adhoc_membre` (`id_contact`),
  CONSTRAINT `fk_forum_message_modified_by` FOREIGN KEY (`modified_by`) REFERENCES `adhoc_membre` (`id_contact`)
);

CREATE TABLE IF NOT EXISTS `adhoc_forum_prive_subscriber` (
  `id_forum` char(1) NOT NULL,
  `id_contact` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id_forum`,`id_contact`),
  KEY `id_forum` (`id_forum`),
  KEY `id_contact` (`id_contact`),
  CONSTRAINT `fk_forum_subscriber_forum` FOREIGN KEY (`id_forum`) REFERENCES `adhoc_forum_prive_info` (`id_forum`),
  CONSTRAINT `fk_forum_subscriber_membre` FOREIGN KEY (`id_contact`) REFERENCES `adhoc_membre` (`id_contact`)
);

CREATE TABLE IF NOT EXISTS `adhoc_messagerie` (
  `id_pm` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_from` int(10) UNSIGNED NOT NULL,
  `id_to` int(10) UNSIGNED NOT NULL,
  `text` text NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `read_to` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `del_from` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `del_to` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_pm`),
  KEY `id_from` (`id_from`),
  KEY `id_to` (`id_to`),
  KEY `del_from` (`del_from`),
  KEY `del_to` (`del_to`),
  CONSTRAINT `fk_messagerie_from` FOREIGN KEY (`id_from`) REFERENCES `adhoc_membre` (`id_contact`),
  CONSTRAINT `fk_messagerie_to` FOREIGN KEY (`id_to`) REFERENCES `adhoc_membre` (`id_contact`)
);

CREATE TABLE IF NOT EXISTS `adhoc_audio` (
  `id_audio` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_contact` int(10) UNSIGNED NOT NULL,
  `id_groupe` int(10) UNSIGNED DEFAULT NULL,
  `id_lieu` int(10) UNSIGNED DEFAULT NULL,
  `id_event` int(10) UNSIGNED DEFAULT NULL,
  `id_structure` int(10) UNSIGNED DEFAULT NULL,
  `name` varchar(250) NOT NULL,
  `online` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_on` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_audio`),
  KEY `id_contact` (`id_contact`),
  KEY `id_groupe` (`id_groupe`),
  KEY `id_lieu` (`id_lieu`),
  KEY `id_event` (`id_event`),
  KEY `id_structure` (`id_structure`),
  KEY `online` (`online`),
  CONSTRAINT `fk_audio_membre` FOREIGN KEY (`id_contact`) REFERENCES `adhoc_membre` (`id_contact`),
  CONSTRAINT `fk_audio_event` FOREIGN KEY (`id_event`) REFERENCES `adhoc_event` (`id_event`),
  CONSTRAINT `fk_audio_groupe` FOREIGN KEY (`id_groupe`) REFERENCES `adhoc_groupe` (`id_groupe`),
  CONSTRAINT `fk_audio_lieu` FOREIGN KEY (`id_lieu`) REFERENCES `adhoc_lieu` (`id_lieu`),
  CONSTRAINT `fk_audio_structure` FOREIGN KEY (`id_structure`) REFERENCES `adhoc_structure` (`id_structure`)
);

CREATE TABLE IF NOT EXISTS `adhoc_photo` (
  `id_photo` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_contact` int(10) UNSIGNED NOT NULL,
  `id_groupe` int(10) UNSIGNED DEFAULT NULL,
  `id_lieu` int(10) UNSIGNED DEFAULT NULL,
  `id_event` int(10) UNSIGNED DEFAULT NULL,
  `id_structure` int(10) UNSIGNED DEFAULT NULL,
  `name` varchar(250) NOT NULL,
  `credits` varchar(200) NOT NULL DEFAULT '',
  `online` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `created_on` datetime DEFAULT CURRENT_TIMESTAMP,
  `modified_on` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_photo`),
  KEY `id_contact` (`id_contact`),
  KEY `id_groupe` (`id_groupe`),
  KEY `id_lieu` (`id_lieu`),
  KEY `id_event` (`id_event`),
  KEY `id_structure` (`id_structure`),
  KEY `online` (`online`),
  CONSTRAINT `fk_photo_membre` FOREIGN KEY (`id_contact`) REFERENCES `adhoc_membre` (`id_contact`),
  CONSTRAINT `fk_photo_groupe` FOREIGN KEY (`id_groupe`) REFERENCES `adhoc_groupe` (`id_groupe`),
  CONSTRAINT `fk_photo_lieu` FOREIGN KEY (`id_lieu`) REFERENCES `adhoc_lieu` (`id_lieu`),
  CONSTRAINT `fk_photo_event` FOREIGN KEY (`id_event`) REFERENCES `adhoc_event` (`id_event`),
  CONSTRAINT `fk_photo_structure` FOREIGN KEY (`id_structure`) REFERENCES `adhoc_structure` (`id_structure`)
);

CREATE TABLE IF NOT EXISTS `adhoc_video` (
  `id_video` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_contact` int(10) UNSIGNED NOT NULL,
  `id_host` tinyint(4) UNSIGNED NOT NULL,
  `reference` varchar(50) NOT NULL,
  `id_groupe` int(10) UNSIGNED DEFAULT NULL,
  `id_lieu` int(10) UNSIGNED DEFAULT NULL,
  `id_event` int(10) UNSIGNED DEFAULT NULL,
  `id_structure` int(10) UNSIGNED DEFAULT NULL,
  `name` varchar(250) NOT NULL,
  `text` mediumtext NOT NULL,
  `width` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `height` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `online` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_on` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_video`),
  KEY `id_contact` (`id_contact`),
  KEY `id_groupe` (`id_groupe`),
  KEY `id_lieu` (`id_lieu`),
  KEY `id_event` (`id_event`),
  KEY `id_structure` (`id_structure`),
  KEY `online` (`online`),
  CONSTRAINT `fk_video_membre` FOREIGN KEY (`id_contact`) REFERENCES `adhoc_membre` (`id_contact`),
  CONSTRAINT `fk_video_groupe` FOREIGN KEY (`id_groupe`) REFERENCES `adhoc_groupe` (`id_groupe`),
  CONSTRAINT `fk_video_lieu` FOREIGN KEY (`id_lieu`) REFERENCES `adhoc_lieu` (`id_lieu`),
  CONSTRAINT `fk_video_event` FOREIGN KEY (`id_event`) REFERENCES `adhoc_event` (`id_event`),
  CONSTRAINT `fk_video_structure` FOREIGN KEY (`id_structure`) REFERENCES `adhoc_structure` (`id_structure`)
);

CREATE TABLE IF NOT EXISTS `adhoc_appartient_a` (
  `id_contact` int(10) UNSIGNED NOT NULL,
  `id_groupe` int(10) UNSIGNED NOT NULL,
  `id_type_musicien` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id_contact`,`id_groupe`,`id_type_musicien`),
  KEY `contact_groupe` (`id_contact`,`id_groupe`) USING BTREE,
  KEY `id_contact` (`id_contact`),
  KEY `id_groupe` (`id_groupe`),
  KEY `id_type_musicien` (`id_type_musicien`),
  CONSTRAINT `fk_appartient_a_membre` FOREIGN KEY (`id_contact`) REFERENCES `adhoc_membre` (`id_contact`),
  CONSTRAINT `fk_appartient_a_groupe` FOREIGN KEY (`id_groupe`) REFERENCES `adhoc_groupe` (`id_groupe`),
  CONSTRAINT `fk_appartient_a_type_musicien` FOREIGN KEY (`id_type_musicien`) REFERENCES `adhoc_type_musicien` (`id_type_musicien`)
);

CREATE TABLE IF NOT EXISTS `adhoc_groupe_style` (
  `id_groupe` int(10) UNSIGNED NOT NULL,
  `id_style` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id_groupe`,`id_style`),
  KEY `id_groupe` (`id_groupe`),
  KEY `id_style` (`id_style`),
  CONSTRAINT `fk_groupe_style_groupe` FOREIGN KEY (`id_groupe`) REFERENCES `adhoc_groupe` (`id_groupe`),
  CONSTRAINT `fk_groupe_style_style` FOREIGN KEY (`id_style`) REFERENCES `adhoc_style` (`id_style`)
);

CREATE TABLE IF NOT EXISTS `adhoc_participe_a` (
  `id_event` int(10) UNSIGNED NOT NULL,
  `id_groupe` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id_event`,`id_groupe`),
  KEY `id_event` (`id_event`),
  KEY `id_groupe` (`id_groupe`),
  CONSTRAINT `fk_participe_a_event` FOREIGN KEY (`id_event`) REFERENCES `adhoc_event` (`id_event`),
  CONSTRAINT `fk_participe_a_groupe` FOREIGN KEY (`id_groupe`) REFERENCES `adhoc_groupe` (`id_groupe`)
);

CREATE TABLE IF NOT EXISTS `adhoc_event_style` (
  `id_event` int(10) UNSIGNED NOT NULL,
  `id_style` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id_event`,`id_style`),
  KEY `id_event` (`id_event`),
  KEY `id_style` (`id_style`),
  CONSTRAINT `fk_event_style_event` FOREIGN KEY (`id_event`) REFERENCES `adhoc_event` (`id_event`),
  CONSTRAINT `fk_event_style_style` FOREIGN KEY (`id_style`) REFERENCES `adhoc_style` (`id_style`)
);

CREATE TABLE IF NOT EXISTS `adhoc_organise_par` (
  `id_event` int(10) UNSIGNED NOT NULL,
  `id_structure` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id_event`,`id_structure`),
  KEY `id_event` (`id_event`),
  KEY `id_structure` (`id_structure`),
  CONSTRAINT `fk_organise_par_event` FOREIGN KEY (`id_event`) REFERENCES `adhoc_event` (`id_event`),
  CONSTRAINT `fk_organise_par_structure` FOREIGN KEY (`id_structure`) REFERENCES `adhoc_structure` (`id_structure`)
);
