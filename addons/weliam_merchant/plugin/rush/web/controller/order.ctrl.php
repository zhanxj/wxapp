<?php
defined('IN_IA') or exit('Access Denied');

class order{
    /**
     * 入口函数
     */
    
     function orderList(){
         global $_W, $_GPC;
         $pindex = max(1, intval($_GPC['page']));
         $psize = 10;
         $where = array('aid' => $_W['aid']);
         if($_GPC['activeid']) $where['activityid'] = $_GPC['activeid'];
         if(!empty($_GPC['status'])){
             $where['status'] = intval($_GPC['status']);
             }else{
             $where['#status'] = '(1,2,3,5,6,7)';
             }
         if (!empty($_GPC['keyword'])){
             if(!empty($_GPC['keywordtype'])){
                 switch($_GPC['keywordtype']){
                 case 1: $where['@id@'] = $_GPC['keyword'];
                    break;
                 case 2: $where['@orderno@'] = $_GPC['keyword'];
                    break;
                 case 3: $where['@activityid@'] = $_GPC['keyword'];
                    break;
                 case 4: $where['@sid@'] = $_GPC['keyword'];
                    break;
                 default:break;
                     }
                 }
             }
         $orders = Rush :: getNumOrder("*", $where, 'ID DESC', $pindex, $psize, 1);
         $pager = $orders[1];
         $orders = $orders[0];
         $status0 = pdo_fetchcolumn('SELECT COUNT(id) FROM ' . tablename(PDO_NAME . 'rush_order') . " WHERE uniacid={$_W['uniacid']} and status in (1,2,3,5,6,7) and aid={$_W['aid']}");
         $status1 = pdo_fetchcolumn('SELECT COUNT(id) FROM ' . tablename(PDO_NAME . 'rush_order') . " WHERE uniacid={$_W['uniacid']} and status = 1 and aid={$_W['aid']}");
         $status2 = pdo_fetchcolumn('SELECT COUNT(id) FROM ' . tablename(PDO_NAME . 'rush_order') . " WHERE uniacid={$_W['uniacid']} and status = 2 and aid={$_W['aid']}");
         $status3 = pdo_fetchcolumn('SELECT COUNT(id) FROM ' . tablename(PDO_NAME . 'rush_order') . " WHERE uniacid={$_W['uniacid']} and status = 3 and aid={$_W['aid']}");
         $status5 = pdo_fetchcolumn('SELECT COUNT(id) FROM ' . tablename(PDO_NAME . 'rush_order') . " WHERE uniacid={$_W['uniacid']} and status = 5 and aid={$_W['aid']}");
         $status6 = pdo_fetchcolumn('SELECT COUNT(id) FROM ' . tablename(PDO_NAME . 'rush_order') . " WHERE uniacid={$_W['uniacid']} and status = 6 and aid={$_W['aid']}");
         $status7 = pdo_fetchcolumn('SELECT COUNT(id) FROM ' . tablename(PDO_NAME . 'rush_order') . " WHERE uniacid={$_W['uniacid']} and status = 7 and aid={$_W['aid']}");
        
         include wl_template('order/order_list');
         }
    
     function deleteOrder(){
         global $_W, $_GPC;
         $id = $_GPC['id'];
         $ids = $_GPC['ids'];
         if($id){
             $res = Rush :: deleteOrder(array('id' => $id));
             if($res){
                 die(json_encode(array('errno' => 0, 'message' => $res, 'id' => $id)));
                 }else{
                 die(json_encode(array('errno' => 2, 'message' => $res, 'id' => $id)));
                 }
             }
         if($ids){
             foreach ($ids as $key => $id){
                 Rush :: deleteOrder(array('id' => $id));
                 }
             die(json_encode(array('errno' => 0, 'message' => '', 'id' => '')));
             }
         }
    
     function remark(){
         global $_W, $_GPC;
         $id = $_GPC['id'];
         $remark = $_GPC['remark'];
         $res = Rush :: updateOrder(array('adminremark' => $remark), array('id' => $id));
         if($res){
             die(json_encode(array('errno' => 0, 'message' => $res, 'id' => $id)));
             }else{
             die(json_encode(array('errno' => 2, 'message' => $res, 'id' => $id)));
             }
         }
    
     function confirmHexiao(){
         global $_W, $_GPC;
         $id = $_GPC['id'];
         $res = Rush :: updateOrder(array('status' => 2, 'verfmid' => -1, 'verftime' => time()), array('id' => $id));
         $item = Rush :: getSingleOrder($id, '*');
         if($res){
             pdo_insert(PDO_NAME . 'merchant_money_record', array('plugin' => 'rush', 'sid' => $item['sid'], 'uniacid' => $_W['uniacid'], 'money' => $item['price'], 'orderid' => $item['id'], 'createtime' => TIMESTAMP, 'type' => 2, 'detail' => '核销成功：' . $item['orderno']));
             SingleMerchant :: updateNoSettlementMoney($item['price'], $item['sid']); //更新可结算金额
             die(json_encode(array('errno' => 0, 'message' => '核销成功', 'id' => $id)));
             }else{
             die(json_encode(array('errno' => 2, 'message' => 'error', 'id' => $id)));
             }
         }
     function cancleHexiao(){
         global $_W, $_GPC;
         $id = $_GPC['id'];
         $res = Rush :: updateOrder(array('status' => 1, 'verfmid' => 0, 'verftime' => 0), array('id' => $id));
         $item = Rush :: getSingleOrder($id, '*');
         if($res){
             pdo_insert(PDO_NAME . 'merchant_money_record', array('plugin' => 'rush', 'sid' => $item['sid'], 'uniacid' => $_W['uniacid'], 'money' => 0 - $item['price'], 'orderid' => $item['id'], 'createtime' => TIMESTAMP, 'type' => 3, 'detail' => '取消核销成功：' . $item['orderno']));
             SingleMerchant :: updateNoSettlementMoney(0 - $item['price'], $item['sid']); //更新可结算金额
             die(json_encode(array('errno' => 0, 'message' => '取消成功', 'id' => $id)));
             }else{
             die(json_encode(array('errno' => 2, 'message' => 'error', 'id' => $id)));
             }
         }
     function refundOrder(){
         global $_W, $_GPC;
         $id = $_GPC['id'];
         $item = Rush :: getSingleOrder($id, '*');
         $res = wlPay :: refundMoney($id, $item['price'], '抢购订单退款', 'rush');
         if($res['status']){
             die(json_encode(array('errno' => 0, 'message' => $res['message'], 'id' => $id)));
             }else{
             die(json_encode(array('errno' => 2, 'message' => $res, 'id' => $id)));
             }
         }
    }
