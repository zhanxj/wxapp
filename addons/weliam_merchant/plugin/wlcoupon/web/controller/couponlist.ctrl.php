<?php
defined('IN_IA')or exit('Access Denied');
class couponlist{
    function couponsList(){
        global $_W, $_GPC;
        $pindex = max(1, intval($_GPC['page']));
        $psize = 10;
        $wheres = array();
        $wheres['uniacid'] = $_W['uniacid'];
        $wheres['aid'] = $_W['aid'];
        $sel1 = array(array('id' => 1, 'name' => '优惠券类型'), array('id' => 2, 'name' => '优惠券状态'), array('id' => 3, 'name' => '按选择时间'),);
        $sel2 = array(1 => array(array('id' => 1, 'name' => '折扣券'), array('id' => 2, 'name' => '代金券'), array('id' => 3, 'name' => '套餐券'), array('id' => 4, 'name' => '团购券'), array('id' => 5, 'name' => '优惠券'),), 2 => array(array('id' => 1, 'name' => '启用'), array('id' => 2, 'name' => '关闭'),),);
        if (!empty($_GPC['sel']['parentid']) && !empty($_GPC['sel']['childid'])){
            if($_GPC['sel']['parentid'] == 1){
                $wheres['type'] = $_GPC['sel']['childid'];
            }
            if($_GPC['sel']['parentid'] == 2){
                $wheres['status'] = $_GPC['sel']['childid'];
            }
        }
        if($_GPC['sel']['parentid'] == 3){
            $time_limit = $_GPC['time_limit'];
            $starttime = strtotime($_GPC['time_limit']['start']);
            $endtime = strtotime($_GPC['time_limit']['end']);
            $wheres['starttime>'] = $starttime;
            $wheres['endtime<'] = $endtime;
        }
        if (empty($starttime) || empty($endtime)){
            $starttime = strtotime('-1 month');
            $endtime = time();
        }
        $coupons = wlCoupon :: getNumCoupons('*', $wheres, 'ID DESC', $pindex, $psize, 1);
        $pager = $coupons[1];
        $coupons = $coupons[0];
        foreach($coupons as $key => & $value){
            $coupons[$key]['discount'] = $coupons[$key]['discount'] / 10;
            $detail = pdo_get('wlmerchant_merchantdata', array('aid' => $_W['aid'], 'id' => $value['merchantid']));
            $coupons[$key]['storename'] = $detail['storename'];
        }
        include wl_template('coupon/coupon_list');
    }
    function createcoupons(){
        global $_W, $_GPC;
        $coupontype = $_GPC['coupontype'];
        if($coupontype == 1 || $coupontype == ''){
            $coupontype = 1;
            $coupon_title = '折扣券';
        }elseif ($coupontype == 2){
            $coupon_title = '代金券';
        }elseif ($coupontype == 3){
            $coupon_title = '套餐券';
        }elseif ($coupontype == 4){
            $coupon_title = '团购券';
        }elseif ($coupontype == 5){
            $coupon_title = '优惠券';
        }
        $url = app_url('wlcoupon/coupon_app/couponslist');
        $location_store = pdo_getall('wlmerchant_merchantdata', array('uniacid' => $_W['uniacid']));
        foreach ($location_store as $key => & $v){
            $asd = substr($v['logo'], 0, 4);
            if($asd != 'http'){
                $v['logo'] = tomedia($v['logo']);
            }
        }
        if (checksubmit('submit')){
            $time = $_GPC['time_limit'];
            $starttime = strtotime($time['start']);
            $endtime = strtotime($time['end']);
            $group = array();
            $data = array('status' => $_GPC['status'], 'type' => $coupontype, 'logo' => $_GPC['logo_url'], 'indeximg' => $_GPC['indeximg'], 'is_charge' => $_GPC['is_charge'], 'price' => $_GPC['price'], 'is_show' => $_GPC['is_show'], 'merchantid' => $_GPC['merchantid'], 'color' => $_GPC['color'], 'title' => $_GPC['title'], 'sub_title' => $_GPC['sub_title'], 'goodsdetail' => htmlspecialchars_decode($_GPC['goodsdetail']), 'time_type' => $_GPC['time_type'], 'starttime' => $starttime, 'endtime' => $endtime, 'createtime' => time(), 'deadline' => $_GPC['deadline'], 'quantity' => $_GPC['quantity'], 'surplus' => 0, 'get_limit' => $_GPC['get_limit'], 'description' => serialize($_GPC['description']), 'usetimes' => $_GPC['usetimes'], 'vipstatus' => $_GPC['vipstatus'], 'vipprice' => $_GPC['vipprice'],);
            $res = wlCoupon :: saveCoupons($data);
            if($res){
                message('创建卡券成功', web_url('wlcoupon/couponlist/couponsList'), 'success');
            }else{
                message('创建卡券失败', referer(), 'success');
            }
        }
        include wl_template('coupon/createcoupons');
    }
    function qrcodeimg(){
        global $_W, $_GPC;
        $url = $_GPC['url'];
        m('qrcode/QRcode') -> png($url, false, QR_ECLEVEL_H, 4);
    }
    function deleteCoupons(){
        global $_W, $_GPC;
        $id = $_GPC['id'];
        $ids = $_GPC['ids'];
        if($id){
            $res = wlCoupon :: deleteCoupons(array('id' => $id));
            if($res){
                die(json_encode(array('errno' => 0, 'message' => $res, 'id' => $id)));
            }else{
                die(json_encode(array('errno' => 2, 'message' => $res, 'id' => $id)));
            }
        }
        if($ids){
            foreach ($ids as $key => $id){
                wlCoupon :: deleteCoupons(array('id' => $id));
            }
            die(json_encode(array('errno' => 0, 'message' => '', 'id' => '')));
        }
    }
    function deleteCoupon(){
        global $_W, $_GPC;
        $id = $_GPC['id'];
        $ids = $_GPC['ids'];
        if($id){
            $res = wlCoupon :: deleteCoupon(array('id' => $id));
            if($res){
                die(json_encode(array('errno' => 0, 'message' => $res, 'id' => $id)));
            }else{
                die(json_encode(array('errno' => 2, 'message' => $res, 'id' => $id)));
            }
        }
        if($ids){
            foreach ($ids as $key => $id){
                wlCoupon :: deleteCoupon(array('id' => $id));
            }
            die(json_encode(array('errno' => 0, 'message' => '', 'id' => '')));
        }
    }
    function disable(){
        global $_W, $_GPC;
        $id = $_GPC['id'];
        $res = wlCoupon :: updateCoupons(array('status' => 3), array('id' => $id));
        if($res){
            die(json_encode(array('errno' => 0, 'message' => '优惠券已失效')));
        }else{
            die(json_encode(array('errno' => 1, 'message' => '设置优惠券失效失败')));
        }
    }
    function editCoupons(){
        global $_W, $_GPC;
        $id = $_GPC['id'];
        $coupons = wlCoupon :: getSingleCoupons($_GPC['id'], '*');
        $storename = pdo_get('wlmerchant_merchantdata', array('id' => $coupons['merchantid']));
        foreach($coupons as $key => $value){
            $coupons['storename'] = $storename['storename'];
            $coupons['logolist'] = $storename['logo'];
        }
        $coupons['description'] = unserialize($coupons['description']);
        $coupontype = $coupons['type'];
        $location_store = pdo_getall('wlmerchant_merchantdata', array('uniacid' => $_W['uniacid']));
        foreach ($location_store as $key => & $v){
            $asd = substr($v['logo'], 0, 4);
            if($asd != 'http'){
                $v['logo'] = tomedia($v['logo']);
                $v['indeximg'] = tomedia($v['indeximg']);
            }
        }
        $url = app_url('wlcoupon/coupon_app/couponsdetail', array('id' => $id));
        if($coupontype == 1 || $coupontype == ''){
            $coupontype = 1;
            $coupon_title = '折扣券';
        }elseif ($coupontype == 2){
            $coupon_title = '代金券';
        }elseif ($coupontype == 3){
            $coupon_title = '套餐券';
        }elseif ($coupontype == 4){
            $coupon_title = '团购券';
        }elseif ($coupontype == 5){
            $coupon_title = '优惠券';
        }
        if (checksubmit('submit')){
            if($_GPC['quantity'] < $coupons['surplus']){
                message('更新卡券失败,库存不能小于已售数量', referer(), 'error');
            }
            $time = $_GPC['time_limit'];
            $starttime = strtotime($time['start']);
            $endtime = strtotime($time['end']);
            $group = array();
            $data = array('status' => $_GPC['status'], 'type' => $coupontype, 'logo' => $_GPC['logo_url'], 'indeximg' => $_GPC['indeximg'], 'is_charge' => $_GPC['is_charge'], 'is_show' => $_GPC['is_show'], 'price' => $_GPC['price'], 'merchantid' => $_GPC['merchantid'], 'color' => $_GPC['color'], 'title' => $_GPC['title'], 'sub_title' => $_GPC['sub_title'], 'goodsdetail' => htmlspecialchars_decode($_GPC['goodsdetail']), 'time_type' => $_GPC['time_type'], 'starttime' => $starttime, 'endtime' => $endtime, 'createtime' => time(), 'deadline' => $_GPC['deadline'], 'quantity' => $_GPC['quantity'], 'get_limit' => $_GPC['get_limit'], 'description' => serialize($_GPC['description']), 'usetimes' => $_GPC['usetimes'], 'vipstatus' => $_GPC['vipstatus'], 'vipprice' => $_GPC['vipprice'],);
            $res = wlCoupon :: updateCoupons($data, array('id' => $id));
            if($res){
                message('更新卡券成功', web_url('wlcoupon/couponlist/couponsList'), 'success');
            }else{
                message('更新卡券失败', referer(), 'error');
            }
        }
        include wl_template('coupon/createcoupons');
    }
    function merbercoupon(){
        global $_W, $_GPC;
        $pindex = max(1, intval($_GPC['page']));
        $psize = 10;
        $wheres = array();
        $wheres['uniacid'] = $_W['uniacid'];
        $wheres['aid'] = $_W['aid'];
        if(!empty($_GPC['parentid'])){
            $wheres['parentid'] = $_GPC['parentid'];
        }
        if(!empty($_GPC['orderno'])){
            $wheres['orderno'] = $_GPC['orderno'];
        }
        $sel1 = array(array('id' => 1, 'name' => '优惠券类型'), array('id' => 2, 'name' => '优惠券状态'), array('id' => 3, 'name' => '按选择时间'), array('id' => 4, 'name' => '按用户昵称'), array('id' => 5, 'name' => '按优惠券标题'),);
        $sel2 = array(1 => array(array('id' => 1, 'name' => '折扣券'), array('id' => 2, 'name' => '代金券'), array('id' => 3, 'name' => '套餐券'), array('id' => 4, 'name' => '团购券'), array('id' => 5, 'name' => '优惠券'),), 2 => array(array('id' => 1, 'name' => '可使用'), array('id' => 2, 'name' => '已使用'),),);
        if (!empty($_GPC['sel']['parentid'])){
            if($_GPC['sel']['parentid'] == 1){
                $wheres['type'] = $_GPC['sel']['childid'];
            }
            if($_GPC['sel']['parentid'] == 2){
                if($_GPC['sel']['childid'] == 1){
                    $wheres['usetimes>'] = 1;
                }else{
                    $wheres['usetimes'] = 0;
                }
            }
            if($_GPC['sel']['parentid'] == 3){
                if (!empty($_GPC['time_limit'])){
                    $starttime = strtotime($_GPC['time_limit']['start']);
                    $endtime = strtotime($_GPC['time_limit']['end']);
                    $wheres['createtime>'] = $starttime;
                    $wheres['endtime<'] = $endtime;
                }
            }
            if($_GPC['sel']['parentid'] == 4){
                $keyword = $_GPC['keyword'];
                $params[':nickname'] = "%{$keyword}%";
                $member = pdo_fetchall("SELECT * FROM " . tablename('wlmerchant_member') . "WHERE uniacid = {$_W['uniacid']} AND aid = {$_W['aid']} AND nickname LIKE :nickname", $params);
                if($member){
                    $mids = "(";
                    foreach ($member as $key => $v){
                        if($key == 0){
                            $mids .= $v['id'];
                        }else{
                            $mids .= "," . $v['id'];
                        }
                    }
                    $mids .= ")";
                    $wheres['mid#'] = $mids;
                }else{
                    $wheres['mid#'] = "(0)";
                }
            }
            if($_GPC['sel']['parentid'] == 5){
                $keyword = $_GPC['keyword'];
                $params[':title'] = "%{$keyword}%";
                $coupons = pdo_fetchall("SELECT * FROM " . tablename('wlmerchant_couponlist') . "WHERE uniacid = {$_W['uniacid']} AND aid = {$_W['aid']} AND title LIKE :title", $params);
                if($coupons){
                    $parentids = "(";
                    foreach ($coupons as $key => $v){
                        if($key == 0){
                            $parentids .= $v['id'];
                        }else{
                            $parentids .= "," . $v['id'];
                        }
                    }
                    $parentids .= ")";
                    $wheres['parentid#'] = $parentids;
                }else{
                    $wheres['parentid#'] = "(0)";
                }
            }
        }
        if (empty($starttime) || empty($endtime)){
            $starttime = strtotime('-1 month');
            $endtime = time();
        }
        $merber_coupon = wlCoupon :: getNumCoupon('*', $wheres, 'ID DESC', $pindex, $psize, 1);
        $pager = $merber_coupon[1];
        $merber_coupon = $merber_coupon[0];
        foreach($merber_coupon as $key => & $v){
            $member = pdo_get('wlmerchant_member', array('id' => $v['mid']), array('avatar', 'nickname', 'mobile'));
            $coupon = pdo_get('wlmerchant_couponlist', array('id' => $v['parentid']), array('logo', 'title', 'merchantid'));
            $merchant = pdo_get('wlmerchant_merchantdata', array('id' => $coupon['merchantid']), array('storename'));
            $v['avatar'] = $member['avatar'];
            $v['nickname'] = $member['nickname'];
            $v['mobile'] = $member['mobile'];
            $v['logo'] = $coupon['logo'];
            $v['title'] = $coupon['title'];
            $v['storename'] = $merchant['storename'];
        }
        include wl_template('coupon/merber_coupons');
    }
    function entry(){
        global $_W, $_GPC;
        $settings = $_W['wlsetting']['coverIndexCoupon'];
        $settings['url'] = app_url('wlcoupon/coupon_app/couponslist');
        $settings['name'] = '优惠券入口';
        if (checksubmit('submit')){
            $cover = Util :: trimWithArray($_GPC['cover']);
            Setting :: wlsetting_save($cover, 'coverIndexCoupon');
            $re = Setting :: saveRule('coverIndexCoupon', $settings['url'], $cover);
            message($re, web_url('wlcoupon/couponlist/entry'));
        }
        include wl_template('coupon/entry');
    }
    function base(){
        global $_W, $_GPC;
        $base = Setting :: agentsetting_read('coupon');
        if (checksubmit('submit')){
            $base = $_GPC['base'];
            $data_img = $_GPC['data_img'];
            $data_url = $_GPC['data_url'];
            $paramids = array();
            $len = count($data_img);
            for ($k = 0;$k < $len;$k++){
                if(!empty($data_img[$k])){
                    $paramids[$k]['data_img'] = $data_img[$k];
                    $paramids[$k]['data_url'] = $data_url[$k];
                }
            }
            $base['content'] = $paramids;
            $res1 = Setting :: agentsetting_save($base, 'coupon');
            if($res1){
                message('保存设置成功！', referer(), 'success');
            }else{
                message('保存设置失败！', referer(), 'error');
            }
        }
        include wl_template('coupon/base');
    }
    function hexiaotime(){
        global $_W, $_GPC;
        $id = $_GPC['id'];
        $coupon = pdo_get('wlmerchant_member_coupons', array('id' => $id), array('usetimes', 'usedtime'));
        $coupon['usedtime'] = unserialize($coupon['usedtime']);
        foreach ($coupon['usedtime'] as $key => & $v){
            $v = date('Y-m-d H:i:s', $v);
        }
        die(json_encode(array('errno' => 0, 'times' => $coupon['usetimes'], 'data' => $coupon['usedtime'])));
    }
    function todetail(){
        global $_W, $_GPC;
        $id = $_GPC['id'];
        $coupon = pdo_get('wlmerchant_couponlist', array('id' => $id), array('goodsdetail', 'description'));
        $data = $coupon['goodsdetail'];
        $data2 = unserialize($coupon['description']);
        die(json_encode(array('errno' => 0, 'data' => $data, 'data2' => $data2)));
    }
    function orderlist(){
        global $_W, $_GPC;
        $pindex = max(1, intval($_GPC['page']));
        $psize = 10;
        $wheres = array();
        $wheres['uniacid'] = $_W['uniacid'];
        $wheres['aid'] = $_W['aid'];
        $wheres['status'] = 1;
        $wheres['plugin'] = 'coupon';
        $sel1 = array(array('id' => 1, 'name' => '优惠券名称'), array('id' => 2, 'name' => '用户昵称'), array('id' => 3, 'name' => '按支付时间'),);
        if($_GPC['sel']['parentid'] == 1){
            $keyword = $_GPC['keyword'];
            $params[':title'] = "%{$keyword}%";
            $coupons = pdo_fetchall("SELECT * FROM " . tablename('wlmerchant_couponlist') . "WHERE uniacid = {$_W['uniacid']} AND aid = {$_W['aid']} AND title LIKE :title", $params);
            if($coupons){
                $parentids = "(";
                foreach ($coupons as $key => $v){
                    if($key == 0){
                        $parentids .= $v['id'];
                    }else{
                        $parentids .= "," . $v['id'];
                    }
                }
                $parentids .= ")";
                $wheres['couponid#'] = $parentids;
            }else{
                $wheres['couponid#'] = "(0)";
            }
        }
        if($_GPC['sel']['parentid'] == 2){
            $keyword = $_GPC['keyword'];
            $params[':nickname'] = "%{$keyword}%";
            $member = pdo_fetchall("SELECT * FROM " . tablename('wlmerchant_member') . "WHERE uniacid = {$_W['uniacid']} AND aid = {$_W['aid']} AND nickname LIKE :nickname", $params);
            if($member){
                $mids = "(";
                foreach ($member as $key => $v){
                    if($key == 0){
                        $mids .= $v['id'];
                    }else{
                        $mids .= "," . $v['id'];
                    }
                }
                $mids .= ")";
                $wheres['mid#'] = $mids;
            }else{
                $wheres['mid#'] = "(0)";
            }
        }
        if($_GPC['sel']['parentid'] == 3){
            if (!empty($_GPC['time_limit'])){
                $starttime = strtotime($_GPC['time_limit']['start']);
                $endtime = strtotime($_GPC['time_limit']['end']);
                $wheres['paytime>'] = $starttime;
                $wheres['paytime<'] = $endtime;
            }
        }
        if (empty($starttime) || empty($endtime)){
            $starttime = strtotime('-1 month');
            $endtime = time();
        }
        $orders = wlCoupon :: getNumCouponOrder('*', $wheres, 'ID DESC', $pindex, $psize, 1);
        $pager = $orders[1];
        $orders = $orders[0];
        foreach ($orders as $key => & $v){
            $coupon = pdo_get('wlmerchant_couponlist', array('id' => $v['fkid']), array('title', 'logo'));
            $merchant = pdo_get('wlmerchant_merchantdata', array('id' => $v['sid']), array('storename'));
            $member = pdo_get('wlmerchant_member', array('id' => $v['mid']), array('nickname', 'avatar', 'mobile'));
            $v['title'] = $coupon['title'];
            $v['logo'] = tomedia($coupon['logo']);
            $v['storename'] = $merchant['storename'];
            $v['nickname'] = $member['nickname'];
            $v['avatar'] = $member['avatar'];
            $v['mobile'] = $member['mobile'];
        }
        include wl_template('coupon/orderlist');
    }
    function remark(){
        global $_W, $_GPC;
        $id = $_GPC['id'];
        $remark = $_GPC['remark'];
        $res = pdo_update('wlmerchant_order', array('remark' => $remark), array('id' => $id));
        if($res){
            die(json_encode(array('errno' => 0, 'message' => $res, 'id' => $id)));
        }else{
            die(json_encode(array('errno' => 2, 'message' => $res, 'id' => $id)));
        }
    }
    function deleteOrder(){
        global $_W, $_GPC;
        $id = $_GPC['id'];
        $res = pdo_delete('wlmerchant_order', array('id' => $id));
        if($res){
            die(json_encode(array('errno' => 0, 'message' => $res, 'id' => $id)));
        }else{
            die(json_encode(array('errno' => 2, 'message' => $res, 'id' => $id)));
        }
    }
    function description(){
        global $_W, $_GPC;
        include wl_template('coupon/description');
    }
}
?>