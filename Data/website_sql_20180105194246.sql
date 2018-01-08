-- -----------------------------
-- Think MySQL Data Transfer 
-- 
-- Host     : 127.0.0.1
-- Port     : 
-- Database : website
-- 
-- Date : 2018-01-05 19:42:46
-- -----------------------------

SET FOREIGN_KEY_CHECKS = 0;/* SqlEnd */



-- -----------------------------
-- Table structure for `en_admin`
-- -----------------------------
DROP TABLE IF EXISTS `en_admin`;/* SqlEnd */
CREATE TABLE `en_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户id',
  `group_id` int(11) DEFAULT NULL COMMENT '所属管理组id',
  `nickname` char(50) DEFAULT NULL COMMENT '用户名',
  `password` varchar(100) DEFAULT NULL COMMENT '密码',
  `truename` char(50) DEFAULT NULL COMMENT '真实姓名',
  `phone` char(20) DEFAULT NULL COMMENT '手机号码',
  `email` varchar(50) DEFAULT NULL COMMENT '邮箱',
  `register_time` int(15) DEFAULT NULL COMMENT '注册时间',
  `register_ip` varchar(50) DEFAULT NULL COMMENT '注册ip',
  `last_login_time` int(15) DEFAULT NULL COMMENT '最后登录时间',
  `last_login_ip` varchar(50) DEFAULT NULL COMMENT '最后登录ip',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态，1正常，0冻结',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='用户表';/* SqlEnd */

-- -----------------------------
-- Records of ``en_admin``
-- -----------------------------
INSERT INTO `en_admin` VALUES ('1','1','admin','21232f297a57a5a743894a0e4a801fc3','','13445678989','admin@qq.com','1492764255','127.0.0.1','1515038660','0.0.0.0','1'),('2','3','manage','70682896e24287b0476eff2a14c148f0','','','manage@qq.com','1492764316','127.0.0.1','1492997498','127.0.0.1','1'),('3','5','expert','b9b83bad6bd2b4f7c40109304cf580e1','test','12234265','pcy030@qq.com','1515137387','0.0.0.0','','','1'),('4','6','museum','eb0ea0bc6c91e1e8058ddddfa6192ce7','pcy','124165256','pc030@qq.com','1515137438','0.0.0.0','','','1'),('5','7','worker','b61822e8357dcaff77eaaccf348d9134','pcy','212121213','ppp030@qq.com','1515137474','0.0.0.0','','','1');/* SqlEnd */



-- -----------------------------
-- Table structure for `en_config`
-- -----------------------------
DROP TABLE IF EXISTS `en_config`;/* SqlEnd */
CREATE TABLE `en_config` (
  `id` int(8) NOT NULL AUTO_INCREMENT COMMENT '设置id',
  `group_id` int(2) DEFAULT NULL COMMENT '设置所属分组',
  `type` char(10) DEFAULT NULL COMMENT '设置值类型',
  `sort` int(11) DEFAULT NULL COMMENT '显示排序',
  `name` varchar(100) DEFAULT NULL COMMENT '设置名称',
  `varname` varchar(200) NOT NULL COMMENT '设置变量名',
  `value` text CHARACTER SET utf8mb4 COMMENT '设置值',
  `unit` varchar(100) DEFAULT NULL COMMENT '单位',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COMMENT='设置表';/* SqlEnd */

-- -----------------------------
-- Records of ``en_config``
-- -----------------------------
INSERT INTO `en_config` VALUES ('1','1','image','1','网站名称','WEB_NAME','',''),('2','1','string','2','网站标题','WEB_SEO_TITLE','当前为英文',''),('3','1','string','3','网站关键字','WEB_SEO_KEYWORDS','',''),('4','1','string','4','网站描述','WEB_SEO_DESCRIPTION','',''),('5','1','string','5','网址','WEB_HTTP','',''),('11','3','bool','1','页面Trace','SHOW_PAGE_TRACE','1',''),('7','5','string','1','后台图片上传大小','UPLOAD_IMG_SIZE','2','MB'),('8','5','string','2','后台附件上传大小','UPLOAD_FILE_SIZE','2','MB'),('9','5','string','3','后台图片上传类型(以英文\"|\"隔开)','UPLOAD_IMG_EXTS','jpg|png|gif',''),('10','5','string','4','后台附件上传类型(以英文\"|\"隔开)','UPLOAD_FILE_EXTS','zip|rar|txt|doc|docx','');/* SqlEnd */



-- -----------------------------
-- Table structure for `en_config_type`
-- -----------------------------
DROP TABLE IF EXISTS `en_config_type`;/* SqlEnd */
CREATE TABLE `en_config_type` (
  `id` int(5) NOT NULL AUTO_INCREMENT COMMENT '设置类型id',
  `name` char(20) DEFAULT NULL COMMENT '设置类型名称',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='设置类型表';/* SqlEnd */

-- -----------------------------
-- Records of ``en_config_type``
-- -----------------------------
INSERT INTO `en_config_type` VALUES ('1','网站信息'),('2','基本设置'),('3','核心设置'),('4','邮箱设置'),('5','附件设置');/* SqlEnd */



-- -----------------------------
-- Table structure for `en_expert`
-- -----------------------------
DROP TABLE IF EXISTS `en_expert`;/* SqlEnd */
CREATE TABLE `en_expert` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `nickname` char(20) NOT NULL,
  `indicator` int(5) NOT NULL COMMENT '一级指标',
  `expert_desc` char(20) DEFAULT NULL COMMENT '专家简介',
  `year` varchar(20) DEFAULT NULL COMMENT '评审年份',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='专家表';/* SqlEnd */




-- -----------------------------
-- Table structure for `en_file`
-- -----------------------------
DROP TABLE IF EXISTS `en_file`;/* SqlEnd */
CREATE TABLE `en_file` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '文件表',
  `file_name` varchar(255) DEFAULT NULL,
  `file_ext` varchar(8) DEFAULT NULL,
  `file_size` double DEFAULT NULL,
  `file_url` varchar(255) DEFAULT NULL,
  `file_sizes` varchar(20) DEFAULT NULL,
  `file_md5` char(32) DEFAULT NULL,
  `file_sha1` char(40) DEFAULT NULL,
  `original_name` varchar(255) DEFAULT NULL,
  `create_time` datetime DEFAULT NULL,
  `img_w` int(10) DEFAULT NULL,
  `img_h` int(10) DEFAULT NULL,
  `is_img` tinyint(1) DEFAULT '0' COMMENT '0为文件，1为图片',
  `is_use` tinyint(1) DEFAULT '1' COMMENT '1为使用，0未使用',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='上传文件记录表';/* SqlEnd */

-- -----------------------------
-- Records of ``en_file``
-- -----------------------------
INSERT INTO `en_file` VALUES ('1','5a4e0ad053fc0.jpg','jpg','81833','/Uploads/image/2018-01-04/5a4e0ad053fc0.jpg','79.92 KB','3f0c9e23040d6bdea716f602fed93593','631ce9c531cc922ed7c24fa12928d3ef6304d864','kh.jpg','2018-01-04 19:06:56','1000','700','1','1');/* SqlEnd */



-- -----------------------------
-- Table structure for `en_group`
-- -----------------------------
DROP TABLE IF EXISTS `en_group`;/* SqlEnd */
CREATE TABLE `en_group` (
  `id` int(15) NOT NULL AUTO_INCREMENT COMMENT '管理分组id',
  `name` varchar(50) DEFAULT NULL COMMENT '分组名称',
  `intro` varchar(50) DEFAULT NULL COMMENT '分组简介',
  `access` text COMMENT '规则id',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态，1正常，0冻结',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;/* SqlEnd */

-- -----------------------------
-- Records of ``en_group``
-- -----------------------------
INSERT INTO `en_group` VALUES ('1','超级管理员组','至高无上的权利','a:53:{i:0;s:1:\"1\";i:1;s:1:\"2\";i:2;s:1:\"3\";i:3;s:1:\"4\";i:4;s:1:\"5\";i:5;s:1:\"6\";i:6;s:1:\"7\";i:7;s:1:\"8\";i:8;s:1:\"9\";i:9;s:2:\"10\";i:10;s:2:\"11\";i:11;s:2:\"12\";i:12;s:2:\"13\";i:13;s:2:\"14\";i:14;s:2:\"15\";i:15;s:2:\"16\";i:16;s:2:\"17\";i:17;s:2:\"18\";i:18;s:2:\"19\";i:19;s:2:\"20\";i:20;s:2:\"22\";i:21;s:2:\"23\";i:22;s:2:\"24\";i:23;s:2:\"25\";i:24;s:2:\"26\";i:25;s:2:\"27\";i:26;s:2:\"28\";i:27;s:2:\"29\";i:28;s:2:\"30\";i:29;s:2:\"31\";i:30;s:2:\"32\";i:31;s:2:\"33\";i:32;s:2:\"34\";i:33;s:2:\"35\";i:34;s:2:\"36\";i:35;s:2:\"37\";i:36;s:2:\"38\";i:37;s:2:\"39\";i:38;s:2:\"40\";i:39;s:2:\"41\";i:40;s:2:\"42\";i:41;s:2:\"43\";i:42;s:2:\"44\";i:43;s:2:\"45\";i:44;s:2:\"46\";i:45;s:2:\"48\";i:46;s:2:\"47\";i:47;s:2:\"49\";i:48;s:2:\"50\";i:49;s:2:\"51\";i:50;s:2:\"52\";i:51;s:2:\"53\";i:52;s:2:\"54\";}','1'),('3','辅助管理员','一人之下，万人之上','a:52:{i:0;s:1:\"1\";i:1;s:1:\"2\";i:2;s:1:\"3\";i:3;s:1:\"4\";i:4;s:1:\"5\";i:5;s:1:\"6\";i:6;s:1:\"7\";i:7;s:1:\"8\";i:8;s:2:\"11\";i:9;s:2:\"12\";i:10;s:2:\"13\";i:11;s:2:\"14\";i:12;s:2:\"15\";i:13;s:2:\"16\";i:14;s:2:\"17\";i:15;s:2:\"18\";i:16;s:2:\"19\";i:17;s:2:\"20\";i:18;s:2:\"56\";i:19;s:2:\"22\";i:20;s:2:\"23\";i:21;s:2:\"24\";i:22;s:2:\"25\";i:23;s:2:\"26\";i:24;s:2:\"27\";i:25;s:2:\"28\";i:26;s:2:\"29\";i:27;s:2:\"30\";i:28;s:2:\"31\";i:29;s:2:\"32\";i:30;s:2:\"33\";i:31;s:2:\"34\";i:32;s:2:\"35\";i:33;s:2:\"36\";i:34;s:2:\"37\";i:35;s:2:\"38\";i:36;s:2:\"39\";i:37;s:2:\"40\";i:38;s:2:\"41\";i:39;s:2:\"42\";i:40;s:2:\"43\";i:41;s:2:\"44\";i:42;s:2:\"45\";i:43;s:2:\"46\";i:44;s:2:\"48\";i:45;s:2:\"47\";i:46;s:2:\"49\";i:47;s:2:\"50\";i:48;s:2:\"51\";i:49;s:2:\"52\";i:50;s:2:\"53\";i:51;s:2:\"54\";}','1'),('5','专家管理员组','管理打分表','','1'),('6','博物馆管理员组','申报书','','1'),('7','评审人员组','管理博物馆，专家，申报书，打分表，汇总表等','','1');/* SqlEnd */



-- -----------------------------
-- Table structure for `en_indicator`
-- -----------------------------
DROP TABLE IF EXISTS `en_indicator`;/* SqlEnd */
CREATE TABLE `en_indicator` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `name` char(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='一级指标';/* SqlEnd */

-- -----------------------------
-- Records of ``en_indicator``
-- -----------------------------
INSERT INTO `en_indicator` VALUES ('1','藏品管理'),('2','科学研究');/* SqlEnd */



-- -----------------------------
-- Table structure for `en_member`
-- -----------------------------
DROP TABLE IF EXISTS `en_member`;/* SqlEnd */
CREATE TABLE `en_member` (
  `id` int(15) NOT NULL AUTO_INCREMENT COMMENT '会员id',
  `nickname` char(50) DEFAULT NULL COMMENT '会员名',
  `password` varchar(100) DEFAULT NULL COMMENT '密码',
  `truename` char(50) DEFAULT NULL COMMENT '真实姓名',
  `sex` tinyint(1) DEFAULT NULL COMMENT '性别，1男，0女',
  `phone` char(20) DEFAULT NULL COMMENT '手机',
  `email` varchar(100) DEFAULT NULL COMMENT '邮箱',
  `register_time` int(15) DEFAULT NULL COMMENT '注册时间',
  `register_ip` varchar(50) DEFAULT NULL COMMENT '注册ip',
  `last_login_time` int(15) DEFAULT NULL COMMENT '最后登录时间',
  `last_login_ip` varchar(50) DEFAULT NULL COMMENT '最后登录ip',
  `status` tinyint(1) DEFAULT '1' COMMENT '会员状态,1正常，0冻结',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='会员表';/* SqlEnd */

-- -----------------------------
-- Records of ``en_member``
-- -----------------------------
INSERT INTO `en_member` VALUES ('1','admin','21232f297a57a5a743894a0e4a801fc3','','','13445678989','admin@qq.com','1492764255','127.0.0.1','','','1');/* SqlEnd */



-- -----------------------------
-- Table structure for `en_navigation`
-- -----------------------------
DROP TABLE IF EXISTS `en_navigation`;/* SqlEnd */
CREATE TABLE `en_navigation` (
  `id` int(5) NOT NULL AUTO_INCREMENT COMMENT '导航id',
  `pid` int(5) DEFAULT NULL COMMENT '上级id',
  `sort` int(5) DEFAULT NULL COMMENT '排序',
  `name` varchar(10) DEFAULT NULL COMMENT '导航名称',
  `url` varchar(150) DEFAULT NULL COMMENT '链接',
  `is_show` tinyint(1) DEFAULT '1' COMMENT '是否显示，1显示，0不显示',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=38 DEFAULT CHARSET=utf8 COMMENT='后台导航表';/* SqlEnd */

-- -----------------------------
-- Records of ``en_navigation``
-- -----------------------------
INSERT INTO `en_navigation` VALUES ('1','0','1','系统设置','javascript:void(0);','1'),('2','0','2','权限管理','javascript:void(0);','1'),('3','0','3','专家','javascript:void(0);','1'),('4','0','4','博物馆','javascript:void(0);','1'),('5','0','5','申报书','javascript:void(0);','1'),('6','0','6','专家打分表','javascript:void(0);','1'),('7','1','1','网站信息','WebConfig/index','1'),('8','1','2','基本设置','BasicConfig/index','1'),('9','1','3','核心设置','CoreConfig/index','1'),('10','1','4','邮箱设置','EmailConfig/index','1'),('11','1','5','附件设置','AdjunctConfig/index','1'),('12','2','1','后台导航','Navigation/index','1'),('13','2','2','规则管理','Rule/index','1'),('14','2','3','分组管理','Group/index','1'),('15','2','4','用户管理','Admin/index','1'),('16','2','5','文件管理','File/index','1'),('17','2','6','备份还原','Database/index','1'),('29','6','1','专家打分表管理','javascript:void(0);','1'),('19','0','7','计算得分','javascript:void(0);','1'),('20','0','8','统计表','javascript:void(0);','1'),('21','0','9','总分排名','javascript:void(0);','1'),('24','3','1','专家用户管理','Expert/index','1'),('25','3','2','指定评审年度专家','javascript:void(0);','1'),('26','4','1','博物馆管理','javascript:void(0);','1'),('27','4','2','各年份参评单位展示','javascript:void(0);','1'),('28','5','1','申报书管理','javascript:void(0);','1'),('30','19','1','定量数据计算','javascript:void(0);','1'),('31','19','2','定量排名计算','javascript:void(0);','1'),('32','19','3','定性数据计算','javascript:void(0);','1'),('33','19','4','定性排名计算','javascript:void(0);','1'),('34','19','5','总分数据计算','javascript:void(0);','1'),('35','19','6','总分排名计算','javascript:void(0);','1'),('36','19','7','全部计算','javascript:void(0);','1'),('37','20','1','总分统计表','javascript:void(0);','1');/* SqlEnd */



-- -----------------------------
-- Table structure for `en_rule`
-- -----------------------------
DROP TABLE IF EXISTS `en_rule`;/* SqlEnd */
CREATE TABLE `en_rule` (
  `id` int(15) NOT NULL AUTO_INCREMENT COMMENT '规则id',
  `pid` int(15) DEFAULT NULL COMMENT '上级id',
  `name` varchar(50) DEFAULT NULL COMMENT '规则名称',
  `rule` varchar(150) DEFAULT NULL COMMENT '规则唯一标识',
  `sort` int(5) DEFAULT NULL COMMENT '排序',
  `level` int(5) DEFAULT NULL COMMENT '层级id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=57 DEFAULT CHARSET=utf8;/* SqlEnd */

-- -----------------------------
-- Records of ``en_rule``
-- -----------------------------
INSERT INTO `en_rule` VALUES ('1','0','附件设置列表','AdjunctConfig/index','1','1'),('2','1','添加附件设置','AdjunctConfig/create','1','2'),('3','1','修改附件设置','AdjunctConfig/editor','2','2'),('4','1','删除附件设置','AdjunctConfig/remove','3','2'),('5','1','批量保存','AdjunctConfig/list_form','4','2'),('6','0','管理人员列表','Admin/index','2','1'),('7','6','添加管理人员','Admin/create','1','2'),('8','6','修改管理人员','Admin/editor','2','2'),('9','6','删除管理人员','Admin/remove','3','2'),('10','6','改变状态','Admin/change_status','4','2'),('11','0','基本设置列表','BasicConfig/index','3','1'),('12','11','添加基本设置','BasicConfig/create','1','2'),('13','11','修改基本设置','BasicConfig/editor','2','2'),('14','11','删除基本设置','BasicConfig/remove','3','2'),('15','11','批量保存','BasicConfig/list_form','4','2'),('16','0','核心设置列表','CoreConfig/index','4','1'),('17','16','添加核心设置','CoreConfig/create','1','2'),('18','16','修改核心设置','CoreConfig/editor','2','2'),('19','16','删除核心设置','CoreConfig/remove','3','2'),('20','16','批量保存','CoreConfig/list_form','4','2'),('56','0','备份文件列表','Database/index','5','1'),('22','0','邮箱设置列表','EmailConfig/index','6','1'),('23','22','添加邮箱设置','EmailConfig/create','1','2'),('24','22','修改邮箱设置','EmailConfig/editor','2','2'),('25','22','删除邮箱设置','EmailConfig/remove','3','2'),('26','22','批量保存','EmailConfig/list_form','4','2'),('27','0','文件夹列表','File/index','7','1'),('28','27','编辑文件','File/editfile','1','2'),('29','27','下载文件','File/downfile','2','2'),('30','27','删除文件','File/delfolder','3','2'),('31','27','批量打包','File/filehandle','4','2'),('32','27','解压','File/decompression','5','2'),('33','0','管理组列表','Group/index','8','1'),('34','33','添加管理组','Group/create','1','2'),('35','33','修改管理组','Group/editor','2','2'),('36','33','删除管理组','Group/remove','3','2'),('37','33','改变状态','Group/change_status','4','2'),('38','33','管理组授权','Group/give_rule','5','2'),('39','0','后台导航列表','Navigation/index','9','1'),('40','39','添加后台导航','Navigation/create','1','2'),('41','39','修改后台导航','Navigation/editor','2','2'),('42','39','删除后台导航','Navigation/remove','3','2'),('43','39','批量保存','Navigation/list_form','4','2'),('44','39','改变状态','Navigation/change_status','5','2'),('45','0','权限规则列表','Rule/index','10','1'),('46','45','添加权限规则','Rule/create','1','2'),('47','45','修改权限规则','Rule/editor','2','2'),('48','45','删除权限规则','Rule/remove','1','2'),('49','45','更新权限规则','Rule/get_all_rule','2','2'),('50','0','站点设置列表','WebConfig/index','11','1'),('51','50','添加站点设置','WebConfig/create','1','2'),('52','50','修改站点设置','WebConfig/editor','2','2'),('53','50','删除站点设置','WebConfig/remove','3','2'),('54','50','批量保存','WebConfig/list_form','4','2');/* SqlEnd */
