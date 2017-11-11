<?php
defined('IN_IA')or exit('Access Denied');
class wlCoupon{
    static function saveCoupons($coupon, $param = array()){
        global $_W;
        if(!is_array($coupon))return FALSE;
        $coupon['uniacid'] = $_W['uniacid'];
        $coupon['aid'] = $_W['aid'];
        if(empty($param)){
            pdo_insert(PDO_NAME . 'couponlist', $coupon);
            return pdo_insertid();
        }
        return FALSE;
    }
    static function updateCoupons($params, $where){
        $res = pdo_update(PDO_NAME . 'couponlist', $params, $where);
        if($res){
            return 1;
        }else{
            return 0;
        }
    }
    static function deleteCoupons($where){
        $res = pdo_delete(PDO_NAME . 'couponlist', $where);
        if($res){
            return 1;
        }else{
            return 0;
        }
    }
    static function deleteCoupon($where){
        $res = pdo_delete(PDO_NAME . 'member_coupons', $where);
        if($res){
            return 1;
        }else{
            return 0;
        }
    }
    static function getNumCoupons($select, $where, $order, $pindex, $psize, $ifpage){
        $goodsInfo = Util :: getNumData($select, PDO_NAME . 'couponlist', $where, $order, $pindex, $psize, $ifpage);
        return $goodsInfo;
    }
    static function getSingleCoupons($id, $select, $where = array()){
        $where['id'] = $id;
        return Util :: getSingelData($select, PDO_NAME . 'couponlist', $where);
    }
    static function saveMemberCoupons($coupon, $param = array()){
        global $_W;
        if(!is_array($coupon))return FALSE;
        $coupon['uniacid'] = $_W['uniacid'];
        if(empty($param)){
            pdo_insert(PDO_NAME . 'member_coupons', $coupon);
            return pdo_insertid();
        }
        return FALSE;
    }
    static function getCouponNum($parentid, $type){
        global $_W;
        $mid = $_W['mid'];
        if($type == 1){
            $num = pdo_fetchcolumn('SELECT count(id) FROM ' . tablename('wlmerchant_member_coupons') . " WHERE mid = '{$mid}' AND parentid = {$parentid} AND status in (1,2)");
        }else{
            $allorder = pdo_getall('wlmerchant_order', array('mid' => $_W['mid'], 'aid' => $_W['aid'], 'fkid' => $parentid, 'status' => 1, 'plugin' => 'coupon'), array('num'));
            $num = 0;
            foreach ($allorder as $key => $v){
                $num = $num + $v['num'];
            }
        }
        return $num;
    }
    static function getNumCoupon($select, $where, $order, $pindex, $psize, $ifpage){
        $orderInfo = Util :: getNumData($select, PDO_NAME . 'member_coupons', $where, $order, $pindex, $psize, $ifpage);
        return $orderInfo;
    }
    static function getSingleCoupon($id, $select, $where = array()){
        $where['id'] = $id;
        return Util :: getSingelData($select, PDO_NAME . 'member_coupons', $where);
    }
    static function updateCoupon($params, $where){
        $res = pdo_update(PDO_NAME . 'member_coupons', $params, $where);
        if($res){
            return 1;
        }else{
            return 0;
        }
    }
    static function saveCouponOrder($data, $param = array()){
        global $_W;
        if(!is_array($data))return FALSE;
        if(empty($param)){
            pdo_insert(PDO_NAME . 'order', $data);
            return pdo_insertid();
        }
        return FALSE;
    }
    static function getNumCouponOrder($select, $where, $order, $pindex, $psize, $ifpage){
        $goodsInfo = Util :: getNumData($select, PDO_NAME . 'order', $where, $order, $pindex, $psize, $ifpage);
        return $goodsInfo;
    }
    static function getNumstore($select, $where, $order, $pindex, $psize, $ifpage){
        $goodsInfo = Util :: getNumData($select, PDO_NAME . 'merchantdata', $where, $order, $pindex, $psize, $ifpage);
        return $goodsInfo;
    }
    static function getstores($locations, $lng, $lat){
        global $_W;
        if (empty($lat) || empty($lng))return false;
        foreach ($locations as $key => $val){
            $loca = unserialize($val['location']);
            $locations[$key]['distance'] = Store :: getdistance($loca['lng'], $loca['lat'], $lng, $lat);
        }
        for($i = 0;$i < count($locations)-1;$i++){
            for($j = 0;$j < count($locations)-1 - $i;$j++){
                if($locations[$j]['distance'] > $locations[$j + 1]['distance']){
                    $temp = $locations[$j + 1];
                    $locations[$j + 1] = $locations[$j];
                    $locations[$j] = $temp;
                }
            }
        }
        foreach ($locations as $key => $value){
            if($value['distance'] > 1000){
                $locations[$key]['distance'] = (floor(($value['distance'] / 1000) * 10) / 10) . "km";
            }else{
                $locations[$key]['distance'] = round($value['distance']) . "m";
            }
        }
        return $locations;
    }
    static function payCouponshargeNotify($params){
        Util :: wl_log('payResult_notify', PATH_PLUGIN . "wlcoupon/data/", $params);
        $order = pdo_get('wlmerchant_order', array('orderno' => $params['tid']), array('id', 'mid', 'num', 'price', 'orderno', 'fkid', 'aid'));
        $data1 = self :: getCouponshargePayData($params, $order);
        pdo_update(PDO_NAME . 'order', $data1, array('id' => $order['id']));
        $coupons = pdo_get('wlmerchant_couponlist', array('id' => $order['fkid']));
        if($coupons['time_type'] == 1){
            $starttime = $coupons['starttime'];
            $endtime = $coupons['endtime'];
        }else{
            $starttime = time();
            $endtime = time() + ($coupons['deadline'] * 24 * 3600);
        }
        $data = array('mid' => $order['mid'], 'aid' => $order['aid'], 'parentid' => $coupons['id'], 'status' => 1, 'type' => $coupons['type'], 'title' => $coupons['title'], 'sub_title' => $coupons['sub_title'], 'content' => $coupons['goodsdetail'], 'description' => $coupons['description'], 'color' => $coupons['color'], 'starttime' => $starttime, 'endtime' => $endtime, 'createtime' => time(), 'orderno' => $params['tid'], 'price' => $order['price'] / $order['num'], 'usetimes' => $coupons['usetimes'] * $order['num'], 'concode' => Util :: createConcode(4));
        $res = self :: saveMemberCoupons($data);
        $newsurplus = $coupons['surplus'] + $order['num'];
        self :: updateCoupons(array('surplus' => $newsurplus), array('id' => $coupons['id']));
    }
    static function getCouponshargePayData($params, $order_out){
        $data = array('status' => $params['result'] == 'success' ? 1 : 0);
        if($params['is_usecard'] == 1){
            $fee = $params['card_fee'];
            $data['is_usecard'] = 1;
        }else{
            $fee = $params['fee'];
        }
        $paytype = array('credit' => 1, 'wechat' => 2, 'alipay' => 3, 'delivery' => 4);
        $data['paytype'] = $paytype[$params['type']];
        if ($params['type'] == 'wechat')$data['transid'] = $params['tag']['transaction_id'];
        $data['paytime'] = TIMESTAMP;
        $data['price'] = $fee;
        return $data;
    }
    static function payCouponshargeReturn($params){
        $res = $params['result'] == 'success' ? 1 : 0;
        if($res){
            wl_message('购买成功', app_url('wlcoupon/coupon_app/couponList'), 'success');
        }else{
            wl_message('您已获得优惠券', app_url('wlcoupon/coupon_app/couponList'), 'error');
        }
    }
}
?>