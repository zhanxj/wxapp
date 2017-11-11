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

$frames['active']['title'] = '<i class="fa fa-globe"></i>&nbsp;&nbsp; 活动';
$frames['active']['items'] = array();
$frames['active']['items']['list1']['url'] = web_url('rush/active/activelist');
$frames['active']['items']['list1']['title'] = '抢购列表';
$frames['active']['items']['list1']['actions'] = array('ac', 'active', 'do', 'activelist');
$frames['active']['items']['list1']['active'] = '';

$frames['active']['items']['createact']['url'] = web_url('rush/active/createactive');
$frames['active']['items']['createact']['title'] = !empty($_GPC['id']) ? '编辑抢购' : '创建抢购';
$frames['active']['items']['createact']['actions'] = array('ac', 'active', 'createactive');
$frames['active']['items']['createact']['active'] = '';

$frames['order']['title'] = '<i class="fa fa-globe"></i>&nbsp;&nbsp; 订单';
$frames['order']['items'] = array();
$frames['order']['items']['list1']['url'] = web_url('rush/order/orderList');
$frames['order']['items']['list1']['title'] = '抢购订单';
$frames['order']['items']['list1']['actions'] = array('ac', 'order', 'do', 'orderList');
$frames['order']['items']['list1']['active'] = '';

$frames['set']['title'] = '<i class="fa fa-globe"></i>&nbsp;&nbsp; 设置';
$frames['set']['items'] = array();
$frames['set']['items']['entry']['url'] = web_url('rush/set/entry');
$frames['set']['items']['entry']['title'] = '入口设置';
$frames['set']['items']['entry']['actions'] = array('ac', 'set', 'entry');
$frames['set']['items']['entry']['active'] = '';

$frames['set']['items']['basics']['url'] = web_url('rush/set/base');
$frames['set']['items']['basics']['title'] = '基础设置';
$frames['set']['items']['basics']['actions'] = array('ac', 'set', 'base');
$frames['set']['items']['basics']['active'] = '';


$config = array();
$config['name'] = '抢购活动';
$config['ident'] = 'rush';
$config['des'] = '可以设置限时抢购、限量抢购商品，多种营销抢购方式，释放用户的购买热情。';
$config['category'] = 'market';
$config['cover'] = web_url('rush/active/activelist', array('status' => 2));
$config['menus'] = $frames;

return $config;
?>
