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

$frames['halfcard']['title'] = '<i class="fa fa-globe"></i>&nbsp;&nbsp; 五折卡';
$frames['halfcard']['items'] = array();
$frames['halfcard']['items']['list']['url'] = web_url('halfcard/halfcard_web/halfcardList');
$frames['halfcard']['items']['list']['title'] = '五折列表';
$frames['halfcard']['items']['list']['actions'] = array('ac', 'halfcard_web', 'halfcardList');
$frames['halfcard']['items']['list']['active'] = '';

$frames['halfcard']['items']['createHalfcard']['url'] = web_url('halfcard/halfcard_web/createHalfcard');
$frames['halfcard']['items']['createHalfcard']['title'] = !empty($_GPC['id']) ? '编辑五折' : '添加五折';
$frames['halfcard']['items']['createHalfcard']['actions'] = array('ac', 'halfcard_web', 'do', array('createHalfcard', 'editHalfcard'));
$frames['halfcard']['items']['createHalfcard']['active'] = '';

$frames['halfcardmember']['title'] = '<i class="fa fa-globe"></i>&nbsp;&nbsp; 五折记录';
$frames['halfcardmember']['items'] = array();

$frames['halfcardmember']['items']['halfcardmemberlist']['url'] = web_url('halfcard/halfcard_web/memberlist');
$frames['halfcardmember']['items']['halfcardmemberlist']['title'] = '用户列表';
$frames['halfcardmember']['items']['halfcardmemberlist']['actions'] = array('ac', 'halfcard_web', 'memberlist');
$frames['halfcardmember']['items']['halfcardmemberlist']['active'] = '';

$frames['halfcardmember']['items']['userhalfcardlist']['url'] = web_url('halfcard/halfcard_web/userhalfcardlist');
$frames['halfcardmember']['items']['userhalfcardlist']['title'] = '使用记录';
$frames['halfcardmember']['items']['userhalfcardlist']['actions'] = array('ac', 'halfcard_web', 'userhalfcardlist');
$frames['halfcardmember']['items']['userhalfcardlist']['active'] = '';

$frames['halfcardmember']['items']['payhalfcardlist']['url'] = web_url('halfcard/halfcard_web/payhalfcardlist');
$frames['halfcardmember']['items']['payhalfcardlist']['title'] = '开通记录';
$frames['halfcardmember']['items']['payhalfcardlist']['actions'] = array('ac', 'halfcard_web', 'payhalfcardlist');
$frames['halfcardmember']['items']['payhalfcardlist']['active'] = '';

$frames['hset']['title'] = '<i class="fa fa-globe"></i>&nbsp;&nbsp; 设置';
$frames['hset']['items'] = array();
$frames['hset']['items']['entry']['url'] = web_url('halfcard/halfcard_web/entry');
$frames['hset']['items']['entry']['title'] = '首页入口';
$frames['hset']['items']['entry']['actions'] = array('ac', 'halfcard_web', 'entry');
$frames['hset']['items']['entry']['active'] = '';

$frames['hset']['items']['open']['url'] = web_url('halfcard/halfcard_web/open');
$frames['hset']['items']['open']['title'] = '购卡入口';
$frames['hset']['items']['open']['actions'] = array('ac', 'halfcard_web', 'open');
$frames['hset']['items']['open']['active'] = '';

$frames['hset']['items']['basics']['url'] = web_url('halfcard/halfcard_web/base');
$frames['hset']['items']['basics']['title'] = '基础设置';
$frames['hset']['items']['basics']['actions'] = array('ac', 'halfcard_web', 'base');
$frames['hset']['items']['basics']['active'] = '';


$config = array();
$config['name'] = '五折卡';
$config['ident'] = 'halfcard';
$config['des'] = '一张集吃喝玩乐为一体的电子虚拟卡，一卡在手，优惠我有。';
$config['category'] = 'market';
$config['cover'] = web_url('halfcard/halfcard_web/halfcardList');
$config['menus'] = $frames;

return $config;
?>
