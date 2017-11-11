<?php
defined('IN_IA') or exit('Access Denied');

class userorder{
    
     public function orderlist(){
         global $_W, $_GPC;
         $pagetitle = !empty($_W['wlsetting']['base']['name']) ? '我的订单 - ' . $_W['wlsetting']['base']['name'] : '我的订单';
         $status = $_GPC['status'];
         if($_W['ispost']){
             $where = " uniacid = {$_W['uniacid']} and mid = {$_W['mid']} ";
             if($status != 'all'){
                 $where .= "and status = {intval($status)}";
                 }
             $myorder = pdo_fetchall('SELECT id,createtime,sid,status,price,"a" FROM ' . tablename(PDO_NAME . "order") . " where {$where} " . ' UNION ALL SELECT id,createtime,sid,status,price,"b" FROM ' . tablename(PDO_NAME . "rush_order") . " where {$where} ");
             krsort($myorder);
             foreach ($myorder as $k => & $v){
                 if($v['a'] == 'a'){
                     $ndorder = pdo_get(PDO_NAME . 'order', array('id' => $v['id'], 'uniacid' => $_W['uniacid']), 'plugin,fkid,orderno');
                     if($ndorder['plugin'] == 'coupon'){
                         $goods = wlCoupon :: getSingleCoupons($ndorder['fkid'], 'title,logo,id');
                         $v['goodsname'] = $goods['title'];
                         $v['goodsimg'] = tomedia($goods['logo']);
                         $coupon = pdo_get(PDO_NAME . 'member_coupons', array('uniacid' => $_W['uniacid'], 'orderno' => $ndorder['orderno']), array('id', 'usetimes', 'endtime'));
                         $this -> checkcoupon($coupon, $ndorder);
                         $v['xiaofei'] = app_url('wlcoupon/coupon_app/couponDetail', array('id' => $coupon['id']));
                         }
                     $v['comment'] = app_url('order/comment/add', array('orderid' => $v['id']));
                     }
                 if($v['a'] == 'b'){
                     $v['activityid'] = pdo_getcolumn(PDO_NAME . 'rush_order', array('id' => $v['id'], 'uniacid' => $_W['uniacid']), 'activityid');
                     $goods = Rush :: getSingleActive($v['activityid'], 'name,thumb,id');
                     $v['goodsname'] = $goods['name'];
                     $v['goodsimg'] = tomedia($goods['thumb']);
                     $v['xiaofei'] = app_url('rush/home/paySuccess', array('orderid' => $v['id']));
                     $v['comment'] = app_url('order/comment/add', array('orderid' => $v['id'], 'plugin' => 'rush'));
                     $v['url'] = app_url('rush/home/detail', array('id' => $goods['id']));
                     }
                 $v['storename'] = pdo_getcolumn(PDO_NAME . 'merchantdata', array('id' => $v['sid'], 'uniacid' => $_W['uniacid']), 'storename');
                 $v['createtime'] = date('Y-m-d H:i', $v['createtime']);
                 }
             $myorder = array_values($myorder);
             die(json_encode(array('errno' => 0, 'data' => $myorder)));
             }
         include wl_template('order/orderlist');
         }
    
     public function orderdetail(){
         global $_W, $_GPC;
        
         include wl_template('order/orderdetail');
         }
    
     public function checkcoupon($coupon, $ndorder){
         global $_W, $_GPC;
         if(empty($coupon) || empty($ndorder)) return FALSE;
         if($coupon['usetimes'] < 1 || $coupon['endtime'] < time()){
             pdo_update(PDO_NAME . 'order', array('status' => 2), array('orderno' => $ndorder['orderno']));
             }
         }
    }
