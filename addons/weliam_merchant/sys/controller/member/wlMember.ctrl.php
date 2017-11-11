<?php
defined('IN_IA')or exit('Access Denied');
class wlMember{
    public function index(){
        global $_W, $_GPC;
        $data = Merchant :: sysMemberSurvey(1);
        $members = $data[0];
        $address_arr = $data[1];
        $yesterday = $data[2];
        $week = $data[3];
        $wek_num = $data[4];
        $mon_num = $data[5];
        $noVipMembers = $data[6];
        $vip = $data[7];
        $time = $data[8];
        $today = $data[9];
        $allfans = $data[11];
        include wl_template('member/summary');
    }
    public function memberIndex(){
        global $_W, $_GPC;
        $where = array();
        $_GPC['vipstatus'] ? $where['vipstatus'] = $_GPC['vipstatus'] : $where['vipstatus'] = '0';
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
        $memberData = Util :: getNumData("*", PDO_NAME . 'member', $where, 'id desc', $pindex, $psize, 1);
        $list = $memberData[0];
        $pager = $memberData[1];
        load() -> model('mc');
        foreach($list as $key => & $value){
            $result = mc_fansinfo($value['openid']);
            $r = mc_fetch($value['uid'], array('credit1', 'credit2'));
            $value['follow'] = $result['follow'];
            $value['credit1'] = $r['credit1'] + $value['credit1'];
            $value['credit2'] = $r['credit2'] + $value['credit2'];
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
            $remark = "后台系统操作！";
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
                $v1 = Member :: credit_update_credit1($uid, $credit1_value, 1, '后台充值');
                $v2 = Member :: credit_update_credit2($uid, $credit2_value, 1, '后台充值');
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
    public function vipRecord(){
        global $_W, $_GPC;
        $pindex = max(1, intval($_GPC['page']));
        $psize = 10;
        $where = array('status' => 1);
        $vipRecord = Util :: getNumData("*", PDO_NAME . 'vip_record', $where, 'id desc', $pindex, $psize, 1);
        foreach($vipRecord[0] as$key => & $value){
            $value['areaName'] = Util :: idSwitch('areaid', 'areaName', $value['areaid']);
            $value['member'] = Member :: getMemberByMid($value['mid']);
        }
        $pager = $vipRecord[1];
        include wl_template('member/vipRecord');
    }
    function selectMember(){
        global $_W, $_GPC;
        $where = array();
        $keyword = trim($_GPC['keyword']);
        if ($keyword != '')$where['@nickname@'] = $keyword;
        $dsData = Util :: getNumData('nickname,avatar,openid', PDO_NAME . 'member', $where, 'id desc', 0, 0, 0);
        $ds = $dsData[0];
        include wl_template('member/selectMember');
        exit;
    }
}
