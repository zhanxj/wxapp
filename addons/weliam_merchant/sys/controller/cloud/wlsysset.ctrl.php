<?php
defined('IN_IA')or exit('Access Denied');
class wlsysset{
    function taskcover(){
        global $_W, $_GPC;
        $settings['url'] = $_W['siteroot'] . "addons/weliam_merchant/core/common/task.php";
        $settings['name'] = '计划任务入口';
        $lock = cache_read(MODULE_NAME . ':task:status');
        if(empty($lock) || ($lock['value'] == 1 && $lock['expire'] < (time() - 600))){
            $status = 1;
        }else{
            $status = 2;
        }
        include wl_template('cloud/taskcover');
    }
    function base(){
        global $_W, $_GPC;
        $settings = Cloud :: wl_syssetting_read('base');
        if (checksubmit('submit')){
            $base = array('name' => $_GPC['name'], 'logo' => $_GPC['logo'], 'copyright' => $_GPC['copyright']);
            Cloud :: wl_syssetting_save($base, 'base');
            message('更新设置成功！', web_url('cloud/wlsysset/base'));
        }
        include wl_template('cloud/base');
    }
}
