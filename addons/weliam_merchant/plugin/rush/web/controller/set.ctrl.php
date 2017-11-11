<?php
defined('IN_IA')or exit('Access Denied');
class set{
    function qr(){
        global $_W, $_GPC;
        if(empty($_GPC['url']))return false;
        m('qrcode/QRcode') -> png($_GPC['url'], false, QR_ECLEVEL_H, 4);
    }
    function entry(){
        global $_W, $_GPC;
        $settings['url'] = app_url('rush/home/index');
        $settings['name'] = '抢购入口';
        include wl_template('set/entry');
    }
    function base(){
        global $_W, $_GPC;
        $base = Setting :: agentsetting_read('rush');
        if (checksubmit('submit')){
            $data_img = $_GPC['data_img'];
            $data_url = $_GPC['data_url'];
            $paramids = array();
            $len = count($data_img);
            for ($k = 0;$k < $len;$k++){
                if(!empty($data_img[$k])){
                    $paramids[$k]['data_img'] = $data_img[$k];
                    $paramids[$k]['data_url'] = $data_url[$k];
                }
            }
            $base = $_GPC['base'];
            $base['content'] = $paramids;
            $res1 = Setting :: agentsetting_save($base, 'rush');
            wl_message('保存设置成功！', referer(), 'success');
        }
        include wl_template('set/base');
    }
    function advtpl(){
        include wl_template('set/imgandurl');
    }
}
