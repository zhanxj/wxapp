<?php
if (!defined('IN_IA')){
     exit('Access Denied');
    }
$frames = array();
$frames['application']['title'] = '<i class="fa fa-cloud"></i>&nbsp;&nbsp; 管理应用';
$frames['application']['items'] = array();

$frames['application']['items']['list']['url'] = web_url('app/plugins');
$frames['application']['items']['list']['title'] = '所有应用';
$frames['application']['items']['list']['actions'] = array();
$frames['application']['items']['list']['active'] = '';
$frames['application']['items']['list']['append']['url'] = web_url('app/plugins');
$frames['application']['items']['list']['append']['title'] = '<i class="fa fa-plus"></i>';

$frames['wlcoupon']['title'] = '<i class="fa fa-globe"></i>&nbsp;&nbsp; 优惠券';
$frames['wlcoupon']['items'] = array();
$frames['wlcoupon']['items']['list']['url'] = web_url('wlcoupon/couponlist/couponsList');
$frames['wlcoupon']['items']['list']['title'] = '优惠券列表';
$frames['wlcoupon']['items']['list']['actions'] = array('ac', 'couponlist', 'couponsList');
$frames['wlcoupon']['items']['list']['active'] = '';

$frames['wlcoupon']['items']['createcoupons']['url'] = web_url('wlcoupon/couponlist/createcoupons');
$frames['wlcoupon']['items']['createcoupons']['title'] = '增加优惠券';
$frames['wlcoupon']['items']['createcoupons']['actions'] = array('ac', 'couponlist', 'createcoupons');
$frames['wlcoupon']['items']['createcoupons']['active'] = '';

$frames['record']['title'] = '<i class="fa fa-globe"></i>&nbsp;&nbsp; 订单记录';
$frames['record']['items'] = array();
$frames['record']['items']['merbercoupon']['url'] = web_url('wlcoupon/couponlist/merbercoupon');
$frames['record']['items']['merbercoupon']['title'] = '用户记录';
$frames['record']['items']['merbercoupon']['actions'] = array('ac', 'couponlist', 'merbercoupon');
$frames['record']['items']['merbercoupon']['active'] = '';

$frames['record']['items']['couponorder']['url'] = web_url('wlcoupon/couponlist/orderlist');
$frames['record']['items']['couponorder']['title'] = '订单列表';
$frames['record']['items']['couponorder']['actions'] = array('ac', 'couponlist', 'orderlist');
$frames['record']['items']['couponorder']['active'] = '';

$frames['sett']['title'] = '<i class="fa fa-globe"></i>&nbsp;&nbsp; 设置';
$frames['sett']['items'] = array();
$frames['sett']['items']['entry']['url'] = web_url('wlcoupon/couponlist/entry');
$frames['sett']['items']['entry']['title'] = '入口设置';
$frames['sett']['items']['entry']['actions'] = array('ac', 'couponlist', 'entry');
$frames['sett']['items']['entry']['active'] = '';

$frames['sett']['items']['basics']['url'] = web_url('wlcoupon/couponlist/base');
$frames['sett']['items']['basics']['title'] = '基础设置';
$frames['sett']['items']['basics']['actions'] = array('ac', 'couponlist', 'base');
$frames['sett']['items']['basics']['active'] = '';


$config = array();
$config['name'] = '超级券';
$config['ident'] = 'wlcoupon';
$config['des'] = '超级券，集折扣券、代金券、套餐券、团购券以及优惠券一身。';
$config['category'] = 'market';
$config['cover'] = web_url('wlcoupon/couponlist/couponsList');
$config['menus'] = $frames;

return $config;
?>
