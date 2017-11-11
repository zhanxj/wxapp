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
        $settings = $_W['wlsetting']['coverIndex'];
        $settings['url'] = app_url('dashboard/home/index');
        $settings['name'] = '首页';
        if (checksubmit('submit')){
            $cover = Util :: trimWithArray($_GPC['cover']);
            $cover['status'] = intval($_GPC['status']);
            Setting :: wlsetting_save($cover, 'coverIndex');
            $re = Setting :: saveRule('coverIndex', $settings['url'], $cover);
            message($re, web_url('setting/coverset/index'));
        }
        include wl_template('setting/coverAll');
    }
    public function member(){
        global $_W, $_GPC;
        $settings = $_W['wlsetting']['coverMember'];
        $settings['url'] = app_url('member/user');
        $settings['name'] = '会员中心';
        if (checksubmit('submit')){
            $cover = Util :: trimWithArray($_GPC['cover']);
            $cover['status'] = intval($_GPC['status']);
            Setting :: wlsetting_save($cover, 'coverMember');
            $re = Setting :: saveRule('coverMember', $settings['url'], $cover);
            message($re, web_url('setting/coverset/member'));
        }
        include wl_template('setting/coverAll');
    }
    public function store(){
        global $_W, $_GPC;
        $settings = $_W['wlsetting']['coverStore'];
        $settings['url'] = app_url('store/merchant');
        $settings['name'] = '商户列表';
        if (checksubmit('submit')){
            $cover = Util :: trimWithArray($_GPC['cover']);
            $cover['status'] = intval($_GPC['status']);
            Setting :: wlsetting_save($cover, 'coverStore');
            $re = Setting :: saveRule('coverStore', $settings['url'], $cover);
            message($re, web_url('setting/coverset/store'));
        }
        include wl_template('setting/coverAll');
    }
    public function vip(){
        global $_W, $_GPC;
        $settings = $_W['wlsetting']['coverVip'];
        $settings['url'] = app_url('member/vip/open');
        $settings['name'] = 'VIP开通';
        if (checksubmit('submit')){
            $cover = Util :: trimWithArray($_GPC['cover']);
            $cover['status'] = intval($_GPC['status']);
            Setting :: wlsetting_save($cover, 'coverVip');
            $re = Setting :: saveRule('coverVip', $settings['url'], $cover);
            message($re, web_url('setting/coverset/vip'));
        }
        include wl_template('setting/coverAll');
    }
}
