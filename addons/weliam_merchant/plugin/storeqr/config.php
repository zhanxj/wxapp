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

$frames['summary']['title'] = '<i class="fa fa-dashboard"></i>&nbsp;&nbsp; 概况';
$frames['summary']['items'] = array();
$frames['summary']['items']['summary']['url'] = web_url('storeqr/sqrcode/summary');
$frames['summary']['items']['summary']['title'] = '二维码统计';
$frames['summary']['items']['summary']['actions'] = array();
$frames['summary']['items']['summary']['active'] = '';

$frames['card']['title'] = '<i class="fa fa-qrcode"></i>&nbsp;&nbsp; 二维码管理';
$frames['card']['items'] = array();
$frames['card']['items']['list']['url'] = web_url('storeqr/sqrcode/qrlist');
$frames['card']['items']['list']['title'] = '二维码列表';
$frames['card']['items']['list']['actions'] = array();
$frames['card']['items']['list']['active'] = '';

$frames['card']['items']['post']['url'] = web_url('storeqr/sqrcode/post');
$frames['card']['items']['post']['title'] = '生成二维码';
$frames['card']['items']['post']['actions'] = array();
$frames['card']['items']['post']['active'] = '';

$frames['set']['title'] = '<i class="fa fa-gear"></i>&nbsp;&nbsp; 设置';
$frames['set']['items'] = array();

$frames['set']['items']['basics']['url'] = web_url('storeqr/sqrcode/setting');
$frames['set']['items']['basics']['title'] = '基础设置';
$frames['set']['items']['basics']['actions'] = array();
$frames['set']['items']['basics']['active'] = '';

$config = array();
$config['name'] = '商户二维码';
$config['des'] = '商户二维码，可方便平台快速入驻商家，商家吸引粉丝，平台吸粉粉丝。';
$config['ident'] = 'storeqr';
$config['category'] = 'help';
$config['cover'] = web_url('storeqr/sqrcode/qrlist');
$config['menus'] = $frames;

return $config;
?>
