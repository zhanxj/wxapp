<?php
defined('IN_IA')or exit('Access Denied');
class home{
    function index(){
        global $_W, $_GPC;
        $pagetitle = !empty($_W['wlsetting']['base']['name'])? '抢购列表 - ' . $_W['wlsetting']['base']['name'] : '抢购列表';
        $status = !empty($_GPC['status'])? $_GPC['status'] : 2;
        $config = Setting :: agentsetting_read('rush');
        $_W['wlsetting']['share']['share_title'] = !empty($config['share_title'])? $config['share_title'] : $_W['wlsetting']['share']['share_title'];
        $_W['wlsetting']['share']['share_desc'] = !empty($config['share_desc'])? $config['share_desc'] : $_W['wlsetting']['share']['share_desc'];
        $_W['wlsetting']['share']['share_image'] = !empty($config['share_image'])? $config['share_image'] : $_W['wlsetting']['share']['share_image'];
        include wl_template('home/goods_list');
    }
    function getGoods(){
        global $_W, $_GPC;
        $where = array('aid' => $_W['aid']);
        $pindex = $_GPC['pindex'];
        $psize = $_GPC['psize'];
        $where['status'] = intval($_GPC['status']);
        $active = Rush :: getNumActive('*', $where, 'id DESC', $pindex, $psize, 1);
        foreach($active[0] as $key => & $v){
            Rush :: changeActivestatus($v);
            $v['thumb'] = tomedia($v['thumb']);
            if($v['status'] == 2){
                $v['sytime'] = $v['endtime'] - time();
                $v['a'] = app_url('rush/home/detail', array('id' => $v['id']));
            }else{
                $v['sytime'] = 0;
                $v['a'] = "#";
                $v['starttime'] = date('Y-m-d H:i:s', $v['starttime']);
            }
            $folllow = pdo_getcolumn(PDO_NAME . 'rush_follows', array('mid' => $_W['mid'], 'actid' => $v['id']), 'id');
            if($folllow){
                $v['follow'] = '已关注';
            }else{
                $v['follow'] = '关注抢购';
            }
        }
        die(json_encode($active[0]));
    }
    function follow(){
        global $_W, $_GPC;
        $id = intval($_GPC['qgid']);
        if($id){
            $config = Setting :: agentsetting_read('rush');
            if($config['follow_time']){
                $sendtime = 60 * $config['follow_time'];
            }else{
                $sendtime = 600;
            }
            $goods = Rush :: getSingleActive($id, "*");
            $lasttime = time() + $sendtime;
            if($goods['starttime'] < $lasttime){
                die(json_encode(array("result" => 2, "msg" => '无需关注，活动即将开始')));
            }
            $folllow = pdo_getcolumn(PDO_NAME . 'rush_follows', array('mid' => $_W['mid'], 'actid' => $id), 'id');
            if($folllow){
                die(json_encode(array("result" => 2, "msg" => '小淘气，不要重复关注哦')));
            }
            pdo_insert(PDO_NAME . 'rush_follows', array('uniacid' => $_W['uniacid'], 'mid' => $_W['mid'], 'aid' => $_W['aid'], 'actid' => $id, 'sendtime' => $goods['starttime'] - $sendtime));
            die(json_encode(array('result' => 1, 'msg' => '抢购关注成功！')));
        }
        die(json_encode(array('result' => 2, 'msg' => '参数错误，请刷新重试！')));
    }
    function detail(){
        global $_W, $_GPC;
        $pagetitle = !empty($_W['wlsetting']['base']['name'])? '抢购详情 - ' . $_W['wlsetting']['base']['name'] : '抢购详情';
        $id = $_GPC['id'];
        if(empty($id)){
            wl_message('缺少重要参数');
        }
        $goods = Rush :: getSingleActive($id, "*");
        Rush :: changeActivestatus($goods);
        $merchant = Store :: getSingleStore($goods['sid']);
        $merchant['storehours'] = unserialize($merchant['storehours']);
        $merchant['provinceid'] = Util :: idSwitch('areaid', 'areaName', $merchant['provinceid']);
        $merchant['areaid'] = Util :: idSwitch('areaid', 'areaName', $merchant['areaid']);
        $merchant['distid'] = Util :: idSwitch('areaid', 'areaName', $merchant['distid']);
        $where['activityid'] = $id;
        $where['#status#'] = "(1,2)";
        $orders = Rush :: getNumOrder("*", $where, 'paytime DESC', 0, 0, 1);
        $goods['buynum'] = $orders[2];
        $orders = $orders[0];
        foreach($orders as $k => & $v){
            $user = Rush :: getSingleMember($v['mid'], 'avatar,nickname');
            $v['userimg'] = tomedia($user['avatar']);
            $v['username'] = mb_substr($user['nickname'], 0, 1, 'utf-8') . '***' . mb_substr($user['nickname'], -1, 1, 'utf-8');
            $v['paytime'] = date('Y-m-d H:i:s', $v['paytime']);
        }
        $_W['wlsetting']['share']['share_title'] = !empty($goods['share_title'])? $goods['share_title'] : $goods['name'];
        $_W['wlsetting']['share']['share_desc'] = !empty($goods['share_desc'])? $goods['share_desc'] : $goods['describe'];
        $_W['wlsetting']['share']['share_image'] = !empty($goods['share_image'])? $goods['share_image'] : $goods['thumb'];
        include wl_template('home/goods_detail');
    }
    function orderConfirm(){
        global $_W, $_GPC;
        $pagetitle = !empty($_W['wlsetting']['base']['name'])? '订单支付 - ' . $_W['wlsetting']['base']['name'] : '订单支付';
        $id = $_GPC['id'];
        if(empty($id)){
            wl_message('缺少重要参数');
        }
        $member = Util :: getSingelData('mobile,credit2,uid', PDO_NAME . 'member', array('id' => $_W['mid']));
        $r = mc_fetch($member['uid'], array('credit1', 'credit2'));
        $activity = Rush :: getSingleActive($id, '*');
        $config = Setting :: agentsetting_read('rush');
        $paySet = $_W['wlsetting']['payset'];
        $paySetStatus = unserialize($paySet['status']);
        if($_W['isajax']){
            if($activity['levelnum'] < 1)wl_message(array('errno' => 1, 'message' => "您来晚一步,最后的机会已经被抢走。"));
            if (is_numeric($member['mobile'])){
                $ifMobile = preg_match('#^13[\d]{9}$|^14[5,7]{1}\d{8}$|^15[^4]{1}\d{8}$|^17[0,6,7,8]{1}\d{8}$|^18[\d]{9}$#', $member['mobile'])? true : false;
            }
            if(!$ifMobile)wl_message(array('errno' => 2, 'message' => "未绑定手机号，去绑定？"));
            $alreadyBuy = Util :: getNumData("id", PDO_NAME . 'rush_order', array('mid' => $_W['mid'], '#status#' => '(1,2,6,7)', 'activityid' => $id), 'id desc', 0, 0, 1);
            $alreadyBuyNum = $alreadyBuy[2];
            if($alreadyBuyNum >= $activity['op_one_limit'] && $activity['op_one_limit'] > 0)wl_message(array('errno' => 3, 'message' => "超过抢购数量!"));
            wl_message(array('errno' => 0, 'message' => '抢购成功'));
        }else{
            include wl_template('home/catch_success');
        }
    }
    function paySuccess(){
        global $_W, $_GPC;
        $pagetitle = !empty($_W['wlsetting']['base']['name'])? '订单详情 - ' . $_W['wlsetting']['base']['name'] : '订单详情';
        $id = $_GPC['orderid'];
        if(empty($id)){
            wl_message('缺少重要参数');
        }
        $url = app_url('rush/home/hexiao', array('id' => $id));
        $order_out = pdo_get(PDO_NAME . 'rush_order', array('id' => $id), array('status'));
        if($order_out['status'] == 6 || $order_out['status'] == 7){
            include wl_template('home/buyFail');
            exit;
        }elseif($order_out['status'] == 1){
            include wl_template('home/buysuccess');
            exit;
        }
    }
    function getGoodsDetail(){
        global $_W, $_GPC;
        $id = $_GPC['id'];
        if(empty($id)){
            wl_message('缺少重要参数');
        }
        $goods = Rush :: getSingleActive($id, '*');
        $goods['thumbs'] = unserialize($goods['thumbs']);
        $goods['tag'] = unserialize($goods['tag']);
        foreach($goods['thumbs'] as $k => & $v){
            $v = tomedia($v);
        }
        foreach($goods['tag'] as $k => & $v){
            $v['data_img'] = tomedia($v['data_img']);
        }
        $where['activityid'] = $id;
        $where['#status#'] = "(1,2)";
        $orders = Rush :: getNumOrder("*", $where, 'paytime DESC', 0, 0, 1);
        $goods['buynum'] = $orders[2];
        $orders = $orders[0];
        foreach($orders as $k => & $v){
            $user = Rush :: getSingleMember($v['mid'], '*');
            $v['userimg'] = tomedia($user['avatar']);
            $v['username'] = mb_substr($user['nickname'], 0, 1, 'utf-8') . '***' . mb_substr($user['nickname'], -1, 1, 'utf-8');
            $v['paytime'] = date('Y-m-d H:i:s', $v['paytime']);
        }
        die(json_encode(array('errno' => 0, 'data' => $goods, 'order' => $orders)));
    }
    function getOrderDetail(){
        global $_W, $_GPC;
        $id = $_GPC['id'];
        if(empty($id)){
            wl_message('缺少重要参数');
        }
        $order = Rush :: getSingleOrder($id, '*');
        $goods = Rush :: getSingleActive($order['activityid'], '*');
        $order['storename'] = Util :: idSwitch('sid', 'sName', $goods['sid']);
        $order['goodsname'] = $goods['name'];
        $order['describe'] = $goods['describe'];
        $order['goodsimg'] = tomedia($goods['thumb']);
        $order['cutofftime'] = date('Y-m-d', $goods['cutofftime']);
        $order['sa'] = app_url('store/merchant/detail', array('id' => $goods['sid']));
        die(json_encode(array('errno' => 0, 'data' => $order, 'img' => '$img')));
    }
    function qrcodeimg(){
        global $_W, $_GPC;
        $url = $_GPC['url'];
        m('qrcode/QRcode') -> png($url, false, QR_ECLEVEL_H, 4);
    }
    function hexiao(){
        global $_W, $_GPC;
        $pagetitle = !empty($_W['wlsetting']['base']['name'])? '订单核销 - ' . $_W['wlsetting']['base']['name'] : '订单核销';
        $id = $_GPC['id'];
        $order = Rush :: getSingleOrder($id, 'sid,status');
        $verifier = SingleMerchant :: verifier($order['sid'], $_W['mid']);
        include wl_template('home/storehexiao');
    }
    function xiaofei(){
        global $_W, $_GPC;
        $params['status'] = 2;
        $params['verfmid'] = $_W['mid'];
        $params['verftime'] = time();
        $where['id'] = $_GPC['id'];
        $res = Rush :: updateOrder($params, $where);
        if($res){
            die(json_encode(array('errno' => 0, 'data' => '核销成功')));
        }else{
            die(json_encode(array('errno' => 1, 'data' => '核销失败')));
        }
    }
    function suremima(){
        global $_W, $_GPC;
        if($_GPC['mima'] == $pwd){
            $params['status'] = 2;
            $params['verfmid'] = $_W['mid'];
            $params['verftime'] = time();
            $where['id'] = $_GPC['id'];
            $res = Rush :: updateOrder($params, $where);
            if($res){
                die(json_encode(array('errno' => 0, 'data' => '核销成功')));
            }else{
                die(json_encode(array('errno' => 1, 'data' => '核销失败')));
            }
        }else{
            die(json_encode(array('errno' => 2, 'data' => '密码错误')));
        }
    }
    function myOrder(){
        global $_W, $_GPC;
        $pagetitle = !empty($_W['wlsetting']['base']['name'])? '我的抢购 - ' . $_W['wlsetting']['base']['name'] : '我的抢购';
        $status = !empty($_GPC['status'])? $_GPC['status'] : 1;
        include wl_template('home/my_order');
    }
    function getOrder(){
        global $_W, $_GPC;
        $where['mid'] = $_W['mid'];
        if(!empty($_GPC['status'])){
            $where['status'] = intval($_GPC['status']);
        }
        $pindex = $_GPC['pindex'];
        $myorder = Rush :: getNumOrder('*', $where, 'ID DESC', $pindex, 10, 1);
        $myorder = $myorder[0];
        foreach ($myorder as $k => & $v){
            $goods = Rush :: getSingleActive($v['activityid'], 'sid,name,thumb,id');
            $v['storename'] = Util :: idSwitch('sid', 'sName', $goods['sid']);
            $v['goodsname'] = $goods['name'];
            $v['goodsimg'] = tomedia($goods['thumb']);
            $v['xiaofei'] = app_url('rush/home/paySuccess', array('orderid' => $v['id']));
            $v['comment'] = app_url('order/comment/add', array('orderid' => $v['id']));
            $v['a'] = app_url('rush/home/detail', array('id' => $goods['id']));
            $v['createtime'] = date('Y-m-d H:i:s', $v['createtime']);
        }
        die(json_encode(array('errno' => 0, 'data' => $myorder)));
    }
}
