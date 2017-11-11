<?php
defined('IN_IA')or exit('Access Denied');
class memberset{
    public function index(){
        global $_W, $_GPC;
        if($_GPC['vip']){
            $_GPC['vip']['detail'] = htmlspecialchars_decode($_GPC['vip']['detail']);
            $month = $_GPC['month'];
            $money = $_GPC['money'];
            $vipSet = array();
            for($i = 0;$i < count($month);$i++){
                $vipSet[$i]['month'] = $month[$i];
                $vipSet[$i]['money'] = $money[$i];
            }
            $_GPC['vip']['mm'] = $vipSet;
            Setting :: wlsetting_save($_GPC['vip'], 'member_vip_price');
        }
        $vipSet = Setting :: wlsetting_read('member_vip_price');
        $vip = $vipSet['mm'];
        include wl_template('member/listSetting');
    }
    public function memberType(){
        global $_W, $_GPC;
        $_GPC['memberType'] = $_GPC['memberType']?$_GPC['memberType']:'display';
        if($_GPC['memberType'] == 'display'){
            $pindex = max(1, $_GPC['page']);
            $listData = Util :: getNumData("*", PDO_NAME . 'member_type', array(), 'id desc', $pindex, 10, 1);
            $list = $listData[0];
        }
        if($_GPC['memberType'] == 'add'){
            $memberType = $_GPC['data'];
            if($_GPC['id'])$data = Util :: getSingelData("*", PDO_NAME . 'member_type', array('id' => $_GPC['id']));
            if($_GPC['data']){
                $memberType['uniacid'] = $_W['uniacid'];
                if($_GPC['id'])pdo_update(PDO_NAME . 'member_type', $memberType, array('id' => $_GPC['id']));
                else pdo_insert(PDO_NAME . 'member_type', $memberType);
                message('操作成功！', web_url('member/memberset/memberType'), 'success');
            }
        }
        if($_GPC['memberType'] == 'del'){
            pdo_delete(PDO_NAME . 'member_type', array('id' => $_GPC['id']));
            message('操作成功！', web_url('member/memberset/memberType'), 'success');
        }
        include wl_template('member/memberType');
    }
}
