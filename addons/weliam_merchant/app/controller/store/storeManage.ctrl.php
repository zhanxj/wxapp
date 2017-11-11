<?php
defined('IN_IA')or exit('Access Denied');
class storeManage{
    public function index(){
        global $_W, $_GPC;
        $pagetitle = !empty($_W['wlsetting']['base']['name'])? '入驻状态 - ' . $_W['wlsetting']['base']['name'] : '入驻状态';
        $users = Store :: getSingleRegister($_W['mid']);
        if(empty($users))header('location: ' . app_url('store/storeManage/enter'));
        if(!empty($users['storeid']))$data = Store :: getSingleStore($users['storeid']);
        include wl_template('store/passing');
    }
    public function enter(){
        global $_W, $_GPC;
        $me = Store :: getSingleRegister($_W['mid']);
        if(!empty($me) && empty($_GPC['mid']))header('location: ' . app_url('store/storeManage/index'));
        $pagetitle = !empty($_W['wlsetting']['base']['name'])? '入驻申请 - ' . $_W['wlsetting']['base']['name'] : '入驻申请';
        if(!empty($me['storeid']))$data = Store :: getSingleStore($me['storeid']);
        $set = Setting :: agentsetting_read('register');
        include wl_template('store/enter');
    }
    public function cancel(){
        global $_W, $_GPC;
        $re = Store :: deleteStoreByMid($_W['mid']);
        if($re){
            header('location: ' . app_url('store/storeManage/enter'));
        }else{
            wl_message('取消申请失败！');
        }
    }
    public function checkApplyAccount(){
        global $_W, $_GPC;
        $store['storename'] = trim($_GPC['storename']);
        $store['uniacid'] = $_W['uniacid'];
        $store['aid'] = $_W['aid'];
        $store['areaid'] = $_W['areaid'];
        $store['createtime'] = time();
        $store['endtime'] = time() + 365 * 24 * 60 * 60;
        $store['status'] = 1;
        $store['enabled'] = 0;
        $store['realname'] = trim($_GPC['name']);
        $store['tel'] = $_GPC['mobile'];
        $arr['storeid'] = Store :: registerEditData($store, $_GPC['id']);
        $arr['name'] = trim($_GPC['name']);
        $arr['mobile'] = $_GPC['mobile'];
        $arr['createtime'] = time();
        $arr['areaid'] = $_W['areaid'];
        $arr['limit'] = serialize($_GPC['funcs']);
        $arr['status'] = 1;
        $arr['enabled'] = 1;
        $arr['ismain'] = 1;
        $arr['uniacid'] = $_W['uniacid'];
        $arr['aid'] = $_W['aid'];
        $re = Store :: saveSingleRegister($arr, $_GPC['mid']);
        die(json_encode(array('status' => $re, 'data' => $_GPC['funcs'])));
    }
    public function a(){
        include wl_template('store/passing');
    }
}
