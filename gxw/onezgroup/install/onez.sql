-- --------------------------------------------------
  --
  -- onez SQL file for installation
  --
  -- --------------------------------------------------
  
DROP TABLE IF EXISTS onez_channel;
CREATE TABLE onez_channel (
  `id` int(11) NOT NULL auto_increment,
  `name` VARCHAR(50) NOT NULL DEFAULT '',
  `username` VARCHAR(50) NOT NULL DEFAULT '',
  `level` INT(11) NOT NULL DEFAULT '0',
  `maxusr` INT(11) NOT NULL DEFAULT '100',
  `allowguest` INT(1) NOT NULL DEFAULT '0',
  `forumid` INT(11) NOT NULL DEFAULT '0',
  `forumname` VARCHAR(50) DEFAULT NULL,
  `addtime` INT(11) NOT NULL DEFAULT '11',
  `exptime` INT(11) NOT NULL DEFAULT '11',
  `ifdefault` INT(11) NOT NULL DEFAULT '0',
  `ifonly` INT(1) NOT NULL DEFAULT '0',
  `masters` VARCHAR(200) DEFAULT NULL,
  `theme` VARCHAR(10) NOT NULL DEFAULT 'QQ2009',
  `savehistory` INT(1) NOT NULL DEFAULT '0',
  `lasttid` INT(11) NOT NULL DEFAULT '0',
  `lastday` VARCHAR(10) DEFAULT NULL,
  `notice` VARCHAR(1000) DEFAULT NULL,
  `word_in` VARCHAR(1000) DEFAULT NULL,
  `word_out` VARCHAR(1000) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS onez_group;
CREATE TABLE onez_group (
  `id` int(11) NOT NULL auto_increment,
  `channelid` INT(11) NOT NULL DEFAULT '0',
  `groupname` VARCHAR(50) NOT NULL DEFAULT '',
  `grades` VARCHAR(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;

DROP TABLE IF EXISTS onez_links;
CREATE TABLE onez_links (
  `id` int(11) NOT NULL auto_increment,
  `cid` INT(11) NOT NULL DEFAULT '0' Comment '所属群',
  `adpos` CHAR(20) DEFAULT NULL Comment '展示位置',
  `icon` CHAR(120) DEFAULT NULL Comment 'GIF图标',
  `title` CHAR(120) DEFAULT NULL Comment '链接文字',
  `linkurl` CHAR(120) DEFAULT NULL Comment '链接地址',
  `addtime` INT(11) NOT NULL DEFAULT '0' Comment '添加时间',
  `addip` CHAR(20) DEFAULT NULL Comment '添加者IP',
  `updatetime` INT(11) NOT NULL DEFAULT '0' Comment '修改时间',
  `endtime` INT(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;

DROP TABLE IF EXISTS onez_message;
CREATE TABLE onez_message (
  `id` int(11) NOT NULL auto_increment,
  `token` CHAR(20) NOT NULL DEFAULT '',
  `content` VARCHAR(500) NOT NULL DEFAULT '',
  `time` VARCHAR(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;

DROP TABLE IF EXISTS onez_robot;
CREATE TABLE onez_robot (
  `id` int(11) NOT NULL auto_increment,
  `botid` CHAR(20) NOT NULL DEFAULT '',
  `botname` VARCHAR(50) NOT NULL DEFAULT '',
  `readme` VARCHAR(200) DEFAULT NULL,
  `con` VARCHAR(1000) DEFAULT NULL,
  `lasttime` INT(11) NOT NULL DEFAULT '0',
  `lastuser` VARCHAR(50) DEFAULT NULL,
  `thecount` INT(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;

DROP TABLE IF EXISTS onez_users;
CREATE TABLE onez_users (
  `id` int(11) NOT NULL auto_increment,
  `uid` INT(11) NOT NULL DEFAULT '0',
  `groupid` INT(11) NOT NULL DEFAULT '0',
  `username` VARCHAR(50) NOT NULL DEFAULT '',
  `password` VARCHAR(32) DEFAULT NULL,
  `email` VARCHAR(200) NOT NULL DEFAULT '',
  `infotime` INT(11) NOT NULL DEFAULT '11',
  `infoip` VARCHAR(20) DEFAULT NULL,
  `timelength` INT(11) NOT NULL DEFAULT '0',
  `extcredits1` INT(11) NOT NULL DEFAULT '0',
  `extcredits2` INT(11) NOT NULL DEFAULT '0',
  `extcredits3` INT(11) NOT NULL DEFAULT '0',
  `extcredits4` INT(11) NOT NULL DEFAULT '0',
  `extcredits5` INT(11) NOT NULL DEFAULT '0',
  `extcredits6` INT(11) NOT NULL DEFAULT '0',
  `extcredits7` INT(11) NOT NULL DEFAULT '0',
  `extcredits8` INT(11) NOT NULL DEFAULT '0',
  `extcredits9` INT(11) NOT NULL DEFAULT '0',
  `extcredits10` INT(11) NOT NULL DEFAULT '0',
  `sex` INT(1) DEFAULT '0',
  `age` VARCHAR(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;
