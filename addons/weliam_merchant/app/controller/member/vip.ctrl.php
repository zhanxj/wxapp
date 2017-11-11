<?php
defined('IN_IA')or exit('Access Denied');
class vip{
    public function open(){
        global $_W, $_GPC;
        $pagetitle = !empty($_W['wlsetting']['base']['name'])? '开通VIP - ' . $_W['wlsetting']['base']['name'] : '开通VIP';
        $vipSet = Setting :: wlsetting_read('member_vip_price');
        $vip = $vipSet['mm'];
        $listData = Util :: getNumData("*", PDO_NAME . 'member_type', array('status' => 1, 'uniacid' => $_W['uniacid']));
        $list = $listData[0];
        include wl_template('member/vip_open');
    }
    public function createOrder(){
        global $_W, $_GPC;
        if(empty($_W['wlmember']['mobile'])){
            wl_message(array('errno' => 1, 'message' => '还未绑定手机号码，点击确定去绑定'));
        }
        $orderno = wlPay :: createVipOrder($_GPC['radioValue']);
        wl_message(array('errno' => 0, 'message' => $orderno));
    }
    public function vipSuccess(){
        global $_W, $_GPC;
        $pagetitle = !empty($_W['wlsetting']['base']['name'])? '开通VIP - ' . $_W['wlsetting']['base']['name'] : '开通VIP';
        $orderid = $_GPC['orderid'];
        if($orderid){
            $where['id'] = $orderid;
            $order = Util :: getSingelData('*', 'wlmerchant_vip_record', $where);
            $where2['openid'] = $order['openid'];
        }else{
            $where2['openid'] = $_W['openid'];
        }
        $member = Util :: getSingelData('*', 'wlmerchant_member', $where2);
        $order['limittime'] = date('Y年m月d日', $member['lastviptime']);
        include wl_template('member/vip_success');
    }
    public function getVipSuccess(){
        global $_W, $_GPC;
        $pagetitle = !empty($_W['wlsetting']['base']['name'])? '开通VIP - ' . $_W['wlsetting']['base']['name'] : '开通VIP';
        $orderno = $_GPC['orderno'];
        $where['orderno'] = $orderno;
        $order = Util :: getSingelData('*', 'wlmerchant_vip_record', $where);
        $where2['openid'] = $order['openid'];
        $member = Util :: getSingelData('*', 'wlmerchant_member', $where2);
        $order['limittime'] = date('Y-m-d H:i:s', $order['limittime']);
        die(json_encode(array('data2' => $member, 'data1' => $order)));
    }
    public function vipToken(){
        global $_W, $_GPC;
        $token = $_GPC['token'];
        $type = Util :: getSingelData("*", PDO_NAME . 'token', array('number' => $token));
        if(empty($type))die(json_encode(array('errno' => 1, 'message' => '激活码不存在！')));
        if($type['status'] != 0)die(json_encode(array('errno' => 2, 'message' => '该激活码已使用！')));
        $num = $type['days'];
        $vipInfo = Util :: getSingelData('*', PDO_NAME . "member", array('uniacid' => $_W['uniacid'], 'id' => $_W['mid']));
        $lastviptime = Member :: vip($vipInfo['id']);
        if($lastviptime){
            $limittime = $lastviptime + $num * 24 * 60 * 60;
            $vipleveltime = floor($limittime / 24 * 60 * 60);
        }else{
            $limittime = time() + $num * 24 * 60 * 60;
            $vipleveltime = $num;
        }
        $aid = Util :: idSwitch('areaid', 'aid', $_W['areaid']);
        $memberData = array('level' => 1, 'vipstatus' => 1, 'vipleveldays' => $type['days'], 'lastviptime' => $limittime, 'areaid' => $_W['areaid'], 'aid' => $aid);
        if(pdo_update(PDO_NAME . 'member', $memberData, array('id' => $_W['mid']))){
            if(pdo_update(PDO_NAME . 'token', array('status' => 1, 'mid' => $_W['mid'], 'openid' => $_W['openid']), array('number' => $token))){
                die(json_encode(array('errno' => 0, 'message' => '激活成功')));
            }else{
                die(json_encode(array('errno' => 3, 'message' => '更新激活码失败！')));
            }
        }else{
            die(json_encode(array('errno' => 3, 'message' => '更新会员失败！')));
        }
    }
}
