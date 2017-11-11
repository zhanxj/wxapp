<?php
defined('IN_IA')or exit('Access Denied');
class memberlist{
    public function index(){
        global $_W, $_GPC;
        $isvip = $_GPC[isvip];
        $pindex = max(1, intval($_GPC['page']));
        $psize = 10;
        $lists = Member :: getAllMember($pindex-1, $psize, $isvip);
        $list = $lists['data'];
        $pager = pagination($users['count'], $pindex, $psize);
        if(checksubmit('submit')){
            echo 1;
        }
        if(checksubmit('selectSubmit')){
            $where = " WHERE 1 and uniacid={$_W['uniacid']} ";
            $params = array();
            $type = intval($_GPC['type']);
            $keyword = trim($_GPC['keyword']);
            if (!empty($keyword)){
                switch($type){
                case 2 : $where .= " AND mobile LIKE :mobile";
                    $params[':mobile'] = "%{$keyword}%";
                    break;
                case 3 : $where .= " AND nickname LIKE :nickname";
                    $params[':nickname'] = "%{$keyword}%";
                    break;
                default : $where .= " AND realname LIKE :realname";
                    $params[':realname'] = "%{$keyword}%";
                }
            }
            $lists = Member :: getSelectMember($pindex-1, $psize, $where, $params);
            $list = $lists['data'];
            include wl_template('member/listIndex');
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
                die(json_encode(array('errno' => 0, 'message' => '操作成功' . $v1, 'credit1' => $credit['credit1'], 'credit2' => $credit['credit2'], 'newname' => $realname, 'newtel' => $telnum)));
            }else{
                die(json_encode(array('errno' => 1, 'message' => '操作失败')));
            }
        }else{
            die(json_encode(array('errno' => 2, 'message' => '输入不正确')));
        }
    }
}
