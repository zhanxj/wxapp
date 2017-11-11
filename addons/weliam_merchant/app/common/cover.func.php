<?php
defined('IN_IA')or exit('Access Denied');
define('IN_APP', true);
global $_W, $_GPC;
$_W['wlmember'] = Member :: wl_member_auth();
$_W['mid'] = $_W['wlmember']['id'];
if(!empty($_GPC['areaid'])){
    Area :: set_area_cookie(intval($_GPC['areaid']));
}
if(empty($_W['areaid']) && !empty($_GPC['__areaid'])){
    $area_mess = Util :: getCookie('__areaid');
    $opareaid = pdo_getcolumn(PDO_NAME . 'oparea', array('uniacid' => $_W['uniacid'], 'areaid' => $area_mess['areaid']), 'id');
    if(!empty($opareaid)){
        $_W['areaid'] = $area_mess['areaid'];
        $_W['areaname'] = $area_mess['name'];
        $_W['aid'] = $area_mess['aid'];
    }
}
if(empty($_W['areaid']) && $_W['plugin'] != 'area'){
    $maera = Area :: get_area();
    if(!empty($maera['id'])){
        Area :: set_area_cookie($maera['id']);
    }else{
        header('location: ' . app_url('area/region/select_region'));
        die;
    }
}
if(!empty($_W['aid'])){
    $_W['agentset'] = Setting :: agentsetting_load();
}
puv();
