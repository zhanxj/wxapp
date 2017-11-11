<?php
defined('IN_IA')or exit('Access Denied');
class Rush{
    static function saveGoodsHouse($goods, $param = array()){
        global $_W;
        if(!is_array($goods))return FALSE;
        $goods['uniacid'] = $_W['uniacid'];
        $goods['aid'] = $_W['aid'];
        $goods['sid'] = $_W['sid']?$_W['sid']:$goods['sid'];
        if(empty($param)){
            pdo_insert(PDO_NAME . 'goodshouse', $goods);
            return pdo_insertid();
        }
        return FALSE;
    }
    static function getSingleGoods($id, $select, $where = array()){
        $where['id'] = $id;
        $goodsInfo = Cache :: getDateByCacheFirst('goods', $id, array('Util', 'getSingelData'), array($select, PDO_NAME . 'goodshouse', $where));
        if(empty($goodsInfo))return array();
        return self :: initSingleGoods($goodsInfo);
    }
    static function getNumGoods($select, $where, $order, $pindex, $psize, $ifpage){
        $goodsInfo = Util :: getNumData($select, PDO_NAME . 'goodshouse', $where, $order, $pindex, $psize, $ifpage);
        foreach($goodsInfo[0] as $k => $v){
            $newGoodInfo[$k] = self :: initSingleGoods($v);
        }
        $newGoodInfo = $newGoodInfo?$newGoodInfo:array();
        return array($newGoodInfo, $goodsInfo[1], $goodsInfo[2])?array($newGoodInfo, $goodsInfo[1], $goodsInfo[2]):array();
    }
    static function getAllGoods($select, $where, $order, $pindex, $psize, $ifpage){
        $goodsInfo = Cache :: getDataByCacheFirst('goods', 'allGoods', array('Util', 'getNumData'), array($select, PDO_NAME . 'goodshouse', $where, $order, $pindex, $psize, $ifpage));
        foreach($goodsInfo[0] as $k => $v){
            $newGoodInfo[$k] = self :: initSingleGoods($v);
        }
        return array($newGoodInfo, $goodsInfo[1], $goodsInfo[2]);
    }
    static function updateGoods($params, $where){
        $res = pdo_update(PDO_NAME . 'goodshouse', $params, $where);
        if($where['id'])Cache :: deleteCache('goods', $where['id']);
        if($res){
            return 1;
        }else{
            return 0;
        }
    }
    static function initSingleGoods($goodsInfo){
        $goodsInfo['thumb'] = tomedia($goodsInfo['thumb']);
        $goodsInfo['plugin'] = 'rush';
        $goodsInfo['a'] = app_url('rush/home/detail', array('id' => $goodsInfo['id']));
        return $goodsInfo;
    }
    static function deleteGoods($where){
        $res = pdo_delete(PDO_NAME . 'goodshouse', $where);
        if($where['id'])Cache :: deleteCache('goods', $where['id']);
        if($res){
            return 1;
        }else{
            return 0;
        }
    }
    static function getNumMerchant($select, $where, $order, $pindex, $psize, $ifpage){
        $merchantInfo = Util :: getNumData($select, PDO_NAME . 'merchantdata', $where, $order, $pindex, $psize, $ifpage);
        return $merchantInfo;
    }
    static function getSingleMerchant($id, $select, $where = array()){
        $where['id'] = $id;
        return Util :: getSingelData($select, PDO_NAME . 'merchantdata', $where);
    }
    static function saveRushActive($active, $param = array()){
        global $_W;
        if(!is_array($active))return FALSE;
        $active['uniacid'] = $_W['uniacid'];
        $active['aid'] = $_W['aid'];
        $active['sid'] = $_W['sid']?$_W['sid']:$active['sid'];
        if(empty($param)){
            pdo_insert(PDO_NAME . 'rush_activity', $active);
            return pdo_insertid();
        }
        return FALSE;
    }
    static function getNumActive($select, $where, $order, $pindex, $psize, $ifpage){
        $activeInfo = Util :: getNumData($select, PDO_NAME . 'rush_activity', $where, $order, $pindex, $psize, $ifpage);
        return $activeInfo;
    }
    static function getSingleActive($id, $select, $where = array()){
        $where['id'] = $id;
        $goodsInfo = Util :: getSingelData($select, PDO_NAME . 'rush_activity', $where);
        if(empty($goodsInfo))return array();
        return self :: initSingleGoods($goodsInfo);
    }
    static function updateActive($params, $where){
        $res = pdo_update(PDO_NAME . 'rush_activity', $params, $where);
        if($where['id'])Cache :: deleteCache('active', $where['id']);
        if($res){
            return 1;
        }else{
            return 0;
        }
    }
    static function deleteActive($where){
        $res = pdo_delete(PDO_NAME . 'rush_activity', $where);
        if($where['id'])Cache :: deleteCache('active', $where['id']);
        if($res){
            return 1;
        }else{
            return 0;
        }
    }
    static function changeActivestatus($arr){
        if(empty($arr))return FALSE;
        if (is_numeric($arr)){
            $arr = self :: getSingleActive($arr, 'id,starttime,endtime,levelnum');
        }
        if (!is_array($arr) || empty($arr)){
            return false;
        }
        if($arr['starttime'] > time()){
            $goods['status'] = 1;
        }elseif($arr['starttime'] < time() && time() < $arr['endtime'] && $arr['levelnum'] > 0){
            $goods['status'] = 2;
        }elseif($arr['endtime'] < time() || $arr['levelnum'] < 1){
            $goods['status'] = 3;
        }
        self :: updateActive($goods, array('id' => $arr['id']));
    }
    static function createOrder($id){
        global $_W;
        $activity = self :: getSingleActive($id, '*');
        $random = Util :: createConcode(1);
        if($_W['wlmember']['vipstatus'] == 1 && !empty($activity['vipprice']))$activity['price'] = $activity['vipprice'];
        $data = array('uniacid' => $_W['uniacid'], 'unionid' => $_W['unionid'], 'mid' => $_W['mid'], 'openid' => $_W['openid'], 'sid' => $activity['sid'], 'aid' => $activity['aid'], 'activityid' => $activity['id'], 'orderno' => "Rush_" . createUniontid(), 'status' => 0, 'createtime' => TIMESTAMP, 'price' => $activity['price'], 'num' => 1, 'checkcode' => $random);
        pdo_insert(PDO_NAME . 'rush_order', $data);
        return pdo_insertid();
    }
    static function getSingleOrder($id, $select, $where = array()){
        $where['id'] = $id;
        $data = Util :: getSingelData($select, PDO_NAME . 'rush_order', $where);
        return self :: initSingleOrder($data);
    }
    static function getNumOrder($select, $where, $order, $pindex, $psize, $ifpage){
        $orderInfo = Util :: getNumData($select, PDO_NAME . 'rush_order', $where, $order, $pindex, $psize, $ifpage);
        $newOrderInfo = array();
        foreach($orderInfo[0] as $k => $v){
            $newOrderInfo[$k] = self :: initSingleOrder($v);
        }
        return array($newOrderInfo, $orderInfo[1], $orderInfo[2])?array($newOrderInfo, $orderInfo[1], $orderInfo[2]):array();
    }
    static function initSingleOrder($orderInfo){
        $active = self :: getSingleActive($orderInfo['activityid'], '*');
        $member = self :: getSingleMember($orderInfo['mid'], '*');
        $orderInfo['gimg'] = $active['thumb'];
        $orderInfo['unit'] = $active['unit'];
        $orderInfo['gname'] = $active['name'];
        $orderInfo['nickname'] = $member['nickname'];
        $orderInfo['headimg'] = $member['avatar'];
        $orderInfo['mobile'] = $member['mobile'];
        $merchant = SingleMerchant :: getSingleMerchant($orderInfo['sid'], "*");
        $orderInfo['merchantName'] = $merchant['storename'];
        $orderInfo['merchantId'] = $merchant['id'];
        $orderInfo['merchantLogo'] = tomedia($merchant['logo']);
        $orderInfo['plugin'] = 'rush';
        return $orderInfo;
    }
    static function updateOrder($params, $where){
        $res = pdo_update(PDO_NAME . 'rush_order', $params, $where);
        if($res){
            return 1;
        }else{
            return 0;
        }
    }
    static function deleteOrder($where){
        $res = pdo_delete(PDO_NAME . 'rush_order', $where);
        if($res){
            return 1;
        }else{
            return 0;
        }
    }
    static function getSingleMember($id, $select, $where = array()){
        $where['id'] = $id;
        return Util :: getSingelData($select, PDO_NAME . 'member', $where);
    }
    static function payRushOrderNotify($params){
        Util :: wl_log('payResult_notify', PATH_PLUGIN . "rush/data/", $params);
        $order_out = pdo_fetch("select * from" . tablename(PDO_NAME . 'rush_order') . "where orderno='{$params['tid']}'");
        $activeInfo = self :: getSingleActive($order_out['activityid'], '*');
        $ifSuccess = TRUE;
        $data = self :: getRushOrderPayData($params, $order_out, $activeInfo);
        if($activeInfo['levelnum'] < 1 || $order_out['status'] != '0'){
            $data['status'] = 6;
            $ifSuccess = FALSE;
        }
        if($ifSuccess){
            $data2['levelnum'] = $activeInfo['levelnum'] - 1;
            if($data2['levelnum'] <= 0)$data2['status'] = 3;
            self :: updateActive($data2, array('id' => $order_out['activityid']));
        }
        $url = app_url('rush/home/myOrder');
        Message :: paySuccess($order_out['openid'], $order_out['price'], $activeInfo['name'], $url);
        Message :: rushSuccess($order_out['openid'], $order_out['id'], $url);
        pdo_update(PDO_NAME . 'rush_order', $data, array('orderno' => $params['tid']));
    }
    static function payRushOrderReturn($params, $backurl = false){
        Util :: wl_log('payResult_return', PATH_PLUGIN . "rush/data/", $params);
        $order_out = pdo_get(PDO_NAME . 'rush_order', array('orderno' => $params['tid']), array('id'));
        if($backurl){
            return app_url('rush/home/paySuccess', array('orderid' => $order_out['id']));
        }else{
            header('location:' . app_url('rush/home/paySuccess', array('orderid' => $order_out['id'])));
        }
    }
    static function getRushOrderPayData($params, $order_out, $goodsInfo){
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
        $data['actualprice'] = $fee;
        $data['createtime'] = TIMESTAMP;
        SingleMerchant :: updateAmount($fee, $order_out['sid'], $order_out['id'], 1, '订单支付成功');
        return $data;
    }
}
