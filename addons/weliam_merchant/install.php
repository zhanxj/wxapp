<?php
$sql =<<<EOF

CREATE TABLE IF NOT EXISTS `ims_wlmerchant_adv` (
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
EOF;
pdo_run($sql);