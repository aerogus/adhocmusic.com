CREATE TABLE `adhoc_alerting` (
  `id_alerting` int(11) NOT NULL,
  `id_contact` int(11) NOT NULL,
  `created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `active` tinyint(4) NOT NULL,
  `type` char(1) NOT NULL,
  `id_content` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `adhoc_appartient_a` (
  `id_contact` int(11) NOT NULL DEFAULT '0',
  `id_groupe` int(11) NOT NULL DEFAULT '0',
  `id_type_musicien` int(11) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `adhoc_audio` (
  `id_audio` int(11) NOT NULL,
  `id_contact` int(11) NOT NULL DEFAULT '1',
  `id_groupe` int(11) NOT NULL DEFAULT '0',
  `id_lieu` int(11) NOT NULL DEFAULT '0',
  `id_event` int(11) NOT NULL DEFAULT '0',
  `id_structure` int(11) NOT NULL DEFAULT '0',
  `name` varchar(250) NOT NULL,
  `created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_on` datetime DEFAULT NULL,
  `online` tinyint(1) NOT NULL DEFAULT '0',
  `mime` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `adhoc_cms` (
  `id_cms` int(11) NOT NULL,
  `alias` varchar(64) NOT NULL,
  `menuselected` varchar(16) NOT NULL,
  `breadcrumb` varchar(250) NOT NULL,
  `title` varchar(100) NOT NULL,
  `created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_on` datetime DEFAULT NULL,
  `content` longtext NOT NULL,
  `online` tinyint(4) NOT NULL,
  `auth` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `adhoc_comment` (
  `id_comment` int(11) NOT NULL,
  `type` char(1) NOT NULL,
  `id_content` int(11) NOT NULL,
  `created_on` datetime DEFAULT CURRENT_TIMESTAMP,
  `modified_on` datetime DEFAULT NULL,
  `online` tinyint(1) NOT NULL,
  `id_contact` int(11) NOT NULL,
  `pseudo` varchar(50) DEFAULT NULL,
  `email` varchar(80) DEFAULT NULL,
  `text` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `adhoc_contact` (
  `id_contact` int(11) NOT NULL,
  `email` varchar(150) DEFAULT NULL,
  `lastnl` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `adhoc_event` (
  `id_event` int(11) NOT NULL,
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
  `modified_on` datetime DEFAULT NULL,
  `nb_photos` int(11) NOT NULL DEFAULT '0',
  `nb_audios` int(11) NOT NULL DEFAULT '0',
  `nb_videos` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `adhoc_event_style` (
  `id_event` int(11) NOT NULL DEFAULT '0',
  `id_style` int(11) NOT NULL DEFAULT '0',
  `ordre` int(11) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `adhoc_exposant` (
  `id_exposant` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `site` varchar(100) NOT NULL,
  `type` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `description` mediumtext NOT NULL,
  `state` mediumtext NOT NULL,
  `created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_on` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `adhoc_faq` (
  `id_faq` int(11) NOT NULL,
  `id_category` int(11) NOT NULL,
  `question` varchar(255) CHARACTER SET latin1 NOT NULL,
  `answer` text CHARACTER SET latin1 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `adhoc_featured` (
  `id_featured` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `description` varchar(100) NOT NULL,
  `link` varchar(100) NOT NULL,
  `label` varchar(50) DEFAULT NULL,
  `datdeb` datetime NOT NULL,
  `datfin` datetime NOT NULL,
  `slot` int(11) NOT NULL,
  `online` tinyint(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `adhoc_forum_prive_info` (
  `id_forum` char(1) NOT NULL,
  `title` varchar(50) NOT NULL,
  `description` tinytext NOT NULL,
  `nb_messages` int(11) NOT NULL DEFAULT '0',
  `nb_threads` int(11) NOT NULL DEFAULT '0',
  `id_thread` int(11) DEFAULT NULL,
  `id_contact` int(11) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `adhoc_forum_prive_message` (
  `id_message` int(11) NOT NULL,
  `id_thread` int(11) NOT NULL,
  `created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_on` datetime DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `text` text CHARACTER SET utf8 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

CREATE TABLE `adhoc_forum_prive_subscriber` (
  `id_forum` char(1) NOT NULL,
  `id_contact` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `adhoc_forum_prive_thread` (
  `id_forum` char(1) NOT NULL,
  `id_thread` int(11) NOT NULL,
  `created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_on` datetime DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `nb_messages` int(11) NOT NULL DEFAULT '0',
  `nb_views` int(11) NOT NULL DEFAULT '0',
  `subject` varchar(200) NOT NULL,
  `online` tinyint(4) NOT NULL DEFAULT '1',
  `closed` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `adhoc_groupe` (
  `id_groupe` int(11) NOT NULL,
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
  `visite` int(11) NOT NULL DEFAULT '0',
  `created_on` datetime DEFAULT CURRENT_TIMESTAMP,
  `modified_on` datetime DEFAULT NULL,
  `cotised_on` datetime DEFAULT NULL,
  `datdeb` date DEFAULT NULL,
  `datfin` date DEFAULT NULL,
  `comment` text NOT NULL,
  `etat` int(11) NOT NULL DEFAULT '1',
  `template` tinytext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `adhoc_groupe_style` (
  `id_groupe` int(11) NOT NULL DEFAULT '0',
  `id_style` int(11) NOT NULL DEFAULT '0',
  `ordre` int(11) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `adhoc_lieu` (
  `id_lieu` int(11) NOT NULL,
  `id_type` int(11) NOT NULL DEFAULT '1',
  `name` varchar(250) NOT NULL,
  `address` varchar(100) NOT NULL,
  `cp` varchar(10) NOT NULL DEFAULT '',
  `city` varchar(250) NOT NULL,
  `tel` varchar(50) NOT NULL DEFAULT '',
  `fax` varchar(50) NOT NULL DEFAULT '',
  `id_city` int(11) NOT NULL,
  `id_departement` char(3) NOT NULL DEFAULT '0',
  `id_region` char(2) NOT NULL,
  `text` text NOT NULL,
  `site` varchar(250) NOT NULL DEFAULT '',
  `email` varchar(250) NOT NULL DEFAULT '',
  `id_country` char(2) NOT NULL DEFAULT 'FR',
  `created_on` datetime DEFAULT CURRENT_TIMESTAMP,
  `modified_on` datetime DEFAULT NULL,
  `id_contact` int(11) NOT NULL DEFAULT '0',
  `online` tinyint(4) NOT NULL DEFAULT '0',
  `lat` float DEFAULT NULL,
  `lng` float DEFAULT NULL,
  `facebook_page_id` char(20) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `adhoc_log_action` (
  `datetime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `action` bigint(20) NOT NULL,
  `id_contact` int(11) NOT NULL,
  `ip` varchar(40) NOT NULL,
  `host` varchar(100) NOT NULL,
  `extra` tinytext
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `adhoc_membre` (
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
  `_fax` varchar(20) NOT NULL DEFAULT '',
  `site` varchar(80) NOT NULL DEFAULT '',
  `text` text NOT NULL,
  `_msn` varchar(50) NOT NULL DEFAULT '',
  `mailing` char(1) NOT NULL DEFAULT '1',
  `level` tinyint(4) NOT NULL DEFAULT '1',
  `facebook_profile_id` bigint(20) UNSIGNED DEFAULT NULL,
  `facebook_access_token` text,
  `facebook_auto_login` tinyint(4) NOT NULL,
  `created_on` datetime DEFAULT CURRENT_TIMESTAMP,
  `modified_on` datetime DEFAULT NULL,
  `visited_on` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `adhoc_membre_adhoc` (
  `id_contact` int(11) NOT NULL DEFAULT '0',
  `function` varchar(50) NOT NULL,
  `birth_date` date DEFAULT NULL,
  `datdeb` date DEFAULT NULL,
  `datfin` date DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1',
  `rank` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `adhoc_messagerie` (
  `id_pm` int(11) NOT NULL,
  `from` int(11) NOT NULL DEFAULT '0',
  `to` int(11) NOT NULL DEFAULT '0',
  `text` text NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `read` tinyint(1) NOT NULL DEFAULT '0',
  `del_from` tinyint(1) NOT NULL DEFAULT '0',
  `del_to` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `adhoc_newsletter` (
  `id_newsletter` tinyint(4) NOT NULL,
  `title` varchar(100) NOT NULL,
  `content` text NOT NULL,
  `html` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

CREATE TABLE `adhoc_newsletter_hit` (
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_newsletter` int(11) NOT NULL,
  `id_contact` int(11) NOT NULL,
  `url` varchar(150) NOT NULL,
  `ip` varchar(50) NOT NULL,
  `host` varchar(100) NOT NULL,
  `useragent` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `adhoc_organise_par` (
  `id_event` int(11) NOT NULL,
  `id_structure` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `adhoc_participe_a` (
  `id_event` int(11) NOT NULL,
  `id_groupe` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `adhoc_photo` (
  `id_photo` int(11) NOT NULL,
  `id_contact` int(11) NOT NULL DEFAULT '1',
  `id_groupe` int(11) NOT NULL DEFAULT '0',
  `id_lieu` int(11) NOT NULL DEFAULT '0',
  `id_event` int(11) NOT NULL DEFAULT '0',
  `id_structure` int(11) NOT NULL DEFAULT '0',
  `name` varchar(250) NOT NULL,
  `_height` int(11) NOT NULL DEFAULT '0',
  `_width` int(11) NOT NULL DEFAULT '0',
  `created_on` datetime DEFAULT CURRENT_TIMESTAMP,
  `modified_on` datetime DEFAULT NULL,
  `online` tinyint(1) NOT NULL DEFAULT '0',
  `credits` varchar(200) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `adhoc_statsnl` (
  `id_contact` int(11) NOT NULL,
  `email` varchar(100) NOT NULL DEFAULT '',
  `pseudo` varchar(50) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ip` varchar(30) NOT NULL DEFAULT '',
  `host` varchar(100) NOT NULL DEFAULT '',
  `useragent` varchar(100) NOT NULL DEFAULT '',
  `id_newsletter` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `adhoc_structure` (
  `id_structure` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `address` tinytext NOT NULL,
  `cp` varchar(10) NOT NULL DEFAULT '',
  `city` varchar(250) NOT NULL,
  `tel` varchar(30) NOT NULL DEFAULT '',
  `fax` varchar(30) NOT NULL DEFAULT '',
  `id_departement` char(3) NOT NULL DEFAULT '0',
  `text` text NOT NULL,
  `site` varchar(250) NOT NULL DEFAULT '',
  `email` varchar(250) NOT NULL DEFAULT '',
  `id_country` char(2) NOT NULL DEFAULT 'FR'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `adhoc_video` (
  `id_video` int(11) NOT NULL,
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
  `modified_on` datetime DEFAULT NULL,
  `online` tinyint(1) NOT NULL DEFAULT '0',
  `width` mediumint(9) NOT NULL DEFAULT '0',
  `height` mediumint(9) NOT NULL DEFAULT '0',
  `nb_views` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `geo_fr_city` (
  `id_city` int(11) NOT NULL COMMENT 'code insee',
  `id_departement` char(3) NOT NULL,
  `cp` char(5) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `geo_fr_departement` (
  `id_departement` char(3) NOT NULL,
  `id_world_region` char(2) NOT NULL,
  `id_region_insee` char(2) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `geo_world_country` (
  `id_country` char(2) NOT NULL,
  `name_fr` varchar(100) NOT NULL,
  `name_en` varchar(100) NOT NULL,
  `capname_fr` varchar(100) NOT NULL,
  `capname_en` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `geo_world_region` (
  `id_country` char(2) NOT NULL,
  `id_region` char(2) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

ALTER TABLE `adhoc_alerting`
  ADD PRIMARY KEY (`id_alerting`);

ALTER TABLE `adhoc_appartient_a`
  ADD PRIMARY KEY (`id_contact`,`id_groupe`,`id_type_musicien`);

ALTER TABLE `adhoc_audio`
  ADD PRIMARY KEY (`id_audio`),
  ADD KEY `id_groupe` (`id_groupe`),
  ADD KEY `id_lieu` (`id_lieu`),
  ADD KEY `id_structure` (`id_structure`),
  ADD KEY `id_contact` (`id_contact`),
  ADD KEY `hash` (`mime`),
  ADD KEY `id_event` (`id_event`);

ALTER TABLE `adhoc_cms`
  ADD PRIMARY KEY (`id_cms`),
  ADD UNIQUE KEY `alias` (`alias`);

ALTER TABLE `adhoc_comment`
  ADD PRIMARY KEY (`id_comment`);

ALTER TABLE `adhoc_contact`
  ADD PRIMARY KEY (`id_contact`),
  ADD UNIQUE KEY `email` (`email`);

ALTER TABLE `adhoc_event`
  ADD PRIMARY KEY (`id_event`),
  ADD KEY `id_lieu` (`id_lieu`),
  ADD KEY `id_contact` (`id_contact`);

ALTER TABLE `adhoc_event_style`
  ADD PRIMARY KEY (`id_event`,`id_style`);

ALTER TABLE `adhoc_exposant`
  ADD PRIMARY KEY (`id_exposant`);

ALTER TABLE `adhoc_faq`
  ADD PRIMARY KEY (`id_faq`),
  ADD KEY `id_category` (`id_category`);

ALTER TABLE `adhoc_featured`
  ADD PRIMARY KEY (`id_featured`);

ALTER TABLE `adhoc_forum_prive_info`
  ADD PRIMARY KEY (`id_forum`);

ALTER TABLE `adhoc_forum_prive_message`
  ADD PRIMARY KEY (`id_message`),
  ADD KEY `id_thread` (`id_thread`);

ALTER TABLE `adhoc_forum_prive_subscriber`
  ADD UNIQUE KEY `id_forum` (`id_forum`,`id_contact`);

ALTER TABLE `adhoc_forum_prive_thread`
  ADD PRIMARY KEY (`id_thread`),
  ADD KEY `id_forum` (`id_forum`);

ALTER TABLE `adhoc_groupe`
  ADD PRIMARY KEY (`id_groupe`),
  ADD UNIQUE KEY `alias` (`alias`),
  ADD KEY `id_departement` (`id_departement`),
  ADD KEY `facebook_page_id` (`facebook_page_id`);

ALTER TABLE `adhoc_groupe_style`
  ADD PRIMARY KEY (`id_groupe`,`id_style`);

ALTER TABLE `adhoc_lieu`
  ADD PRIMARY KEY (`id_lieu`),
  ADD KEY `id_departement` (`id_departement`),
  ADD KEY `id_pays` (`id_country`),
  ADD KEY `lat` (`lat`,`lng`),
  ADD KEY `id_region` (`id_region`);

ALTER TABLE `adhoc_membre`
  ADD PRIMARY KEY (`id_contact`),
  ADD KEY `cp_membre` (`cp`),
  ADD KEY `facebook_uid` (`facebook_profile_id`);

ALTER TABLE `adhoc_membre_adhoc`
  ADD PRIMARY KEY (`id_contact`);

ALTER TABLE `adhoc_messagerie`
  ADD PRIMARY KEY (`id_pm`),
  ADD KEY `from` (`from`),
  ADD KEY `to` (`to`),
  ADD KEY `del_from` (`del_from`),
  ADD KEY `del_to` (`del_to`);

ALTER TABLE `adhoc_newsletter`
  ADD PRIMARY KEY (`id_newsletter`);

ALTER TABLE `adhoc_organise_par`
  ADD PRIMARY KEY (`id_event`,`id_structure`);

ALTER TABLE `adhoc_participe_a`
  ADD PRIMARY KEY (`id_event`,`id_groupe`);

ALTER TABLE `adhoc_photo`
  ADD PRIMARY KEY (`id_photo`),
  ADD KEY `id_groupe` (`id_groupe`),
  ADD KEY `id_lieu` (`id_lieu`),
  ADD KEY `id_structure` (`id_structure`),
  ADD KEY `id_contact` (`id_contact`),
  ADD KEY `id_event` (`id_event`);

ALTER TABLE `adhoc_structure`
  ADD PRIMARY KEY (`id_structure`),
  ADD KEY `id_departement` (`id_departement`),
  ADD KEY `id_pays` (`id_country`);

ALTER TABLE `adhoc_video`
  ADD PRIMARY KEY (`id_video`),
  ADD KEY `id_groupe` (`id_groupe`),
  ADD KEY `id_lieu` (`id_lieu`),
  ADD KEY `id_structure` (`id_structure`),
  ADD KEY `id_contact` (`id_contact`),
  ADD KEY `id_event` (`id_event`);

ALTER TABLE `geo_fr_city`
  ADD PRIMARY KEY (`id_city`);

ALTER TABLE `geo_fr_departement`
  ADD PRIMARY KEY (`id_departement`),
  ADD KEY `id_region_old` (`id_region_insee`);

ALTER TABLE `geo_world_country`
  ADD PRIMARY KEY (`id_country`);

ALTER TABLE `geo_world_region`
  ADD PRIMARY KEY (`id_country`,`id_region`);
