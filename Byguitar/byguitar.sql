/*
SQLyog Enterprise - MySQL GUI v8.1 
MySQL - 5.1.49-community : Database - byguitar
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

CREATE DATABASE /*!32312 IF NOT EXISTS*/`byguitar` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `byguitar`;

/*Table structure for table `bg_access` */

DROP TABLE IF EXISTS `bg_access`;

CREATE TABLE `bg_access` (
  `role_id` smallint(6) unsigned NOT NULL,
  `node_id` smallint(6) unsigned NOT NULL,
  `level` tinyint(1) NOT NULL,
  `pid` smallint(6) NOT NULL,
  `module` varchar(50) DEFAULT NULL,
  KEY `groupId` (`role_id`),
  KEY `nodeId` (`node_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Table structure for table `bg_admin` */

DROP TABLE IF EXISTS `bg_admin`;

CREATE TABLE `bg_admin` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `account` varchar(100) COLLATE utf8_bin NOT NULL,
  `email` varchar(100) COLLATE utf8_bin NOT NULL,
  `nickname` varchar(60) CHARACTER SET utf8 NOT NULL,
  `password` char(32) CHARACTER SET utf8 NOT NULL,
  `flag` longtext CHARACTER SET utf8 NOT NULL,
  `logins` int(10) NOT NULL DEFAULT '0',
  `lastlogin` int(11) NOT NULL,
  `lastip` varchar(50) CHARACTER SET utf8 NOT NULL,
  `adduser` varchar(60) CHARACTER SET utf8 NOT NULL,
  `acceptip` varchar(50) CHARACTER SET utf8 NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=82 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Table structure for table `bg_album` */

DROP TABLE IF EXISTS `bg_album`;

CREATE TABLE `bg_album` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `gid` int(10) NOT NULL COMMENT '歌手id',
  `name` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '专辑名',
  `company` varchar(255) COLLATE utf8_bin NOT NULL,
  `issuetime` int(11) NOT NULL,
  `cover` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT 'album/albumface.jpg' COMMENT '封面',
  `date` int(11) NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=670 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Table structure for table `bg_albumcollected` */

DROP TABLE IF EXISTS `bg_albumcollected`;

CREATE TABLE `bg_albumcollected` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `aid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '专辑id',
  PRIMARY KEY (`id`),
  UNIQUE KEY `ut` (`uid`,`aid`)
) ENGINE=InnoDB AUTO_INCREMENT=93 DEFAULT CHARSET=utf8 COMMENT='用户收藏的专辑';

/*Table structure for table `bg_albumtab` */

DROP TABLE IF EXISTS `bg_albumtab`;

CREATE TABLE `bg_albumtab` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `albumid` int(10) NOT NULL,
  `tabid` int(10) NOT NULL,
  `tabname` varchar(255) CHARACTER SET utf8 NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT '0',
  `class` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Table structure for table `bg_blogcomment` */

DROP TABLE IF EXISTS `bg_blogcomment`;

CREATE TABLE `bg_blogcomment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(10) NOT NULL,
  `uname` varchar(60) CHARACTER SET utf8 NOT NULL,
  `sendid` int(10) NOT NULL,
  `sendtime` int(11) NOT NULL,
  `pid` int(10) NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT '0',
  `content` longtext CHARACTER SET utf8 NOT NULL,
  `reply` longtext CHARACTER SET utf8 NOT NULL,
  `redate` int(11) NOT NULL,
  `pldate` int(11) NOT NULL,
  `userip` varchar(50) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Table structure for table `bg_blogtopic` */

DROP TABLE IF EXISTS `bg_blogtopic`;

CREATE TABLE `bg_blogtopic` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `catid` int(10) NOT NULL,
  `scatid` int(10) NOT NULL,
  `uid` int(10) NOT NULL,
  `uname` varchar(60) CHARACTER SET utf8 NOT NULL,
  `title` varchar(255) CHARACTER SET utf8 NOT NULL,
  `content` longtext COLLATE utf8_bin NOT NULL,
  `posttime` int(11) NOT NULL,
  `child` int(10) NOT NULL,
  `hits` int(10) NOT NULL,
  `isview` tinyint(1) NOT NULL DEFAULT '1',
  `islock` tinyint(1) NOT NULL DEFAULT '0',
  `type` tinyint(1) NOT NULL DEFAULT '0',
  `lastpostime` int(11) NOT NULL,
  `isbest` tinyint(1) NOT NULL DEFAULT '0',
  `sokey` varchar(255) CHARACTER SET utf8 NOT NULL,
  `weather` int(10) NOT NULL,
  `visituser` varchar(255) CHARACTER SET utf8 NOT NULL,
  `shares` int(10) NOT NULL DEFAULT '0',
  `sharedate` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Table structure for table `bg_cdb_attachments` */

DROP TABLE IF EXISTS `bg_cdb_attachments`;

CREATE TABLE `bg_cdb_attachments` (
  `aid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `tid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `pid` int(10) unsigned NOT NULL DEFAULT '0',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
  `readperm` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `price` smallint(6) unsigned NOT NULL DEFAULT '0',
  `filename` char(100) NOT NULL DEFAULT '',
  `filetype` char(50) NOT NULL DEFAULT '',
  `filesize` int(10) unsigned NOT NULL DEFAULT '0',
  `attachment` char(100) NOT NULL DEFAULT '',
  `downloads` mediumint(8) NOT NULL DEFAULT '0',
  `isimage` tinyint(1) NOT NULL DEFAULT '0',
  `uid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `thumb` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `remote` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `width` smallint(6) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`aid`),
  KEY `tid` (`tid`),
  KEY `pid` (`pid`,`aid`),
  KEY `uid` (`uid`),
  KEY `dateline` (`dateline`,`isimage`,`downloads`)
) ENGINE=MyISAM AUTO_INCREMENT=16653 DEFAULT CHARSET=gbk;

/*Table structure for table `bg_cdb_forumfields` */

DROP TABLE IF EXISTS `bg_cdb_forumfields`;

CREATE TABLE `bg_cdb_forumfields` (
  `fid` smallint(6) unsigned NOT NULL DEFAULT '0',
  `description` text NOT NULL,
  `password` varchar(12) NOT NULL DEFAULT '',
  `icon` varchar(255) NOT NULL DEFAULT '',
  `postcredits` varchar(255) NOT NULL DEFAULT '',
  `replycredits` varchar(255) NOT NULL DEFAULT '',
  `getattachcredits` varchar(255) NOT NULL DEFAULT '',
  `postattachcredits` varchar(255) NOT NULL DEFAULT '',
  `digestcredits` varchar(255) NOT NULL DEFAULT '',
  `redirect` varchar(255) NOT NULL DEFAULT '',
  `attachextensions` varchar(255) NOT NULL DEFAULT '',
  `moderators` text NOT NULL,
  `rules` text NOT NULL,
  `threadtypes` text NOT NULL,
  `threadsorts` text NOT NULL,
  `viewperm` text NOT NULL,
  `postperm` text NOT NULL,
  `replyperm` text NOT NULL,
  `getattachperm` text NOT NULL,
  `postattachperm` text NOT NULL,
  `keywords` text NOT NULL,
  `supe_pushsetting` text NOT NULL,
  `formulaperm` text NOT NULL,
  `modrecommend` text NOT NULL,
  `tradetypes` text NOT NULL,
  `typemodels` mediumtext NOT NULL,
  `threadplugin` text NOT NULL,
  `extra` text NOT NULL,
  PRIMARY KEY (`fid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

/*Table structure for table `bg_cdb_forums` */

DROP TABLE IF EXISTS `bg_cdb_forums`;

CREATE TABLE `bg_cdb_forums` (
  `fid` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `fup` smallint(6) unsigned NOT NULL DEFAULT '0',
  `type` enum('group','forum','sub') NOT NULL DEFAULT 'forum',
  `name` char(50) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `displayorder` smallint(6) NOT NULL DEFAULT '0',
  `styleid` smallint(6) unsigned NOT NULL DEFAULT '0',
  `threads` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `posts` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `todayposts` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `lastpost` char(110) NOT NULL DEFAULT '',
  `allowsmilies` tinyint(1) NOT NULL DEFAULT '0',
  `allowhtml` tinyint(1) NOT NULL DEFAULT '0',
  `allowbbcode` tinyint(1) NOT NULL DEFAULT '0',
  `allowimgcode` tinyint(1) NOT NULL DEFAULT '0',
  `allowanonymous` tinyint(1) NOT NULL DEFAULT '0',
  `allowshare` tinyint(1) NOT NULL DEFAULT '0',
  `allowpostspecial` smallint(6) unsigned NOT NULL DEFAULT '0',
  `allowspecialonly` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `alloweditrules` tinyint(1) NOT NULL DEFAULT '0',
  `allowfeed` tinyint(1) NOT NULL DEFAULT '1',
  `recyclebin` tinyint(1) NOT NULL DEFAULT '0',
  `modnewposts` tinyint(1) NOT NULL DEFAULT '0',
  `jammer` tinyint(1) NOT NULL DEFAULT '0',
  `disablewatermark` tinyint(1) NOT NULL DEFAULT '0',
  `inheritedmod` tinyint(1) NOT NULL DEFAULT '0',
  `autoclose` smallint(6) NOT NULL DEFAULT '0',
  `forumcolumns` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `threadcaches` tinyint(1) NOT NULL DEFAULT '0',
  `alloweditpost` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `simple` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `allowmediacode` tinyint(1) NOT NULL DEFAULT '0',
  `allowtag` tinyint(1) NOT NULL DEFAULT '1',
  `modworks` tinyint(1) unsigned NOT NULL,
  `allowglobalstick` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`fid`),
  KEY `forum` (`status`,`type`,`displayorder`),
  KEY `fup` (`fup`)
) ENGINE=MyISAM AUTO_INCREMENT=109 DEFAULT CHARSET=gbk;

/*Table structure for table `bg_cdb_memberfields` */

DROP TABLE IF EXISTS `bg_cdb_memberfields`;

CREATE TABLE `bg_cdb_memberfields` (
  `uid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `nickname` varchar(30) NOT NULL DEFAULT '',
  `site` varchar(75) NOT NULL DEFAULT '',
  `alipay` varchar(50) NOT NULL DEFAULT '',
  `icq` varchar(12) NOT NULL DEFAULT '',
  `qq` varchar(12) NOT NULL DEFAULT '',
  `yahoo` varchar(40) NOT NULL DEFAULT '',
  `msn` varchar(100) NOT NULL DEFAULT '',
  `taobao` varchar(40) NOT NULL DEFAULT '',
  `location` varchar(30) NOT NULL DEFAULT '',
  `customstatus` varchar(30) NOT NULL DEFAULT '',
  `medals` text NOT NULL,
  `avatar` varchar(255) NOT NULL DEFAULT '',
  `avatarwidth` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `avatarheight` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `bio` text NOT NULL,
  `sightml` text NOT NULL,
  `ignorepm` text NOT NULL,
  `groupterms` text NOT NULL,
  `authstr` varchar(20) NOT NULL DEFAULT '',
  `spacename` varchar(40) NOT NULL DEFAULT '',
  `buyercredit` smallint(6) NOT NULL DEFAULT '0',
  `sellercredit` smallint(6) NOT NULL DEFAULT '0',
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

/*Table structure for table `bg_cdb_posts` */

DROP TABLE IF EXISTS `bg_cdb_posts`;

CREATE TABLE `bg_cdb_posts` (
  `pid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `fid` smallint(6) unsigned NOT NULL DEFAULT '0',
  `tid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `first` tinyint(1) NOT NULL DEFAULT '0',
  `author` varchar(15) NOT NULL DEFAULT '',
  `authorid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `subject` varchar(80) NOT NULL DEFAULT '',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
  `message` mediumtext NOT NULL,
  `useip` varchar(15) NOT NULL DEFAULT '',
  `invisible` tinyint(1) NOT NULL DEFAULT '0',
  `anonymous` tinyint(1) NOT NULL DEFAULT '0',
  `usesig` tinyint(1) NOT NULL DEFAULT '0',
  `htmlon` tinyint(1) NOT NULL DEFAULT '0',
  `bbcodeoff` tinyint(1) NOT NULL DEFAULT '0',
  `smileyoff` tinyint(1) NOT NULL DEFAULT '0',
  `parseurloff` tinyint(1) NOT NULL DEFAULT '0',
  `attachment` tinyint(1) NOT NULL DEFAULT '0',
  `rate` smallint(6) NOT NULL DEFAULT '0',
  `ratetimes` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`pid`),
  KEY `fid` (`fid`),
  KEY `authorid` (`authorid`),
  KEY `dateline` (`dateline`),
  KEY `invisible` (`invisible`),
  KEY `displayorder` (`tid`,`invisible`,`dateline`),
  KEY `first` (`tid`,`first`)
) ENGINE=MyISAM AUTO_INCREMENT=240605 DEFAULT CHARSET=gbk;

/*Table structure for table `bg_cdb_threads` */

DROP TABLE IF EXISTS `bg_cdb_threads`;

CREATE TABLE `bg_cdb_threads` (
  `tid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `fid` smallint(6) unsigned NOT NULL DEFAULT '0',
  `iconid` smallint(6) unsigned NOT NULL DEFAULT '0',
  `typeid` smallint(6) unsigned NOT NULL DEFAULT '0',
  `sortid` smallint(6) unsigned NOT NULL DEFAULT '0',
  `readperm` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `price` smallint(6) NOT NULL DEFAULT '0',
  `author` char(15) NOT NULL DEFAULT '',
  `authorid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `subject` char(80) NOT NULL DEFAULT '',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
  `lastpost` int(10) unsigned NOT NULL DEFAULT '0',
  `lastposter` char(15) NOT NULL DEFAULT '',
  `views` int(10) unsigned NOT NULL DEFAULT '0',
  `replies` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `displayorder` tinyint(1) NOT NULL DEFAULT '0',
  `highlight` tinyint(1) NOT NULL DEFAULT '0',
  `digest` tinyint(1) NOT NULL DEFAULT '0',
  `rate` tinyint(1) NOT NULL DEFAULT '0',
  `special` tinyint(1) NOT NULL DEFAULT '0',
  `attachment` tinyint(1) NOT NULL DEFAULT '0',
  `moderated` tinyint(1) NOT NULL DEFAULT '0',
  `closed` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `itemid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `supe_pushstatus` tinyint(1) NOT NULL DEFAULT '0',
  `sgid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `recommends` smallint(6) NOT NULL,
  `recommend_add` smallint(6) NOT NULL,
  `recommend_sub` smallint(6) NOT NULL,
  `heats` int(10) unsigned NOT NULL DEFAULT '0',
  `status` smallint(6) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`tid`),
  KEY `digest` (`digest`),
  KEY `displayorder` (`fid`,`displayorder`,`lastpost`),
  KEY `typeid` (`fid`,`typeid`,`displayorder`,`lastpost`),
  KEY `sgid` (`fid`,`sgid`),
  KEY `sortid` (`sortid`),
  KEY `recommends` (`recommends`),
  KEY `heats` (`heats`),
  KEY `authorid` (`authorid`)
) ENGINE=MyISAM AUTO_INCREMENT=30874 DEFAULT CHARSET=gbk;

/*Table structure for table `bg_comment` */

DROP TABLE IF EXISTS `bg_comment`;

CREATE TABLE `bg_comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) unsigned DEFAULT NULL COMMENT '货品id',
  `op_id` int(11) unsigned DEFAULT '0' COMMENT '订单商品id',
  `user_id` int(11) unsigned DEFAULT NULL COMMENT '用户id',
  `content` varchar(255) DEFAULT NULL COMMENT '评论内容',
  `commentscore` int(11) unsigned DEFAULT NULL COMMENT '评分(评价有评分，留言没有评分)',
  `commenttype` smallint(1) unsigned NOT NULL DEFAULT '0' COMMENT '类型：0，留言；1，评价',
  `usefultotal` int(11) unsigned DEFAULT '0' COMMENT '评价的有用总数',
  `create_time` int(11) unsigned DEFAULT NULL COMMENT '创建时间',
  `is_show` tinyint(1) unsigned DEFAULT '0' COMMENT '是否隐藏(1显示 0隐藏)',
  `is_del` tinyint(1) unsigned DEFAULT '0' COMMENT '是否删除(0显示 1删除)',
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='商品评论表';

/*Table structure for table `bg_config` */

DROP TABLE IF EXISTS `bg_config`;

CREATE TABLE `bg_config` (
  `id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL,
  `create_time` int(11) unsigned NOT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `name` varchar(30) NOT NULL,
  `type` tinyint(1) unsigned NOT NULL,
  `extra` varchar(255) NOT NULL,
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `sort` mediumint(5) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

/*Table structure for table `bg_diqu` */

DROP TABLE IF EXISTS `bg_diqu`;

CREATE TABLE `bg_diqu` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL COMMENT '地区名称',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='歌手地区';

/*Table structure for table `bg_flash` */

DROP TABLE IF EXISTS `bg_flash`;

CREATE TABLE `bg_flash` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `img` varchar(200) NOT NULL COMMENT '图片路径',
  `img_url` varchar(200) NOT NULL COMMENT '图片指向路径',
  `img_desc` varchar(100) NOT NULL COMMENT '图片说明',
  `img_type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '图片板块（1首页）',
  `img_sort` tinyint(1) NOT NULL DEFAULT '0' COMMENT '图片顺序',
  `create_time` int(11) DEFAULT '0' COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;

/*Table structure for table `bg_friend` */

DROP TABLE IF EXISTS `bg_friend`;

CREATE TABLE `bg_friend` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(10) NOT NULL,
  `fid` int(10) NOT NULL,
  `date` int(11) NOT NULL,
  `mod` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=55 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Table structure for table `bg_group` */

DROP TABLE IF EXISTS `bg_group`;

CREATE TABLE `bg_group` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `classid` int(10) NOT NULL,
  `groupname` varchar(255) CHARACTER SET utf8 NOT NULL,
  `groupinfo` varchar(255) CHARACTER SET utf8 NOT NULL,
  `appuid` int(10) NOT NULL,
  `appuname` varchar(60) CHARACTER SET utf8 NOT NULL,
  `unum` int(10) NOT NULL DEFAULT '0',
  `stats` tinyint(1) NOT NULL,
  `postnum` int(10) NOT NULL DEFAULT '0',
  `topicnum` int(10) NOT NULL DEFAULT '0',
  `todaynum` int(10) NOT NULL DEFAULT '0',
  `yesterdaynum` int(10) NOT NULL DEFAULT '0',
  `limit` int(10) NOT NULL DEFAULT '200',
  `date` int(11) NOT NULL,
  `passdate` int(11) NOT NULL,
  `visitdate` int(11) NOT NULL,
  `locked` tinyint(1) NOT NULL DEFAULT '0',
  `viewflag` tinyint(1) NOT NULL DEFAULT '0',
  `logo` varchar(255) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Table structure for table `bg_groupboard` */

DROP TABLE IF EXISTS `bg_groupboard`;

CREATE TABLE `bg_groupboard` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `boardname` varchar(255) CHARACTER SET utf8 NOT NULL,
  `boardinfo` varchar(255) CHARACTER SET utf8 NOT NULL,
  `face` varchar(255) CHARACTER SET utf8 NOT NULL,
  `topicnum` int(10) NOT NULL,
  `todaynum` int(10) NOT NULL,
  `postnum` int(10) NOT NULL,
  `rootid` int(10) NOT NULL,
  `loastpost` varchar(255) CHARACTER SET utf8 NOT NULL,
  `rules` varchar(500) CHARACTER SET utf8 NOT NULL,
  `boardstats` tinyint(1) NOT NULL DEFAULT '0',
  `date` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Table structure for table `bg_grouptopic` */

DROP TABLE IF EXISTS `bg_grouptopic`;

CREATE TABLE `bg_grouptopic` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8 NOT NULL,
  `groupid` int(10) NOT NULL,
  `boardid` int(10) NOT NULL,
  `pollid` int(10) NOT NULL,
  `locktopic` int(10) NOT NULL,
  `child` int(10) NOT NULL,
  `postuname` varchar(60) CHARACTER SET utf8 NOT NULL,
  `postuid` int(10) NOT NULL,
  `date` int(11) NOT NULL,
  `hits` int(10) NOT NULL,
  `expression` varchar(255) CHARACTER SET utf8 NOT NULL,
  `loastpost` varchar(255) CHARACTER SET utf8 NOT NULL,
  `istop` tinyint(1) NOT NULL DEFAULT '0',
  `lastposttime` int(11) NOT NULL,
  `isbest` tinyint(1) NOT NULL DEFAULT '0',
  `mode` tinyint(1) NOT NULL DEFAULT '0',
  `topicmode` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Table structure for table `bg_groupuser` */

DROP TABLE IF EXISTS `bg_groupuser`;

CREATE TABLE `bg_groupuser` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `groupid` int(10) NOT NULL,
  `uid` int(10) NOT NULL,
  `uname` varchar(60) CHARACTER SET utf8 NOT NULL,
  `islock` tinyint(1) NOT NULL DEFAULT '0',
  `intro` varchar(255) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Table structure for table `bg_manage_menu` */

DROP TABLE IF EXISTS `bg_manage_menu`;

CREATE TABLE `bg_manage_menu` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) DEFAULT NULL,
  `title` varchar(50) DEFAULT NULL,
  `url` varchar(100) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '0',
  `remark` varchar(255) DEFAULT NULL,
  `sort` smallint(6) DEFAULT NULL,
  `parent_id` smallint(6) DEFAULT NULL,
  `level` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `level` (`level`),
  KEY `pid` (`parent_id`),
  KEY `status` (`status`),
  KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=1322 DEFAULT CHARSET=utf8;

/*Table structure for table `bg_menu` */

DROP TABLE IF EXISTS `bg_menu`;

CREATE TABLE `bg_menu` (
  `id` mediumint(5) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(25) DEFAULT NULL,
  `name` varchar(25) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `type` int(11) NOT NULL DEFAULT '0',
  `sort` mediumint(5) unsigned DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `pid` mediumint(5) unsigned DEFAULT NULL,
  `level` tinyint(1) unsigned DEFAULT NULL,
  `target` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

/*Table structure for table `bg_msg` */

DROP TABLE IF EXISTS `bg_msg`;

CREATE TABLE `bg_msg` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sendid` int(10) NOT NULL,
  `sender` varchar(60) CHARACTER SET utf8 NOT NULL,
  `incetptid` int(10) NOT NULL,
  `incept` varchar(60) CHARACTER SET utf8 NOT NULL,
  `title` varchar(255) CHARACTER SET utf8 NOT NULL,
  `message` varchar(500) CHARACTER SET utf8 NOT NULL,
  `flag` tinyint(1) NOT NULL,
  `date` int(11) NOT NULL,
  `delr` tinyint(1) NOT NULL,
  `dels` tinyint(1) NOT NULL,
  `issend` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Table structure for table `bg_node` */

DROP TABLE IF EXISTS `bg_node`;

CREATE TABLE `bg_node` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `title` varchar(50) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '0',
  `remark` varchar(255) DEFAULT NULL,
  `sort` smallint(6) unsigned DEFAULT NULL,
  `pid` smallint(6) unsigned NOT NULL,
  `level` tinyint(1) unsigned NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT '0',
  `group_id` tinyint(3) unsigned DEFAULT '0',
  `module` varchar(25) NOT NULL,
  `is_show` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `level` (`level`),
  KEY `pid` (`pid`),
  KEY `status` (`status`),
  KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=60 DEFAULT CHARSET=utf8;

/*Table structure for table `bg_orderemail` */

DROP TABLE IF EXISTS `bg_orderemail`;

CREATE TABLE `bg_orderemail` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(60) CHARACTER SET utf8 NOT NULL,
  `date` int(11) NOT NULL,
  `ip` varchar(50) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=263 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Table structure for table `bg_ordersong` */

DROP TABLE IF EXISTS `bg_ordersong`;

CREATE TABLE `bg_ordersong` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `song` varchar(255) CHARACTER SET utf8 NOT NULL,
  `singer` varchar(60) CHARACTER SET utf8 NOT NULL,
  `times` int(10) NOT NULL DEFAULT '1',
  `date` int(11) NOT NULL,
  `zid` int(10) NOT NULL,
  `user` longtext CHARACTER SET utf8 NOT NULL,
  `ip` varchar(50) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=233 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Table structure for table `bg_pms` */

DROP TABLE IF EXISTS `bg_pms`;

CREATE TABLE `bg_pms` (
  `pmid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `msgfrom` varchar(15) CHARACTER SET gbk NOT NULL DEFAULT '',
  `msgfromid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `msgtoid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `folder` enum('inbox','outbox') CHARACTER SET gbk NOT NULL DEFAULT 'inbox',
  `new` tinyint(1) NOT NULL DEFAULT '0',
  `subject` varchar(75) CHARACTER SET gbk NOT NULL DEFAULT '',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
  `message` text CHARACTER SET gbk NOT NULL,
  `delstatus` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `related` int(10) unsigned NOT NULL DEFAULT '0',
  `fromappid` smallint(6) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`pmid`),
  KEY `msgtoid` (`msgtoid`),
  KEY `msgfromid` (`msgfromid`)
) ENGINE=MyISAM AUTO_INCREMENT=1829 DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC;

/*Table structure for table `bg_report` */

DROP TABLE IF EXISTS `bg_report`;

CREATE TABLE `bg_report` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` tinyint(1) NOT NULL,
  `report` longtext NOT NULL,
  `date` int(11) NOT NULL,
  `uid` int(10) NOT NULL,
  `uemail` varchar(100) NOT NULL,
  `ip` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

/*Table structure for table `bg_reportype` */

DROP TABLE IF EXISTS `bg_reportype`;

CREATE TABLE `bg_reportype` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `class` varchar(255) CHARACTER SET utf8 NOT NULL,
  `nums` int(19) NOT NULL DEFAULT '0',
  `date` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Table structure for table `bg_role` */

DROP TABLE IF EXISTS `bg_role`;

CREATE TABLE `bg_role` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `pid` smallint(6) DEFAULT NULL,
  `status` tinyint(1) unsigned DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `ename` varchar(5) DEFAULT NULL,
  `create_time` int(11) unsigned NOT NULL,
  `update_time` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `parentId` (`pid`),
  KEY `ename` (`ename`),
  KEY `status` (`status`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Table structure for table `bg_roleuser` */

DROP TABLE IF EXISTS `bg_roleuser`;

CREATE TABLE `bg_roleuser` (
  `role_id` mediumint(9) unsigned DEFAULT NULL,
  `user_id` char(32) DEFAULT NULL,
  KEY `group_id` (`role_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Table structure for table `bg_shop_config` */

DROP TABLE IF EXISTS `bg_shop_config`;

CREATE TABLE `bg_shop_config` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `attribute_name` varchar(50) DEFAULT NULL COMMENT '属性中文名',
  `attribute` varchar(50) DEFAULT NULL COMMENT '属性英文名',
  `value` varchar(50) DEFAULT NULL COMMENT '属性值',
  `add_time` int(10) DEFAULT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `bg_singer` */

DROP TABLE IF EXISTS `bg_singer`;

CREATE TABLE `bg_singer` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(60) CHARACTER SET utf8 NOT NULL,
  `sex` tinyint(1) NOT NULL COMMENT '1男2女3乐队',
  `face` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT 'singer/singerface.jpg',
  `style` int(10) NOT NULL,
  `alubmid` int(10) NOT NULL,
  `diqu` varchar(255) CHARACTER SET utf8 NOT NULL,
  `zimu` char(2) CHARACTER SET utf8 NOT NULL,
  `tabs` int(10) NOT NULL DEFAULT '0',
  `imgtabs` int(10) NOT NULL DEFAULT '0',
  `txttabs` int(10) NOT NULL DEFAULT '0',
  `gtptabs` int(10) NOT NULL DEFAULT '0',
  `views` int(10) NOT NULL DEFAULT '0',
  `ispass` tinyint(1) NOT NULL DEFAULT '0',
  `date` int(11) NOT NULL,
  `shares` int(10) NOT NULL DEFAULT '0',
  `sharedate` int(11) NOT NULL,
  `qita` varchar(255) COLLATE utf8_bin NOT NULL,
  `dangan` text COLLATE utf8_bin COMMENT '歌手档案',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=407 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Table structure for table `bg_singercollected` */

DROP TABLE IF EXISTS `bg_singercollected`;

CREATE TABLE `bg_singercollected` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `gid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '歌手id',
  PRIMARY KEY (`id`),
  UNIQUE KEY `ut` (`uid`,`gid`)
) ENGINE=InnoDB AUTO_INCREMENT=264 DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='用户收藏的歌手';

/*Table structure for table `bg_singerstyle` */

DROP TABLE IF EXISTS `bg_singerstyle`;

CREATE TABLE `bg_singerstyle` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL COMMENT '歌手风格名称',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='歌手风格';

/*Table structure for table `bg_song` */

DROP TABLE IF EXISTS `bg_song`;

CREATE TABLE `bg_song` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `song` varchar(255) CHARACTER SET utf8 NOT NULL,
  `singer` int(10) NOT NULL,
  `alubm` int(10) NOT NULL,
  `ci` varchar(60) CHARACTER SET utf8 NOT NULL,
  `qu` varchar(60) CHARACTER SET utf8 NOT NULL,
  `imgtab` int(10) NOT NULL DEFAULT '0',
  `txttab` int(10) NOT NULL DEFAULT '0',
  `gtptab` int(10) NOT NULL DEFAULT '0',
  `date` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Table structure for table `bg_store` */

DROP TABLE IF EXISTS `bg_store`;

CREATE TABLE `bg_store` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(10) NOT NULL,
  `type` tinyint(1) NOT NULL,
  `tabid` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Table structure for table `bg_tab` */

DROP TABLE IF EXISTS `bg_tab`;

CREATE TABLE `bg_tab` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sid` int(10) NOT NULL COMMENT '歌名id',
  `tabname` varchar(255) NOT NULL,
  `songname` varchar(255) NOT NULL,
  `gid` int(10) NOT NULL COMMENT '歌手id',
  `singer` varchar(60) NOT NULL,
  `aid` int(10) NOT NULL COMMENT '专辑id',
  `album` varchar(255) NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 img;1 gtd;2 txt',
  `tabfile` varchar(1024) NOT NULL COMMENT '谱文件地址',
  `author` varchar(60) NOT NULL,
  `oid` int(10) NOT NULL COMMENT '上传人id',
  `owner` varchar(60) NOT NULL,
  `ownerclass` tinyint(1) NOT NULL COMMENT '自建分类',
  `nandu` tinyint(1) NOT NULL COMMENT '难度',
  `class` tinyint(3) NOT NULL,
  `date` int(11) NOT NULL,
  `downs` int(10) NOT NULL DEFAULT '0',
  `views` int(10) NOT NULL DEFAULT '0',
  `ispass` tinyint(1) NOT NULL DEFAULT '0',
  `isbest` tinyint(1) NOT NULL DEFAULT '0',
  `shares` int(10) NOT NULL,
  `sharedate` int(11) NOT NULL,
  `paizi` varchar(20) DEFAULT NULL COMMENT '拍子',
  `paisu` varchar(20) DEFAULT NULL COMMENT '拍速',
  `diaoshi` varchar(20) DEFAULT NULL COMMENT '调式',
  `biandiaojia` tinyint(1) DEFAULT '0' COMMENT '变调夹',
  `is_double` tinyint(1) DEFAULT '0' COMMENT '单双吉他',
  `video_url` varchar(300) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL COMMENT '视频地址',
  `audio_url` varchar(300) DEFAULT NULL COMMENT '音频地址',
  `play_notice` varchar(500) DEFAULT NULL COMMENT '表演及编配提示',
  `praise` int(10) DEFAULT '0' COMMENT '赞',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1224 DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='谱子信息表';

/*Table structure for table `bg_tabclass` */

DROP TABLE IF EXISTS `bg_tabclass`;

CREATE TABLE `bg_tabclass` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `class` varchar(255) CHARACTER SET utf8 NOT NULL,
  `nums` int(19) NOT NULL DEFAULT '0',
  `date` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Table structure for table `bg_tabcollected` */

DROP TABLE IF EXISTS `bg_tabcollected`;

CREATE TABLE `bg_tabcollected` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `tid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '谱子id',
  PRIMARY KEY (`id`),
  UNIQUE KEY `ut` (`uid`,`tid`)
) ENGINE=InnoDB AUTO_INCREMENT=1462 DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='用户收藏的谱子';

/*Table structure for table `bg_ulog` */

DROP TABLE IF EXISTS `bg_ulog`;

CREATE TABLE `bg_ulog` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(10) NOT NULL,
  `uname` varchar(60) CHARACTER SET utf8 NOT NULL,
  `ulog` varchar(500) CHARACTER SET utf8 NOT NULL,
  `date` int(11) NOT NULL,
  `ip` varchar(50) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Table structure for table `bg_updatelog` */

DROP TABLE IF EXISTS `bg_updatelog`;

CREATE TABLE `bg_updatelog` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` char(100) NOT NULL,
  `updatelog` longtext NOT NULL,
  `date` int(11) NOT NULL,
  `uid` int(10) NOT NULL,
  `uemail` varchar(100) NOT NULL,
  `ip` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

/*Table structure for table `bg_user` */

DROP TABLE IF EXISTS `bg_user`;

CREATE TABLE `bg_user` (
  `id` bigint(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户id',
  `username` varchar(60) DEFAULT NULL COMMENT '用户名',
  `password` char(32) DEFAULT NULL COMMENT '密码',
  `email` varchar(50) DEFAULT NULL,
  `sex` smallint(1) unsigned zerofill DEFAULT '1',
  `birthday` int(11) DEFAULT NULL,
  `mobile` varchar(11) DEFAULT NULL,
  `qq` varchar(11) DEFAULT NULL,
  `province` varchar(50) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `county` varchar(50) DEFAULT NULL,
  `topics` int(10) DEFAULT '0',
  `tabs` int(10) DEFAULT '0',
  `videos` int(10) DEFAULT '0',
  `friends` int(10) DEFAULT '0',
  `sign` text,
  `face` tinyint(255) DEFAULT '0',
  `info` longtext,
  `style` varchar(255) DEFAULT NULL COMMENT '风格',
  `favstar` varchar(60) DEFAULT NULL,
  `guitar` varchar(60) DEFAULT NULL,
  `ptime` varchar(60) DEFAULT NULL,
  `class` varchar(20) DEFAULT NULL,
  `group` varchar(50) DEFAULT NULL,
  `power` int(10) DEFAULT '0',
  `wealth` int(10) DEFAULT '0',
  `question` varchar(60) DEFAULT NULL,
  `answer` varchar(60) DEFAULT NULL,
  `regtime` int(11) DEFAULT NULL,
  `lastlogin` int(11) DEFAULT NULL,
  `logins` int(10) DEFAULT '0',
  `views` int(10) DEFAULT '0',
  `islock` tinyint(1) DEFAULT '1',
  `isbest` int(10) DEFAULT NULL,
  `lastip` varchar(30) DEFAULT NULL,
  `regip` varchar(30) DEFAULT NULL,
  `setting` varchar(255) DEFAULT NULL,
  `groupid` int(10) DEFAULT NULL,
  `msg` int(10) DEFAULT '0',
  `money` int(10) DEFAULT '0',
  `ticket` int(10) DEFAULT '0',
  `logfail` tinyint(4) NOT NULL DEFAULT '0',
  `logfailtime` int(11) DEFAULT NULL,
  `posts` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '发贴数',
  `digestposts` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '精华帖数',
  `credits` int(10) NOT NULL DEFAULT '0' COMMENT '总积分',
  `adminid` tinyint(1) NOT NULL DEFAULT '0' COMMENT '管理组id',
  `lastpost` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '最后发表时间',
  `avatar` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '0.jpg' COMMENT '头像地址',
  `salt` char(6) NOT NULL DEFAULT '',
  `md5email` char(32) NOT NULL,
  `expired` int(11) NOT NULL,
  `source` varchar(10) DEFAULT NULL COMMENT '用户来源',
  PRIMARY KEY (`id`),
  KEY `email` (`email`),
  KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=214163 DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='用户表';

/*Table structure for table `bg_user_qqh` */

DROP TABLE IF EXISTS `bg_user_qqh`;

CREATE TABLE `bg_user_qqh` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `userid` int(11) unsigned DEFAULT NULL COMMENT '暖岛用户id',
  `gender` char(2) DEFAULT '' COMMENT '性别',
  `uid` varchar(20) DEFAULT '' COMMENT 'qq对应的openid',
  `token` varchar(120) DEFAULT '' COMMENT '用户微博授权token',
  `expires_in` varchar(60) DEFAULT '' COMMENT 'access_token的生命周期',
  `name` varchar(60) DEFAULT '' COMMENT '微博昵称',
  `avatar` varchar(120) DEFAULT '' COMMENT '头像',
  `setting` smallint(1) unsigned DEFAULT '0' COMMENT '动态设置：0 发微博，1不发送',
  `posttype` varchar(20) DEFAULT '' COMMENT '发送微博的设置格式：喜欢,购买,评论与留言；（0表示关，1表示开）',
  `logintime` int(11) DEFAULT '0' COMMENT '上次联合登录时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uid` (`uid`),
  KEY `userid` (`userid`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8 COMMENT='QQ联合登陆信息';

/*Table structure for table `bg_user_weibo` */

DROP TABLE IF EXISTS `bg_user_weibo`;

CREATE TABLE `bg_user_weibo` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `userid` int(11) unsigned NOT NULL COMMENT '暖岛用户id',
  `uid` varchar(20) NOT NULL COMMENT '微博用户uid',
  `token` varchar(120) NOT NULL COMMENT '用户微博授权token',
  `expires_in` varchar(60) NOT NULL COMMENT 'access_token的生命周期',
  `name` varchar(60) NOT NULL COMMENT '微博昵称',
  `avatar` varchar(120) NOT NULL COMMENT '头像',
  `setting` smallint(1) unsigned NOT NULL DEFAULT '0' COMMENT '动态设置：0 发微博，1不发送',
  `posttype` varchar(20) NOT NULL DEFAULT '' COMMENT '发送微博的设置格式：喜欢,购买,评论与留言；（0表示关，1表示开）',
  `logintime` int(11) NOT NULL DEFAULT '0' COMMENT '上次联合登录时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uid` (`uid`),
  KEY `userid` (`userid`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COMMENT='微博登陆用户信息';

/*Table structure for table `bg_useraccess` */

DROP TABLE IF EXISTS `bg_useraccess`;

CREATE TABLE `bg_useraccess` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Table structure for table `bg_useralbum` */

DROP TABLE IF EXISTS `bg_useralbum`;

CREATE TABLE `bg_useralbum` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `info` varchar(255) CHARACTER SET utf8 NOT NULL,
  `appuid` int(10) NOT NULL,
  `appuname` varchar(60) CHARACTER SET utf8 NOT NULL,
  `tabnum` int(10) NOT NULL DEFAULT '0',
  `date` int(11) NOT NULL,
  `cover` varchar(255) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Table structure for table `bg_usergroups` */

DROP TABLE IF EXISTS `bg_usergroups`;

CREATE TABLE `bg_usergroups` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Table structure for table `bg_zine` */

DROP TABLE IF EXISTS `bg_zine`;

CREATE TABLE `bg_zine` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `class` int(6) NOT NULL,
  `scover` varchar(255) CHARACTER SET utf8 NOT NULL,
  `mcover` varchar(255) CHARACTER SET utf8 NOT NULL,
  `bcover` varchar(255) CHARACTER SET utf8 NOT NULL,
  `content` longtext CHARACTER SET utf8 NOT NULL,
  `poptab` longtext CHARACTER SET utf8 NOT NULL,
  `solotab` longtext CHARACTER SET utf8 NOT NULL,
  `views` int(10) NOT NULL DEFAULT '0',
  `downs` int(10) NOT NULL DEFAULT '0',
  `replys` int(10) NOT NULL DEFAULT '0',
  `date` int(11) NOT NULL,
  `editor` varchar(255) CHARACTER SET utf8 NOT NULL,
  `intro` longtext CHARACTER SET utf8 NOT NULL,
  `link1` varchar(255) CHARACTER SET utf8 NOT NULL,
  `link2` varchar(255) CHARACTER SET utf8 NOT NULL,
  `link3` varchar(255) CHARACTER SET utf8 NOT NULL,
  `link4` varchar(255) CHARACTER SET utf8 NOT NULL,
  `veditor` varchar(60) CHARACTER SET utf8 NOT NULL,
  `peditor` varchar(60) CHARACTER SET utf8 NOT NULL,
  `team` varchar(60) CHARACTER SET utf8 NOT NULL,
  `taobaolink` varchar(255) CHARACTER SET utf8 NOT NULL,
  `bbslink` varchar(255) CHARACTER SET utf8 NOT NULL,
  `qita` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=50 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Table structure for table `bg_zineclass` */

DROP TABLE IF EXISTS `bg_zineclass`;

CREATE TABLE `bg_zineclass` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `class` varchar(100) COLLATE utf8_bin NOT NULL,
  `type` varchar(20) COLLATE utf8_bin NOT NULL,
  `date` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Table structure for table `bg_zinecomment` */

DROP TABLE IF EXISTS `bg_zinecomment`;

CREATE TABLE `bg_zinecomment` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uid` int(10) NOT NULL,
  `uname` varchar(60) CHARACTER SET utf8 NOT NULL,
  `zid` int(10) NOT NULL,
  `comment` varchar(255) CHARACTER SET utf8 NOT NULL,
  `reply` varchar(255) CHARACTER SET utf8 NOT NULL,
  `redate` int(11) NOT NULL,
  `pldate` int(11) NOT NULL,
  `uip` varchar(30) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=167 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
