<?php
defined('IN_IA')or exit('Access Denied');
class halfcardopen{
    public function open(){
        global $_W, $_GPC;
        $pagetitle = !empty($_W['wlsetting']['base']['name'])? '开通五折卡 - ' . $_W['wlsetting']['base']['name'] : '开通五折卡';
        $base = Setting :: agentsetting_read('halfcard');
        if($_W['wlsetting']['halfcard']['halfcardtype'] == 1){
            $where = array('mid' => $_W['mid']);
            $hcqa = unserialize($_W['wlsetting']['halfcard']['qanda']);
            $listData = Util :: getNumData("*", PDO_NAME . 'halfcard_type', array('aid' => 0, 'status' => 1));
            $hcprice = $listData[0];
        }else{
            $where = array('mid' => $_W['mid'], 'aid' => $_W['aid']);
            $hcqa = unserialize($base['qanda']);
            $listData = Util :: getNumData("*", PDO_NAME . 'halfcard_type', array('aid' => $_W['aid'], 'status' => 1));
            $hcprice = $listData[0];
        }
        $member = pdo_getcolumn('wlmerchant_halfcardmember', $where, 'id');
        if($member){
            $halfcardflag = 1;
        }
        if($halfcardflag == 1){
            header('location:' . app_url('halfcard/halfcard_app/userhalfcard'));
        }else{
            include wl_template('halfcardhtml/openhalfcard');
        }
    }
    public function createOrder(){
        global $_W, $_GPC;
        $member = Util :: getSingelData('mobile,credit2,uid', PDO_NAME . 'member', array('id' => $_W['mid']));
        $halfcardbase = Setting :: agentsetting_read('halfcard');
        if (is_numeric($member['mobile'])){
            $ifMobile = preg_match('#^13[\d]{9}$|^14[5,7]{1}\d{8}$|^15[^4]{1}\d{8}$|^17[0,6,7,8]{1}\d{8}$|^18[\d]{9}$#', $member['mobile'])? true : false;
        }
        if(!$ifMobile)wl_message(array('errno' => 2, 'message' => "未绑定手机号，去绑定？"));
        if($halfcardbase['status']){
            $orderno = Halfcard :: createHalfOrder($_GPC['radioValue'], $_GPC['price']);
            wl_message(array('errno' => 0, 'message' => $orderno));
        }else{
            wl_message(array('errno' => 1, 'message' => '功能已禁用,退出!'));
        }
    }
    public function openSuccess(){
        global $_W, $_GPC;
        $member = pdo_get('wlmerchant_halfcardmember', array('mid' => $_W['mid'], 'aid' => $_W['aid']));
        $member['expiretime'] = date('Y年m月d日', $member['expiretime']);
        include wl_template('halfcardhtml/open_success');
    }
    public function activation(){
        global $_W, $_GPC;
        $cardno = $_GPC['cardno'];
        $cardpa = $_GPC['cardpa'];
        $res = 1;
        if($res){
            $member = pdo_get('wlmerchant_halfcardmember', array('id' => $_W['mid']));
            wl_debug($member);
        }
    }
}
