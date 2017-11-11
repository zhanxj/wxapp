<?php
 class wlCommon{
    function uploadImage(){
        global $_W, $_GPC;
        $info = Util :: uploadImageInWeixin($_GPC['serverId']);
        die($info);
    }
    function wlPay(){
        global $_W, $_GPC;
        $pagetitle = !empty($_W['wlsetting']['base']['name'])? '支付订单 - ' . $_W['wlsetting']['base']['name'] : '支付订单';
        $orderType = $_GPC['orderType'];
        $orderId = $_GPC['orderId'];
        $payType = $_GPC['payType'];
        $done = $_GPC['done'];
        $toPay = $_GPC['toPay'];
        $member = Util :: getSingelData('mobile,credit2,uid', PDO_NAME . 'member', array('id' => $_W['mid']));
        $credits = Member :: credit_get_by_uid($member['uid']);
        $mobile = $member['mobile'];
        if($orderType == 'rush'){
            $order = Rush :: getSingleOrder($orderId, 'activityid,orderno,price');
            $active = Rush :: getSingleActive($order['activityid'], 'name');
            $name = $active['name'];
            $price = $order['price'];
            if(!$toPay)wlPay :: getCash($payType, $order['orderno'], $active['name'], $order['price'], 'RushOrder', 'Rush', $done);
        }
        if($orderType == 'halfCard'){
            $order = Util :: getSingelData('orderno,price', PDO_NAME . 'halfcard_record', array('id' => $orderId));
            $name = '五折卡充值';
            $price = $order['price'];
            if(!$toPay)wlPay :: getCash($payType, $order['orderno'], '五折卡充值', $order['price'], 'halfcard', 'Merchant', $done);
        }
        if($orderType == 'coupon'){
            $order = pdo_get('wlmerchant_order', array('id' => $orderId));
            $coupon = wlCoupon :: getSingleCoupons($order['fkid'], '*');
            $name = $coupon['title'];
            $price = $order['price'];
            $order['title'] = $coupon['title'];
            if(!$toPay)wlPay :: getCash($payType, $order['orderno'], $order['title'], $order['price'], 'Couponsharge', 'wlCoupon', $done);
        }
        if($orderType == 'vip'){
            $order = Util :: getSingelData('orderno,price', PDO_NAME . 'vip_record', array('id' => $orderId));
            $name = 'VIP充值';
            $price = $order['price'];
            if(!$toPay)wlPay :: getCash($payType, $order['orderno'], 'VIP充值', $order['price'], 'Vip', 'Merchant', $done);
        }
        if($toPay == 1){
            $payset = Setting :: wlsetting_read('payset');
            $status = unserialize($payset['status']);
            include wl_template('common/pay');
        }
    }
}
?>