<?php
defined('IN_IA')or exit('Access Denied');
class coverset{
    public function qr(){
        global $_W, $_GPC;
        if(empty($_GPC['url']))return false;
        m('qrcode/QRcode') -> png($_GPC['url'], false, QR_ECLEVEL_H, 4);
    }
    public function index(){
        global $_W, $_GPC;
        $areaid = pdo_getcolumn(PDO_NAME . 'oparea', array('uniacid' => $_W['uniacid'], 'aid' => $_W['aid']), 'areaid');
        $settings['url'] = app_url('dashboard/home/index', array('areaid' => $areaid));
        $settings['name'] = '首页';
        include wl_template('agentset/cover');
    }
    public function member(){
        global $_W, $_GPC;
        $areaid = pdo_getcolumn(PDO_NAME . 'oparea', array('uniacid' => $_W['uniacid'], 'aid' => $_W['aid']), 'areaid');
        $settings['url'] = app_url('member/user', array('areaid' => $areaid));
        $settings['name'] = '会员中心';
        include wl_template('agentset/cover');
    }
    public function store(){
        global $_W, $_GPC;
        $areaid = pdo_getcolumn(PDO_NAME . 'oparea', array('uniacid' => $_W['uniacid'], 'aid' => $_W['aid']), 'areaid');
        $settings['url'] = app_url('store/merchant', array('areaid' => $areaid));
        $settings['name'] = '商户列表';
        include wl_template('agentset/cover');
    }
    public function vip(){
        global $_W, $_GPC;
        $areaid = pdo_getcolumn(PDO_NAME . 'oparea', array('uniacid' => $_W['uniacid'], 'aid' => $_W['aid']), 'areaid');
        $settings['url'] = app_url('member/vip/open', array('areaid' => $areaid));;
        $settings['name'] = 'VIP开通';
        include wl_template('agentset/cover');
    }
}
