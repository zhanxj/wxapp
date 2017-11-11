<?php
defined('IN_IA')or exit('Access Denied');
class register{
    public function index(){
        global $_W, $_GPC;
        $pindex = max(1, intval($_GPC['page']));
        $psize = 10;
        $registeres = Store :: getAllRegister($pindex-1, $psize, $_GPC['status']);
        $registers = $registeres['data'];
        foreach($registers as $key => $value){
            $registers[$key]['member'] = Member :: getMemberByMid($value['mid'], array('id', 'nickname'));
            $registers[$key]['storedata'] = Store :: getSingleStore($value['storeid']);
        }
        $pager = pagination($registeres['count'], $pindex, $psize);
        include wl_template('store/registerIndex');
    }
    public function add(){
        global $_W, $_GPC;
        if($_GPC['op'] == 'selectnickname'){
            $con = "uniacid='{$_W['uniacid']}' ";
            $keyword = $_GPC['keyword'];
            if ($keyword != ''){
                $con .= " and nickname LIKE '%{$keyword}%' ";
            }
            $ds = Store :: registerNickname($con);
            include wl_template('store/registerQueryNickname');
            exit;
        }
    }
    public function edit(){
        global $_W, $_GPC;
        if($_GPC['op'] == 'reject'){
            if(pdo_update(PDO_NAME . 'merchantdata', array('status' => 0), array('id' => $_GPC['id']))){
                Store :: editSingleRegister($_GPC['uid'], array('status' => 0, 'reject' => $_GPC['reject']));
                wl_message('驳回成功', referer(), 'succuss');
            }
            wl_message('驳回失败', referer(), 'error');
        }
        if($_GPC['op'] == 'pass'){
            if(pdo_update(PDO_NAME . 'merchantdata', array('status' => 2), array('id' => $_GPC['id']))){
                Store :: editSingleRegister($_GPC['uid'], array('status' => 2, 'reject' => $_GPC['reject']));
                wl_message('通过操作成功', web_url('store/merchant/index', array('enabled' => 0)), 'succuss');
            }
            wl_message('通过操作失败', referer(), 'error');
        }
    }
    public function set(){
        global $_W, $_GPC;
        if($_GPC['set']){
            $_GPC['set']['detail'] = htmlspecialchars_decode($_GPC['set']['detail']);
            $res1 = Setting :: agentsetting_save($_GPC['set'], 'register');
            wl_message('保存成功！', referer(), 'succuss');
        }
        $set = Setting :: agentsetting_read('register');
        include wl_template('store/registerSet');
        exit;
    }
}
