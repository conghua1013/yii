/*
SQLyog Enterprise - MySQL GUI v8.1 
MySQL - 5.1.49-community : Database - byguitar_shop
*********************************************************************
*/




CREATE DATABASE /*!32312 IF NOT EXISTS*/`byguitar_shop` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `byguitar_shop`;

/*Table structure for table `bg_manage_menu` */

DROP TABLE IF EXISTS `bg_manage_menu`;

CREATE TABLE `bg_manage_menu` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) DEFAULT NULL,
  `title` varchar(50) DEFAULT NULL COMMENT '菜单名称',
  `url` varchar(100) DEFAULT NULL COMMENT '菜单链接',
  `page_sign` varchar(30) DEFAULT NULL COMMENT '菜单页面标记',
  `status` tinyint(1) DEFAULT '0' COMMENT '菜单状态',
  `remark` varchar(255) DEFAULT NULL COMMENT '菜单描述',
  `sort` smallint(6) DEFAULT NULL COMMENT '排序',
  `parent_id` smallint(6) DEFAULT NULL COMMENT '父级id',
  `level` tinyint(1) DEFAULT NULL COMMENT '菜单级别',
  PRIMARY KEY (`id`),
  KEY `level` (`level`),
  KEY `pid` (`parent_id`),
  KEY `status` (`status`)
) ENGINE=MyISAM AUTO_INCREMENT=42 DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='后台系统菜单表';

/*Data for the table `bg_manage_menu` */

insert  into `bg_manage_menu`(id,name,title,url,page_sign,status,remark,sort,parent_id,level) values (1,'','商品','',NULL,1,'',1,0,1),(2,NULL,'分类管理','',NULL,1,'',1,1,2),(3,NULL,'品牌管理','',NULL,1,'',1,1,2),(4,NULL,'商品属性管理','',NULL,1,'',1,1,2),(5,NULL,'商品管理','',NULL,1,'',1,1,2),(6,'categoryList','分类列表','category/index',NULL,1,'',1,2,3),(7,'brandList','品牌列表','brand/index',NULL,1,'',1,3,3),(8,'productAttrList','商品属性列表','product/attrList',NULL,1,'',1,4,3),(9,'productList','商品列表','product/index',NULL,1,'',1,5,3),(10,NULL,'运营','',NULL,1,'',1,0,1),(11,'','网站首页配置','',NULL,1,'',1,10,2),(12,'bannerList','首页banner配置列表','banner/index',NULL,1,'',1,11,3),(13,'indexModuleList','首页模块配置','indexmodule/index',NULL,1,'',1,11,3),(14,NULL,'优惠券管理','',NULL,1,'',1,10,2),(15,NULL,'运营配置管理','',NULL,1,'',1,10,2),(16,'couponList','优惠券类型列表','coupon/index',NULL,1,'',1,14,3),(17,NULL,'订单','',NULL,1,'',1,0,1),(18,NULL,'订单管理','',NULL,1,'',1,17,2),(19,'orderList','订单列表','order/index',NULL,1,'',1,18,3),(20,NULL,'用户','',NULL,1,'',1,0,1),(21,NULL,'用户管理','',NULL,1,'',1,20,2),(22,'userList','用户列表','user/index',NULL,1,'',1,21,3),(23,NULL,'系统','',NULL,1,'',1,0,1),(24,NULL,'系统管理','',NULL,1,'',1,23,2),(25,'menuList','后台菜单列表','menu/index',NULL,1,'',1,24,3),(26,NULL,'数据','',NULL,1,'',1,0,1),(27,NULL,'订单数据','',NULL,1,'',1,26,2),(28,'orderStatistics','订单统计','statistics/index',NULL,1,'统计数据菜单',1,27,3),(29,'shopConfigList','运营配置项列表','shopConfig/index',NULL,1,'',1,15,3),(30,NULL,'支付方式管理','',NULL,1,'',1,10,2),(31,'paymentList','支付方式列表','payment/index',NULL,1,'',1,30,3),(32,NULL,'快递管理','',NULL,1,'',1,10,2),(33,'shippingList','快递列表','shipping/index',NULL,1,'',1,32,3),(34,NULL,'地区管理','',NULL,1,'',1,10,2),(35,'regionList','地区列表','region/index',NULL,1,'',1,34,3),(36,NULL,'客服','',NULL,1,'',1,0,1),(37,NULL,'评论管理','',NULL,1,'',1,36,2),(38,NULL,'咨询管理','',NULL,1,'',1,36,2),(39,'commentList','评论列表','comment/index',NULL,1,'',1,37,3),(40,'consultationList','资讯列表','consultation/index',NULL,1,'',1,38,3),(41,'coupon','优惠券列表','coupon/couponList',NULL,1,'',1,14,3);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;










/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

CREATE DATABASE /*!32312 IF NOT EXISTS*/`byguitar_shop` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `byguitar_shop`;

/*Table structure for table `bg_address` */

DROP TABLE IF EXISTS `bg_address`;

CREATE TABLE `bg_address` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` mediumint(8) NOT NULL DEFAULT '0' COMMENT '用户id',
  `consignee` varchar(60) NOT NULL DEFAULT '' COMMENT '收货人',
  `country` smallint(5) DEFAULT '0' COMMENT '国家',
  `province` smallint(5) NOT NULL DEFAULT '0' COMMENT '省',
  `city` smallint(5) NOT NULL DEFAULT '0' COMMENT '市',
  `district` smallint(5) DEFAULT '0' COMMENT '区',
  `address` varchar(120) NOT NULL DEFAULT '' COMMENT '具体地址',
  `zipcode` varchar(60) DEFAULT '' COMMENT '邮编',
  `tel` varchar(60) DEFAULT '' COMMENT '电话',
  `mobile` varchar(60) NOT NULL DEFAULT '' COMMENT '手机',
  `is_default` tinyint(1) DEFAULT '0' COMMENT '是否默认',
  `add_time` int(11) DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='用户收货地址';

/*Table structure for table `bg_banner` */

DROP TABLE IF EXISTS `bg_banner`;

CREATE TABLE `bg_banner` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL COMMENT '广告标题',
  `station` tinyint(2) NOT NULL COMMENT '1:首页轮播图片2:首页小banner',
  `img` varchar(255) NOT NULL COMMENT '广告图片',
  `link` varchar(255) DEFAULT NULL COMMENT '广告链接',
  `sort` smallint(6) DEFAULT NULL COMMENT '排序',
  `is_show` tinyint(1) DEFAULT '0' COMMENT '是否显示 0：隐藏 1：显示',
  `start_time` int(10) DEFAULT '0' COMMENT '开始时间',
  `end_time` int(10) DEFAULT '0' COMMENT '结束时间',
  `add_time` int(10) DEFAULT '0' COMMENT '添加时间',
  PRIMARY KEY (`id`),
  KEY `station` (`station`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Table structure for table `bg_brand` */

DROP TABLE IF EXISTS `bg_brand`;

CREATE TABLE `bg_brand` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `brand_name` varchar(100) DEFAULT NULL COMMENT '品牌名',
  `english_name` varchar(100) DEFAULT NULL COMMENT '品牌英文名',
  `from_city` varchar(80) DEFAULT NULL COMMENT '品牌属地',
  `mobile` varchar(15) DEFAULT NULL COMMENT '手机',
  `tel` varchar(30) DEFAULT NULL COMMENT '电话',
  `address` varchar(300) DEFAULT NULL COMMENT '联系地址',
  `brand_logo` varchar(200) DEFAULT NULL COMMENT '品牌logo',
  `title` varchar(200) DEFAULT NULL COMMENT '页面标题',
  `keywords` varchar(200) DEFAULT NULL COMMENT '页面关键字',
  `describtion` varchar(500) DEFAULT NULL COMMENT '页面表述',
  `site_url` varchar(500) DEFAULT NULL COMMENT '品牌网址',
  `is_show` tinyint(1) DEFAULT '1' COMMENT '是否显示（1显示 0 不显示）',
  `sort` int(6) DEFAULT '1' COMMENT '排序字段(默认从大到小)',
  `add_time` int(10) DEFAULT '0' COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='品牌表';

/*Table structure for table `bg_cart` */

DROP TABLE IF EXISTS `bg_cart`;

CREATE TABLE `bg_cart` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT '0' COMMENT '用户id',
  `product_id` int(11) DEFAULT '0' COMMENT '货品id',
  `color_id` tinyint(5) DEFAULT '0' COMMENT '颜色id',
  `size_id` tinyint(5) DEFAULT '0' COMMENT '尺寸id',
  `shop_price` decimal(10,2) DEFAULT '0.00' COMMENT '售价',
  `sell_price` decimal(10,2) DEFAULT '0.00' COMMENT '最终售价',
  `quantity` smallint(6) DEFAULT '0' COMMENT '数量',
  `add_time` int(11) DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) DEFAULT '0' COMMENT '更新时间',
  `over_time` int(11) DEFAULT '0' COMMENT '过期时间',
  `is_pay` smallint(2) DEFAULT '0' COMMENT '是否结算（0：未结算 1：已结算,未支付订单 2：确认订单）',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC;

/*Table structure for table `bg_category` */

DROP TABLE IF EXISTS `bg_category`;

CREATE TABLE `bg_category` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `cat_name` varchar(10) DEFAULT NULL COMMENT '分类名',
  `level` tinyint(1) DEFAULT '1' COMMENT '分类级别',
  `parent_id` int(5) DEFAULT '0' COMMENT '父级分类id',
  `is_show` tinyint(1) DEFAULT '1' COMMENT '前台是否显示',
  `select_able` tinyint(1) DEFAULT '1' COMMENT '是否可选（商品）',
  `url` varchar(200) DEFAULT NULL COMMENT '分类链接',
  `title` varchar(200) DEFAULT NULL COMMENT '页面title',
  `keywords` varchar(200) DEFAULT NULL COMMENT '页面关键字',
  `describtion` varchar(500) DEFAULT NULL COMMENT '页面描述',
  `sort` int(5) DEFAULT '1' COMMENT '排序',
  `add_time` int(10) DEFAULT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=69 DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='分类表';

/*Table structure for table `bg_comment` */

DROP TABLE IF EXISTS `bg_comment`;

CREATE TABLE `bg_comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) unsigned DEFAULT NULL COMMENT '货品id',
  `op_id` int(11) unsigned DEFAULT '0' COMMENT '订单商品id',
  `user_id` int(11) unsigned DEFAULT NULL COMMENT '用户id',
  `content` varchar(255) DEFAULT NULL COMMENT '评论内容',
  `comment_score` int(11) unsigned DEFAULT NULL COMMENT '评分(评价有评分，留言没有评分)',
  `comment_type` smallint(1) unsigned DEFAULT '0' COMMENT '类型：0，留言；1，评价',
  `useful_num` int(11) unsigned DEFAULT '0' COMMENT '评价的有用总数',
  `add_time` int(11) unsigned DEFAULT NULL COMMENT '创建时间',
  `is_show` tinyint(1) unsigned DEFAULT '0' COMMENT '是否隐藏(1显示 0隐藏)',
  `is_del` tinyint(1) unsigned DEFAULT '0' COMMENT '是否删除(0显示 1删除)',
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='商品评论表';

/*Table structure for table `bg_consultation` */

DROP TABLE IF EXISTS `bg_consultation`;

CREATE TABLE `bg_consultation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) unsigned DEFAULT NULL COMMENT '货品id',
  `user_id` int(11) unsigned DEFAULT NULL COMMENT '用户id',
  `content` varchar(255) DEFAULT NULL COMMENT '资讯内容',
  `type` smallint(1) unsigned NOT NULL DEFAULT '0' COMMENT '类型：1，资讯；2，回复',
  `useful_num` int(11) unsigned DEFAULT '0' COMMENT '有用总数',
  `add_time` int(11) unsigned DEFAULT NULL COMMENT '创建时间',
  `is_show` tinyint(1) unsigned DEFAULT '0' COMMENT '是否隐藏(1显示 0隐藏)',
  `is_del` tinyint(1) unsigned DEFAULT '0' COMMENT '是否删除(0显示 1删除)',
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='商品资讯表';

/*Table structure for table `bg_coupon` */

DROP TABLE IF EXISTS `bg_coupon`;

CREATE TABLE `bg_coupon` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `coupon_sn` varchar(20) DEFAULT NULL COMMENT '优惠券号',
  `coupon_type_id` int(8) DEFAULT '0' COMMENT '优惠券类型id',
  `coupon_amount` decimal(6,2) DEFAULT '0.00' COMMENT '优惠券金额',
  `satisfied_amount` int(5) DEFAULT '0' COMMENT '使用满足金额条件',
  `start_time` int(10) DEFAULT '0' COMMENT '开始时间',
  `end_time` int(10) DEFAULT '0' COMMENT '结束时间',
  `user_id` int(10) DEFAULT NULL COMMENT '绑定用户id',
  `order_id` int(10) DEFAULT '0' COMMENT '使用订单id',
  `band_type` tinyint(10) DEFAULT '0' COMMENT '绑定类型(1用户绑定,2系统绑定)',
  `band_time` int(10) DEFAULT '0' COMMENT '绑定时间',
  `use_time` int(10) DEFAULT '0' COMMENT '使用时间',
  `add_time` int(10) DEFAULT '0' COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=84 DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='优惠券表';

/*Table structure for table `bg_coupon_type` */

DROP TABLE IF EXISTS `bg_coupon_type`;

CREATE TABLE `bg_coupon_type` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `coupon_name` varchar(100) DEFAULT NULL COMMENT '优惠券名称',
  `coupon_type` tinyint(1) DEFAULT '1' COMMENT '类型(1:A类 2:B类 )',
  `coupon_sn` varchar(20) DEFAULT NULL COMMENT '只有B类券写该字段',
  `coupon_amount` decimal(6,2) DEFAULT '0.00' COMMENT '优惠券金额',
  `satisfied_amount` decimal(6,2) DEFAULT '0.00' COMMENT '满足条件能使用',
  `detail` varchar(300) DEFAULT NULL COMMENT '优惠券的描述',
  `start_time` int(10) DEFAULT '0' COMMENT '优惠券开始时间',
  `end_time` int(10) DEFAULT '0' COMMENT '优惠券结束时间',
  `add_time` int(10) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='优惠券类型详情表';

/*Table structure for table `bg_cron_log` */

DROP TABLE IF EXISTS `bg_cron_log`;

CREATE TABLE `bg_cron_log` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `cron_name` varchar(20) DEFAULT NULL COMMENT '脚本的名称',
  `cron_url` varchar(100) DEFAULT NULL COMMENT '脚本路径',
  `detail` varchar(200) DEFAULT NULL COMMENT '脚本的详细描述',
  `success_msg` varchar(500) DEFAULT NULL COMMENT '成功信息',
  `add_time` int(10) DEFAULT '0' COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `bg_index_module` */

DROP TABLE IF EXISTS `bg_index_module`;

CREATE TABLE `bg_index_module` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) DEFAULT NULL COMMENT '模块标题',
  `img` varchar(200) DEFAULT NULL COMMENT '图片',
  `link` varchar(200) DEFAULT NULL COMMENT '图片链接',
  `describtion` varchar(500) DEFAULT NULL COMMENT 'banner描述',
  `product_ids` varchar(200) DEFAULT NULL COMMENT '商品id，用,链接起来',
  `type` tinyint(1) DEFAULT '0' COMMENT '自动策略',
  `is_show` tinyint(1) DEFAULT '0' COMMENT '是否显示 1显示 0不显示',
  `sort` mediumint(5) DEFAULT '0' COMMENT '排序',
  `start_time` int(10) DEFAULT '0' COMMENT '开始时间',
  `end_time` int(10) DEFAULT '0' COMMENT '结束时间',
  `add_time` int(10) DEFAULT '0' COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='首页模块配置';

/*Table structure for table `bg_like` */

DROP TABLE IF EXISTS `bg_like`;

CREATE TABLE `bg_like` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) unsigned DEFAULT NULL COMMENT '货品id',
  `user_id` int(11) unsigned DEFAULT NULL COMMENT '用户id',
  `add_time` int(11) unsigned DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='用户喜欢表';

/*Table structure for table `bg_manage_menu` */

DROP TABLE IF EXISTS `bg_manage_menu`;

CREATE TABLE `bg_manage_menu` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) DEFAULT NULL,
  `title` varchar(50) DEFAULT NULL COMMENT '菜单名称',
  `url` varchar(100) DEFAULT NULL COMMENT '菜单链接',
  `page_sign` varchar(30) DEFAULT NULL COMMENT '菜单页面标记',
  `status` tinyint(1) DEFAULT '0' COMMENT '菜单状态',
  `remark` varchar(255) DEFAULT NULL COMMENT '菜单描述',
  `sort` smallint(6) DEFAULT NULL COMMENT '排序',
  `parent_id` smallint(6) DEFAULT NULL COMMENT '父级id',
  `level` tinyint(1) DEFAULT NULL COMMENT '菜单级别',
  PRIMARY KEY (`id`),
  KEY `level` (`level`),
  KEY `pid` (`parent_id`),
  KEY `status` (`status`)
) ENGINE=MyISAM AUTO_INCREMENT=42 DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='后台系统菜单表';

/*Table structure for table `bg_order` */

DROP TABLE IF EXISTS `bg_order`;

CREATE TABLE `bg_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_sn` varchar(20) DEFAULT NULL COMMENT '订单编号',
  `user_id` int(11) unsigned DEFAULT NULL COMMENT '用户id',
  `order_status` tinyint(1) DEFAULT '0' COMMENT '订单状态',
  `order_type` tinyint(1) DEFAULT '0' COMMENT '订单类型(1网站订单2手机订单)',
  `pay_id` tinyint(3) DEFAULT '0' COMMENT '支付方式id',
  `pay_status` tinyint(1) DEFAULT '0' COMMENT '订单状态(0新下单1已付款2已过期3退款)',
  `pay_time` int(11) DEFAULT '0' COMMENT '付款时间',
  `pay_amount` decimal(10,2) DEFAULT '0.00' COMMENT '客户支付的费用',
  `shipping_id` tinyint(2) DEFAULT '0' COMMENT '快递id',
  `shipping_fee` decimal(5,2) DEFAULT '0.00' COMMENT '下单运费',
  `final_shipping_fee` decimal(5,2) DEFAULT '0.00' COMMENT '实际运费',
  `shipping_status` tinyint(1) DEFAULT '0' COMMENT '发货状态(1未发货2已发货3部分发货)',
  `shipping_time` int(11) DEFAULT '0' COMMENT '发货时间',
  `order_amount` decimal(10,2) DEFAULT '0.00' COMMENT '订单金额',
  `product_amount` decimal(10,2) DEFAULT '0.00' COMMENT '货品金额总计',
  `quantity` smallint(6) DEFAULT '0' COMMENT '商品数量',
  `coupon_id` smallint(6) DEFAULT '0' COMMENT '优惠券id',
  `coupon_amount` decimal(10,2) DEFAULT '0.00' COMMENT '优惠券使用金额(按实际使用优惠)',
  `discount` decimal(10,2) DEFAULT '0.00' COMMENT '折扣金额',
  `consignee` varchar(60) DEFAULT NULL COMMENT '收货人',
  `mobile` varchar(60) DEFAULT NULL COMMENT '手机',
  `province` smallint(6) DEFAULT '0' COMMENT '省',
  `city` smallint(6) DEFAULT '0' COMMENT '市',
  `district` smallint(6) DEFAULT '0' COMMENT '县',
  `address` varchar(255) DEFAULT NULL COMMENT '地址',
  `email` varchar(255) DEFAULT NULL COMMENT 'email',
  `remark` varchar(255) DEFAULT NULL COMMENT '订单备注',
  `cps_msg` varchar(60) DEFAULT '' COMMENT 'cps 参数信息',
  `source` varchar(60) DEFAULT '' COMMENT '来源地',
  `add_time` int(11) DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) DEFAULT '0' COMMENT '订单更新时间',
  `receive_time` int(11) DEFAULT '0' COMMENT '收货时间',
  `prepare_time` int(11) DEFAULT '0' COMMENT '打包准备时间',
  `shipping_sn` varchar(30) DEFAULT NULL COMMENT '运单号',
  `trade_no` varchar(50) DEFAULT NULL COMMENT '支付宝的交易号',
  PRIMARY KEY (`id`),
  UNIQUE KEY `ordersn` (`order_sn`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8 COMMENT='订单信息表';

/*Table structure for table `bg_order_log` */

DROP TABLE IF EXISTS `bg_order_log`;

CREATE TABLE `bg_order_log` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `order_id` int(10) DEFAULT '0' COMMENT '订单id',
  `admin_id` int(10) DEFAULT '0' COMMENT '管理员id',
  `admin_name` varchar(50) DEFAULT NULL COMMENT '操作员名字',
  `phone` varchar(30) DEFAULT NULL COMMENT '操作员联系方式',
  `type` varchar(20) DEFAULT NULL COMMENT '日志的类型',
  `msg` varchar(300) DEFAULT NULL COMMENT '日志信息',
  `is_show` tinyint(1) DEFAULT '0' COMMENT '是否显示',
  `add_time` int(10) DEFAULT '0' COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='订单日志表';

/*Table structure for table `bg_order_pay_log` */

DROP TABLE IF EXISTS `bg_order_pay_log`;

CREATE TABLE `bg_order_pay_log` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) DEFAULT '0' COMMENT '用户id',
  `order_id` int(10) DEFAULT '0' COMMENT '订单id',
  `pay_id` tinyint(1) DEFAULT '0' COMMENT '支付方式id',
  `pay_amount` decimal(7,2) DEFAULT '0.00' COMMENT '支付金额',
  `pay_time` int(10) DEFAULT '0' COMMENT '支付时间',
  `add_time` int(10) DEFAULT '0' COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='订单支付日志表';

/*Table structure for table `bg_order_product` */

DROP TABLE IF EXISTS `bg_order_product`;

CREATE TABLE `bg_order_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '订单id',
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `product_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '货品id',
  `product_sn` varchar(100) DEFAULT NULL COMMENT '商品编号',
  `product_name` varchar(255) DEFAULT NULL COMMENT '商品名称',
  `size_id` int(10) DEFAULT '0' COMMENT '商品尺寸',
  `brand_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '品牌id',
  `sell_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '商品售价',
  `quantity` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '商品数量',
  `other_info` int(10) DEFAULT NULL COMMENT '其他信息',
  `ship_id` int(10) DEFAULT NULL COMMENT '快递id',
  `ship_code` varchar(30) DEFAULT NULL COMMENT '运单号',
  `ship_time` int(10) DEFAULT NULL COMMENT '发货时间',
  `comment_id` int(10) DEFAULT '0' COMMENT '评论id',
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  KEY `product_id` (`product_id`),
  KEY `brand_id` (`brand_id`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8 COMMENT='订单商品信息表';

/*Table structure for table `bg_order_shipping` */

DROP TABLE IF EXISTS `bg_order_shipping`;

CREATE TABLE `bg_order_shipping` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) DEFAULT NULL COMMENT '订单id',
  `shipping_id` smallint(6) NOT NULL DEFAULT '0' COMMENT '快递公司id',
  `shipping_sn` varchar(100) NOT NULL DEFAULT '' COMMENT '运单号',
  `shipping_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '发货状态(1未发货2已发货)',
  `shipping_fee` decimal(10,2) DEFAULT NULL COMMENT '实际运费',
  `weight` smallint(6) NOT NULL DEFAULT '0' COMMENT '重量',
  `remark` varchar(255) DEFAULT NULL COMMENT '备注',
  `is_packing` smallint(1) DEFAULT '0' COMMENT '是否打印（0：未打印 1：已打印）',
  `receive_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '签收时间',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '发货时间',
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='订单发货信息表';

/*Table structure for table `bg_payment` */

DROP TABLE IF EXISTS `bg_payment`;

CREATE TABLE `bg_payment` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT COMMENT '支付方式id',
  `pay_code` varchar(60) DEFAULT NULL COMMENT '支付方式代码',
  `pay_name` varchar(60) DEFAULT NULL COMMENT '支付方式名',
  `payment_logo` varchar(100) DEFAULT NULL COMMENT '支付方式的logo图片',
  `keya` varchar(100) DEFAULT NULL COMMENT '密钥',
  `keyb` varchar(100) DEFAULT NULL COMMENT '密钥',
  `is_valid` tinyint(1) DEFAULT '1' COMMENT '是否有效',
  `is_plat` tinyint(1) DEFAULT '0' COMMENT '是否是支付平台',
  `sort` mediumint(6) DEFAULT '1' COMMENT '排序',
  `parent_id` tinyint(3) DEFAULT '0' COMMENT '支付方式父ID',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COMMENT='支付方式信息表';

/*Table structure for table `bg_product` */

DROP TABLE IF EXISTS `bg_product`;

CREATE TABLE `bg_product` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `product_sn` varchar(12) DEFAULT NULL COMMENT '商品的编号',
  `product_name` varchar(256) DEFAULT NULL COMMENT '商品名称',
  `subhead` varchar(256) DEFAULT NULL COMMENT '商品副标题',
  `cat_id` int(5) DEFAULT '0' COMMENT '分类id',
  `brand_id` int(5) DEFAULT '0' COMMENT '品牌id',
  `color_id` int(5) DEFAULT '0' COMMENT '商品颜色',
  `size_id` int(5) DEFAULT '0' COMMENT '商品尺寸',
  `color_ids` varchar(100) DEFAULT NULL COMMENT '颜色id用,连接',
  `same_color_products` varchar(500) DEFAULT NULL COMMENT '相同颜色的商品id，用,连接',
  `size_ids` varchar(100) DEFAULT NULL COMMENT '尺寸id用,连接',
  `origin_id` int(5) DEFAULT '0' COMMENT '原产地',
  `market_price` decimal(7,2) DEFAULT '0.00' COMMENT '市场售价',
  `cost_price` decimal(7,2) DEFAULT '0.00' COMMENT '成本价',
  `sell_price` decimal(7,2) DEFAULT '0.00' COMMENT '商品实际售价',
  `img` varchar(200) DEFAULT NULL COMMENT '商品主图',
  `is_multiple` tinyint(1) DEFAULT '0' COMMENT '商品多款式与否',
  `quantity` int(6) DEFAULT '1' COMMENT '商品库存',
  `detail` text COMMENT '商品详情',
  `vedio_url` varchar(500) DEFAULT NULL COMMENT '视频地址',
  `keywords` varchar(200) DEFAULT NULL COMMENT '关键字',
  `describtion` varchar(200) DEFAULT NULL COMMENT '商品描述(用于title)',
  `promote_price` decimal(7,2) DEFAULT '0.00' COMMENT '促销价',
  `promote_start_time` int(10) DEFAULT '0' COMMENT '促销开始时间',
  `promote_end_time` int(10) DEFAULT '0' COMMENT '促销结束时间',
  `discount` decimal(3,2) DEFAULT '0.00' COMMENT '折扣比例',
  `status` tinyint(1) DEFAULT '0' COMMENT '1:初审 2:上架 3下架 ',
  `like_num` int(10) DEFAULT '0' COMMENT '喜欢数',
  `sold_num` int(10) DEFAULT '0' COMMENT '售出个数',
  `is_show` tinyint(1) DEFAULT '0' COMMENT '是否展示',
  `add_time` int(10) DEFAULT '0' COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='商品表';

/*Table structure for table `bg_product_attr` */

DROP TABLE IF EXISTS `bg_product_attr`;

CREATE TABLE `bg_product_attr` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `product_id` int(10) DEFAULT '0' COMMENT '商品id',
  `attr_group_id` int(10) DEFAULT '0' COMMENT '属性类别id',
  `attr_id` int(10) DEFAULT '0' COMMENT '属性值id',
  `num` int(8) DEFAULT '0' COMMENT '库存个数',
  `add_time` int(10) DEFAULT '0' COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=112 DEFAULT CHARSET=utf8 COMMENT='商品对应属性表';

/*Table structure for table `bg_product_attributes` */

DROP TABLE IF EXISTS `bg_product_attributes`;

CREATE TABLE `bg_product_attributes` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) DEFAULT NULL COMMENT '所属属性di',
  `attr_name` varchar(50) DEFAULT NULL COMMENT '属性名',
  `add_time` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='商品属性表';

/*Table structure for table `bg_product_category` */

DROP TABLE IF EXISTS `bg_product_category`;

CREATE TABLE `bg_product_category` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `product_id` int(10) DEFAULT '0' COMMENT '商品id',
  `one_id` int(10) DEFAULT '0' COMMENT '一级分类id',
  `two_id` int(10) DEFAULT '0' COMMENT '二级分类id',
  `add_time` int(10) DEFAULT '0' COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='商品分类关系表';

/*Table structure for table `bg_product_extend` */

DROP TABLE IF EXISTS `bg_product_extend`;

CREATE TABLE `bg_product_extend` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `product_id` int(10) DEFAULT '0' COMMENT '商品id',
  `star_num` decimal(4,1) DEFAULT '0.0' COMMENT '商品的星评',
  `comment_num` int(6) DEFAULT '0' COMMENT '商品的评论',
  `other_info` text COMMENT '商品的其他属性',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='商品的属性扩展表';

/*Table structure for table `bg_product_img` */

DROP TABLE IF EXISTS `bg_product_img`;

CREATE TABLE `bg_product_img` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `product_id` int(10) DEFAULT '0',
  `img` varchar(100) DEFAULT NULL,
  `add_time` int(10) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='商品图片表';

/*Table structure for table `bg_product_stock` */

DROP TABLE IF EXISTS `bg_product_stock`;

CREATE TABLE `bg_product_stock` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `product_id` int(10) DEFAULT '0' COMMENT '商品id',
  `size_id` int(5) DEFAULT '0' COMMENT '尺寸id',
  `quantity` int(10) DEFAULT '0' COMMENT '数量',
  `add_time` int(10) DEFAULT '0' COMMENT '添加时间',
  `update_time` int(10) DEFAULT '0' COMMENT '更新时间',
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COMMENT='商品库存表';

/*Table structure for table `bg_region` */

DROP TABLE IF EXISTS `bg_region`;

CREATE TABLE `bg_region` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `parent_id` smallint(6) DEFAULT NULL COMMENT '父级地址id',
  `region_name` varchar(100) DEFAULT NULL COMMENT '地址名',
  `level` tinyint(1) DEFAULT NULL COMMENT '地址等级',
  `area_code` varchar(10) DEFAULT NULL COMMENT '可能是邮编',
  `is_show` tinyint(1) DEFAULT NULL COMMENT '是否删除',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4954 DEFAULT CHARSET=utf8 COMMENT='地址信息表';

/*Table structure for table `bg_shipping` */

DROP TABLE IF EXISTS `bg_shipping`;

CREATE TABLE `bg_shipping` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `shipping_name` varchar(255) DEFAULT NULL COMMENT '快递公司名',
  `shipping_fee` decimal(10,2) DEFAULT NULL COMMENT '运费',
  `shipping_code` varchar(50) NOT NULL DEFAULT '' COMMENT '针对快递100的运送方式缩写',
  `is_show` int(1) DEFAULT '1' COMMENT '是否启用',
  `detail` varchar(50) NOT NULL DEFAULT '' COMMENT '快递的描述',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=utf8 COMMENT='快递信息表';

/*Table structure for table `bg_shop_config` */

DROP TABLE IF EXISTS `bg_shop_config`;

CREATE TABLE `bg_shop_config` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `attribute_name` varchar(50) DEFAULT NULL COMMENT '属性中文名',
  `attribute` varchar(50) DEFAULT NULL COMMENT '属性英文名',
  `value` varchar(50) DEFAULT NULL COMMENT '属性值',
  `add_time` int(10) DEFAULT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='商城配置表';

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
