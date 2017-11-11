<?php
defined('IN_IA') or exit('Access Denied');

class coupon_app{
     function getCoupon(){
         global $_W, $_GPC;
         $couponid = $_GPC['id'];
         $coupons = wlCoupon :: getSingleCoupons($couponid, '*');
         $num = wlCoupon :: getCouponNum($couponid, 1);
         if($coupons['time_type'] == 1 && $coupons['endtime'] < time()){
            wl_message('抱歉，优惠券已停止发放', app_url('wlcoupon/coupon_app/couponList'), 'error');
        }
         if($coupons['status'] == 0){
            wl_message('抱歉，优惠券已被禁用', app_url('wlcoupon/coupon_app/couponList'), 'error');
        }
         if($coupons['status'] == 3){
            wl_message('抱歉，优惠券已经失效', app_url('wlcoupon/coupon_app/couponList'), 'error');
        }
         if($coupons['surplus'] > ($coupons['quantity'] - 1)){
            wl_message('抱歉，优惠券已经被领光了', app_url('wlcoupon/coupon_app/couponList'), 'error');
        }
         if($num){
             if(($num > $coupons['get_limit'] || $num == $coupons['get_limit']) && $coupons['get_limit'] > 0){
                 wl_message('抱歉，一个用户只能领取' . $coupons['get_limit'] . '张。', app_url('wlcoupon/coupon_app/couponList'), 'error');
                 }
             }
         $newsurplus = $coupons['surplus'] + 1;
         wlCoupon :: updateCoupons(array('surplus' => $newsurplus), array('id' => $couponid));
         if($coupons['time_type'] == 1){
             $starttime = $coupons['starttime'];
             $endtime = $coupons['endtime'];
             }else{
             $starttime = time();
             $endtime = time() + ($coupons['deadline'] * 24 * 3600);
             }
         $data = array(
            'mid' => $_W['mid'],
             'parentid' => $coupons['id'],
             'status' => 1,
             'type' => $coupons['type'],
             'title' => $coupons['title'],
             'sub_title' => $coupons['sub_title'],
             'content' => $coupons['goodsdetail'],
             'description' => $coupons['description'],
             'color' => $coupons['color'],
             'starttime' => $starttime,
             'endtime' => $endtime,
             'createtime' => time(),
             'usetimes' => $coupons['usetimes'],
             'concode' => Util :: createConcode(4)
            );
         $res = wlCoupon :: saveMemberCoupons($data);
         if($res){
             wl_message('恭喜你获得一张优惠券', app_url('wlcoupon/coupon_app/couponList'), 'success');
             }else{
             wl_message('获取优惠券失败', app_url('wlcoupon/coupon_app/couponList'), 'error');
             }
         }
    
     function createCouponorder(){
         global $_W, $_GPC;
         $couponid = $_GPC['id'];
         $coupons = wlCoupon :: getSingleCoupons($couponid, '*');
         $member = Util :: getSingelData('mobile,credit2,uid,vipstatus', PDO_NAME . 'member', array('id' => $_W['mid']));
         if (is_numeric($member['mobile'])){
             $ifMobile = preg_match('#^13[\d]{9}$|^14[5,7]{1}\d{8}$|^15[^4]{1}\d{8}$|^17[0,6,7,8]{1}\d{8}$|^18[\d]{9}$#', $member['mobile']) ? true : false;
             }
         if(!$ifMobile)wl_message(array('errno' => 2, 'message' => "未绑定手机号，去绑定？"));
         $num = wlCoupon :: getCouponNum($couponid, 2);
         $couponnum = $_GPC['num'];
         $allnum = $num + $couponnum;
         if($coupons['time_type'] == 1 && $coupons['endtime'] < time()){
            wl_message(array('errno' => 1, 'message' => '抱歉，优惠券已停止发放'));
        }
         if(($coupons['quantity'] - $coupons['surplus']) < $couponnum){
            wl_message(array('errno' => 1, 'message' => '抱歉，优惠券库存不足'));
        }
         if($allnum > $coupons['get_limit'] && $coupons['get_limit'] > 0){
             wl_message(array('errno' => 1, 'message' => '抱歉，一个用户只能购买' . $coupons['get_limit'] . '张,您已购买' . $num . '张。'));
             }
         if($coupons['vipstatus'] == 2 && $member['vipstatus'] == 1){
             $coupons['price'] = $coupons['vipprice'];
             }
         $data = array(
            'uniacid' => $_W['uniacid'],
             'mid' => $_W['mid'],
             'aid' => $_W['aid'],
             'fkid' => $couponid,
             'sid' => $coupons['merchantid'],
             'status' => 0,
             'paytype' => 2,
             'createtime' => time(),
             'orderno' => date('Ymd') . substr(time(), -5) . substr(microtime(), 2, 5) . sprintf('%02d', rand(0, 99)),
             'price' => $coupons['price'] * $couponnum,
             'num' => $couponnum,
             'plugin' => 'coupon',
             'payfor' => 'couponsharge',
            );
         $res = wlCoupon :: saveCouponOrder($data);
         if($res){
             wl_message(array('errno' => 0, 'message' => $res));
             }else{
             wl_message(array('errno' => 1, 'message' => '未知错误，请重试。'));
             }
         }
    
    
     function couponList(){
         global $_W, $_GPC;
         $pagetitle = !empty($_W['wlsetting']['base']['name']) ? '我的卡券 - ' . $_W['wlsetting']['base']['name'] : '我的卡券';
         $status = $_GPC['status'];
         if($status == ''){
             $status = 1;
             }
         include wl_template('couponhtml/couponlist');
         }
     function couponDetail(){
         global $_W, $_GPC;
         $pagetitle = !empty($_W['wlsetting']['base']['name']) ? '卡券详情 - ' . $_W['wlsetting']['base']['name'] : '卡券详情';
         $id = $_GPC['id'];
         include wl_template('couponhtml/coupondetail');
         }
    
     function getcoupons(){
         global $_W, $_GPC;
         if($_GPC['status']){
             $status = $_GPC['status'];
             }else{
             $status = 1;
             }
         $where['mid'] = $_W['mid'];
         if($status == 1){
             $where['usetimes>'] = 1;
             $where['endtime>'] = time();
             }elseif ($status == 2){
             $where['usetimes'] = 0;
             }else{
             $where['usetimes>'] = 1;
             $where['endtime<'] = time();
             }
         $couponlist = wlCoupon :: getNumCoupon('*', $where, 'ID DESC', 0, 0, 0);
         $couponlist = $couponlist[0];
         foreach ($couponlist as $key => & $v){
             if($v['type'] == 1){
                 $v['type'] = '折扣券';
                 }else if($v['type'] == 2){
                 $v['type'] = '代金券';
                 }else if($v['type'] == 3){
                 $v['type'] = '套餐券';
                 }else if($v['type'] == 4){
                 $v['type'] = '团购券';
                 }else if($v['type'] == 5){
                 $v['type'] = '其他券';
                 }
             $v['starttime'] = date('Y-m-d', $v['starttime']);
             $v['endtime'] = date('y-m-d H:i:s', $v['endtime']);
             $parent = pdo_get('wlmerchant_couponlist', array('id' => $v['parentid']), array('logo', 'merchantid'));
             $store = pdo_get('wlmerchant_merchantdata', array('id' => $parent['merchantid']), array('storename'));
             $v['storename'] = $store['storename'];
            // $v['usedtime'] = date('Y-m-d H:i:s',$v['usedtime']);
            $v['logo'] = tomedia($parent['logo']);
             $v['description'] = unserialize($v['description']);
             }
         die(json_encode(array('errno' => 0, 'data' => $couponlist)));
         }
    
     function getcoupondetail(){
         global $_W, $_GPC;
         $id = $_GPC['id'];
         $res = wlCoupon :: getSingleCoupon($id, '*');
         $res['timess'] = $res['endtime'];
         $res['starttime'] = date('Y-m-d H:i:s', $res['starttime']);
         $res['endtime'] = date('Y-m-d H:i:s', $res['endtime']);
         if($res['usedtime']){
             $res['usedtime'] = unserialize($res['usedtime']);
             foreach ($res['usedtime'] as $key => & $v){
                 $v = date('Y-m-d H:i:s', $v);
                 }
             }
         $parent = wlCoupon :: getSingleCoupons($res['parentid'], 'merchantid,logo');
         $store = pdo_get('wlmerchant_merchantdata', array('id' => $parent['merchantid']));
         $res['couponlogo'] = tomedia($parent['logo']);
         $res['storename'] = $store['storename'];
         $res['storelogo'] = tomedia($store['logo']);
         $url = app_url('wlcoupon/coupon_app/hexiaocoupon', array('id' => $id));
         $res['qrimgurl'] = app_url('wlcoupon/coupon_app/qrcodeimg', array('url' => $url));
         $res['description'] = unserialize($res['description']);
         die(json_encode(array('errno' => 0, 'data' => $res)));
         }
    
     function couponslist(){
         global $_W, $_GPC;
         $base = Setting :: agentsetting_read('coupon');
         $pagetitle = !empty($_W['wlsetting']['base']['name']) ? '优惠券列表 - ' . $_W['wlsetting']['base']['name'] : '优惠券列表';
         $_W['wlsetting']['share']['share_title'] = !empty($base['share_title']) ? $base['share_title'] : $_W['wlsetting']['share']['share_title'];
         $_W['wlsetting']['share']['share_desc'] = !empty($base['share_desc']) ? $base['share_desc'] : $_W['wlsetting']['share']['share_desc'];
         $_W['wlsetting']['share']['share_image'] = !empty($base['share_image']) ? $base['share_image'] : $_W['wlsetting']['share']['share_image'];
        
         include wl_template('couponhtml/couponslist');
         }
    
     public function getstore(){
         global $_W, $_GPC;
         $lng = $_GPC['lng'];
         $lat = $_GPC['lat'];
         $parm = array('uniacid' => $_W['uniacid'], 'status' => 2, 'enabled' => 1, 'areaid' => $_W['areaid']);
         $pindex = max(1, intval($_GPC['page']));
         $psize = 10;
         if(!empty($_GPC['cid'])){
             $parm['onelevel'] = intval($_GPC['cid']);
             }
         if(!empty($_GPC['pid'])){
             $parm['twolevel'] = intval($_GPC['pid']);
             }
         if(!empty($_GPC['distid'])){
             $parm['distid'] = intval($_GPC['distid']);
             }
         $couponlist = pdo_fetchall("SELECT * FROM " . tablename('wlmerchant_couponlist') . "WHERE uniacid = {$_W['uniacid']} AND aid = {$_W['aid']}");
         if($couponlist){
             $ids = "(";
             foreach ($couponlist as $key => $v){
                 if($key == 0){
                     $ids .= $v['merchantid'];
                     }else{
                     $ids .= "," . $v['merchantid'];
                     }
                 }
             $ids .= ")";
             $parm['id#'] = $ids;
             }else{
             $parm['id#'] = "(0)";
             }
         // $locations = pdo_getall(PDO_NAME.'merchantdata',$parm,array('id','storename','logo','location','storehours','onelevel','twolevel'));
        $locations = wlCoupon :: getNumstore('*', $parm, 'ID DESC', 0, 0, 0);
         $locations = $locations[0];
         $locations = wlCoupon :: getstores($locations, $lng, $lat);
         // $locations = array_slice($locations,$psize*($pindex-1),$psize);
        foreach ($locations as $key => & $v){
             $coupon = pdo_getall(PDO_NAME . 'couponlist', array('merchantid' => $v['id'], 'is_show' => 0 , 'endtime >' => time()));
             if($coupon){
                 foreach ($coupon as $k => & $asd){
                     $asd['logo'] = tomedia($asd['logo']);
                     $asd['starttime'] = date('Y-m-d H:i:s', $asd['starttime']);
                     $asd['endtime'] = date('Y-m-d H:i:s', $asd['endtime']);
                     if($asd['is_charge'] == 1){
                         $asd['charge'] = '￥' . $asd['price'];
                         }else{
                         $asd['charge'] = '免费';
                         }
                     $asd['href'] = app_url('wlcoupon/coupon_app/couponsdetail', array('id' => $asd['id']));
                     }
                 $v['coupon'] = $coupon;
                 }else{
                 $v = '';
                 }
            
             }
         die(json_encode($locations));
         }
    
    
     public function couponsdetail(){
         global $_W, $_GPC;
         $pagetitle = !empty($_W['wlsetting']['base']['name']) ? '卡券详情 - ' . $_W['wlsetting']['base']['name'] : '卡券详情';
         $id = $_GPC['id'];
         $coupons = wlCoupon :: getSingleCoupons($id, '*');
         $store = pdo_get('wlmerchant_merchantdata', array('id' => $coupons['merchantid']));
         $store['storehours'] = unserialize($store['storehours']);
         $coupons['storename'] = $store['storename'];
         $coupons['storelogo'] = tomedia($store['logo']);
         if($coupons['time_type'] == 1){
             $starttime = date('Y-m-d H:i:s', $coupons['starttime']);
             $endtime = date('Y-m-d H:i:s', $coupons['endtime']);
             }else{
             $starttime = date('Y-m-d H:i:s', time());
             $endtime = time() + ($coupons['deadline'] * 24 * 3600);
             $endtime = date('Y-m-d H:i:s', $endtime);
             }
         // wl_debug($coupons);
        $coupons['description'] = unserialize($coupons['description']);
         if($coupons['is_charge']){
             $allorder = pdo_getall('wlmerchant_order', array('mid' => $_W['mid'], 'aid' => $_W['aid'], 'fkid' => $id, 'status' => 1, 'plugin' => 'coupon'), array('num'));
             $buynum = 0;
             foreach ($allorder as $key => $v){
                 $buynum = $buynum + $v['num'];
                 }
             }else{
             $buynum = pdo_fetchcolumn('SELECT count(id) FROM ' . tablename('wlmerchant_member_coupons') . " WHERE parentid = {$id} AND mid = {$_W['mid']}");
             }
         if($coupons['get_limit']){
             if($buynum > ($coupons['get_limit'] - 1)){
                 $limitflag = 1;
                 }
             }
         if(!$limitflag){
             $member = pdo_get('wlmerchant_member', array('id' => $_W['mid']), array('vipstatus'));
             if($coupons['vipstatus'] == 1){
                 if($member['vipstatus'] != 1){
                     $limitflag = 2;
                     }
                 }else if($coupons['vipstatus'] == 2){
                 if($member['vipstatus'] == 1){
                     $limitflag = 3;
                     }
                 }
             }
         // wl_debug($limitflag);
        $url = app_url('wlcoupon/coupon_app/tips', array('id' => $id));
         $shengyu = $coupons['quantity'] - $coupons['surplus'];
         include wl_template('couponhtml/couponsdetail2');
         }
    
     function qrcodeimg(){
         global $_W, $_GPC;
         $url = $_GPC['url'];
         m('qrcode/QRcode') -> png($url, false, QR_ECLEVEL_H, 4);
         }
     function tips(){
         global $_W, $_GPC;
         $id = $_GPC['id'];
         wl_message('请点选下方按钮领取或购买', app_url('wlcoupon/coupon_app/couponsdetail', array('id' => $id)), 'error');
         }
    
     function topayCoupon(){
         global $_W, $_GPC;
         $pagetitle = !empty($_W['wlsetting']['base']['name']) ? '购买卡券 - ' . $_W['wlsetting']['base']['name'] : '购买卡券';
         $id = $_GPC['id'];
         $coupons = wlCoupon :: getSingleCoupons($id, '*');
         $member = pdo_get('wlmerchant_member', array('id' => $_W['mid']), array('mobile', 'vipstatus'));
         if($member['mobile']){
             $mobile = substr($member['mobile'], 0, 3) . "****" . substr($member['mobile'], -4, 4);
             }else{
             $mobile = '未绑定手机';
             }
         if($coupons['vipstatus'] == 2 && $member['vipstatus'] == 1){
             $coupons['price'] = $coupons['vipprice'];
             }
         $url = app_url('wlcoupon/coupon_app/topayCoupon', array('id' => $id));
         include wl_template('couponhtml/topaycoupon');
         }
    
     function hexiaocoupon(){
         global $_W, $_GPC;
         $id = $_GPC['id'];
         $num = $_GPC['num'];
         $password = $_GPC['password'];
         $coupon = wlCoupon :: getSingleCoupon($id, 'status,usedtime,endtime,usetimes,parentid,orderno');
         if(empty($num)){
             $num = 1;
             }
         if($password){
             if($password != 'asdasd'){
                 wl_message('核销密码错误', 'referer', 'error');
                 }else{
                 if($coupon['usetimes'] == 0){
                     wl_message('该优惠券已失效', 'close', 'error');
                     }
                 if($coupon['endtime'] < time()){
                     wl_message('该优惠券已过期', 'close', 'error');
                     }
                 $usetimes = $coupon['usetimes'] - $num;
                 if($coupon['usedtime']){
                     $coupon['usedtime'] = unserialize($coupon['usedtime']);
                     for ($i = 0; $i < $num ; $i++){
                         $coupon['usedtime'][] = time();
                         }
                     $coupon['usedtime'] = serialize($coupon['usedtime']);
                     }else{
                     for ($i = 0; $i < $num ; $i++){
                         $coupon['usedtime'][] = time();
                         }
                     $coupon['usedtime'] = serialize($coupon['usedtime']);
                     }
                 $res = wlCoupon :: updateCoupon(array('usetimes' => $usetimes, 'usedtime' => $coupon['usedtime']), array('id' => $id));
                 if($res){
                     wl_message('使用优惠券成功', 'close', 'success');
                     }else{
                     wl_message('使用优惠券失败', 'close', 'error');
                     }
                 }
             }else{
             $parent = wlCoupon :: getSingleCoupons($coupon['parentid'], 'merchantid');
             $verifier = SingleMerchant :: verifier($parent['merchantid'], $_W['mid']);
             if($verifier){
                 if($coupon['usetimes'] == 0){
                     wl_message('该优惠券已失效', 'close', 'error');
                     }
                 if($coupon['endtime'] < time()){
                     wl_message('该优惠券已过期', 'close', 'error');
                     }
                 $usetimes = $coupon['usetimes'] - $num;
                 if($usetimes < 1){
                     $res2 = pdo_update('wlmerchant_order', array('status' => 2), array('orderno' => $coupon['orderno']));
                     }
                 if($coupon['usedtime']){
                     $coupon['usedtime'] = unserialize($coupon['usedtime']);
                     for ($i = 0; $i < $num ; $i++){
                         $coupon['usedtime'][] = time();
                         }
                     $coupon['usedtime'] = serialize($coupon['usedtime']);
                     }else{
                     for ($i = 0; $i < $num ; $i++){
                         $coupon['usedtime'][] = time();
                         }
                     $coupon['usedtime'] = serialize($coupon['usedtime']);
                     }
                 $res = wlCoupon :: updateCoupon(array('usetimes' => $usetimes, 'usedtime' => $coupon['usedtime']), array('id' => $id));
                 if($res){
                     wl_message('使用优惠券成功', 'close', 'success');
                     }else{
                     wl_message('使用优惠券失败', 'close', 'error');
                     }
                 }else{
                 wl_message('非管理员无法核销', 'close', 'error');
                 }
             }
         }
    }
?>