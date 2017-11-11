<?php
$sql="CREATE TABLE IF NOT EXISTS `ims_wlmerchant_adv` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `aid` int(11) NOT NULL,
  `advname` varchar(50) DEFAULT '' COMMENT '幻灯片名称',
  `link` varchar(255) DEFAULT '' COMMENT '幻灯片链接',
  `thumb` varchar(255) NOT NULL DEFAULT '' COMMENT '幻灯片图片',
  `displayorder` int(11) DEFAULT '0' COMMENT '排序',
  `enabled` tinyint(2) NOT NULL DEFAULT '0' COMMENT '1显示',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_wlmerchant_agentsetting` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `aid` int(11) NOT NULL,
  `key` varchar(64) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_wlmerchant_agentusers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) NOT NULL,
  `groupid` int(10) unsigned NOT NULL,
  `agentname` varchar(64) NOT NULL,
  `username` varchar(32) NOT NULL,
  `password` varchar(64) NOT NULL,
  `salt` varchar(10) NOT NULL,
  `realname` varchar(32) NOT NULL,
  `mobile` varchar(32) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `joindate` int(10) unsigned NOT NULL,
  `joinip` varchar(15) NOT NULL,
  `lastvisit` int(10) unsigned NOT NULL,
  `lastip` varchar(15) NOT NULL,
  `remark` varchar(500) NOT NULL,
  `starttime` int(10) unsigned NOT NULL,
  `endtime` int(10) unsigned NOT NULL,
  `type` tinyint(3) unsigned NOT NULL,
  `percent` varchar(200) DEFAULT NULL,
  `cashopenid` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `username` (`username`),
  KEY `uniacid` (`uniacid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_wlmerchant_agentusers_group` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `name` varchar(50) NOT NULL,
  `package` varchar(5000) NOT NULL,
  `isdefault` int(2) unsigned NOT NULL,
  `enabled` int(2) unsigned NOT NULL,
  `createtime` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_wlmerchant_apirecord` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `sendmid` int(11) NOT NULL,
  `sendmobile` varchar(15) DEFAULT NULL,
  `takemid` int(11) NOT NULL,
  `takemobile` varchar(15) DEFAULT NULL,
  `type` smallint(2) NOT NULL,
  `remark` varchar(32) DEFAULT NULL,
  `createtime` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_wlmerchant_area` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) unsigned NOT NULL,
  `name` varchar(500) NOT NULL,
  `visible` tinyint(4) unsigned NOT NULL,
  `displayorder` tinyint(11) unsigned NOT NULL,
  `level` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `isShow` (`visible`),
  KEY `parentId` (`pid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_wlmerchant_banner` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '唯一标识',
  `uniacid` int(11) NOT NULL,
  `aid` int(11) NOT NULL,
  `name` varchar(32) NOT NULL,
  `link` varchar(255) NOT NULL,
  `thumb` varchar(255) NOT NULL,
  `displayorder` int(11) NOT NULL,
  `enabled` int(11) NOT NULL,
  `visible_level` varchar(145) NOT NULL COMMENT '1强制推广',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_wlmerchant_category_store` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL DEFAULT '0',
  `aid` int(10) NOT NULL DEFAULT '0',
  `name` varchar(50) NOT NULL COMMENT '分类名称',
  `thumb` varchar(255) NOT NULL COMMENT '分类图片',
  `parentid` int(10) unsigned DEFAULT '0' COMMENT '上级分类ID,0为第一级',
  `isrecommand` int(10) DEFAULT '0',
  `description` varchar(500) DEFAULT NULL COMMENT '分类介绍',
  `displayorder` tinyint(3) unsigned DEFAULT '0' COMMENT '排序',
  `enabled` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否开启',
  `visible_level` int(11) DEFAULT NULL COMMENT '1为首页顶部展示',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_wlmerchant_collect` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `mid` int(11) DEFAULT NULL,
  `storeid` int(11) DEFAULT NULL,
  `createtime` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_wlmerchant_comment` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) unsigned NOT NULL DEFAULT '0',
  `gid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '对应的商品id',
  `mid` int(11) DEFAULT NULL COMMENT '用户ID',
  `sid` int(11) DEFAULT NULL COMMENT '商家ID',
  `parentid` int(11) DEFAULT NULL COMMENT '回复上级ID',
  `pic` varchar(1000) DEFAULT NULL COMMENT '图片',
  `idoforder` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '对应的order的id',
  `text` varchar(800) DEFAULT NULL COMMENT '评价文字',
  `status` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '是否显示 0显示 1不显示',
  `level` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '评价等级 1好评 2中评 3差评',
  `createtime` varchar(145) NOT NULL DEFAULT '0' COMMENT '评价时间',
  `headimg` varchar(255) DEFAULT NULL COMMENT '评价人头像',
  `nickname` varchar(32) DEFAULT NULL COMMENT '评价人昵称',
  `plugin` varchar(32) DEFAULT NULL COMMENT '插件名称',
  `star` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `index` (`idoforder`,`gid`,`status`,`uniacid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='价';
CREATE TABLE IF NOT EXISTS `ims_wlmerchant_couponlist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `aid` int(11) DEFAULT NULL COMMENT '代理id',
  `status` int(11) NOT NULL COMMENT '优惠券状态 1启用 0禁用2已失效',
  `type` int(11) NOT NULL COMMENT '优惠券类型 1 折扣券 2代金券 3礼品券 4 团购券 5优惠券',
  `is_charge` int(11) NOT NULL COMMENT '是否收费 1收费 0免费',
  `logo` varchar(100) NOT NULL COMMENT '优惠券logo',
  `indeximg` varchar(100) DEFAULT NULL COMMENT '优惠券详情顶部图片',
  `merchantid` int(11) NOT NULL COMMENT '商户id',
  `color` varchar(100) NOT NULL COMMENT '优惠券颜色',
  `title` varchar(145) NOT NULL COMMENT '优惠券标题',
  `sub_title` varchar(145) DEFAULT NULL COMMENT '优惠券小标题',
  `goodsdetail` text COMMENT '商品详情',
  `time_type` int(11) NOT NULL COMMENT '时间类型 1.规定时间段 2 领取后限制',
  `starttime` varchar(255) DEFAULT NULL COMMENT '开始时间',
  `endtime` varchar(255) DEFAULT NULL COMMENT '结束时间',
  `deadline` int(11) DEFAULT NULL COMMENT '持续天数',
  `quantity` int(11) NOT NULL COMMENT '库存',
  `surplus` int(11) NOT NULL COMMENT '剩余数量',
  `get_limit` int(11) NOT NULL COMMENT '限量',
  `description` text NOT NULL COMMENT '卡券使用须知',
  `usetimes` int(11) NOT NULL COMMENT '使用次数',
  `createtime` varchar(255) NOT NULL COMMENT '创建时间',
  `price` decimal(10,2) DEFAULT NULL COMMENT '收费金额',
  `is_show` int(11) NOT NULL COMMENT '是否列表显示 0显示 1隐藏',
  `vipstatus` int(11) DEFAULT '0',
  `vipprice` decimal(10,2) DEFAULT '0.00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_wlmerchant_creditrecord` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `openid` varchar(245) NOT NULL,
  `num` varchar(30) NOT NULL,
  `createtime` varchar(145) NOT NULL,
  `transid` varchar(145) NOT NULL,
  `status` int(11) NOT NULL,
  `paytype` int(2) NOT NULL COMMENT '1微信2后台',
  `ordersn` varchar(145) NOT NULL,
  `type` int(2) NOT NULL COMMENT '1积分2余额',
  `remark` varchar(145) NOT NULL,
  `table` tinyint(4) DEFAULT NULL COMMENT '1微擎2tg',
  `uid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_wlmerchant_goodshouse` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `sid` int(11) DEFAULT NULL COMMENT '商家id',
  `aid` int(11) DEFAULT NULL COMMENT '代理id',
  `name` varchar(145) DEFAULT NULL COMMENT '活动名称',
  `code` varchar(145) DEFAULT NULL COMMENT '商品编号',
  `describe` varchar(255) DEFAULT NULL COMMENT '描述',
  `detail` text COMMENT '详情',
  `price` decimal(10,2) DEFAULT '0.00' COMMENT '抢购价',
  `oldprice` decimal(10,2) DEFAULT '0.00' COMMENT '原价',
  `vipprice` decimal(10,2) DEFAULT '0.00' COMMENT 'vip价格',
  `num` int(11) DEFAULT NULL COMMENT '限量',
  `levelnum` int(11) DEFAULT NULL COMMENT '剩余数量',
  `endtime` varchar(225) DEFAULT NULL COMMENT '活动结束时间',
  `follow` int(11) DEFAULT NULL COMMENT '关注人数',
  `tag` text COMMENT '标签',
  `share_title` varchar(32) DEFAULT NULL,
  `share_image` varchar(250) DEFAULT NULL,
  `share_desc` varchar(32) DEFAULT NULL,
  `unit` varchar(32) DEFAULT NULL COMMENT '单位',
  `thumb` varchar(145) DEFAULT NULL COMMENT '首页图片',
  `thumbs` text COMMENT '图集',
  `salenum` int(11) DEFAULT NULL COMMENT '销量',
  `displayorder` int(11) DEFAULT NULL COMMENT '排序',
  `stock` int(11) DEFAULT NULL COMMENT '库存',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_wlmerchant_halfcard_record` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `mid` int(11) DEFAULT NULL,
  `aid` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL COMMENT '充值金额',
  `howlong` varchar(145) DEFAULT NULL COMMENT '充值五折卡月数',
  `paytime` varchar(145) DEFAULT NULL COMMENT '充值时间',
  `orderno` varchar(145) DEFAULT NULL COMMENT '充值单号',
  `limittime` varchar(145) DEFAULT NULL COMMENT '下次到期时期',
  `status` int(11) DEFAULT NULL COMMENT '0未支付 1已经支付',
  `paytype` int(11) DEFAULT NULL,
  `transid` varchar(145) DEFAULT NULL,
  `createtime` varchar(145) DEFAULT NULL COMMENT '创建时间',
  `issettlement` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `adx_uniacid` (`uniacid`),
  KEY `adx_aid` (`aid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_wlmerchant_halfcard_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `logo` varchar(145) DEFAULT NULL,
  `name` varchar(145) DEFAULT NULL,
  `days` int(11) DEFAULT '0',
  `price` decimal(10,2) DEFAULT '0.00',
  `status` int(11) DEFAULT NULL,
  `num` int(11) DEFAULT NULL,
  `aid` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_wlmerchant_halfcardlist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL COMMENT '公众号id',
  `aid` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL COMMENT '状态 1启用 0禁用',
  `merchantid` int(11) NOT NULL COMMENT '商户id',
  `title` varchar(145) NOT NULL COMMENT '商品标题',
  `datestatus` int(11) NOT NULL COMMENT '时间格式 1 星期 2日期',
  `week` text COMMENT '五折时间 星期',
  `day` text COMMENT '五折时间 天数',
  `adv` text NOT NULL COMMENT '幻灯片',
  `limit` text COMMENT '限制说明',
  `detail` text COMMENT '商品详细说明',
  `describe` text COMMENT '半价卡使用说明',
  `createtime` varchar(100) NOT NULL COMMENT '创建时间',
  `pv` int(11) DEFAULT NULL COMMENT '浏览次数',
  `discount` decimal(10,1) DEFAULT '0.0',
  `daily` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `adx_uniacid` (`uniacid`),
  KEY `adx_aid` (`aid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_wlmerchant_halfcardmember` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `aid` int(11) DEFAULT NULL COMMENT '代理id',
  `mid` int(11) DEFAULT NULL COMMENT '用户id',
  `expiretime` int(11) DEFAULT NULL COMMENT '五折卡结束时间',
  `createtime` int(11) DEFAULT NULL COMMENT '记录创建时间',
  PRIMARY KEY (`id`),
  KEY `adx_uniacid` (`uniacid`),
  KEY `adx_aid` (`aid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_wlmerchant_halfcardrecord` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `mid` int(11) NOT NULL,
  `aid` int(11) NOT NULL,
  `status` int(11) NOT NULL COMMENT '状态 1未使用 2已经使用',
  `activeid` int(11) NOT NULL COMMENT '五折活动ID',
  `merchantid` int(11) NOT NULL COMMENT '五折店铺ID',
  `date` varchar(145) NOT NULL COMMENT '优惠日期',
  `qrcode` varchar(145) NOT NULL COMMENT '核销号码',
  `hexiaotime` varchar(45) NOT NULL COMMENT '核销时间',
  `verfmid` int(11) NOT NULL COMMENT '核销人',
  `createtime` varchar(45) NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `adx_uniacid` (`uniacid`),
  KEY `adx_aid` (`aid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_wlmerchant_indexset` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `aid` int(11) NOT NULL,
  `key` varchar(32) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='主页设置：排版；魔方';
CREATE TABLE IF NOT EXISTS `ims_wlmerchant_member` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '会员ID',
  `uid` int(11) NOT NULL COMMENT '微擎会员id',
  `invid` int(11) NOT NULL COMMENT '邀请人id',
  `uniacid` int(11) NOT NULL COMMENT '公众号ID',
  `openid` varchar(100) NOT NULL,
  `unionid` varchar(100) NOT NULL,
  `nickname` varchar(50) NOT NULL,
  `realname` varchar(50) NOT NULL,
  `credit1` decimal(10,2) NOT NULL COMMENT '积分',
  `credit2` decimal(10,2) NOT NULL COMMENT '余额',
  `gender` int(11) NOT NULL,
  `isvip` int(11) NOT NULL DEFAULT '1' COMMENT '会员类型1普通2VIP',
  `vipendtime` int(11) NOT NULL COMMENT '会员到期时间',
  `avatar` varchar(445) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `createtime` int(11) NOT NULL COMMENT '创建时间',
  `areaid` int(11) DEFAULT NULL COMMENT '地区ID',
  `aid` int(11) DEFAULT NULL COMMENT '所属代理ID',
  `level` int(11) DEFAULT '0' COMMENT '1：VIP1',
  `dealnum` int(11) DEFAULT '0' COMMENT '成交量',
  `dealmoney` decimal(10,2) DEFAULT '0.00' COMMENT '成交额',
  `vipstatus` int(11) DEFAULT NULL COMMENT 'VIP状态',
  `lastviptime` varchar(145) DEFAULT '0' COMMENT '上次VIP应该结束时间',
  `vipleveldays` int(11) DEFAULT '0' COMMENT '会员持续天数，每天更新',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_wlmerchant_member_coupons` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `mid` int(11) NOT NULL COMMENT '用户id',
  `aid` int(11) DEFAULT NULL COMMENT '代理ID',
  `parentid` int(11) NOT NULL COMMENT '父类优惠券id',
  `status` int(11) NOT NULL COMMENT '卡券状态 1未使用 2已使用 5未支付',
  `type` int(11) NOT NULL COMMENT '优惠券类型 1 折扣券 2代金券 3礼品券 4 团购券 5优惠券',
  `title` varchar(145) DEFAULT NULL COMMENT '优惠券标题',
  `sub_title` varchar(145) DEFAULT NULL COMMENT '优惠券副标题',
  `content` text NOT NULL COMMENT '优惠券内容',
  `description` text NOT NULL COMMENT '使用须知',
  `color` varchar(32) DEFAULT NULL COMMENT '颜色',
  `usetimes` int(11) DEFAULT NULL COMMENT '剩余使用次数',
  `starttime` int(11) NOT NULL COMMENT '开始时间',
  `endtime` int(11) NOT NULL COMMENT '结束时间',
  `createtime` int(11) NOT NULL COMMENT '创建时间',
  `usedtime` text COMMENT '使用时间',
  `orderno` varchar(145) DEFAULT NULL COMMENT '订单号',
  `price` decimal(10,2) DEFAULT NULL COMMENT '支付金额',
  `concode` varchar(32) DEFAULT NULL COMMENT '消费码',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_wlmerchant_member_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `logo` varchar(145) DEFAULT NULL,
  `name` varchar(145) DEFAULT NULL,
  `days` int(11) DEFAULT '0',
  `price` decimal(10,2) DEFAULT '0.00',
  `uniacid` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL COMMENT '1显示',
  `num` int(11) DEFAULT NULL COMMENT '可开通次数',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_wlmerchant_merchant_account` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `sid` int(11) NOT NULL COMMENT '商家ID',
  `uid` int(11) NOT NULL COMMENT '操作员id',
  `amount` decimal(10,2) NOT NULL COMMENT '交易总金额',
  `updatetime` varchar(45) NOT NULL COMMENT '上次结算时间',
  `no_money` decimal(10,2) NOT NULL COMMENT '目前未结算金额',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_wlmerchant_merchant_money_record` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `sid` int(11) DEFAULT NULL COMMENT '商家ID',
  `money` decimal(10,2) DEFAULT '0.00' COMMENT '变动金额',
  `createtime` varchar(145) DEFAULT NULL COMMENT '变动时间',
  `orderid` int(11) DEFAULT NULL COMMENT '订单ID',
  `type` int(11) DEFAULT NULL COMMENT '1支付成功2发货成功成为可结算金额3取消发货4商家结算5退款',
  `detail` text COMMENT '详情',
  `plugin` varchar(32) DEFAULT NULL COMMENT '插件名',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='商家金额记录';
CREATE TABLE IF NOT EXISTS `ims_wlmerchant_merchant_record` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `sid` int(11) NOT NULL COMMENT '商家id',
  `percent` varchar(32) NOT NULL COMMENT '佣金百分比',
  `commission` varchar(32) NOT NULL COMMENT '佣金',
  `money` varchar(45) NOT NULL COMMENT '本次结算金额',
  `get_money` varchar(32) DEFAULT NULL COMMENT '本次商家得到金额',
  `uid` int(11) NOT NULL COMMENT '操作员id',
  `createtime` varchar(45) NOT NULL COMMENT '结算时间',
  `orderno` varchar(145) NOT NULL COMMENT '订单号',
  `plugin` varchar(32) DEFAULT NULL COMMENT '插件名',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_wlmerchant_merchantdata` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `aid` int(11) DEFAULT NULL COMMENT '代理id',
  `provinceid` int(11) DEFAULT NULL COMMENT '省ID',
  `areaid` int(11) NOT NULL COMMENT '地区id',
  `distid` int(11) DEFAULT NULL COMMENT '区县id',
  `storename` varchar(64) NOT NULL COMMENT '店铺名称',
  `mobile` varchar(32) DEFAULT NULL COMMENT '联系电话',
  `onelevel` int(11) NOT NULL COMMENT '一级分类',
  `twolevel` int(11) NOT NULL COMMENT '二级分类',
  `logo` varchar(128) DEFAULT NULL COMMENT '店铺logo',
  `introduction` text COMMENT '店铺简介',
  `address` varchar(100) DEFAULT NULL COMMENT '店铺地址',
  `location` varchar(64) DEFAULT NULL COMMENT '具体位置',
  `realname` varchar(32) DEFAULT NULL COMMENT '联系人',
  `tel` varchar(20) DEFAULT NULL COMMENT '联系电话',
  `enabled` int(2) DEFAULT NULL COMMENT '商户状态',
  `status` int(2) DEFAULT NULL COMMENT '是否审核通过',
  `groupid` int(11) DEFAULT NULL COMMENT '所属组别',
  `storehours` varchar(100) DEFAULT NULL COMMENT '营业时间',
  `endtime` int(11) DEFAULT NULL COMMENT '结束时间',
  `createtime` int(11) NOT NULL COMMENT '创建时间',
  `remark` text COMMENT '备注',
  `percent` decimal(10,2) DEFAULT '0.00',
  `cardsn` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `key_uniacid` (`uniacid`),
  KEY `key_areaid` (`areaid`),
  KEY `key_location` (`location`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='商户资料表';
CREATE TABLE IF NOT EXISTS `ims_wlmerchant_merchantuser` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `mid` int(11) NOT NULL COMMENT '绑定微信id',
  `storeid` int(11) NOT NULL COMMENT '商户id',
  `name` varchar(64) NOT NULL COMMENT '姓名',
  `mobile` varchar(32) NOT NULL COMMENT '电话',
  `account` varchar(32) DEFAULT NULL COMMENT '账号',
  `salt` varchar(16) DEFAULT NULL COMMENT '加密盐',
  `password` varchar(64) DEFAULT NULL COMMENT '密码',
  `groupid` int(11) DEFAULT NULL COMMENT '所属组别',
  `areaid` varchar(16) NOT NULL COMMENT '区域id',
  `endtime` varchar(32) DEFAULT NULL COMMENT '到期时间',
  `createtime` varchar(32) NOT NULL COMMENT '创建时间',
  `limit` text NOT NULL COMMENT '拥有权限',
  `reject` varchar(300) DEFAULT NULL COMMENT '驳回原因',
  `status` int(2) NOT NULL COMMENT '是否通过审核',
  `enabled` int(2) NOT NULL COMMENT '是否启用',
  `ismain` int(2) DEFAULT NULL COMMENT '1超级管理员2核销员',
  `aid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='代理、商户表';
CREATE TABLE IF NOT EXISTS `ims_wlmerchant_merchantuser_qrlog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `memberid` int(11) NOT NULL,
  `codes` int(11) DEFAULT NULL,
  `status` int(1) NOT NULL,
  `createtime` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_wlmerchant_nav` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '唯一标识',
  `uniacid` int(11) NOT NULL,
  `aid` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `link` varchar(255) NOT NULL,
  `thumb` varchar(255) NOT NULL,
  `displayorder` int(11) NOT NULL,
  `enabled` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_wlmerchant_notice` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '唯一标识',
  `uniacid` int(11) NOT NULL,
  `aid` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text,
  `enabled` int(11) NOT NULL,
  `createtime` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_wlmerchant_oparea` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) NOT NULL,
  `areaid` int(11) NOT NULL,
  `aid` int(10) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '0禁用1启用',
  `ishot` int(11) NOT NULL COMMENT '0非热门1热门城市',
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_wlmerchant_oplog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `describe` varchar(225) DEFAULT NULL COMMENT '操作描述',
  `view_url` varchar(225) DEFAULT NULL COMMENT '操作界面url',
  `ip` varchar(32) DEFAULT NULL COMMENT 'IP',
  `data` varchar(1024) DEFAULT NULL COMMENT '操作数据',
  `createtime` varchar(32) DEFAULT NULL COMMENT '操作时间',
  `user` varchar(32) DEFAULT NULL COMMENT '操作员',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_wlmerchant_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL COMMENT '公众号ID',
  `mid` int(11) DEFAULT NULL COMMENT '用户id',
  `aid` int(11) DEFAULT NULL COMMENT '代理id',
  `sid` int(11) DEFAULT NULL COMMENT '商家id',
  `orderno` varchar(145) DEFAULT NULL COMMENT '订单号',
  `fkid` int(11) DEFAULT NULL COMMENT '商品关联ID',
  `status` int(11) DEFAULT NULL COMMENT '状态 0未支付 1已支付',
  `oprice` decimal(10,2) DEFAULT '0.00' COMMENT '原价',
  `price` decimal(10,2) DEFAULT '0.00' COMMENT '实际支付金额',
  `num` int(11) DEFAULT NULL COMMENT '购买数量',
  `paytime` varchar(145) DEFAULT NULL COMMENT '支付时间',
  `paytype` int(11) DEFAULT NULL COMMENT '支付方式 1微信',
  `createtime` varchar(145) DEFAULT NULL COMMENT '创建时间',
  `remark` text COMMENT '卖家备注',
  `issettlement` int(11) DEFAULT '0' COMMENT '1待结算2已结算',
  `plugin` varchar(32) DEFAULT NULL COMMENT '插件',
  `payfor` varchar(32) DEFAULT NULL COMMENT '干什么支付',
  `is_usecard` tinyint(3) DEFAULT NULL COMMENT '1使用优惠',
  `card_type` tinyint(3) DEFAULT NULL COMMENT '优惠类型',
  `card_id` int(3) DEFAULT NULL COMMENT '优惠ID',
  `card_fee` decimal(10,2) DEFAULT '0.00' COMMENT '优惠金额',
  `transid` varchar(145) DEFAULT NULL COMMENT '微信订单号',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_wlmerchant_paylog` (
  `plid` bigint(11) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(20) NOT NULL,
  `uniacid` int(11) NOT NULL,
  `acid` int(10) NOT NULL,
  `openid` varchar(40) NOT NULL,
  `uniontid` varchar(64) NOT NULL,
  `tid` varchar(128) NOT NULL,
  `fee` decimal(10,2) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `module` varchar(50) NOT NULL,
  `tag` varchar(2000) NOT NULL,
  `is_usecard` tinyint(3) unsigned NOT NULL,
  `card_type` tinyint(3) unsigned NOT NULL,
  `card_id` varchar(50) NOT NULL,
  `card_fee` decimal(10,2) unsigned NOT NULL,
  `encrypt_code` varchar(100) NOT NULL,
  `plugin` varchar(50) DEFAULT NULL COMMENT '插件名',
  `payfor` varchar(145) DEFAULT NULL COMMENT '干什么支付',
  PRIMARY KEY (`plid`),
  KEY `idx_openid` (`openid`),
  KEY `idx_tid` (`tid`),
  KEY `idx_uniacid` (`uniacid`),
  KEY `uniontid` (`uniontid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_wlmerchant_puv` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `areaid` int(11) DEFAULT NULL COMMENT '地区id',
  `uniacid` int(11) NOT NULL,
  `pv` int(11) NOT NULL,
  `uv` int(11) NOT NULL,
  `date` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_wlmerchant_puvrecord` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `mid` int(11) NOT NULL,
  `pv` int(11) NOT NULL,
  `date` varchar(20) NOT NULL,
  `areaid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`),
  KEY `mid` (`mid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_wlmerchant_qrcode` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `aid` int(10) DEFAULT NULL,
  `uniacid` int(10) unsigned NOT NULL,
  `sid` int(11) NOT NULL COMMENT '商户ID',
  `qrid` int(10) unsigned NOT NULL,
  `model` tinyint(1) NOT NULL,
  `cardsn` varchar(64) NOT NULL,
  `salt` varchar(32) DEFAULT NULL COMMENT '加密盐',
  `status` tinyint(1) unsigned NOT NULL,
  `createtime` int(10) unsigned NOT NULL,
  `remark` varchar(50) NOT NULL COMMENT '场景备注',
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`),
  KEY `aid` (`aid`),
  KEY `qrid` (`qrid`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_wlmerchant_refund_record` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `type` int(11) NOT NULL COMMENT '1手机端2Web端3最后一人退款4部分退款5计划任务退款',
  `payfee` varchar(100) NOT NULL COMMENT '支付金额',
  `paytype` int(3) DEFAULT NULL COMMENT '支付方式1余额2微信',
  `refundfee` varchar(100) NOT NULL COMMENT '退还金额',
  `transid` varchar(115) NOT NULL COMMENT '订单编号',
  `refund_id` varchar(115) NOT NULL COMMENT '微信退款单号',
  `refundername` varchar(100) NOT NULL COMMENT '退款人姓名',
  `refundermobile` varchar(100) NOT NULL COMMENT '退款人电话',
  `goodsname` varchar(100) NOT NULL COMMENT '商品名称',
  `createtime` varchar(45) NOT NULL COMMENT '退款时间',
  `status` int(11) NOT NULL COMMENT '0未成功1成功',
  `orderid` varchar(45) NOT NULL COMMENT '订单id',
  `sid` int(11) NOT NULL COMMENT '商家id',
  `remark` text COMMENT '退款备注',
  `plugin` varchar(32) DEFAULT NULL COMMENT '插件名称',
  `errmsg` varchar(445) DEFAULT '0' COMMENT '退款错误信息',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_wlmerchant_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '角色id',
  `uniacid` int(11) NOT NULL COMMENT '公众号id',
  `limit` text NOT NULL COMMENT '该角色拥有的权限数组',
  `title` varchar(32) NOT NULL COMMENT '角色title',
  `status` int(2) NOT NULL COMMENT '角色是否显示状态：2显示；0、1不显示',
  `type` int(2) NOT NULL COMMENT '角色类型（备用）',
  `createtime` varchar(32) NOT NULL COMMENT '创建时间',
  `updatetime` varchar(32) NOT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='角色创建表';
CREATE TABLE IF NOT EXISTS `ims_wlmerchant_rush_activity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL COMMENT '公众号id',
  `sid` int(11) DEFAULT NULL COMMENT '商家id',
  `aid` int(11) DEFAULT NULL COMMENT '代理id',
  `name` varchar(145) DEFAULT NULL COMMENT '活动名称【可和仓库的商品名称一致】',
  `code` varchar(145) DEFAULT NULL COMMENT '商品编号',
  `detail` text COMMENT '详情',
  `price` decimal(10,2) DEFAULT NULL COMMENT '抢购价',
  `oldprice` decimal(10,2) DEFAULT NULL COMMENT '原价',
  `vipprice` decimal(10,2) DEFAULT '0.00' COMMENT 'vip价格',
  `num` int(11) DEFAULT NULL COMMENT '限量',
  `levelnum` int(11) DEFAULT NULL COMMENT '剩余数量',
  `status` int(11) DEFAULT '1' COMMENT '1进行中2已结束',
  `starttime` varchar(225) DEFAULT NULL COMMENT '活动开始时间',
  `endtime` varchar(225) DEFAULT NULL COMMENT '活动结束时间',
  `follow` int(11) DEFAULT NULL COMMENT '关注人数',
  `tag` text COMMENT '标签',
  `share_title` varchar(32) DEFAULT NULL,
  `share_image` varchar(250) DEFAULT NULL,
  `share_desc` varchar(32) DEFAULT NULL,
  `unit` varchar(32) DEFAULT NULL COMMENT '单位',
  `thumb` varchar(145) DEFAULT NULL COMMENT '首页图片',
  `thumbs` text COMMENT '图集',
  `describe` text,
  `op_one_limit` int(11) DEFAULT NULL COMMENT '单人限购',
  `cutofftime` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_wlmerchant_rush_follows` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `aid` int(11) DEFAULT NULL,
  `mid` int(11) DEFAULT NULL,
  `actid` int(11) DEFAULT NULL,
  `sendtime` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `adx_uniacid` (`uniacid`),
  KEY `adx_aid` (`aid`),
  KEY `adx_sendtime` (`sendtime`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_wlmerchant_rush_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `unionid` varchar(145) DEFAULT NULL COMMENT '用户微信id',
  `openid` varchar(225) DEFAULT NULL,
  `mid` int(11) DEFAULT NULL COMMENT '会员ID',
  `aid` int(11) DEFAULT NULL COMMENT '代理id',
  `sid` int(11) DEFAULT NULL COMMENT '商家id',
  `activityid` int(11) DEFAULT NULL COMMENT '活动id',
  `status` int(11) DEFAULT NULL COMMENT '0未支付1已支付2已消费',
  `orderno` varchar(145) DEFAULT NULL COMMENT '订单号',
  `transid` varchar(145) DEFAULT NULL COMMENT '微信支付ID',
  `price` decimal(10,2) DEFAULT NULL COMMENT '实际支付金额',
  `mobile` varchar(145) DEFAULT NULL COMMENT '电话',
  `num` int(11) DEFAULT NULL COMMENT '抢购数量',
  `actualprice` decimal(10,2) DEFAULT NULL COMMENT '实际支付',
  `goodscode` varchar(145) DEFAULT NULL COMMENT '商品编号',
  `paytime` varchar(145) DEFAULT NULL COMMENT '支付时间',
  `paytype` int(2) DEFAULT NULL COMMENT '支付方式 1余额 2微信 3支付宝 4货到付款',
  `checkcode` varchar(145) DEFAULT NULL COMMENT '核销码',
  `createtime` varchar(225) DEFAULT NULL COMMENT '创建时间',
  `adminremark` text COMMENT '卖家备注',
  `verfmid` int(11) NOT NULL,
  `verftime` int(11) NOT NULL,
  `issettlement` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_wlmerchant_setting` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `key` varchar(64) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_wlmerchant_settlement_record` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `sid` int(11) DEFAULT NULL,
  `aid` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT '0' COMMENT '-1系统审核不通过-2代理审核不通过1代理审核中2系统审核中，3系统审核通过，待结算,4已结算给代理,5已结算到商家',
  `type` int(11) DEFAULT '0' COMMENT '1商家售卖金额提现申请2代理VIP开通金额申请3代理五折卡开通金额申请',
  `sapplymoney` decimal(10,2) DEFAULT '0.00' COMMENT '商家申请结算金额',
  `aapplymoney` decimal(10,2) DEFAULT '0.00' COMMENT '代理申请金额',
  `sgetmoney` decimal(10,2) DEFAULT '0.00' COMMENT '商家实际得到金额',
  `agetmoney` decimal(10,2) DEFAULT '0.00' COMMENT '代理实际得到金额',
  `spercentmoney` decimal(10,2) DEFAULT '0.00' COMMENT '商家缴纳佣金',
  `apercentmoney` decimal(10,2) DEFAULT '0.00' COMMENT '代理缴纳佣金',
  `spercent` decimal(10,4) DEFAULT '0.0000' COMMENT '商家给代理的抽成比例',
  `apercent` decimal(10,4) DEFAULT '0.0000' COMMENT '代理给系统的抽成比例',
  `applytime` varchar(145) DEFAULT NULL COMMENT '申请时间',
  `updatetime` varchar(145) DEFAULT NULL COMMENT '最后操作时间',
  `settletype` int(11) DEFAULT '0' COMMENT '1手动结算2微信钱包',
  `ids` text COMMENT '申请结算的订单id集',
  `ordernum` int(11) DEFAULT NULL COMMENT '结算订单数',
  `sopenid` varchar(145) DEFAULT NULL,
  `aopenid` varchar(145) DEFAULT NULL,
  `type2` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='商家向代理提出结算申请记录';
CREATE TABLE IF NOT EXISTS `ims_wlmerchant_smstpl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `type` varchar(32) NOT NULL,
  `smstplid` varchar(32) NOT NULL,
  `data` text NOT NULL,
  `status` smallint(2) NOT NULL,
  `createtime` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_wlmerchant_store_notice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `mid` int(11) NOT NULL,
  `sid` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `createtime` int(11) NOT NULL,
  `content` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_uniacid` (`uniacid`),
  KEY `idx_mid` (`mid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_wlmerchant_storefans` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `sid` int(11) NOT NULL,
  `mid` int(11) NOT NULL,
  `source` int(2) NOT NULL COMMENT '1收藏店铺2挪车卡绑定3店铺二维码',
  `createtime` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_uniacid` (`uniacid`),
  KEY `idx_sid` (`sid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_wlmerchant_storeusers_group` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `name` varchar(50) NOT NULL,
  `package` varchar(5000) NOT NULL,
  `isdefault` int(2) unsigned NOT NULL,
  `enabled` int(2) unsigned NOT NULL,
  `createtime` int(11) unsigned NOT NULL,
  `aid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_wlmerchant_token` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `number` varchar(145) DEFAULT '0.00',
  `uniacid` int(11) DEFAULT NULL,
  `aid` int(11) DEFAULT '0',
  `days` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT '0.00',
  `type` int(11) DEFAULT NULL COMMENT '可生成类型ID',
  `tokentype` int(11) DEFAULT NULL COMMENT '邀请码类型1VIP2五折',
  `typename` varchar(145) DEFAULT NULL COMMENT '可生成类型名称',
  `status` int(11) DEFAULT '0' COMMENT '1使用中',
  `remark` text,
  `openid` varchar(145) DEFAULT NULL,
  `mid` int(11) DEFAULT NULL,
  `createtime` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_wlmerchant_token_apply` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `aid` int(11) DEFAULT NULL,
  `type` int(11) DEFAULT NULL COMMENT '申请指定类型激活码的id',
  `tokentype` int(11) DEFAULT NULL COMMENT '1VIP2五折',
  `num` int(11) DEFAULT NULL COMMENT '申请生成个数',
  `createtime` varchar(145) DEFAULT NULL COMMENT '申请时间',
  `status` int(11) DEFAULT NULL COMMENT '申请状态',
  `uniacid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_wlmerchant_vip_record` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mid` int(11) DEFAULT NULL,
  `uid` int(11) DEFAULT NULL,
  `areaid` int(11) DEFAULT NULL,
  `aid` int(11) DEFAULT NULL,
  `openid` varchar(145) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT '0.00' COMMENT '充值金额',
  `howlong` varchar(145) DEFAULT NULL COMMENT '充值VIP月数',
  `createtime` varchar(145) DEFAULT NULL COMMENT '创建时间',
  `paytime` varchar(145) DEFAULT NULL COMMENT '充值时间',
  `orderno` varchar(145) DEFAULT NULL COMMENT '充值单号',
  `limittime` varchar(145) DEFAULT NULL COMMENT '下次会员到期时间',
  `status` int(11) DEFAULT '0' COMMENT '0未支付1已支付',
  `uniacid` int(11) DEFAULT NULL,
  `unionid` varchar(145) DEFAULT NULL,
  `paytype` int(11) DEFAULT NULL,
  `transid` varchar(145) DEFAULT NULL,
  `issettlement` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_wlmerchant_waittask` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `value` varchar(145) DEFAULT NULL,
  `key` varchar(145) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
";
pdo_run($sql);
if(!pdo_fieldexists('wlmerchant_adv',  'id')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_adv')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists('wlmerchant_adv',  'uniacid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_adv')." ADD `uniacid` int(11) NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_adv',  'aid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_adv')." ADD `aid` int(11) NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_adv',  'advname')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_adv')." ADD `advname` varchar(50) DEFAULT '' COMMENT '幻灯片名称';");
}
if(!pdo_fieldexists('wlmerchant_adv',  'link')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_adv')." ADD `link` varchar(255) DEFAULT '' COMMENT '幻灯片链接';");
}
if(!pdo_fieldexists('wlmerchant_adv',  'thumb')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_adv')." ADD `thumb` varchar(255) NOT NULL DEFAULT '' COMMENT '幻灯片图片';");
}
if(!pdo_fieldexists('wlmerchant_adv',  'displayorder')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_adv')." ADD `displayorder` int(11) DEFAULT '0' COMMENT '排序';");
}
if(!pdo_fieldexists('wlmerchant_adv',  'enabled')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_adv')." ADD `enabled` tinyint(2) NOT NULL DEFAULT '0' COMMENT '1显示';");
}
if(!pdo_fieldexists('wlmerchant_agentsetting',  'id')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_agentsetting')." ADD `id` int(11) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists('wlmerchant_agentsetting',  'uniacid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_agentsetting')." ADD `uniacid` int(11) NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_agentsetting',  'aid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_agentsetting')." ADD `aid` int(11) NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_agentsetting',  'key')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_agentsetting')." ADD `key` varchar(64) NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_agentsetting',  'value')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_agentsetting')." ADD `value` text NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_agentusers',  'id')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_agentusers')." ADD `id` int(10) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists('wlmerchant_agentusers',  'uniacid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_agentusers')." ADD `uniacid` int(10) NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_agentusers',  'groupid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_agentusers')." ADD `groupid` int(10) unsigned NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_agentusers',  'agentname')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_agentusers')." ADD `agentname` varchar(64) NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_agentusers',  'username')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_agentusers')." ADD `username` varchar(32) NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_agentusers',  'password')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_agentusers')." ADD `password` varchar(64) NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_agentusers',  'salt')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_agentusers')." ADD `salt` varchar(10) NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_agentusers',  'realname')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_agentusers')." ADD `realname` varchar(32) NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_agentusers',  'mobile')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_agentusers')." ADD `mobile` varchar(32) NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_agentusers',  'status')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_agentusers')." ADD `status` tinyint(4) NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_agentusers',  'joindate')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_agentusers')." ADD `joindate` int(10) unsigned NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_agentusers',  'joinip')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_agentusers')." ADD `joinip` varchar(15) NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_agentusers',  'lastvisit')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_agentusers')." ADD `lastvisit` int(10) unsigned NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_agentusers',  'lastip')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_agentusers')." ADD `lastip` varchar(15) NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_agentusers',  'remark')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_agentusers')." ADD `remark` varchar(500) NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_agentusers',  'starttime')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_agentusers')." ADD `starttime` int(10) unsigned NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_agentusers',  'endtime')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_agentusers')." ADD `endtime` int(10) unsigned NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_agentusers',  'type')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_agentusers')." ADD `type` tinyint(3) unsigned NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_agentusers',  'percent')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_agentusers')." ADD `percent` varchar(200) DEFAULT NULL;");
}
if(!pdo_fieldexists('wlmerchant_agentusers',  'cashopenid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_agentusers')." ADD `cashopenid` varchar(200) DEFAULT NULL;");
}
if(!pdo_indexexists('wlmerchant_agentusers',  'username')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_agentusers')." ADD KEY `username` (`username`);");
}
if(!pdo_indexexists('wlmerchant_agentusers',  'uniacid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_agentusers')." ADD KEY `uniacid` (`uniacid`);");
}
if(!pdo_fieldexists('wlmerchant_agentusers_group',  'id')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_agentusers_group')." ADD `id` int(10) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists('wlmerchant_agentusers_group',  'uniacid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_agentusers_group')." ADD `uniacid` int(10) unsigned NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_agentusers_group',  'name')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_agentusers_group')." ADD `name` varchar(50) NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_agentusers_group',  'package')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_agentusers_group')." ADD `package` varchar(5000) NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_agentusers_group',  'isdefault')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_agentusers_group')." ADD `isdefault` int(2) unsigned NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_agentusers_group',  'enabled')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_agentusers_group')." ADD `enabled` int(2) unsigned NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_agentusers_group',  'createtime')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_agentusers_group')." ADD `createtime` int(11) unsigned NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_apirecord',  'id')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_apirecord')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists('wlmerchant_apirecord',  'uniacid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_apirecord')." ADD `uniacid` int(11) NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_apirecord',  'sendmid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_apirecord')." ADD `sendmid` int(11) NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_apirecord',  'sendmobile')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_apirecord')." ADD `sendmobile` varchar(15) DEFAULT NULL;");
}
if(!pdo_fieldexists('wlmerchant_apirecord',  'takemid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_apirecord')." ADD `takemid` int(11) NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_apirecord',  'takemobile')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_apirecord')." ADD `takemobile` varchar(15) DEFAULT NULL;");
}
if(!pdo_fieldexists('wlmerchant_apirecord',  'type')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_apirecord')." ADD `type` smallint(2) NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_apirecord',  'remark')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_apirecord')." ADD `remark` varchar(32) DEFAULT NULL;");
}
if(!pdo_fieldexists('wlmerchant_apirecord',  'createtime')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_apirecord')." ADD `createtime` int(11) NOT NULL;");
}
if(!pdo_indexexists('wlmerchant_apirecord',  'uniacid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_apirecord')." ADD KEY `uniacid` (`uniacid`);");
}
if(!pdo_fieldexists('wlmerchant_area',  'id')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_area')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists('wlmerchant_area',  'pid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_area')." ADD `pid` int(11) unsigned NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_area',  'name')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_area')." ADD `name` varchar(500) NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_area',  'visible')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_area')." ADD `visible` tinyint(4) unsigned NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_area',  'displayorder')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_area')." ADD `displayorder` tinyint(11) unsigned NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_area',  'level')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_area')." ADD `level` tinyint(3) unsigned NOT NULL;");
}
if(!pdo_indexexists('wlmerchant_area',  'isShow')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_area')." ADD KEY `isShow` (`visible`);");
}
if(!pdo_indexexists('wlmerchant_area',  'parentId')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_area')." ADD KEY `parentId` (`pid`);");
}
if(!pdo_fieldexists('wlmerchant_banner',  'id')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_banner')." ADD `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '唯一标识';");
}
if(!pdo_fieldexists('wlmerchant_banner',  'uniacid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_banner')." ADD `uniacid` int(11) NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_banner',  'aid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_banner')." ADD `aid` int(11) NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_banner',  'name')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_banner')." ADD `name` varchar(32) NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_banner',  'link')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_banner')." ADD `link` varchar(255) NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_banner',  'thumb')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_banner')." ADD `thumb` varchar(255) NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_banner',  'displayorder')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_banner')." ADD `displayorder` int(11) NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_banner',  'enabled')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_banner')." ADD `enabled` int(11) NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_banner',  'visible_level')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_banner')." ADD `visible_level` varchar(145) NOT NULL COMMENT '1强制推广';");
}
if(!pdo_fieldexists('wlmerchant_category_store',  'id')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_category_store')." ADD `id` int(10) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists('wlmerchant_category_store',  'uniacid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_category_store')." ADD `uniacid` int(10) unsigned NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists('wlmerchant_category_store',  'aid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_category_store')." ADD `aid` int(10) NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists('wlmerchant_category_store',  'name')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_category_store')." ADD `name` varchar(50) NOT NULL COMMENT '分类名称';");
}
if(!pdo_fieldexists('wlmerchant_category_store',  'thumb')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_category_store')." ADD `thumb` varchar(255) NOT NULL COMMENT '分类图片';");
}
if(!pdo_fieldexists('wlmerchant_category_store',  'parentid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_category_store')." ADD `parentid` int(10) unsigned DEFAULT '0' COMMENT '上级分类ID,0为第一级';");
}
if(!pdo_fieldexists('wlmerchant_category_store',  'isrecommand')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_category_store')." ADD `isrecommand` int(10) DEFAULT '0';");
}
if(!pdo_fieldexists('wlmerchant_category_store',  'description')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_category_store')." ADD `description` varchar(500) DEFAULT NULL COMMENT '分类介绍';");
}
if(!pdo_fieldexists('wlmerchant_category_store',  'displayorder')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_category_store')." ADD `displayorder` tinyint(3) unsigned DEFAULT '0' COMMENT '排序';");
}
if(!pdo_fieldexists('wlmerchant_category_store',  'enabled')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_category_store')." ADD `enabled` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否开启';");
}
if(!pdo_fieldexists('wlmerchant_category_store',  'visible_level')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_category_store')." ADD `visible_level` int(11) DEFAULT NULL COMMENT '1为首页顶部展示';");
}
if(!pdo_fieldexists('wlmerchant_collect',  'id')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_collect')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists('wlmerchant_collect',  'uniacid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_collect')." ADD `uniacid` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists('wlmerchant_collect',  'mid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_collect')." ADD `mid` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists('wlmerchant_collect',  'storeid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_collect')." ADD `storeid` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists('wlmerchant_collect',  'createtime')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_collect')." ADD `createtime` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists('wlmerchant_comment',  'id')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_comment')." ADD `id` int(11) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists('wlmerchant_comment',  'uniacid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_comment')." ADD `uniacid` int(11) unsigned NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists('wlmerchant_comment',  'gid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_comment')." ADD `gid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '对应的商品id';");
}
if(!pdo_fieldexists('wlmerchant_comment',  'mid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_comment')." ADD `mid` int(11) DEFAULT NULL COMMENT '用户ID';");
}
if(!pdo_fieldexists('wlmerchant_comment',  'sid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_comment')." ADD `sid` int(11) DEFAULT NULL COMMENT '商家ID';");
}
if(!pdo_fieldexists('wlmerchant_comment',  'parentid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_comment')." ADD `parentid` int(11) DEFAULT NULL COMMENT '回复上级ID';");
}
if(!pdo_fieldexists('wlmerchant_comment',  'pic')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_comment')." ADD `pic` varchar(1000) DEFAULT NULL COMMENT '图片';");
}
if(!pdo_fieldexists('wlmerchant_comment',  'idoforder')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_comment')." ADD `idoforder` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '对应的order的id';");
}
if(!pdo_fieldexists('wlmerchant_comment',  'text')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_comment')." ADD `text` varchar(800) DEFAULT NULL COMMENT '评价文字';");
}
if(!pdo_fieldexists('wlmerchant_comment',  'status')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_comment')." ADD `status` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '是否显示 0显示 1不显示';");
}
if(!pdo_fieldexists('wlmerchant_comment',  'level')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_comment')." ADD `level` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '评价等级 1好评 2中评 3差评';");
}
if(!pdo_fieldexists('wlmerchant_comment',  'createtime')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_comment')." ADD `createtime` varchar(145) NOT NULL DEFAULT '0' COMMENT '评价时间';");
}
if(!pdo_fieldexists('wlmerchant_comment',  'headimg')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_comment')." ADD `headimg` varchar(255) DEFAULT NULL COMMENT '评价人头像';");
}
if(!pdo_fieldexists('wlmerchant_comment',  'nickname')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_comment')." ADD `nickname` varchar(32) DEFAULT NULL COMMENT '评价人昵称';");
}
if(!pdo_fieldexists('wlmerchant_comment',  'plugin')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_comment')." ADD `plugin` varchar(32) DEFAULT NULL COMMENT '插件名称';");
}
if(!pdo_fieldexists('wlmerchant_comment',  'star')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_comment')." ADD `star` int(11) DEFAULT '0';");
}
if(!pdo_indexexists('wlmerchant_comment',  'index')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_comment')." ADD KEY `index` (`idoforder`,`gid`,`status`,`uniacid`);");
}
if(!pdo_fieldexists('wlmerchant_couponlist',  'id')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_couponlist')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists('wlmerchant_couponlist',  'uniacid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_couponlist')." ADD `uniacid` int(11) NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_couponlist',  'aid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_couponlist')." ADD `aid` int(11) DEFAULT NULL COMMENT '代理id';");
}
if(!pdo_fieldexists('wlmerchant_couponlist',  'status')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_couponlist')." ADD `status` int(11) NOT NULL COMMENT '优惠券状态 1启用 0禁用2已失效';");
}
if(!pdo_fieldexists('wlmerchant_couponlist',  'type')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_couponlist')." ADD `type` int(11) NOT NULL COMMENT '优惠券类型 1 折扣券 2代金券 3礼品券 4 团购券 5优惠券';");
}
if(!pdo_fieldexists('wlmerchant_couponlist',  'is_charge')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_couponlist')." ADD `is_charge` int(11) NOT NULL COMMENT '是否收费 1收费 0免费';");
}
if(!pdo_fieldexists('wlmerchant_couponlist',  'logo')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_couponlist')." ADD `logo` varchar(100) NOT NULL COMMENT '优惠券logo';");
}
if(!pdo_fieldexists('wlmerchant_couponlist',  'indeximg')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_couponlist')." ADD `indeximg` varchar(100) DEFAULT NULL COMMENT '优惠券详情顶部图片';");
}
if(!pdo_fieldexists('wlmerchant_couponlist',  'merchantid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_couponlist')." ADD `merchantid` int(11) NOT NULL COMMENT '商户id';");
}
if(!pdo_fieldexists('wlmerchant_couponlist',  'color')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_couponlist')." ADD `color` varchar(100) NOT NULL COMMENT '优惠券颜色';");
}
if(!pdo_fieldexists('wlmerchant_couponlist',  'title')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_couponlist')." ADD `title` varchar(145) NOT NULL COMMENT '优惠券标题';");
}
if(!pdo_fieldexists('wlmerchant_couponlist',  'sub_title')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_couponlist')." ADD `sub_title` varchar(145) DEFAULT NULL COMMENT '优惠券小标题';");
}
if(!pdo_fieldexists('wlmerchant_couponlist',  'goodsdetail')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_couponlist')." ADD `goodsdetail` text COMMENT '商品详情';");
}
if(!pdo_fieldexists('wlmerchant_couponlist',  'time_type')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_couponlist')." ADD `time_type` int(11) NOT NULL COMMENT '时间类型 1.规定时间段 2 领取后限制';");
}
if(!pdo_fieldexists('wlmerchant_couponlist',  'starttime')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_couponlist')." ADD `starttime` varchar(255) DEFAULT NULL COMMENT '开始时间';");
}
if(!pdo_fieldexists('wlmerchant_couponlist',  'endtime')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_couponlist')." ADD `endtime` varchar(255) DEFAULT NULL COMMENT '结束时间';");
}
if(!pdo_fieldexists('wlmerchant_couponlist',  'deadline')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_couponlist')." ADD `deadline` int(11) DEFAULT NULL COMMENT '持续天数';");
}
if(!pdo_fieldexists('wlmerchant_couponlist',  'quantity')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_couponlist')." ADD `quantity` int(11) NOT NULL COMMENT '库存';");
}
if(!pdo_fieldexists('wlmerchant_couponlist',  'surplus')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_couponlist')." ADD `surplus` int(11) NOT NULL COMMENT '剩余数量';");
}
if(!pdo_fieldexists('wlmerchant_couponlist',  'get_limit')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_couponlist')." ADD `get_limit` int(11) NOT NULL COMMENT '限量';");
}
if(!pdo_fieldexists('wlmerchant_couponlist',  'description')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_couponlist')." ADD `description` text NOT NULL COMMENT '卡券使用须知';");
}
if(!pdo_fieldexists('wlmerchant_couponlist',  'usetimes')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_couponlist')." ADD `usetimes` int(11) NOT NULL COMMENT '使用次数';");
}
if(!pdo_fieldexists('wlmerchant_couponlist',  'createtime')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_couponlist')." ADD `createtime` varchar(255) NOT NULL COMMENT '创建时间';");
}
if(!pdo_fieldexists('wlmerchant_couponlist',  'price')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_couponlist')." ADD `price` decimal(10,2) DEFAULT NULL COMMENT '收费金额';");
}
if(!pdo_fieldexists('wlmerchant_couponlist',  'is_show')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_couponlist')." ADD `is_show` int(11) NOT NULL COMMENT '是否列表显示 0显示 1隐藏';");
}
if(!pdo_fieldexists('wlmerchant_couponlist',  'vipstatus')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_couponlist')." ADD `vipstatus` int(11) DEFAULT '0';");
}
if(!pdo_fieldexists('wlmerchant_couponlist',  'vipprice')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_couponlist')." ADD `vipprice` decimal(10,2) DEFAULT '0.00';");
}
if(!pdo_fieldexists('wlmerchant_creditrecord',  'id')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_creditrecord')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists('wlmerchant_creditrecord',  'uniacid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_creditrecord')." ADD `uniacid` int(11) NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_creditrecord',  'openid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_creditrecord')." ADD `openid` varchar(245) NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_creditrecord',  'num')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_creditrecord')." ADD `num` varchar(30) NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_creditrecord',  'createtime')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_creditrecord')." ADD `createtime` varchar(145) NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_creditrecord',  'transid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_creditrecord')." ADD `transid` varchar(145) NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_creditrecord',  'status')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_creditrecord')." ADD `status` int(11) NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_creditrecord',  'paytype')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_creditrecord')." ADD `paytype` int(2) NOT NULL COMMENT '1微信2后台';");
}
if(!pdo_fieldexists('wlmerchant_creditrecord',  'ordersn')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_creditrecord')." ADD `ordersn` varchar(145) NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_creditrecord',  'type')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_creditrecord')." ADD `type` int(2) NOT NULL COMMENT '1积分2余额';");
}
if(!pdo_fieldexists('wlmerchant_creditrecord',  'remark')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_creditrecord')." ADD `remark` varchar(145) NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_creditrecord',  'table')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_creditrecord')." ADD `table` tinyint(4) DEFAULT NULL COMMENT '1微擎2tg';");
}
if(!pdo_fieldexists('wlmerchant_creditrecord',  'uid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_creditrecord')." ADD `uid` int(11) NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_goodshouse',  'id')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_goodshouse')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists('wlmerchant_goodshouse',  'uniacid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_goodshouse')." ADD `uniacid` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists('wlmerchant_goodshouse',  'sid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_goodshouse')." ADD `sid` int(11) DEFAULT NULL COMMENT '商家id';");
}
if(!pdo_fieldexists('wlmerchant_goodshouse',  'aid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_goodshouse')." ADD `aid` int(11) DEFAULT NULL COMMENT '代理id';");
}
if(!pdo_fieldexists('wlmerchant_goodshouse',  'name')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_goodshouse')." ADD `name` varchar(145) DEFAULT NULL COMMENT '活动名称';");
}
if(!pdo_fieldexists('wlmerchant_goodshouse',  'code')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_goodshouse')." ADD `code` varchar(145) DEFAULT NULL COMMENT '商品编号';");
}
if(!pdo_fieldexists('wlmerchant_goodshouse',  'describe')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_goodshouse')." ADD `describe` varchar(255) DEFAULT NULL COMMENT '描述';");
}
if(!pdo_fieldexists('wlmerchant_goodshouse',  'detail')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_goodshouse')." ADD `detail` text COMMENT '详情';");
}
if(!pdo_fieldexists('wlmerchant_goodshouse',  'price')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_goodshouse')." ADD `price` decimal(10,2) DEFAULT '0.00' COMMENT '抢购价';");
}
if(!pdo_fieldexists('wlmerchant_goodshouse',  'oldprice')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_goodshouse')." ADD `oldprice` decimal(10,2) DEFAULT '0.00' COMMENT '原价';");
}
if(!pdo_fieldexists('wlmerchant_goodshouse',  'vipprice')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_goodshouse')." ADD `vipprice` decimal(10,2) DEFAULT '0.00' COMMENT 'vip价格';");
}
if(!pdo_fieldexists('wlmerchant_goodshouse',  'num')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_goodshouse')." ADD `num` int(11) DEFAULT NULL COMMENT '限量';");
}
if(!pdo_fieldexists('wlmerchant_goodshouse',  'levelnum')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_goodshouse')." ADD `levelnum` int(11) DEFAULT NULL COMMENT '剩余数量';");
}
if(!pdo_fieldexists('wlmerchant_goodshouse',  'endtime')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_goodshouse')." ADD `endtime` varchar(225) DEFAULT NULL COMMENT '活动结束时间';");
}
if(!pdo_fieldexists('wlmerchant_goodshouse',  'follow')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_goodshouse')." ADD `follow` int(11) DEFAULT NULL COMMENT '关注人数';");
}
if(!pdo_fieldexists('wlmerchant_goodshouse',  'tag')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_goodshouse')." ADD `tag` text COMMENT '标签';");
}
if(!pdo_fieldexists('wlmerchant_goodshouse',  'share_title')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_goodshouse')." ADD `share_title` varchar(32) DEFAULT NULL;");
}
if(!pdo_fieldexists('wlmerchant_goodshouse',  'share_image')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_goodshouse')." ADD `share_image` varchar(250) DEFAULT NULL;");
}
if(!pdo_fieldexists('wlmerchant_goodshouse',  'share_desc')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_goodshouse')." ADD `share_desc` varchar(32) DEFAULT NULL;");
}
if(!pdo_fieldexists('wlmerchant_goodshouse',  'unit')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_goodshouse')." ADD `unit` varchar(32) DEFAULT NULL COMMENT '单位';");
}
if(!pdo_fieldexists('wlmerchant_goodshouse',  'thumb')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_goodshouse')." ADD `thumb` varchar(145) DEFAULT NULL COMMENT '首页图片';");
}
if(!pdo_fieldexists('wlmerchant_goodshouse',  'thumbs')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_goodshouse')." ADD `thumbs` text COMMENT '图集';");
}
if(!pdo_fieldexists('wlmerchant_goodshouse',  'salenum')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_goodshouse')." ADD `salenum` int(11) DEFAULT NULL COMMENT '销量';");
}
if(!pdo_fieldexists('wlmerchant_goodshouse',  'displayorder')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_goodshouse')." ADD `displayorder` int(11) DEFAULT NULL COMMENT '排序';");
}
if(!pdo_fieldexists('wlmerchant_goodshouse',  'stock')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_goodshouse')." ADD `stock` int(11) DEFAULT NULL COMMENT '库存';");
}
if(!pdo_fieldexists('wlmerchant_halfcard_record',  'id')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_halfcard_record')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists('wlmerchant_halfcard_record',  'uniacid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_halfcard_record')." ADD `uniacid` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists('wlmerchant_halfcard_record',  'mid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_halfcard_record')." ADD `mid` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists('wlmerchant_halfcard_record',  'aid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_halfcard_record')." ADD `aid` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists('wlmerchant_halfcard_record',  'price')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_halfcard_record')." ADD `price` decimal(10,2) DEFAULT NULL COMMENT '充值金额';");
}
if(!pdo_fieldexists('wlmerchant_halfcard_record',  'howlong')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_halfcard_record')." ADD `howlong` varchar(145) DEFAULT NULL COMMENT '充值五折卡月数';");
}
if(!pdo_fieldexists('wlmerchant_halfcard_record',  'paytime')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_halfcard_record')." ADD `paytime` varchar(145) DEFAULT NULL COMMENT '充值时间';");
}
if(!pdo_fieldexists('wlmerchant_halfcard_record',  'orderno')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_halfcard_record')." ADD `orderno` varchar(145) DEFAULT NULL COMMENT '充值单号';");
}
if(!pdo_fieldexists('wlmerchant_halfcard_record',  'limittime')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_halfcard_record')." ADD `limittime` varchar(145) DEFAULT NULL COMMENT '下次到期时期';");
}
if(!pdo_fieldexists('wlmerchant_halfcard_record',  'status')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_halfcard_record')." ADD `status` int(11) DEFAULT NULL COMMENT '0未支付 1已经支付';");
}
if(!pdo_fieldexists('wlmerchant_halfcard_record',  'paytype')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_halfcard_record')." ADD `paytype` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists('wlmerchant_halfcard_record',  'transid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_halfcard_record')." ADD `transid` varchar(145) DEFAULT NULL;");
}
if(!pdo_fieldexists('wlmerchant_halfcard_record',  'createtime')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_halfcard_record')." ADD `createtime` varchar(145) DEFAULT NULL COMMENT '创建时间';");
}
if(!pdo_fieldexists('wlmerchant_halfcard_record',  'issettlement')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_halfcard_record')." ADD `issettlement` int(11) DEFAULT '0';");
}
if(!pdo_indexexists('wlmerchant_halfcard_record',  'adx_uniacid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_halfcard_record')." ADD KEY `adx_uniacid` (`uniacid`);");
}
if(!pdo_indexexists('wlmerchant_halfcard_record',  'adx_aid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_halfcard_record')." ADD KEY `adx_aid` (`aid`);");
}
if(!pdo_fieldexists('wlmerchant_halfcard_type',  'id')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_halfcard_type')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists('wlmerchant_halfcard_type',  'uniacid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_halfcard_type')." ADD `uniacid` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists('wlmerchant_halfcard_type',  'logo')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_halfcard_type')." ADD `logo` varchar(145) DEFAULT NULL;");
}
if(!pdo_fieldexists('wlmerchant_halfcard_type',  'name')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_halfcard_type')." ADD `name` varchar(145) DEFAULT NULL;");
}
if(!pdo_fieldexists('wlmerchant_halfcard_type',  'days')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_halfcard_type')." ADD `days` int(11) DEFAULT '0';");
}
if(!pdo_fieldexists('wlmerchant_halfcard_type',  'price')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_halfcard_type')." ADD `price` decimal(10,2) DEFAULT '0.00';");
}
if(!pdo_fieldexists('wlmerchant_halfcard_type',  'status')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_halfcard_type')." ADD `status` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists('wlmerchant_halfcard_type',  'num')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_halfcard_type')." ADD `num` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists('wlmerchant_halfcard_type',  'aid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_halfcard_type')." ADD `aid` int(11) DEFAULT '0';");
}
if(!pdo_fieldexists('wlmerchant_halfcardlist',  'id')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_halfcardlist')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists('wlmerchant_halfcardlist',  'uniacid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_halfcardlist')." ADD `uniacid` int(11) NOT NULL COMMENT '公众号id';");
}
if(!pdo_fieldexists('wlmerchant_halfcardlist',  'aid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_halfcardlist')." ADD `aid` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists('wlmerchant_halfcardlist',  'status')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_halfcardlist')." ADD `status` int(11) NOT NULL COMMENT '状态 1启用 0禁用';");
}
if(!pdo_fieldexists('wlmerchant_halfcardlist',  'merchantid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_halfcardlist')." ADD `merchantid` int(11) NOT NULL COMMENT '商户id';");
}
if(!pdo_fieldexists('wlmerchant_halfcardlist',  'title')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_halfcardlist')." ADD `title` varchar(145) NOT NULL COMMENT '商品标题';");
}
if(!pdo_fieldexists('wlmerchant_halfcardlist',  'datestatus')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_halfcardlist')." ADD `datestatus` int(11) NOT NULL COMMENT '时间格式 1 星期 2日期';");
}
if(!pdo_fieldexists('wlmerchant_halfcardlist',  'week')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_halfcardlist')." ADD `week` text COMMENT '五折时间 星期';");
}
if(!pdo_fieldexists('wlmerchant_halfcardlist',  'day')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_halfcardlist')." ADD `day` text COMMENT '五折时间 天数';");
}
if(!pdo_fieldexists('wlmerchant_halfcardlist',  'adv')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_halfcardlist')." ADD `adv` text NOT NULL COMMENT '幻灯片';");
}
if(!pdo_fieldexists('wlmerchant_halfcardlist',  'limit')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_halfcardlist')." ADD `limit` text COMMENT '限制说明';");
}
if(!pdo_fieldexists('wlmerchant_halfcardlist',  'detail')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_halfcardlist')." ADD `detail` text COMMENT '商品详细说明';");
}
if(!pdo_fieldexists('wlmerchant_halfcardlist',  'describe')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_halfcardlist')." ADD `describe` text COMMENT '半价卡使用说明';");
}
if(!pdo_fieldexists('wlmerchant_halfcardlist',  'createtime')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_halfcardlist')." ADD `createtime` varchar(100) NOT NULL COMMENT '创建时间';");
}
if(!pdo_fieldexists('wlmerchant_halfcardlist',  'pv')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_halfcardlist')." ADD `pv` int(11) DEFAULT NULL COMMENT '浏览次数';");
}
if(!pdo_fieldexists('wlmerchant_halfcardlist',  'discount')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_halfcardlist')." ADD `discount` decimal(10,1) DEFAULT '0.0';");
}
if(!pdo_fieldexists('wlmerchant_halfcardlist',  'daily')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_halfcardlist')." ADD `daily` int(11) DEFAULT '0';");
}
if(!pdo_indexexists('wlmerchant_halfcardlist',  'adx_uniacid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_halfcardlist')." ADD KEY `adx_uniacid` (`uniacid`);");
}
if(!pdo_indexexists('wlmerchant_halfcardlist',  'adx_aid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_halfcardlist')." ADD KEY `adx_aid` (`aid`);");
}
if(!pdo_fieldexists('wlmerchant_halfcardmember',  'id')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_halfcardmember')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists('wlmerchant_halfcardmember',  'uniacid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_halfcardmember')." ADD `uniacid` int(11) NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_halfcardmember',  'aid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_halfcardmember')." ADD `aid` int(11) DEFAULT NULL COMMENT '代理id';");
}
if(!pdo_fieldexists('wlmerchant_halfcardmember',  'mid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_halfcardmember')." ADD `mid` int(11) DEFAULT NULL COMMENT '用户id';");
}
if(!pdo_fieldexists('wlmerchant_halfcardmember',  'expiretime')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_halfcardmember')." ADD `expiretime` int(11) DEFAULT NULL COMMENT '五折卡结束时间';");
}
if(!pdo_fieldexists('wlmerchant_halfcardmember',  'createtime')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_halfcardmember')." ADD `createtime` int(11) DEFAULT NULL COMMENT '记录创建时间';");
}
if(!pdo_indexexists('wlmerchant_halfcardmember',  'adx_uniacid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_halfcardmember')." ADD KEY `adx_uniacid` (`uniacid`);");
}
if(!pdo_indexexists('wlmerchant_halfcardmember',  'adx_aid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_halfcardmember')." ADD KEY `adx_aid` (`aid`);");
}
if(!pdo_fieldexists('wlmerchant_halfcardrecord',  'id')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_halfcardrecord')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists('wlmerchant_halfcardrecord',  'uniacid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_halfcardrecord')." ADD `uniacid` int(11) NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_halfcardrecord',  'mid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_halfcardrecord')." ADD `mid` int(11) NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_halfcardrecord',  'aid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_halfcardrecord')." ADD `aid` int(11) NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_halfcardrecord',  'status')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_halfcardrecord')." ADD `status` int(11) NOT NULL COMMENT '状态 1未使用 2已经使用';");
}
if(!pdo_fieldexists('wlmerchant_halfcardrecord',  'activeid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_halfcardrecord')." ADD `activeid` int(11) NOT NULL COMMENT '五折活动ID';");
}
if(!pdo_fieldexists('wlmerchant_halfcardrecord',  'merchantid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_halfcardrecord')." ADD `merchantid` int(11) NOT NULL COMMENT '五折店铺ID';");
}
if(!pdo_fieldexists('wlmerchant_halfcardrecord',  'date')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_halfcardrecord')." ADD `date` varchar(145) NOT NULL COMMENT '优惠日期';");
}
if(!pdo_fieldexists('wlmerchant_halfcardrecord',  'qrcode')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_halfcardrecord')." ADD `qrcode` varchar(145) NOT NULL COMMENT '核销号码';");
}
if(!pdo_fieldexists('wlmerchant_halfcardrecord',  'hexiaotime')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_halfcardrecord')." ADD `hexiaotime` varchar(45) NOT NULL COMMENT '核销时间';");
}
if(!pdo_fieldexists('wlmerchant_halfcardrecord',  'verfmid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_halfcardrecord')." ADD `verfmid` int(11) NOT NULL COMMENT '核销人';");
}
if(!pdo_fieldexists('wlmerchant_halfcardrecord',  'createtime')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_halfcardrecord')." ADD `createtime` varchar(45) NOT NULL COMMENT '创建时间';");
}
if(!pdo_indexexists('wlmerchant_halfcardrecord',  'adx_uniacid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_halfcardrecord')." ADD KEY `adx_uniacid` (`uniacid`);");
}
if(!pdo_indexexists('wlmerchant_halfcardrecord',  'adx_aid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_halfcardrecord')." ADD KEY `adx_aid` (`aid`);");
}
if(!pdo_fieldexists('wlmerchant_indexset',  'id')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_indexset')." ADD `id` int(11) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists('wlmerchant_indexset',  'uniacid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_indexset')." ADD `uniacid` int(11) NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_indexset',  'aid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_indexset')." ADD `aid` int(11) NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_indexset',  'key')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_indexset')." ADD `key` varchar(32) NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_indexset',  'value')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_indexset')." ADD `value` text NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_member',  'id')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_member')." ADD `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '会员ID';");
}
if(!pdo_fieldexists('wlmerchant_member',  'uid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_member')." ADD `uid` int(11) NOT NULL COMMENT '微擎会员id';");
}
if(!pdo_fieldexists('wlmerchant_member',  'invid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_member')." ADD `invid` int(11) NOT NULL COMMENT '邀请人id';");
}
if(!pdo_fieldexists('wlmerchant_member',  'uniacid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_member')." ADD `uniacid` int(11) NOT NULL COMMENT '公众号ID';");
}
if(!pdo_fieldexists('wlmerchant_member',  'openid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_member')." ADD `openid` varchar(100) NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_member',  'unionid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_member')." ADD `unionid` varchar(100) NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_member',  'nickname')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_member')." ADD `nickname` varchar(50) NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_member',  'realname')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_member')." ADD `realname` varchar(50) NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_member',  'credit1')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_member')." ADD `credit1` decimal(10,2) NOT NULL COMMENT '积分';");
}
if(!pdo_fieldexists('wlmerchant_member',  'credit2')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_member')." ADD `credit2` decimal(10,2) NOT NULL COMMENT '余额';");
}
if(!pdo_fieldexists('wlmerchant_member',  'gender')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_member')." ADD `gender` int(11) NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_member',  'isvip')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_member')." ADD `isvip` int(11) NOT NULL DEFAULT '1' COMMENT '会员类型1普通2VIP';");
}
if(!pdo_fieldexists('wlmerchant_member',  'vipendtime')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_member')." ADD `vipendtime` int(11) NOT NULL COMMENT '会员到期时间';");
}
if(!pdo_fieldexists('wlmerchant_member',  'avatar')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_member')." ADD `avatar` varchar(445) NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_member',  'mobile')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_member')." ADD `mobile` varchar(20) NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_member',  'createtime')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_member')." ADD `createtime` int(11) NOT NULL COMMENT '创建时间';");
}
if(!pdo_fieldexists('wlmerchant_member',  'areaid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_member')." ADD `areaid` int(11) DEFAULT NULL COMMENT '地区ID';");
}
if(!pdo_fieldexists('wlmerchant_member',  'aid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_member')." ADD `aid` int(11) DEFAULT NULL COMMENT '所属代理ID';");
}
if(!pdo_fieldexists('wlmerchant_member',  'level')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_member')." ADD `level` int(11) DEFAULT '0' COMMENT '1：VIP1';");
}
if(!pdo_fieldexists('wlmerchant_member',  'dealnum')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_member')." ADD `dealnum` int(11) DEFAULT '0' COMMENT '成交量';");
}
if(!pdo_fieldexists('wlmerchant_member',  'dealmoney')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_member')." ADD `dealmoney` decimal(10,2) DEFAULT '0.00' COMMENT '成交额';");
}
if(!pdo_fieldexists('wlmerchant_member',  'vipstatus')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_member')." ADD `vipstatus` int(11) DEFAULT NULL COMMENT 'VIP状态';");
}
if(!pdo_fieldexists('wlmerchant_member',  'lastviptime')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_member')." ADD `lastviptime` varchar(145) DEFAULT '0' COMMENT '上次VIP应该结束时间';");
}
if(!pdo_fieldexists('wlmerchant_member',  'vipleveldays')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_member')." ADD `vipleveldays` int(11) DEFAULT '0' COMMENT '会员持续天数，每天更新';");
}
if(!pdo_fieldexists('wlmerchant_member_coupons',  'id')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_member_coupons')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists('wlmerchant_member_coupons',  'uniacid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_member_coupons')." ADD `uniacid` int(11) NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_member_coupons',  'mid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_member_coupons')." ADD `mid` int(11) NOT NULL COMMENT '用户id';");
}
if(!pdo_fieldexists('wlmerchant_member_coupons',  'aid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_member_coupons')." ADD `aid` int(11) DEFAULT NULL COMMENT '代理ID';");
}
if(!pdo_fieldexists('wlmerchant_member_coupons',  'parentid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_member_coupons')." ADD `parentid` int(11) NOT NULL COMMENT '父类优惠券id';");
}
if(!pdo_fieldexists('wlmerchant_member_coupons',  'status')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_member_coupons')." ADD `status` int(11) NOT NULL COMMENT '卡券状态 1未使用 2已使用 5未支付';");
}
if(!pdo_fieldexists('wlmerchant_member_coupons',  'type')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_member_coupons')." ADD `type` int(11) NOT NULL COMMENT '优惠券类型 1 折扣券 2代金券 3礼品券 4 团购券 5优惠券';");
}
if(!pdo_fieldexists('wlmerchant_member_coupons',  'title')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_member_coupons')." ADD `title` varchar(145) DEFAULT NULL COMMENT '优惠券标题';");
}
if(!pdo_fieldexists('wlmerchant_member_coupons',  'sub_title')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_member_coupons')." ADD `sub_title` varchar(145) DEFAULT NULL COMMENT '优惠券副标题';");
}
if(!pdo_fieldexists('wlmerchant_member_coupons',  'content')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_member_coupons')." ADD `content` text NOT NULL COMMENT '优惠券内容';");
}
if(!pdo_fieldexists('wlmerchant_member_coupons',  'description')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_member_coupons')." ADD `description` text NOT NULL COMMENT '使用须知';");
}
if(!pdo_fieldexists('wlmerchant_member_coupons',  'color')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_member_coupons')." ADD `color` varchar(32) DEFAULT NULL COMMENT '颜色';");
}
if(!pdo_fieldexists('wlmerchant_member_coupons',  'usetimes')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_member_coupons')." ADD `usetimes` int(11) DEFAULT NULL COMMENT '剩余使用次数';");
}
if(!pdo_fieldexists('wlmerchant_member_coupons',  'starttime')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_member_coupons')." ADD `starttime` int(11) NOT NULL COMMENT '开始时间';");
}
if(!pdo_fieldexists('wlmerchant_member_coupons',  'endtime')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_member_coupons')." ADD `endtime` int(11) NOT NULL COMMENT '结束时间';");
}
if(!pdo_fieldexists('wlmerchant_member_coupons',  'createtime')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_member_coupons')." ADD `createtime` int(11) NOT NULL COMMENT '创建时间';");
}
if(!pdo_fieldexists('wlmerchant_member_coupons',  'usedtime')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_member_coupons')." ADD `usedtime` text COMMENT '使用时间';");
}
if(!pdo_fieldexists('wlmerchant_member_coupons',  'orderno')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_member_coupons')." ADD `orderno` varchar(145) DEFAULT NULL COMMENT '订单号';");
}
if(!pdo_fieldexists('wlmerchant_member_coupons',  'price')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_member_coupons')." ADD `price` decimal(10,2) DEFAULT NULL COMMENT '支付金额';");
}
if(!pdo_fieldexists('wlmerchant_member_coupons',  'concode')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_member_coupons')." ADD `concode` varchar(32) DEFAULT NULL COMMENT '消费码';");
}
if(!pdo_fieldexists('wlmerchant_member_type',  'id')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_member_type')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists('wlmerchant_member_type',  'logo')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_member_type')." ADD `logo` varchar(145) DEFAULT NULL;");
}
if(!pdo_fieldexists('wlmerchant_member_type',  'name')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_member_type')." ADD `name` varchar(145) DEFAULT NULL;");
}
if(!pdo_fieldexists('wlmerchant_member_type',  'days')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_member_type')." ADD `days` int(11) DEFAULT '0';");
}
if(!pdo_fieldexists('wlmerchant_member_type',  'price')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_member_type')." ADD `price` decimal(10,2) DEFAULT '0.00';");
}
if(!pdo_fieldexists('wlmerchant_member_type',  'uniacid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_member_type')." ADD `uniacid` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists('wlmerchant_member_type',  'status')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_member_type')." ADD `status` int(11) DEFAULT NULL COMMENT '1显示';");
}
if(!pdo_fieldexists('wlmerchant_member_type',  'num')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_member_type')." ADD `num` int(11) DEFAULT NULL COMMENT '可开通次数';");
}
if(!pdo_fieldexists('wlmerchant_merchant_account',  'id')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_merchant_account')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists('wlmerchant_merchant_account',  'uniacid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_merchant_account')." ADD `uniacid` int(11) NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_merchant_account',  'sid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_merchant_account')." ADD `sid` int(11) NOT NULL COMMENT '商家ID';");
}
if(!pdo_fieldexists('wlmerchant_merchant_account',  'uid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_merchant_account')." ADD `uid` int(11) NOT NULL COMMENT '操作员id';");
}
if(!pdo_fieldexists('wlmerchant_merchant_account',  'amount')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_merchant_account')." ADD `amount` decimal(10,2) NOT NULL COMMENT '交易总金额';");
}
if(!pdo_fieldexists('wlmerchant_merchant_account',  'updatetime')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_merchant_account')." ADD `updatetime` varchar(45) NOT NULL COMMENT '上次结算时间';");
}
if(!pdo_fieldexists('wlmerchant_merchant_account',  'no_money')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_merchant_account')." ADD `no_money` decimal(10,2) NOT NULL COMMENT '目前未结算金额';");
}
if(!pdo_fieldexists('wlmerchant_merchant_money_record',  'id')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_merchant_money_record')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists('wlmerchant_merchant_money_record',  'uniacid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_merchant_money_record')." ADD `uniacid` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists('wlmerchant_merchant_money_record',  'sid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_merchant_money_record')." ADD `sid` int(11) DEFAULT NULL COMMENT '商家ID';");
}
if(!pdo_fieldexists('wlmerchant_merchant_money_record',  'money')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_merchant_money_record')." ADD `money` decimal(10,2) DEFAULT '0.00' COMMENT '变动金额';");
}
if(!pdo_fieldexists('wlmerchant_merchant_money_record',  'createtime')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_merchant_money_record')." ADD `createtime` varchar(145) DEFAULT NULL COMMENT '变动时间';");
}
if(!pdo_fieldexists('wlmerchant_merchant_money_record',  'orderid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_merchant_money_record')." ADD `orderid` int(11) DEFAULT NULL COMMENT '订单ID';");
}
if(!pdo_fieldexists('wlmerchant_merchant_money_record',  'type')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_merchant_money_record')." ADD `type` int(11) DEFAULT NULL COMMENT '1支付成功2发货成功成为可结算金额3取消发货4商家结算5退款';");
}
if(!pdo_fieldexists('wlmerchant_merchant_money_record',  'detail')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_merchant_money_record')." ADD `detail` text COMMENT '详情';");
}
if(!pdo_fieldexists('wlmerchant_merchant_money_record',  'plugin')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_merchant_money_record')." ADD `plugin` varchar(32) DEFAULT NULL COMMENT '插件名';");
}
if(!pdo_fieldexists('wlmerchant_merchant_record',  'id')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_merchant_record')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists('wlmerchant_merchant_record',  'uniacid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_merchant_record')." ADD `uniacid` int(11) NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_merchant_record',  'sid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_merchant_record')." ADD `sid` int(11) NOT NULL COMMENT '商家id';");
}
if(!pdo_fieldexists('wlmerchant_merchant_record',  'percent')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_merchant_record')." ADD `percent` varchar(32) NOT NULL COMMENT '佣金百分比';");
}
if(!pdo_fieldexists('wlmerchant_merchant_record',  'commission')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_merchant_record')." ADD `commission` varchar(32) NOT NULL COMMENT '佣金';");
}
if(!pdo_fieldexists('wlmerchant_merchant_record',  'money')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_merchant_record')." ADD `money` varchar(45) NOT NULL COMMENT '本次结算金额';");
}
if(!pdo_fieldexists('wlmerchant_merchant_record',  'get_money')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_merchant_record')." ADD `get_money` varchar(32) DEFAULT NULL COMMENT '本次商家得到金额';");
}
if(!pdo_fieldexists('wlmerchant_merchant_record',  'uid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_merchant_record')." ADD `uid` int(11) NOT NULL COMMENT '操作员id';");
}
if(!pdo_fieldexists('wlmerchant_merchant_record',  'createtime')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_merchant_record')." ADD `createtime` varchar(45) NOT NULL COMMENT '结算时间';");
}
if(!pdo_fieldexists('wlmerchant_merchant_record',  'orderno')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_merchant_record')." ADD `orderno` varchar(145) NOT NULL COMMENT '订单号';");
}
if(!pdo_fieldexists('wlmerchant_merchant_record',  'plugin')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_merchant_record')." ADD `plugin` varchar(32) DEFAULT NULL COMMENT '插件名';");
}
if(!pdo_fieldexists('wlmerchant_merchantdata',  'id')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_merchantdata')." ADD `id` int(11) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists('wlmerchant_merchantdata',  'uniacid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_merchantdata')." ADD `uniacid` int(11) NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_merchantdata',  'aid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_merchantdata')." ADD `aid` int(11) DEFAULT NULL COMMENT '代理id';");
}
if(!pdo_fieldexists('wlmerchant_merchantdata',  'provinceid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_merchantdata')." ADD `provinceid` int(11) DEFAULT NULL COMMENT '省ID';");
}
if(!pdo_fieldexists('wlmerchant_merchantdata',  'areaid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_merchantdata')." ADD `areaid` int(11) NOT NULL COMMENT '地区id';");
}
if(!pdo_fieldexists('wlmerchant_merchantdata',  'distid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_merchantdata')." ADD `distid` int(11) DEFAULT NULL COMMENT '区县id';");
}
if(!pdo_fieldexists('wlmerchant_merchantdata',  'storename')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_merchantdata')." ADD `storename` varchar(64) NOT NULL COMMENT '店铺名称';");
}
if(!pdo_fieldexists('wlmerchant_merchantdata',  'mobile')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_merchantdata')." ADD `mobile` varchar(32) DEFAULT NULL COMMENT '联系电话';");
}
if(!pdo_fieldexists('wlmerchant_merchantdata',  'onelevel')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_merchantdata')." ADD `onelevel` int(11) NOT NULL COMMENT '一级分类';");
}
if(!pdo_fieldexists('wlmerchant_merchantdata',  'twolevel')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_merchantdata')." ADD `twolevel` int(11) NOT NULL COMMENT '二级分类';");
}
if(!pdo_fieldexists('wlmerchant_merchantdata',  'logo')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_merchantdata')." ADD `logo` varchar(128) DEFAULT NULL COMMENT '店铺logo';");
}
if(!pdo_fieldexists('wlmerchant_merchantdata',  'introduction')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_merchantdata')." ADD `introduction` text COMMENT '店铺简介';");
}
if(!pdo_fieldexists('wlmerchant_merchantdata',  'address')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_merchantdata')." ADD `address` varchar(100) DEFAULT NULL COMMENT '店铺地址';");
}
if(!pdo_fieldexists('wlmerchant_merchantdata',  'location')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_merchantdata')." ADD `location` varchar(64) DEFAULT NULL COMMENT '具体位置';");
}
if(!pdo_fieldexists('wlmerchant_merchantdata',  'realname')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_merchantdata')." ADD `realname` varchar(32) DEFAULT NULL COMMENT '联系人';");
}
if(!pdo_fieldexists('wlmerchant_merchantdata',  'tel')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_merchantdata')." ADD `tel` varchar(20) DEFAULT NULL COMMENT '联系电话';");
}
if(!pdo_fieldexists('wlmerchant_merchantdata',  'enabled')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_merchantdata')." ADD `enabled` int(2) DEFAULT NULL COMMENT '商户状态';");
}
if(!pdo_fieldexists('wlmerchant_merchantdata',  'status')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_merchantdata')." ADD `status` int(2) DEFAULT NULL COMMENT '是否审核通过';");
}
if(!pdo_fieldexists('wlmerchant_merchantdata',  'groupid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_merchantdata')." ADD `groupid` int(11) DEFAULT NULL COMMENT '所属组别';");
}
if(!pdo_fieldexists('wlmerchant_merchantdata',  'storehours')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_merchantdata')." ADD `storehours` varchar(100) DEFAULT NULL COMMENT '营业时间';");
}
if(!pdo_fieldexists('wlmerchant_merchantdata',  'endtime')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_merchantdata')." ADD `endtime` int(11) DEFAULT NULL COMMENT '结束时间';");
}
if(!pdo_fieldexists('wlmerchant_merchantdata',  'createtime')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_merchantdata')." ADD `createtime` int(11) NOT NULL COMMENT '创建时间';");
}
if(!pdo_fieldexists('wlmerchant_merchantdata',  'remark')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_merchantdata')." ADD `remark` text COMMENT '备注';");
}
if(!pdo_fieldexists('wlmerchant_merchantdata',  'percent')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_merchantdata')." ADD `percent` decimal(10,2) DEFAULT '0.00';");
}
if(!pdo_fieldexists('wlmerchant_merchantdata',  'cardsn')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_merchantdata')." ADD `cardsn` varchar(50) DEFAULT NULL;");
}
if(!pdo_indexexists('wlmerchant_merchantdata',  'key_uniacid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_merchantdata')." ADD KEY `key_uniacid` (`uniacid`);");
}
if(!pdo_indexexists('wlmerchant_merchantdata',  'key_areaid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_merchantdata')." ADD KEY `key_areaid` (`areaid`);");
}
if(!pdo_indexexists('wlmerchant_merchantdata',  'key_location')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_merchantdata')." ADD KEY `key_location` (`location`);");
}
if(!pdo_fieldexists('wlmerchant_merchantuser',  'id')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_merchantuser')." ADD `id` int(11) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists('wlmerchant_merchantuser',  'uniacid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_merchantuser')." ADD `uniacid` int(11) NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_merchantuser',  'mid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_merchantuser')." ADD `mid` int(11) NOT NULL COMMENT '绑定微信id';");
}
if(!pdo_fieldexists('wlmerchant_merchantuser',  'storeid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_merchantuser')." ADD `storeid` int(11) NOT NULL COMMENT '商户id';");
}
if(!pdo_fieldexists('wlmerchant_merchantuser',  'name')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_merchantuser')." ADD `name` varchar(64) NOT NULL COMMENT '姓名';");
}
if(!pdo_fieldexists('wlmerchant_merchantuser',  'mobile')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_merchantuser')." ADD `mobile` varchar(32) NOT NULL COMMENT '电话';");
}
if(!pdo_fieldexists('wlmerchant_merchantuser',  'account')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_merchantuser')." ADD `account` varchar(32) DEFAULT NULL COMMENT '账号';");
}
if(!pdo_fieldexists('wlmerchant_merchantuser',  'salt')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_merchantuser')." ADD `salt` varchar(16) DEFAULT NULL COMMENT '加密盐';");
}
if(!pdo_fieldexists('wlmerchant_merchantuser',  'password')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_merchantuser')." ADD `password` varchar(64) DEFAULT NULL COMMENT '密码';");
}
if(!pdo_fieldexists('wlmerchant_merchantuser',  'groupid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_merchantuser')." ADD `groupid` int(11) DEFAULT NULL COMMENT '所属组别';");
}
if(!pdo_fieldexists('wlmerchant_merchantuser',  'areaid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_merchantuser')." ADD `areaid` varchar(16) NOT NULL COMMENT '区域id';");
}
if(!pdo_fieldexists('wlmerchant_merchantuser',  'endtime')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_merchantuser')." ADD `endtime` varchar(32) DEFAULT NULL COMMENT '到期时间';");
}
if(!pdo_fieldexists('wlmerchant_merchantuser',  'createtime')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_merchantuser')." ADD `createtime` varchar(32) NOT NULL COMMENT '创建时间';");
}
if(!pdo_fieldexists('wlmerchant_merchantuser',  'limit')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_merchantuser')." ADD `limit` text NOT NULL COMMENT '拥有权限';");
}
if(!pdo_fieldexists('wlmerchant_merchantuser',  'reject')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_merchantuser')." ADD `reject` varchar(300) DEFAULT NULL COMMENT '驳回原因';");
}
if(!pdo_fieldexists('wlmerchant_merchantuser',  'status')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_merchantuser')." ADD `status` int(2) NOT NULL COMMENT '是否通过审核';");
}
if(!pdo_fieldexists('wlmerchant_merchantuser',  'enabled')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_merchantuser')." ADD `enabled` int(2) NOT NULL COMMENT '是否启用';");
}
if(!pdo_fieldexists('wlmerchant_merchantuser',  'ismain')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_merchantuser')." ADD `ismain` int(2) DEFAULT NULL COMMENT '1超级管理员2核销员';");
}
if(!pdo_fieldexists('wlmerchant_merchantuser',  'aid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_merchantuser')." ADD `aid` int(11) NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_merchantuser_qrlog',  'id')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_merchantuser_qrlog')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists('wlmerchant_merchantuser_qrlog',  'uniacid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_merchantuser_qrlog')." ADD `uniacid` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists('wlmerchant_merchantuser_qrlog',  'memberid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_merchantuser_qrlog')." ADD `memberid` int(11) NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_merchantuser_qrlog',  'codes')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_merchantuser_qrlog')." ADD `codes` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists('wlmerchant_merchantuser_qrlog',  'status')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_merchantuser_qrlog')." ADD `status` int(1) NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_merchantuser_qrlog',  'createtime')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_merchantuser_qrlog')." ADD `createtime` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists('wlmerchant_nav',  'id')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_nav')." ADD `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '唯一标识';");
}
if(!pdo_fieldexists('wlmerchant_nav',  'uniacid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_nav')." ADD `uniacid` int(11) NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_nav',  'aid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_nav')." ADD `aid` int(11) NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_nav',  'name')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_nav')." ADD `name` varchar(50) NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_nav',  'link')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_nav')." ADD `link` varchar(255) NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_nav',  'thumb')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_nav')." ADD `thumb` varchar(255) NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_nav',  'displayorder')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_nav')." ADD `displayorder` int(11) NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_nav',  'enabled')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_nav')." ADD `enabled` int(11) NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_notice',  'id')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_notice')." ADD `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '唯一标识';");
}
if(!pdo_fieldexists('wlmerchant_notice',  'uniacid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_notice')." ADD `uniacid` int(11) NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_notice',  'aid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_notice')." ADD `aid` int(11) NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_notice',  'title')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_notice')." ADD `title` varchar(255) NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_notice',  'content')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_notice')." ADD `content` text;");
}
if(!pdo_fieldexists('wlmerchant_notice',  'enabled')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_notice')." ADD `enabled` int(11) NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_notice',  'createtime')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_notice')." ADD `createtime` varchar(32) NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_oparea',  'id')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_oparea')." ADD `id` int(10) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists('wlmerchant_oparea',  'uniacid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_oparea')." ADD `uniacid` int(10) NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_oparea',  'areaid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_oparea')." ADD `areaid` int(11) NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_oparea',  'aid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_oparea')." ADD `aid` int(10) NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_oparea',  'status')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_oparea')." ADD `status` int(11) NOT NULL DEFAULT '1' COMMENT '0禁用1启用';");
}
if(!pdo_fieldexists('wlmerchant_oparea',  'ishot')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_oparea')." ADD `ishot` int(11) NOT NULL COMMENT '0非热门1热门城市';");
}
if(!pdo_indexexists('wlmerchant_oparea',  'uniacid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_oparea')." ADD KEY `uniacid` (`uniacid`);");
}
if(!pdo_fieldexists('wlmerchant_oplog',  'id')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_oplog')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists('wlmerchant_oplog',  'uniacid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_oplog')." ADD `uniacid` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists('wlmerchant_oplog',  'describe')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_oplog')." ADD `describe` varchar(225) DEFAULT NULL COMMENT '操作描述';");
}
if(!pdo_fieldexists('wlmerchant_oplog',  'view_url')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_oplog')." ADD `view_url` varchar(225) DEFAULT NULL COMMENT '操作界面url';");
}
if(!pdo_fieldexists('wlmerchant_oplog',  'ip')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_oplog')." ADD `ip` varchar(32) DEFAULT NULL COMMENT 'IP';");
}
if(!pdo_fieldexists('wlmerchant_oplog',  'data')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_oplog')." ADD `data` varchar(1024) DEFAULT NULL COMMENT '操作数据';");
}
if(!pdo_fieldexists('wlmerchant_oplog',  'createtime')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_oplog')." ADD `createtime` varchar(32) DEFAULT NULL COMMENT '操作时间';");
}
if(!pdo_fieldexists('wlmerchant_oplog',  'user')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_oplog')." ADD `user` varchar(32) DEFAULT NULL COMMENT '操作员';");
}
if(!pdo_fieldexists('wlmerchant_order',  'id')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_order')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists('wlmerchant_order',  'uniacid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_order')." ADD `uniacid` int(11) DEFAULT NULL COMMENT '公众号ID';");
}
if(!pdo_fieldexists('wlmerchant_order',  'mid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_order')." ADD `mid` int(11) DEFAULT NULL COMMENT '用户id';");
}
if(!pdo_fieldexists('wlmerchant_order',  'aid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_order')." ADD `aid` int(11) DEFAULT NULL COMMENT '代理id';");
}
if(!pdo_fieldexists('wlmerchant_order',  'sid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_order')." ADD `sid` int(11) DEFAULT NULL COMMENT '商家id';");
}
if(!pdo_fieldexists('wlmerchant_order',  'orderno')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_order')." ADD `orderno` varchar(145) DEFAULT NULL COMMENT '订单号';");
}
if(!pdo_fieldexists('wlmerchant_order',  'fkid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_order')." ADD `fkid` int(11) DEFAULT NULL COMMENT '商品关联ID';");
}
if(!pdo_fieldexists('wlmerchant_order',  'status')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_order')." ADD `status` int(11) DEFAULT NULL COMMENT '状态 0未支付 1已支付';");
}
if(!pdo_fieldexists('wlmerchant_order',  'oprice')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_order')." ADD `oprice` decimal(10,2) DEFAULT '0.00' COMMENT '原价';");
}
if(!pdo_fieldexists('wlmerchant_order',  'price')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_order')." ADD `price` decimal(10,2) DEFAULT '0.00' COMMENT '实际支付金额';");
}
if(!pdo_fieldexists('wlmerchant_order',  'num')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_order')." ADD `num` int(11) DEFAULT NULL COMMENT '购买数量';");
}
if(!pdo_fieldexists('wlmerchant_order',  'paytime')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_order')." ADD `paytime` varchar(145) DEFAULT NULL COMMENT '支付时间';");
}
if(!pdo_fieldexists('wlmerchant_order',  'paytype')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_order')." ADD `paytype` int(11) DEFAULT NULL COMMENT '支付方式 1微信';");
}
if(!pdo_fieldexists('wlmerchant_order',  'createtime')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_order')." ADD `createtime` varchar(145) DEFAULT NULL COMMENT '创建时间';");
}
if(!pdo_fieldexists('wlmerchant_order',  'remark')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_order')." ADD `remark` text COMMENT '卖家备注';");
}
if(!pdo_fieldexists('wlmerchant_order',  'issettlement')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_order')." ADD `issettlement` int(11) DEFAULT '0' COMMENT '1待结算2已结算';");
}
if(!pdo_fieldexists('wlmerchant_order',  'plugin')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_order')." ADD `plugin` varchar(32) DEFAULT NULL COMMENT '插件';");
}
if(!pdo_fieldexists('wlmerchant_order',  'payfor')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_order')." ADD `payfor` varchar(32) DEFAULT NULL COMMENT '干什么支付';");
}
if(!pdo_fieldexists('wlmerchant_order',  'is_usecard')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_order')." ADD `is_usecard` tinyint(3) DEFAULT NULL COMMENT '1使用优惠';");
}
if(!pdo_fieldexists('wlmerchant_order',  'card_type')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_order')." ADD `card_type` tinyint(3) DEFAULT NULL COMMENT '优惠类型';");
}
if(!pdo_fieldexists('wlmerchant_order',  'card_id')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_order')." ADD `card_id` int(3) DEFAULT NULL COMMENT '优惠ID';");
}
if(!pdo_fieldexists('wlmerchant_order',  'card_fee')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_order')." ADD `card_fee` decimal(10,2) DEFAULT '0.00' COMMENT '优惠金额';");
}
if(!pdo_fieldexists('wlmerchant_order',  'transid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_order')." ADD `transid` varchar(145) DEFAULT NULL COMMENT '微信订单号';");
}
if(!pdo_fieldexists('wlmerchant_paylog',  'plid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_paylog')." ADD `plid` bigint(11) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists('wlmerchant_paylog',  'type')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_paylog')." ADD `type` varchar(20) NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_paylog',  'uniacid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_paylog')." ADD `uniacid` int(11) NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_paylog',  'acid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_paylog')." ADD `acid` int(10) NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_paylog',  'openid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_paylog')." ADD `openid` varchar(40) NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_paylog',  'uniontid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_paylog')." ADD `uniontid` varchar(64) NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_paylog',  'tid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_paylog')." ADD `tid` varchar(128) NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_paylog',  'fee')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_paylog')." ADD `fee` decimal(10,2) NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_paylog',  'status')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_paylog')." ADD `status` tinyint(4) NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_paylog',  'module')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_paylog')." ADD `module` varchar(50) NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_paylog',  'tag')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_paylog')." ADD `tag` varchar(2000) NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_paylog',  'is_usecard')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_paylog')." ADD `is_usecard` tinyint(3) unsigned NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_paylog',  'card_type')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_paylog')." ADD `card_type` tinyint(3) unsigned NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_paylog',  'card_id')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_paylog')." ADD `card_id` varchar(50) NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_paylog',  'card_fee')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_paylog')." ADD `card_fee` decimal(10,2) unsigned NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_paylog',  'encrypt_code')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_paylog')." ADD `encrypt_code` varchar(100) NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_paylog',  'plugin')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_paylog')." ADD `plugin` varchar(50) DEFAULT NULL COMMENT '插件名';");
}
if(!pdo_fieldexists('wlmerchant_paylog',  'payfor')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_paylog')." ADD `payfor` varchar(145) DEFAULT NULL COMMENT '干什么支付';");
}
if(!pdo_indexexists('wlmerchant_paylog',  'idx_openid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_paylog')." ADD KEY `idx_openid` (`openid`);");
}
if(!pdo_indexexists('wlmerchant_paylog',  'idx_tid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_paylog')." ADD KEY `idx_tid` (`tid`);");
}
if(!pdo_indexexists('wlmerchant_paylog',  'idx_uniacid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_paylog')." ADD KEY `idx_uniacid` (`uniacid`);");
}
if(!pdo_indexexists('wlmerchant_paylog',  'uniontid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_paylog')." ADD KEY `uniontid` (`uniontid`);");
}
if(!pdo_fieldexists('wlmerchant_puv',  'id')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_puv')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists('wlmerchant_puv',  'areaid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_puv')." ADD `areaid` int(11) DEFAULT NULL COMMENT '地区id';");
}
if(!pdo_fieldexists('wlmerchant_puv',  'uniacid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_puv')." ADD `uniacid` int(11) NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_puv',  'pv')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_puv')." ADD `pv` int(11) NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_puv',  'uv')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_puv')." ADD `uv` int(11) NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_puv',  'date')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_puv')." ADD `date` varchar(20) NOT NULL;");
}
if(!pdo_indexexists('wlmerchant_puv',  'uniacid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_puv')." ADD KEY `uniacid` (`uniacid`);");
}
if(!pdo_fieldexists('wlmerchant_puvrecord',  'id')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_puvrecord')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists('wlmerchant_puvrecord',  'uniacid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_puvrecord')." ADD `uniacid` int(11) NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_puvrecord',  'mid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_puvrecord')." ADD `mid` int(11) NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_puvrecord',  'pv')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_puvrecord')." ADD `pv` int(11) NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_puvrecord',  'date')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_puvrecord')." ADD `date` varchar(20) NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_puvrecord',  'areaid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_puvrecord')." ADD `areaid` int(11) DEFAULT NULL;");
}
if(!pdo_indexexists('wlmerchant_puvrecord',  'uniacid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_puvrecord')." ADD KEY `uniacid` (`uniacid`);");
}
if(!pdo_indexexists('wlmerchant_puvrecord',  'mid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_puvrecord')." ADD KEY `mid` (`mid`);");
}
if(!pdo_fieldexists('wlmerchant_qrcode',  'id')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_qrcode')." ADD `id` int(10) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists('wlmerchant_qrcode',  'aid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_qrcode')." ADD `aid` int(10) DEFAULT NULL;");
}
if(!pdo_fieldexists('wlmerchant_qrcode',  'uniacid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_qrcode')." ADD `uniacid` int(10) unsigned NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_qrcode',  'sid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_qrcode')." ADD `sid` int(11) NOT NULL COMMENT '商户ID';");
}
if(!pdo_fieldexists('wlmerchant_qrcode',  'qrid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_qrcode')." ADD `qrid` int(10) unsigned NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_qrcode',  'model')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_qrcode')." ADD `model` tinyint(1) NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_qrcode',  'cardsn')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_qrcode')." ADD `cardsn` varchar(64) NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_qrcode',  'salt')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_qrcode')." ADD `salt` varchar(32) DEFAULT NULL COMMENT '加密盐';");
}
if(!pdo_fieldexists('wlmerchant_qrcode',  'status')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_qrcode')." ADD `status` tinyint(1) unsigned NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_qrcode',  'createtime')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_qrcode')." ADD `createtime` int(10) unsigned NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_qrcode',  'remark')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_qrcode')." ADD `remark` varchar(50) NOT NULL COMMENT '场景备注';");
}
if(!pdo_indexexists('wlmerchant_qrcode',  'uniacid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_qrcode')." ADD KEY `uniacid` (`uniacid`);");
}
if(!pdo_indexexists('wlmerchant_qrcode',  'aid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_qrcode')." ADD KEY `aid` (`aid`);");
}
if(!pdo_indexexists('wlmerchant_qrcode',  'qrid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_qrcode')." ADD KEY `qrid` (`qrid`) USING BTREE;");
}
if(!pdo_fieldexists('wlmerchant_refund_record',  'id')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_refund_record')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists('wlmerchant_refund_record',  'uniacid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_refund_record')." ADD `uniacid` int(11) NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_refund_record',  'type')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_refund_record')." ADD `type` int(11) NOT NULL COMMENT '1手机端2Web端3最后一人退款4部分退款5计划任务退款';");
}
if(!pdo_fieldexists('wlmerchant_refund_record',  'payfee')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_refund_record')." ADD `payfee` varchar(100) NOT NULL COMMENT '支付金额';");
}
if(!pdo_fieldexists('wlmerchant_refund_record',  'paytype')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_refund_record')." ADD `paytype` int(3) DEFAULT NULL COMMENT '支付方式1余额2微信';");
}
if(!pdo_fieldexists('wlmerchant_refund_record',  'refundfee')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_refund_record')." ADD `refundfee` varchar(100) NOT NULL COMMENT '退还金额';");
}
if(!pdo_fieldexists('wlmerchant_refund_record',  'transid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_refund_record')." ADD `transid` varchar(115) NOT NULL COMMENT '订单编号';");
}
if(!pdo_fieldexists('wlmerchant_refund_record',  'refund_id')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_refund_record')." ADD `refund_id` varchar(115) NOT NULL COMMENT '微信退款单号';");
}
if(!pdo_fieldexists('wlmerchant_refund_record',  'refundername')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_refund_record')." ADD `refundername` varchar(100) NOT NULL COMMENT '退款人姓名';");
}
if(!pdo_fieldexists('wlmerchant_refund_record',  'refundermobile')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_refund_record')." ADD `refundermobile` varchar(100) NOT NULL COMMENT '退款人电话';");
}
if(!pdo_fieldexists('wlmerchant_refund_record',  'goodsname')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_refund_record')." ADD `goodsname` varchar(100) NOT NULL COMMENT '商品名称';");
}
if(!pdo_fieldexists('wlmerchant_refund_record',  'createtime')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_refund_record')." ADD `createtime` varchar(45) NOT NULL COMMENT '退款时间';");
}
if(!pdo_fieldexists('wlmerchant_refund_record',  'status')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_refund_record')." ADD `status` int(11) NOT NULL COMMENT '0未成功1成功';");
}
if(!pdo_fieldexists('wlmerchant_refund_record',  'orderid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_refund_record')." ADD `orderid` varchar(45) NOT NULL COMMENT '订单id';");
}
if(!pdo_fieldexists('wlmerchant_refund_record',  'sid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_refund_record')." ADD `sid` int(11) NOT NULL COMMENT '商家id';");
}
if(!pdo_fieldexists('wlmerchant_refund_record',  'remark')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_refund_record')." ADD `remark` text COMMENT '退款备注';");
}
if(!pdo_fieldexists('wlmerchant_refund_record',  'plugin')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_refund_record')." ADD `plugin` varchar(32) DEFAULT NULL COMMENT '插件名称';");
}
if(!pdo_fieldexists('wlmerchant_refund_record',  'errmsg')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_refund_record')." ADD `errmsg` varchar(445) DEFAULT '0' COMMENT '退款错误信息';");
}
if(!pdo_fieldexists('wlmerchant_role',  'id')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_role')." ADD `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '角色id';");
}
if(!pdo_fieldexists('wlmerchant_role',  'uniacid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_role')." ADD `uniacid` int(11) NOT NULL COMMENT '公众号id';");
}
if(!pdo_fieldexists('wlmerchant_role',  'limit')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_role')." ADD `limit` text NOT NULL COMMENT '该角色拥有的权限数组';");
}
if(!pdo_fieldexists('wlmerchant_role',  'title')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_role')." ADD `title` varchar(32) NOT NULL COMMENT '角色title';");
}
if(!pdo_fieldexists('wlmerchant_role',  'status')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_role')." ADD `status` int(2) NOT NULL COMMENT '角色是否显示状态：2显示；0、1不显示';");
}
if(!pdo_fieldexists('wlmerchant_role',  'type')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_role')." ADD `type` int(2) NOT NULL COMMENT '角色类型（备用）';");
}
if(!pdo_fieldexists('wlmerchant_role',  'createtime')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_role')." ADD `createtime` varchar(32) NOT NULL COMMENT '创建时间';");
}
if(!pdo_fieldexists('wlmerchant_role',  'updatetime')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_role')." ADD `updatetime` varchar(32) NOT NULL COMMENT '修改时间';");
}
if(!pdo_fieldexists('wlmerchant_rush_activity',  'id')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_rush_activity')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists('wlmerchant_rush_activity',  'uniacid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_rush_activity')." ADD `uniacid` int(11) DEFAULT NULL COMMENT '公众号id';");
}
if(!pdo_fieldexists('wlmerchant_rush_activity',  'sid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_rush_activity')." ADD `sid` int(11) DEFAULT NULL COMMENT '商家id';");
}
if(!pdo_fieldexists('wlmerchant_rush_activity',  'aid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_rush_activity')." ADD `aid` int(11) DEFAULT NULL COMMENT '代理id';");
}
if(!pdo_fieldexists('wlmerchant_rush_activity',  'name')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_rush_activity')." ADD `name` varchar(145) DEFAULT NULL COMMENT '活动名称【可和仓库的商品名称一致】';");
}
if(!pdo_fieldexists('wlmerchant_rush_activity',  'code')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_rush_activity')." ADD `code` varchar(145) DEFAULT NULL COMMENT '商品编号';");
}
if(!pdo_fieldexists('wlmerchant_rush_activity',  'detail')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_rush_activity')." ADD `detail` text COMMENT '详情';");
}
if(!pdo_fieldexists('wlmerchant_rush_activity',  'price')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_rush_activity')." ADD `price` decimal(10,2) DEFAULT NULL COMMENT '抢购价';");
}
if(!pdo_fieldexists('wlmerchant_rush_activity',  'oldprice')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_rush_activity')." ADD `oldprice` decimal(10,2) DEFAULT NULL COMMENT '原价';");
}
if(!pdo_fieldexists('wlmerchant_rush_activity',  'vipprice')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_rush_activity')." ADD `vipprice` decimal(10,2) DEFAULT '0.00' COMMENT 'vip价格';");
}
if(!pdo_fieldexists('wlmerchant_rush_activity',  'num')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_rush_activity')." ADD `num` int(11) DEFAULT NULL COMMENT '限量';");
}
if(!pdo_fieldexists('wlmerchant_rush_activity',  'levelnum')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_rush_activity')." ADD `levelnum` int(11) DEFAULT NULL COMMENT '剩余数量';");
}
if(!pdo_fieldexists('wlmerchant_rush_activity',  'status')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_rush_activity')." ADD `status` int(11) DEFAULT '1' COMMENT '1进行中2已结束';");
}
if(!pdo_fieldexists('wlmerchant_rush_activity',  'starttime')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_rush_activity')." ADD `starttime` varchar(225) DEFAULT NULL COMMENT '活动开始时间';");
}
if(!pdo_fieldexists('wlmerchant_rush_activity',  'endtime')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_rush_activity')." ADD `endtime` varchar(225) DEFAULT NULL COMMENT '活动结束时间';");
}
if(!pdo_fieldexists('wlmerchant_rush_activity',  'follow')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_rush_activity')." ADD `follow` int(11) DEFAULT NULL COMMENT '关注人数';");
}
if(!pdo_fieldexists('wlmerchant_rush_activity',  'tag')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_rush_activity')." ADD `tag` text COMMENT '标签';");
}
if(!pdo_fieldexists('wlmerchant_rush_activity',  'share_title')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_rush_activity')." ADD `share_title` varchar(32) DEFAULT NULL;");
}
if(!pdo_fieldexists('wlmerchant_rush_activity',  'share_image')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_rush_activity')." ADD `share_image` varchar(250) DEFAULT NULL;");
}
if(!pdo_fieldexists('wlmerchant_rush_activity',  'share_desc')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_rush_activity')." ADD `share_desc` varchar(32) DEFAULT NULL;");
}
if(!pdo_fieldexists('wlmerchant_rush_activity',  'unit')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_rush_activity')." ADD `unit` varchar(32) DEFAULT NULL COMMENT '单位';");
}
if(!pdo_fieldexists('wlmerchant_rush_activity',  'thumb')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_rush_activity')." ADD `thumb` varchar(145) DEFAULT NULL COMMENT '首页图片';");
}
if(!pdo_fieldexists('wlmerchant_rush_activity',  'thumbs')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_rush_activity')." ADD `thumbs` text COMMENT '图集';");
}
if(!pdo_fieldexists('wlmerchant_rush_activity',  'describe')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_rush_activity')." ADD `describe` text;");
}
if(!pdo_fieldexists('wlmerchant_rush_activity',  'op_one_limit')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_rush_activity')." ADD `op_one_limit` int(11) DEFAULT NULL COMMENT '单人限购';");
}
if(!pdo_fieldexists('wlmerchant_rush_activity',  'cutofftime')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_rush_activity')." ADD `cutofftime` int(11) NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_rush_follows',  'id')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_rush_follows')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists('wlmerchant_rush_follows',  'uniacid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_rush_follows')." ADD `uniacid` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists('wlmerchant_rush_follows',  'aid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_rush_follows')." ADD `aid` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists('wlmerchant_rush_follows',  'mid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_rush_follows')." ADD `mid` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists('wlmerchant_rush_follows',  'actid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_rush_follows')." ADD `actid` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists('wlmerchant_rush_follows',  'sendtime')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_rush_follows')." ADD `sendtime` int(11) DEFAULT NULL;");
}
if(!pdo_indexexists('wlmerchant_rush_follows',  'adx_uniacid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_rush_follows')." ADD KEY `adx_uniacid` (`uniacid`);");
}
if(!pdo_indexexists('wlmerchant_rush_follows',  'adx_aid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_rush_follows')." ADD KEY `adx_aid` (`aid`);");
}
if(!pdo_indexexists('wlmerchant_rush_follows',  'adx_sendtime')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_rush_follows')." ADD KEY `adx_sendtime` (`sendtime`);");
}
if(!pdo_fieldexists('wlmerchant_rush_order',  'id')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_rush_order')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists('wlmerchant_rush_order',  'uniacid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_rush_order')." ADD `uniacid` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists('wlmerchant_rush_order',  'unionid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_rush_order')." ADD `unionid` varchar(145) DEFAULT NULL COMMENT '用户微信id';");
}
if(!pdo_fieldexists('wlmerchant_rush_order',  'openid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_rush_order')." ADD `openid` varchar(225) DEFAULT NULL;");
}
if(!pdo_fieldexists('wlmerchant_rush_order',  'mid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_rush_order')." ADD `mid` int(11) DEFAULT NULL COMMENT '会员ID';");
}
if(!pdo_fieldexists('wlmerchant_rush_order',  'aid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_rush_order')." ADD `aid` int(11) DEFAULT NULL COMMENT '代理id';");
}
if(!pdo_fieldexists('wlmerchant_rush_order',  'sid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_rush_order')." ADD `sid` int(11) DEFAULT NULL COMMENT '商家id';");
}
if(!pdo_fieldexists('wlmerchant_rush_order',  'activityid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_rush_order')." ADD `activityid` int(11) DEFAULT NULL COMMENT '活动id';");
}
if(!pdo_fieldexists('wlmerchant_rush_order',  'status')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_rush_order')." ADD `status` int(11) DEFAULT NULL COMMENT '0未支付1已支付2已消费';");
}
if(!pdo_fieldexists('wlmerchant_rush_order',  'orderno')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_rush_order')." ADD `orderno` varchar(145) DEFAULT NULL COMMENT '订单号';");
}
if(!pdo_fieldexists('wlmerchant_rush_order',  'transid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_rush_order')." ADD `transid` varchar(145) DEFAULT NULL COMMENT '微信支付ID';");
}
if(!pdo_fieldexists('wlmerchant_rush_order',  'price')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_rush_order')." ADD `price` decimal(10,2) DEFAULT NULL COMMENT '实际支付金额';");
}
if(!pdo_fieldexists('wlmerchant_rush_order',  'mobile')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_rush_order')." ADD `mobile` varchar(145) DEFAULT NULL COMMENT '电话';");
}
if(!pdo_fieldexists('wlmerchant_rush_order',  'num')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_rush_order')." ADD `num` int(11) DEFAULT NULL COMMENT '抢购数量';");
}
if(!pdo_fieldexists('wlmerchant_rush_order',  'actualprice')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_rush_order')." ADD `actualprice` decimal(10,2) DEFAULT NULL COMMENT '实际支付';");
}
if(!pdo_fieldexists('wlmerchant_rush_order',  'goodscode')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_rush_order')." ADD `goodscode` varchar(145) DEFAULT NULL COMMENT '商品编号';");
}
if(!pdo_fieldexists('wlmerchant_rush_order',  'paytime')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_rush_order')." ADD `paytime` varchar(145) DEFAULT NULL COMMENT '支付时间';");
}
if(!pdo_fieldexists('wlmerchant_rush_order',  'paytype')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_rush_order')." ADD `paytype` int(2) DEFAULT NULL COMMENT '支付方式 1余额 2微信 3支付宝 4货到付款';");
}
if(!pdo_fieldexists('wlmerchant_rush_order',  'checkcode')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_rush_order')." ADD `checkcode` varchar(145) DEFAULT NULL COMMENT '核销码';");
}
if(!pdo_fieldexists('wlmerchant_rush_order',  'createtime')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_rush_order')." ADD `createtime` varchar(225) DEFAULT NULL COMMENT '创建时间';");
}
if(!pdo_fieldexists('wlmerchant_rush_order',  'adminremark')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_rush_order')." ADD `adminremark` text COMMENT '卖家备注';");
}
if(!pdo_fieldexists('wlmerchant_rush_order',  'verfmid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_rush_order')." ADD `verfmid` int(11) NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_rush_order',  'verftime')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_rush_order')." ADD `verftime` int(11) NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_rush_order',  'issettlement')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_rush_order')." ADD `issettlement` int(11) DEFAULT '0';");
}
if(!pdo_fieldexists('wlmerchant_setting',  'id')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_setting')." ADD `id` int(11) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists('wlmerchant_setting',  'uniacid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_setting')." ADD `uniacid` int(11) NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_setting',  'key')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_setting')." ADD `key` varchar(64) NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_setting',  'value')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_setting')." ADD `value` text NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_settlement_record',  'id')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_settlement_record')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists('wlmerchant_settlement_record',  'uniacid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_settlement_record')." ADD `uniacid` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists('wlmerchant_settlement_record',  'sid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_settlement_record')." ADD `sid` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists('wlmerchant_settlement_record',  'aid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_settlement_record')." ADD `aid` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists('wlmerchant_settlement_record',  'status')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_settlement_record')." ADD `status` int(11) DEFAULT '0' COMMENT '-1系统审核不通过-2代理审核不通过1代理审核中2系统审核中，3系统审核通过，待结算,4已结算给代理,5已结算到商家';");
}
if(!pdo_fieldexists('wlmerchant_settlement_record',  'type')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_settlement_record')." ADD `type` int(11) DEFAULT '0' COMMENT '1商家售卖金额提现申请2代理VIP开通金额申请3代理五折卡开通金额申请';");
}
if(!pdo_fieldexists('wlmerchant_settlement_record',  'sapplymoney')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_settlement_record')." ADD `sapplymoney` decimal(10,2) DEFAULT '0.00' COMMENT '商家申请结算金额';");
}
if(!pdo_fieldexists('wlmerchant_settlement_record',  'aapplymoney')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_settlement_record')." ADD `aapplymoney` decimal(10,2) DEFAULT '0.00' COMMENT '代理申请金额';");
}
if(!pdo_fieldexists('wlmerchant_settlement_record',  'sgetmoney')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_settlement_record')." ADD `sgetmoney` decimal(10,2) DEFAULT '0.00' COMMENT '商家实际得到金额';");
}
if(!pdo_fieldexists('wlmerchant_settlement_record',  'agetmoney')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_settlement_record')." ADD `agetmoney` decimal(10,2) DEFAULT '0.00' COMMENT '代理实际得到金额';");
}
if(!pdo_fieldexists('wlmerchant_settlement_record',  'spercentmoney')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_settlement_record')." ADD `spercentmoney` decimal(10,2) DEFAULT '0.00' COMMENT '商家缴纳佣金';");
}
if(!pdo_fieldexists('wlmerchant_settlement_record',  'apercentmoney')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_settlement_record')." ADD `apercentmoney` decimal(10,2) DEFAULT '0.00' COMMENT '代理缴纳佣金';");
}
if(!pdo_fieldexists('wlmerchant_settlement_record',  'spercent')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_settlement_record')." ADD `spercent` decimal(10,4) DEFAULT '0.0000' COMMENT '商家给代理的抽成比例';");
}
if(!pdo_fieldexists('wlmerchant_settlement_record',  'apercent')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_settlement_record')." ADD `apercent` decimal(10,4) DEFAULT '0.0000' COMMENT '代理给系统的抽成比例';");
}
if(!pdo_fieldexists('wlmerchant_settlement_record',  'applytime')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_settlement_record')." ADD `applytime` varchar(145) DEFAULT NULL COMMENT '申请时间';");
}
if(!pdo_fieldexists('wlmerchant_settlement_record',  'updatetime')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_settlement_record')." ADD `updatetime` varchar(145) DEFAULT NULL COMMENT '最后操作时间';");
}
if(!pdo_fieldexists('wlmerchant_settlement_record',  'settletype')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_settlement_record')." ADD `settletype` int(11) DEFAULT '0' COMMENT '1手动结算2微信钱包';");
}
if(!pdo_fieldexists('wlmerchant_settlement_record',  'ids')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_settlement_record')." ADD `ids` text COMMENT '申请结算的订单id集';");
}
if(!pdo_fieldexists('wlmerchant_settlement_record',  'ordernum')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_settlement_record')." ADD `ordernum` int(11) DEFAULT NULL COMMENT '结算订单数';");
}
if(!pdo_fieldexists('wlmerchant_settlement_record',  'sopenid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_settlement_record')." ADD `sopenid` varchar(145) DEFAULT NULL;");
}
if(!pdo_fieldexists('wlmerchant_settlement_record',  'aopenid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_settlement_record')." ADD `aopenid` varchar(145) DEFAULT NULL;");
}
if(!pdo_fieldexists('wlmerchant_settlement_record',  'type2')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_settlement_record')." ADD `type2` int(11) DEFAULT '0';");
}
if(!pdo_fieldexists('wlmerchant_smstpl',  'id')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_smstpl')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists('wlmerchant_smstpl',  'uniacid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_smstpl')." ADD `uniacid` int(11) NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_smstpl',  'name')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_smstpl')." ADD `name` varchar(50) NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_smstpl',  'type')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_smstpl')." ADD `type` varchar(32) NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_smstpl',  'smstplid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_smstpl')." ADD `smstplid` varchar(32) NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_smstpl',  'data')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_smstpl')." ADD `data` text NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_smstpl',  'status')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_smstpl')." ADD `status` smallint(2) NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_smstpl',  'createtime')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_smstpl')." ADD `createtime` int(11) NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_store_notice',  'id')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_store_notice')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists('wlmerchant_store_notice',  'uniacid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_store_notice')." ADD `uniacid` int(11) NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_store_notice',  'mid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_store_notice')." ADD `mid` int(11) NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_store_notice',  'sid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_store_notice')." ADD `sid` int(11) NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_store_notice',  'status')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_store_notice')." ADD `status` int(11) NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_store_notice',  'createtime')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_store_notice')." ADD `createtime` int(11) NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_store_notice',  'content')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_store_notice')." ADD `content` varchar(500) DEFAULT NULL;");
}
if(!pdo_indexexists('wlmerchant_store_notice',  'idx_uniacid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_store_notice')." ADD KEY `idx_uniacid` (`uniacid`);");
}
if(!pdo_indexexists('wlmerchant_store_notice',  'idx_mid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_store_notice')." ADD KEY `idx_mid` (`mid`);");
}
if(!pdo_fieldexists('wlmerchant_storefans',  'id')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_storefans')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists('wlmerchant_storefans',  'uniacid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_storefans')." ADD `uniacid` int(11) NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_storefans',  'sid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_storefans')." ADD `sid` int(11) NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_storefans',  'mid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_storefans')." ADD `mid` int(11) NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_storefans',  'source')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_storefans')." ADD `source` int(2) NOT NULL COMMENT '1收藏店铺2挪车卡绑定3店铺二维码';");
}
if(!pdo_fieldexists('wlmerchant_storefans',  'createtime')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_storefans')." ADD `createtime` int(11) NOT NULL;");
}
if(!pdo_indexexists('wlmerchant_storefans',  'idx_uniacid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_storefans')." ADD KEY `idx_uniacid` (`uniacid`);");
}
if(!pdo_indexexists('wlmerchant_storefans',  'idx_sid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_storefans')." ADD KEY `idx_sid` (`sid`);");
}
if(!pdo_fieldexists('wlmerchant_storeusers_group',  'id')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_storeusers_group')." ADD `id` int(10) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists('wlmerchant_storeusers_group',  'uniacid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_storeusers_group')." ADD `uniacid` int(10) unsigned NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_storeusers_group',  'name')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_storeusers_group')." ADD `name` varchar(50) NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_storeusers_group',  'package')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_storeusers_group')." ADD `package` varchar(5000) NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_storeusers_group',  'isdefault')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_storeusers_group')." ADD `isdefault` int(2) unsigned NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_storeusers_group',  'enabled')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_storeusers_group')." ADD `enabled` int(2) unsigned NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_storeusers_group',  'createtime')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_storeusers_group')." ADD `createtime` int(11) unsigned NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_storeusers_group',  'aid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_storeusers_group')." ADD `aid` int(11) NOT NULL;");
}
if(!pdo_fieldexists('wlmerchant_token',  'id')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_token')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists('wlmerchant_token',  'number')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_token')." ADD `number` varchar(145) DEFAULT '0.00';");
}
if(!pdo_fieldexists('wlmerchant_token',  'uniacid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_token')." ADD `uniacid` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists('wlmerchant_token',  'aid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_token')." ADD `aid` int(11) DEFAULT '0';");
}
if(!pdo_fieldexists('wlmerchant_token',  'days')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_token')." ADD `days` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists('wlmerchant_token',  'price')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_token')." ADD `price` decimal(10,2) DEFAULT '0.00';");
}
if(!pdo_fieldexists('wlmerchant_token',  'type')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_token')." ADD `type` int(11) DEFAULT NULL COMMENT '可生成类型ID';");
}
if(!pdo_fieldexists('wlmerchant_token',  'tokentype')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_token')." ADD `tokentype` int(11) DEFAULT NULL COMMENT '邀请码类型1VIP2五折';");
}
if(!pdo_fieldexists('wlmerchant_token',  'typename')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_token')." ADD `typename` varchar(145) DEFAULT NULL COMMENT '可生成类型名称';");
}
if(!pdo_fieldexists('wlmerchant_token',  'status')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_token')." ADD `status` int(11) DEFAULT '0' COMMENT '1使用中';");
}
if(!pdo_fieldexists('wlmerchant_token',  'remark')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_token')." ADD `remark` text;");
}
if(!pdo_fieldexists('wlmerchant_token',  'openid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_token')." ADD `openid` varchar(145) DEFAULT NULL;");
}
if(!pdo_fieldexists('wlmerchant_token',  'mid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_token')." ADD `mid` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists('wlmerchant_token',  'createtime')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_token')." ADD `createtime` int(11) DEFAULT '0';");
}
if(!pdo_fieldexists('wlmerchant_token_apply',  'id')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_token_apply')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists('wlmerchant_token_apply',  'aid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_token_apply')." ADD `aid` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists('wlmerchant_token_apply',  'type')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_token_apply')." ADD `type` int(11) DEFAULT NULL COMMENT '申请指定类型激活码的id';");
}
if(!pdo_fieldexists('wlmerchant_token_apply',  'tokentype')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_token_apply')." ADD `tokentype` int(11) DEFAULT NULL COMMENT '1VIP2五折';");
}
if(!pdo_fieldexists('wlmerchant_token_apply',  'num')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_token_apply')." ADD `num` int(11) DEFAULT NULL COMMENT '申请生成个数';");
}
if(!pdo_fieldexists('wlmerchant_token_apply',  'createtime')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_token_apply')." ADD `createtime` varchar(145) DEFAULT NULL COMMENT '申请时间';");
}
if(!pdo_fieldexists('wlmerchant_token_apply',  'status')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_token_apply')." ADD `status` int(11) DEFAULT NULL COMMENT '申请状态';");
}
if(!pdo_fieldexists('wlmerchant_token_apply',  'uniacid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_token_apply')." ADD `uniacid` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists('wlmerchant_vip_record',  'id')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_vip_record')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists('wlmerchant_vip_record',  'mid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_vip_record')." ADD `mid` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists('wlmerchant_vip_record',  'uid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_vip_record')." ADD `uid` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists('wlmerchant_vip_record',  'areaid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_vip_record')." ADD `areaid` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists('wlmerchant_vip_record',  'aid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_vip_record')." ADD `aid` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists('wlmerchant_vip_record',  'openid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_vip_record')." ADD `openid` varchar(145) DEFAULT NULL;");
}
if(!pdo_fieldexists('wlmerchant_vip_record',  'price')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_vip_record')." ADD `price` decimal(10,2) DEFAULT '0.00' COMMENT '充值金额';");
}
if(!pdo_fieldexists('wlmerchant_vip_record',  'howlong')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_vip_record')." ADD `howlong` varchar(145) DEFAULT NULL COMMENT '充值VIP月数';");
}
if(!pdo_fieldexists('wlmerchant_vip_record',  'createtime')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_vip_record')." ADD `createtime` varchar(145) DEFAULT NULL COMMENT '创建时间';");
}
if(!pdo_fieldexists('wlmerchant_vip_record',  'paytime')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_vip_record')." ADD `paytime` varchar(145) DEFAULT NULL COMMENT '充值时间';");
}
if(!pdo_fieldexists('wlmerchant_vip_record',  'orderno')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_vip_record')." ADD `orderno` varchar(145) DEFAULT NULL COMMENT '充值单号';");
}
if(!pdo_fieldexists('wlmerchant_vip_record',  'limittime')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_vip_record')." ADD `limittime` varchar(145) DEFAULT NULL COMMENT '下次会员到期时间';");
}
if(!pdo_fieldexists('wlmerchant_vip_record',  'status')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_vip_record')." ADD `status` int(11) DEFAULT '0' COMMENT '0未支付1已支付';");
}
if(!pdo_fieldexists('wlmerchant_vip_record',  'uniacid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_vip_record')." ADD `uniacid` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists('wlmerchant_vip_record',  'unionid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_vip_record')." ADD `unionid` varchar(145) DEFAULT NULL;");
}
if(!pdo_fieldexists('wlmerchant_vip_record',  'paytype')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_vip_record')." ADD `paytype` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists('wlmerchant_vip_record',  'transid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_vip_record')." ADD `transid` varchar(145) DEFAULT NULL;");
}
if(!pdo_fieldexists('wlmerchant_vip_record',  'issettlement')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_vip_record')." ADD `issettlement` int(11) DEFAULT '0';");
}
if(!pdo_fieldexists('wlmerchant_waittask',  'id')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_waittask')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists('wlmerchant_waittask',  'uniacid')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_waittask')." ADD `uniacid` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists('wlmerchant_waittask',  'value')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_waittask')." ADD `value` varchar(145) DEFAULT NULL;");
}
if(!pdo_fieldexists('wlmerchant_waittask',  'key')) {
	pdo_query("ALTER TABLE ".tablename('wlmerchant_waittask')." ADD `key` varchar(145) DEFAULT NULL;");
}

?>