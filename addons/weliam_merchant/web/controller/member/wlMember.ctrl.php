<?php
defined('IN_IA')or exit('Access Denied');
class wlMember{
    public function memberIndex(){
        global $_W, $_GPC;
        $_GPC['vipstatus'] = 1;
        $where = array('aid' => $_W['aid'], 'vipstatus' => $_GPC['vipstatus']);
        $pindex = max(1, intval($_GPC['page']));
        $psize = 10;
        if($_GPC['keyword'])$where['mobile^realname^nickname'] = $_GPC['keyword'];
        $memberData = Util :: getNumData("*", PDO_NAME . 'member', $where, 'credit2 desc', $pindex, $psize, 1);
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
    public function vipRecord(){
        global $_W, $_GPC;
        $pindex = max(1, intval($_GPC['page']));
        $psize = 10;
        $where = array('status' => 1, 'aid' => $_W['aid']);
        $vipRecord = Util :: getNumData("*", PDO_NAME . 'vip_record', $where, 'id desc', $pindex, $psize, 1);
        foreach($vipRecord[0] as$key => & $value){
            $value['areaName'] = Util :: idSwitch('areaid', 'areaName', $value['areaid']);
            $value['member'] = Member :: getMemberByMid($value['mid']);
        }
        $pager = $vipRecord[1];
        include wl_template('member/vipRecord');
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
                message('操作成功！', web_url('member/wlMember/memberType'), 'success');
            }
        }
        if($_GPC['memberType'] == 'del'){
            pdo_delete(PDO_NAME . 'member_type', array('id' => $_GPC['id']));
            message('操作成功！', web_url('member/wlMember/memberType'), 'success');
        }
        include wl_template('member/memberType');
    }
}
