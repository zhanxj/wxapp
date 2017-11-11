<?php
defined('IN_IA')or exit('Access Denied');
class vipmember{
    public function index(){
        global $_W, $_GPC;
        $where = array();
        $where['isvip'] = 2;
        $pindex = max(1, intval($_GPC['page']));
        $psize = 10;
        if($_GPC['keyword'] && $_GPC['type']){
            if (!empty($_GPC['keyword'])){
                switch($_GPC['type']){
                case 2 : $where['@mobile@'] = $_GPC['keyword'];
                    break;
                case 3 : $where['@realname@'] = $_GPC['keyword'];
                    break;
                default : $where['@nickname@'] = $_GPC['keyword'];
                }
            }
        }
        $memberData = Util :: getNumData("*", PDO_NAME . 'member', $where, 'credit2 desc', $pindex, $psize, 1);
        $list = $memberData[0];
        $pager = $memberData[1];
        foreach($list as $key => & $value){
            $value['level'] = $value['level'] > 0?"VIP " . $value['level']:"普通会员";
            $value['areaid'] = Util :: idSwitch('areaid', 'areaName', $value['areaid']);
        }
        include wl_template('member/listIndex');
    }
    public function creditRecord(){
        global $_W, $_GPC;
        $uid = $_GPC['uid'];
        $status = !empty($_GPC['status'])?$_GPC['status']:1;
        $creditsRecords = Member :: getSingleRecord($uid, $status);
        $member = Member :: getSingleUser($uid);
        include wl_template('member/listhistory');
    }
    public function modal(){
        global $_W, $_GPC;
        $uid = $_GPC['uid'];
        $remark = $_GPC['remark'];
        if(empty($remark)){
            $remark = "拼团后台系统操作！";
        }
        $credit1_type = $_GPC['credit1_type'];
        $credit1_value = $_GPC['credit1_value'];
        if($credit1_type == 2){
            $credit1_value = 0 - $credit1_value;
        }
        $credit2_type = $_GPC['credit2_type'];
        $credit2_value = $_GPC['credit2_value'];
        if($credit2_type == 2){
            $credit2_value = 0 - $credit2_value;
        }
        $realname = $_GPC['realname'];
        $telnum = $_GPC['telnum'];
        if($_GPC['level'])pdo_update(PDO_NAME . 'member', array('level' => $_GPC['level'], 'isvip' => 2), array('uid' => $uid));
        if(is_numeric($credit1_value) && is_numeric($credit2_value)){
            if($credit2_value != 0 || $credit1_value != 0){
                $v1 = Member :: creditUpdateCredit1($uid, $credit1_value, $remark);
                $v2 = Member :: creditUpdateCredit2($uid, $credit2_value, $remark);
            }else{
                $v1 = 1;
                $v2 = 1;
            }
            $credit = Member :: creditGetByUid($uid);
            if(empty($credit1_value))$v1 = 1;
            if(empty($credit2_value))$v2 = 1;
            if($v1 && $v2){
                die(json_encode(array('errno' => 0, 'message' => '操作成功', 'credit1' => $credit['credit1'], 'credit2' => $credit['credit2'], 'newname' => $realname, 'newtel' => $telnum)));
            }else{
                die(json_encode(array('errno' => 1, 'message' => '操作失败')));
            }
        }else{
            die(json_encode(array('errno' => 2, 'message' => '输入不正确')));
        }
    }
}
