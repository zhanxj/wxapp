<?php
defined('IN_IA') or exit('Access Denied');

class supervise{
    
     public function __construct(){
         global $_W, $_GPC;
         if(!empty($_GPC['__wl_storeid'])){
             $_W['storeid'] = intval($_GPC['__wl_storeid']);
             }
         if(!empty($_GPC['__wl_storeaid'])){
             $_W['aid'] = intval($_GPC['__wl_storeaid']);
             }
         }
    
    /**
     * 判断店铺ID是否存在
     */
     public function checkstoreid(){
         global $_W;
         if(empty($_W['storeid'])){
             header('location: ' . app_url('store/supervise/storelist'));
             die();
             }
         }
    
    /**
     * 店铺列表
     */
     public function storelist(){
         global $_W, $_GPC;
         $pagetitle = !empty($_W['wlsetting']['base']['name']) ? '店铺列表 - ' . $_W['wlsetting']['base']['name'] : '店铺列表';
         $storeids = pdo_getall(PDO_NAME . 'merchantuser', array('uniacid' => $_W['uniacid'], 'mid' => $_W['mid'], 'status' => 2, 'enabled' => 1), 'storeid');
        
         if(empty($storeids)) wl_message('您还不是商家或账户正在审核中，请先申请入驻平台。', app_url('store/storeManage/enter'), 'warning');
         foreach ($storeids as $key => $value){
             $stores[$key] = pdo_get(PDO_NAME . 'merchantdata', array('id' => $value['storeid']));
             }
         include wl_template('store/storelist');
         }
    
    /**
     * 选择店铺
     */
     public function switchstore(){
         global $_W, $_GPC;
         $storeid = intval($_GPC['storeid']);
         $role = pdo_get(PDO_NAME . 'merchantuser', array('mid' => $_W['mid'], 'storeid' => $storeid), array('id', 'aid'));
         if(empty($role)){
             wl_message('操作失败, 您没有访问权限.');
             }
         if($role['aid'] == 0){
             $role['aid'] = pdo_getcolumn(PDO_NAME . 'merchantdata', array('id' => $storeid), 'aid');
             pdo_update(PDO_NAME . 'merchantuser', array('aid' => $role['aid']), array('mid' => $_W['mid'], 'storeid' => $storeid));
             }
         isetcookie('__wl_storeid', $storeid, 7 * 86400);
         isetcookie('__wl_storeaid', $role['aid'], 7 * 86400);
         header('location: ' . app_url('store/supervise/platform'));
         }
    
    /**
     * 粉丝管理
     */
     public function fans(){
         global $_W, $_GPC;
         $pagetitle = !empty($_W['wlsetting']['base']['name']) ? '粉丝管理 - ' . $_W['wlsetting']['base']['name'] : '粉丝管理';
         $fansnum = pdo_fetchcolumn("SELECT COUNT(id) FROM " . tablename(PDO_NAME . 'storefans') . " WHERE uniacid = '{$_W['uniacid']}' and sid = {$_W['storeid']}");
        
         include wl_template('store/fans');
         }
    
    /**
     * 店铺管理首页
     */
     public function platform(){
         global $_W, $_GPC;
        // wl_debug(Util::createConcode());
        $this -> checkstoreid();
         $store = Store :: getSingleStore($_W['storeid']);
         $pagetitle = !empty($_W['wlsetting']['base']['name']) ? $store['storename'] . ' - ' . $_W['wlsetting']['base']['name'] : $store['storename'];
         $where = array();
         $where['sid'] = $_W['storeid'];
         $where['#status#'] = '(1,2,3,4,6,7)';
         $where['paytime>'] = strtotime(date('Y-m-d'));
         $where['paytime<'] = strtotime(date('Y-m-d')) + 24 * 60 * 60;
         $account = Util :: getSingelData('*', PDO_NAME . 'merchant_account', array('sid' => $_W['storeid']));
         $orderData = Util :: getNumData("price", PDO_NAME . 'rush_order', $where, 'id desc', 0, 0, 1);
         $money = 0;
         foreach($orderData[0] as$key => $value){
             $money += $value['price'];
             }
         include wl_template('store/platform');
         }
    
     public function shopset(){
         global $_W, $_GPC;
         $this -> checkstoreid();
         $pagetitle = !empty($_W['wlsetting']['base']['name']) ? '店铺管理 - ' . $_W['wlsetting']['base']['name'] : '店铺管理';
         $store = Store :: getSingleStore($_W['storeid']);
         $_W['wlsetting']['share']['share_title'] = $store['storename'];
         $_W['wlsetting']['share']['share_url'] = app_url('store/merchant/detail', array('id' => $_W['storeid']));
         $_W['wlsetting']['share']['share_image'] = $store['logo'];
        
         include wl_template('store/shopset');
         }
    
     public function storeqr(){
         global $_W, $_GPC;
         $this -> checkstoreid();
         $pagetitle = !empty($_W['wlsetting']['base']['name']) ? '店铺二维码 - ' . $_W['wlsetting']['base']['name'] : '店铺二维码';
         $store = Store :: getSingleStore($_W['storeid']);
         if(empty($store['cardsn'])){
             Storeqr :: qr_createkeywords();
             $return = Storeqr :: creatstoreqr(2);
             if($return['result'] == 2) wl_message('店铺二维码生成失败，请重试！');
             $qrid = $return['qrid'];
             $qrcode = pdo_get(PDO_NAME . 'qrcode', array('uniacid' => $_W['uniacid'], 'qrid' => $qrid));
             pdo_update(PDO_NAME . 'qrcode', array('sid' => $_W['storeid'], 'status' => 2), array('id' => $qrcode['id']));
             pdo_update(PDO_NAME . 'merchantdata', array('cardsn' => $qrcode['cardsn']), array('id' => $_W['storeid']));
             }else{
             $qrid = pdo_getcolumn(PDO_NAME . 'qrcode', array('sid' => $_W['storeid'], 'status' => 2), 'qrid');
             }
         $ticket = pdo_getcolumn('qrcode', array('id' => $qrid), 'ticket');
         $showurl = 'https:mp.weixin.qq.com/cgi-bin/showqrcode?ticket=' . urlencode($ticket);
         include wl_template('store/storeqr');
         }
    
    /**
     * 店铺信息设置
     */
     public function information(){
         global $_W, $_GPC;
         $this -> checkstoreid();
         $pagetitle = !empty($_W['wlsetting']['base']['name']) ? '店铺信息 - ' . $_W['wlsetting']['base']['name'] : '店铺信息';
         $store = Store :: getSingleStore($_W['storeid']);
         $store['location'] = unserialize($store['location']);
         include wl_template('store/information');
         }
    
     public function submitInformation(){
         global $_W, $_GPC;
         $this -> checkstoreid();
         $data = $_GPC['merchant'];
         $data['logo'] = $_GPC['images'][0];
         $data['location'] = serialize(array('lng' => $_GPC['lng'], 'lat' => $_GPC['lat']));
         pdo_update(PDO_NAME . 'merchantdata', $data, array('id' => $_W['storeid']));
         wl_message('保存成功', '', 'success');
         }
    
     public function verificationtool(){
         global $_W, $_GPC;
         $this -> checkstoreid();
         $pagetitle = !empty($_W['wlsetting']['base']['name']) ? '核销工具 - ' . $_W['wlsetting']['base']['name'] : '核销工具';
         include wl_template('store/verificationtool');
         }
    
     public function verifcode(){
         global $_W, $_GPC;
         $this -> checkstoreid();
         $type = intval($_GPC['veriftype']);
         $code = trim($_GPC['verifcode']);
         $num = intval($_GPC['couponnum']);
         // 抢购订单
        if($type == 1){
             $order = pdo_get(PDO_NAME . 'rush_order', array('uniacid' => $_W['uniacid'], 'sid' => $_W['storeid'], 'checkcode' => $code), array('id', 'status'));
             if($order && $order['status'] == 1){
                 $re = pdo_update(PDO_NAME . 'rush_order', array('status' => 2, 'verfmid' => $_W['mid'], 'verftime' => time()), array('id' => $order['id']));
                 if($re){
                     die(json_encode(array("result" => 1)));
                     }
                 }elseif($order['status'] == 2){
                 die(json_encode(array("result" => 2, 'msg' => '请勿重复核销')));
                 }
             die(json_encode(array("result" => 2, 'msg' => '核销码无效，请检查一下')));
             }
         // 五折卡
        if($type == 2){
             $order = pdo_get(PDO_NAME . 'halfcardrecord', array('uniacid' => $_W['uniacid'], 'merchantid' => $_W['storeid'], 'qrcode' => $code), array('id', 'status'));
             if($order && $order['status'] == 1){
                 $re = pdo_update(PDO_NAME . 'halfcardrecord', array('status' => 2, 'verfmid' => $_W['mid'], 'hexiaotime' => time()), array('id' => $order['id']));
                 if($re){
                     die(json_encode(array("result" => 1)));
                     }
                 }elseif($order['status'] == 2){
                 die(json_encode(array("result" => 2, 'msg' => '请勿重复核销')));
                 }
             die(json_encode(array("result" => 2, 'msg' => '核销码无效，请检查一下')));
             }
         // 卡券
        if($type == 3){
             $order = pdo_get(PDO_NAME . 'member_coupons', array('uniacid' => $_W['uniacid'], 'concode' => $code), array('id', 'usetimes', 'endtime', 'usedtime', 'orderno'));
             if($order){
                 if($order['endtime'] > time()){
                     if($order['usetimes'] > 0){
                         if($order['usetimes'] >= $num){
                             $newtime = $order['usetimes'] - $num;
                             if($order['usedtime']){
                                 $order['usedtime'] = unserialize($order['usedtime']);
                                 for ($i = 0; $i < $num ; $i++){
                                     $order['usedtime'][] = time();
                                     }
                                 $order['usedtime'] = serialize($order['usedtime']);
                                 }else{
                                 for ($i = 0; $i < $num ; $i++){
                                     $order['usedtime'][] = time();
                                     }
                                 $order['usedtime'] = serialize($order['usedtime']);
                                 }
                             if($newtime < 1){
                                 $res2 = pdo_update('wlmerchant_order', array('status' => 2), array('orderno' => $order['orderno']));
                                 }
                             $res = wlCoupon :: updateCoupon(array('usetimes' => $newtime, 'usedtime' => $order['usedtime']), array('id' => $order['id']));
                             if($res){
                                 die(json_encode(array("result" => 1)));
                                 }else{
                                 die(json_encode(array("result" => 2, 'msg' => '核销错误，请重试')));
                                 }
                             }else{
                             die(json_encode(array("result" => 2, 'msg' => '卡券剩余使用次数为' . $order['usetimes'] . '次')));
                             }
                         }else{
                         die(json_encode(array("result" => 2, 'msg' => '卡券已使用，无法继续核销')));
                         }
                     }else{
                     die(json_encode(array("result" => 2, 'msg' => '卡券已过期，无法继续核销')));
                     }
                 }else{
                 die(json_encode(array("result" => 2, 'msg' => '消费码无效，请检查一下')));
                 }
             }
         die(json_encode(array("result" => 2, 'msg' => '核销码类型错误')));
         }
    
    /**
     * 商家商品管理
     */
     public function goods(){
         global $_W, $_GPC;
         $this -> checkstoreid();
         $pagetitle = !empty($_W['wlsetting']['base']['name']) ? '商品管理 - ' . $_W['wlsetting']['base']['name'] : '商品管理';
        
         $merchantGoodsData = Util :: getNumData('*', PDO_NAME . 'goodshouse', array('sid' => $_W['storeid']));
         $goods = $merchantGoodsData[0];
         foreach($goods as $key => & $value){
             $value['plugin'] = 'goodshouse';
             if($_GPC['type'] == 'rush'){
                 $value['a'] = app_url('store/supervise/createGoodsStep3', array('goodsid' => $value['id'], 'func' => 1));
                 }else{
                 $value['a'] = app_url('store/supervise/createGoodsStep2', array('id' => $value['id']));
                 }
             }
         include wl_template('store/goodsList');
         }
    /**
     * 新建商品
     */
     public function createGoodsStep1(){
         global $_W, $_GPC;
         $func = $_GPC['func']; //1抢购
         include wl_template('store/createGoodsStep1');
         }
    
     public function createGoodsStep2(){
         global $_W, $_GPC;
         $this -> checkstoreid();
         $func = $_GPC['func']; //1抢购
         if($func){
             switch($func){
             case 1:$name = '抢购';
                break;
                 }
             }
         $pagetitle = !empty($_W['wlsetting']['base']['name']) ? '商品管理 - ' . $_W['wlsetting']['base']['name'] : '商品管理';
         $id = $_GPC['id'];
         if($id){
             $goods = Util :: getSingelData('*', PDO_NAME . 'goodshouse', array('id' => $_GPC['id']));
             $goods['thumbs'] = unserialize($goods['thumbs']);
             }
         if($_GPC['token']){
             $data = $_GPC['goods'];
             $images = $_GPC['images'];
             $data['thumb'] = $images[0];
             unset($images[0]);
             $data['thumbs'] = serialize($images);
             $data['uniacid'] = $_W['uniacid'];
             $data['sid'] = $_W['storeid'];
             $data['aid'] = $_W['aid'];
             if($id){
                 pdo_update(PDO_NAME . 'goodshouse', $data, array('id' => $_GPC['id']));
                 }else{
                 $res = pdo_insert(PDO_NAME . 'goodshouse', $data);
                 $id = pdo_insertid();
                 }
             if($func){
                 header('location:' . app_url('store/supervise/createGoodsStep3', array('goodsid' => $id, 'func' => $func)));
                 }else{
                 wl_message('保存成功！', app_url('store/supervise/goods'), 'success');
                 }
             }
         include wl_template('store/createGoodsStep2');
         }
    
     public function createGoodsStep3(){
         global $_W, $_GPC;
         $this -> checkstoreid();
         $pagetitle = !empty($_W['wlsetting']['base']['name']) ? '商品管理 - ' . $_W['wlsetting']['base']['name'] : '商品管理';
         $func = $_GPC['func']; //1抢购
         $goodsid = $_GPC['goodsid']; //仓库商品ID
         $id = $_GPC['id']; //抢购活动ID
         if($func){
             switch($func){
             case 1:$name = '抢购';
                break;
                 }
             }
        
         if($func == 1){ // 抢购
             if(empty($id)){
                 // 从仓库选择商品
                $goods = Rush :: getSingleGoods($goodsid, '*');
                 }else{
                 // 编辑商品
                $goods = Rush :: getSingleActive($id, '*');
                 $goods['thumbs'] = unserialize($goods['thumbs']);
                 $active = 1;
                 }
             $sale = $goods['num'] - $goods['levelnum'];
             if (empty($goods['starttime']) || empty($goods['endtime'])){ // 初始化时间
                 $goods['starttime'] = time();
                 $goods['endtime'] = strtotime('+1 month');
                 $goods['cutofftime'] = strtotime('+1 month');
                 }
            
             if ($_GPC['token']){
                 $data = $_GPC['goods'];
                
                 $data['starttime'] = strtotime($data['starttime']);
                 $data['endtime'] = strtotime($data['endtime']);
                 $data['cutofftime'] = strtotime($data['cutofftime']);
                 $data['levelnum'] = $data['num'] - $sale;
                /**
                 * 从商品库中的商品调取必须数据
                 */
                 if(empty($id)){
                     $data['thumb'] = $goods['thumb'];
                     $data['thumbs'] = $goods['thumbs'];
                     $data['unit'] = $goods['unit'];
                     $data['oldprice'] = $goods['oldprice'];
                     $data['uniacid'] = $goods['uniacid'];
                     $data['sid'] = $goods['sid'];
                     $data['aid'] = $goods['aid'];
                     $data['uniacid'] = $goods['uniacid'];
                     $data['describe'] = $goods['describe'];
                     $data['name'] = $goods['name'];
                     }else{
                     $images = $_GPC['images'];
                     $data['thumb'] = $images[0];
                     unset($images[0]);
                     $data['thumbs'] = serialize($images);
                     }
                 // 抢购状态通过抢购时间判断
                if($data['starttime'] > time()){
                     $data['status'] = 1;
                     }elseif($data['starttime'] < time() && time() < $data['endtime']){
                     $data['status'] = 2;
                     }elseif($data['endtime'] < time()){
                     $data['status'] = 3;
                     }
                 if($id){
                     $res = Rush :: updateActive($data, array('id' => $id));
                     }else{
                     $data['levelnum'] = $data['num'] - $sale;
                     $res = Rush :: saveRushActive($data);
                     }
                 if($res) wl_message('保存成功！', app_url('store/supervise/rush'), 'success');
                 wl_message('保存失败！', referer(), 'error');
                 }
             }
         include wl_template('store/createGoodsStep3');
         }
    /**
     * 新建分类
     */
     public function createCategory(){
         global $_W, $_GPC;
         $pagetitle = !empty($_W['wlsetting']['base']['name']) ? '商品管理 - ' . $_W['wlsetting']['base']['name'] : '商品管理';
         $merchantGoodsData = Util :: getNumData('*', PDO_NAME . 'goodshouse', array('sid' => $_W['storeid']));
         $merchantGoods = $merchantGoodsData[0];
         include wl_template('store/createCategory');
         }
    /**
     * 管理员管理
     */
     public function admin(){
         global $_W, $_GPC;
         $this -> checkstoreid();
         $op = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
         if($op == 'display'){
             $pagetitle = !empty($_W['wlsetting']['base']['name']) ? '管理员管理 - ' . $_W['wlsetting']['base']['name'] : '管理员管理';
             $admin = pdo_get(PDO_NAME . 'merchantuser', array('uniacid' => $_W['uniacid'], 'storeid' => $_W['storeid'], 'ismain' => 1));
             $admin['member'] = Member :: getMemberByMid($admin['mid'], array('avatar'));
             $hxadmin = pdo_getall(PDO_NAME . 'merchantuser', array('uniacid' => $_W['uniacid'], 'storeid' => $_W['storeid'], 'ismain' => 2));
             if($hxadmin){
                 foreach ($hxadmin as $key => $value){
                     $hxadmin[$key]['member'] = Member :: getMemberByMid($value['mid'], array('avatar'));
                     }
                 }
             include wl_template('store/admin');
             }
        
         if($op == 'add'){
             if($_W['ispost']){
                 $data = array(
                    'uniacid' => $_W['uniacid'],
                     'mid' => $_GPC['adminid'],
                     'storeid' => $_W['storeid'],
                     'name' => $_GPC['adminname'],
                     'mobile' => $_GPC['admintel'],
                     'areaid' => $_W['areaid'],
                     'createtime' => time(),
                     'status' => 2,
                     'enabled' => 1,
                     'ismain' => 2
                    );
                 if(pdo_insert(PDO_NAME . 'merchantuser', $data)){
                     die(json_encode(array("result" => 1)));
                     }else{
                     die(json_encode(array("result" => 2, 'msg' => '管理员添加失败，请重试')));
                     }
                 }
             $id = intval($_GPC['id']);
             if($id){
                 $pagetitle = !empty($_W['wlsetting']['base']['name']) ? '编辑管理员 - ' . $_W['wlsetting']['base']['name'] : '编辑管理员';
                 $admin = pdo_get(PDO_NAME . 'merchantuser', array('id' => $id));
                 }else{
                 $pagetitle = !empty($_W['wlsetting']['base']['name']) ? '添加管理员 - ' . $_W['wlsetting']['base']['name'] : '添加管理员';
                 $qrcode = time();
                 $showurl = urlencode(app_url('store/supervise/confirmadmin', array('codes' => $qrcode, 'storeid' => $_W['storeid'])));
                 pdo_insert(PDO_NAME . 'merchantuser_qrlog', array('uniacid' => $_W['uniacid'], 'codes' => $qrcode, 'createtime' => $qrcode));
                 pdo_delete(PDO_NAME . 'merchantuser_qrlog', array('uniacid' => $_W['uniacid'], 'createtime <' => $qrcode-300, 'status !=' => 1));
                 }
            
             include wl_template('store/admin_add');
             }
        
         if($op == 'ajax'){
             $qrcode = $_GPC['codes'];
             $item = pdo_get(PDO_NAME . 'merchantuser_qrlog', array('uniacid' => $_W['uniacid'], 'codes' => $qrcode));
             $itemtime = $item['createtime'] + 300;
             if (empty($item) || $itemtime < time()){
                 die(json_encode(array("success" => false, "msg" => "二维码过期", "reload" => true)));
                 }
             if ($item['status'] == 0){
                 die(json_encode(array("success" => false, "msg" => "", "reload" => false)));
                 }
             $data = pdo_get(PDO_NAME . "member", array('id' => $item['memberid']), array('avatar', 'nickname', 'id'));
             die(json_encode(array("success" => true, 'dat' => $data)));
             }
        
         if($op == 'del'){
             $id = intval($_GPC['id']);
             if($id){
                 $admin = pdo_get(PDO_NAME . 'merchantuser', array('id' => $id));
                 if($admin['ismain'] == 1){
                     wl_message('店铺超级管理员无法删除');
                     }
                 if(pdo_delete(PDO_NAME . 'merchantuser', array('id' => $id))){
                     wl_message('删除管理员成功', app_url('store/supervise/admin'), 'success');
                     }
                 wl_message('删除管理员失败，请返回重试！');
                 }else{
                 wl_message('缺少关键参数，请返回重试！');
                 }
             }
         }
    
    /**
     * 订单管理
     */
     public function order(){
         global $_W, $_GPC;
         $pagetitle = !empty($_W['wlsetting']['base']['name']) ? '订单管理 - ' . $_W['wlsetting']['base']['name'] : '订单管理';
         $type = $_GPC['type']?$_GPC['type']:'rush';
         $status = $_GPC['status']?$_GPC['status']:1;
         $this -> checkstoreid();
         switch($type){
         case 'rush':$name = '抢购';
            break;
         case 'coupon':$name = '卡券';
            break;
         default:$name = '全部';
            break;
             }
        
         include wl_template('store/order');
         }
    
     public function summary(){
         global $_W, $_GPC;
         $this -> checkstoreid();
         $pagetitle = !empty($_W['wlsetting']['base']['name']) ? '数据统计 - ' . $_W['wlsetting']['base']['name'] : '数据统计';
         $store = Store :: getSingleStore($_W['storeid']);
        
         include wl_template('store/summary');
         }
    
    /**
     * 生成二维码
     */
     public function showqrcode(){
         global $_W, $_GPC;
         $url = urldecode($_GPC['url']);
         require IA_ROOT . '/framework/library/qrcode/phpqrcode.php';
         QRcode :: png($url, false, QR_ECLEVEL_L, 8, 0);
         }
    
    /**
     * 确认成为管理员
     */
     public function confirmadmin(){
         global $_W, $_GPC;
         $pagetitle = !empty($_W['wlsetting']['base']['name']) ? '管理员确认 - ' . $_W['wlsetting']['base']['name'] : '管理员确认';
         $op = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
         if($op == 'display'){
             $qrcode = $_GPC['codes'];
             if(empty($qrcode) || empty($_GPC['storeid'])){
                 wl_message('缺少重要参数，请重新扫描二维码', 'close');
                 }
             $store = Store :: getSingleStore($_GPC['storeid']);
             include wl_template('store/admin_confirmadmin');
             }
         if($op == 'confirm'){
             $qrcode = $_GPC['codes'];
             if(empty($qrcode)){
                 wl_message('缺少重要参数，请重新扫描二维码', 'close');
                 }
             $item = pdo_get(PDO_NAME . 'merchantuser_qrlog', array('uniacid' => $_W['uniacid'], 'codes' => $qrcode));
             $itemtime = $item['createtime'] + 300;
             if (empty($item) || $itemtime < time() || $item['status'] == 1){
                 wl_message('二维码已过期，请重新扫描二维码', 'close');
                 }
             pdo_update(PDO_NAME . 'merchantuser_qrlog', array('memberid' => $_W['mid'], 'status' => 1), array('id' => $item['id']));
             wl_message('恭喜您，成为店铺管理员', 'close', 'success');
             }
         }
    
     public function applist(){
         global $_W, $_GPC;
         $this -> checkstoreid();
         $pagetitle = !empty($_W['wlsetting']['base']['name']) ? '营销 - ' . $_W['wlsetting']['base']['name'] : '营销';
        
         include wl_template('store/applist');
         }
    
    /**
     * 抢购管理
     */
     public function rush(){
         global $_W, $_GPC;
         $this -> checkstoreid();
         $pagetitle = !empty($_W['wlsetting']['base']['name']) ? '抢购管理 - ' . $_W['wlsetting']['base']['name'] : '抢购管理';
        
         $data = array();
         $data['status'] = empty($_GPC['status'])? '2':$_GPC['status'];
         $data['aid'] = $_W['aid'];
         $data['sid'] = $_W['storeid'];
         $activity = Rush :: getNumActive('*', $data, 'ID DESC', 0, 0, 0);
         $goods = $activity[0];
         foreach($goods as $key => & $value){
             $value['plugin'] = 'rush';
             $value['a'] = app_url('store/supervise/createGoodsStep3', array('id' => $value['id'], 'func' => 1));
             }
        
         include wl_template('store/rush');
         }
    
     public function get_rush_order(){
         global $_W, $_GPC;
         $pindex = $_GPC['pindex'];
         $type = $_GPC['type']?$_GPC['type']:'rush';
         $where = array('uniacid' => $_W['uniacid'], 'sid' => $_W['storeid']);
         if(!empty($_GPC['status'])){
             $where['status'] = intval($_GPC['status']);
             }
         if($type == 'rush'){
             $myorder = Rush :: getNumOrder('*', $where, 'ID DESC', $pindex, 10, 1);
             $myorder = $myorder[0];
             foreach ($myorder as $k => & $v){
                 $v['createtime'] = date('Y-m-d H:i:s', $v['createtime']);
                 }
             }else{
             $where['plugin'] = $type;
             $myorder = Util :: getNumData('price,createtime,fkid,mid,status', PDO_NAME . 'order', $where, 'ID DESC', $pindex, 10, 1);
             $myorder = $myorder[0];
             foreach ($myorder as $key => & $value){
                 if($type == 'coupon'){
                     $goods = wlCoupon :: getSingleCoupons($value['fkid'], 'title');
                     $value['gname'] = $goods['title'];
                     }
                 $member = pdo_get(PDO_NAME . 'member', array('id' => $value['mid'], 'uniacid' => $_W['uniacid']), array('nickname', 'mobile'));
                 $value['nickname'] = $member['nickname'];
                 $value['mobile'] = $member['mobile'];
                 $value['createtime'] = date('Y-m-d H:i:s', $value['createtime']);
                 }
             }
         die(json_encode(array('errno' => 0, 'data' => $myorder)));
         }
    
     public function get_fans(){
         global $_W, $_GPC;
         $pindex = $_GPC['pindex'];
         $where = array('uniacid' => $_W['uniacid'], 'sid' => $_W['storeid']);
         $myorder = Util :: getNumData(' mid ', PDO_NAME . 'storefans', $where, 'ID DESC', $pindex, 20, 1);
         $myorder = $myorder[0];
         foreach ($myorder as $k => & $v){
             $member = pdo_get(PDO_NAME . 'member', array('uniacid' => $_W['uniacid'], 'id' => $v['mid']), array('avatar', 'nickname', 'vipstatus'));
             $v['avatar'] = $member['avatar'];
             $v['nickname'] = $member['nickname'];
             if($member['vipstatus'] == 1){
                 $v['type'] = 'VIP';
                 }else{
                 $v['type'] = '普通';
                 }
             }
         die(json_encode(array('errno' => 0, 'data' => $myorder)));
         }
    
     public function cash(){
         global $_W, $_GPC;
         $this -> checkstoreid();
         $pagetitle = !empty($_W['wlsetting']['base']['name']) ? '申请结算 - ' . $_W['wlsetting']['base']['name'] : '申请结算';
        
         $_GPC['type'] = $_GPC['type']?$_GPC['type']:'apply';
         $orderType = $_GPC['orderType']?$_GPC['orderType']:'rush';
         if($orderType == 'rush')$type2 = 0;
         if($orderType == 'coupon')$type2 = 1;
        
        
        /**
         * 申请结算 S
         */
         $s = Util :: getSingelData('percent', PDO_NAME . 'merchantdata', array('id' => $_W['storeid']));
         if($_GPC['num'] > 0 && $_GPC['money'] > 0 && !empty($_GPC['ids'])){
             if(!empty($_GPC['ids']) && is_array($_GPC['ids'])){
                 $a = Util :: getSingelData('percent,cashopenid', PDO_NAME . 'agentusers', array('id' => $_W['aid']));
                 $p = !empty($a['percent'])?unserialize($a['percent']):array();
                 $data = array(
                    'ids' => serialize($_GPC['ids']),
                     'uniacid' => $_W['uniacid'],
                     'sid' => $_W['storeid'],
                     'aid' => $_W['aid'],
                     'status' => 1,
                     'type' => 1,
                     'ordernum' => $_GPC['num'],
                     'sapplymoney' => $_GPC['money'],
                     'applytime' => TIMESTAMP,
                     'updatetime' => TIMESTAMP,
                     'spercent' => $s['percent'],
                     'apercent' => $p['syssalepercent'],
                     'spercentmoney' => sprintf("%.2f", $s['percent'] * $_GPC['money'] / 100),
                     'type2' => $type2,
                     'sopenid' => $_W['openid'],
                     'aopenid' => $a['cashopenid']
                    );
                 if(pdo_insert(PDO_NAME . 'settlement_record', $data)){
                     if($orderType == 'rush'){
                         foreach($_GPC['ids'] as $key => $value){
                             pdo_update(PDO_NAME . 'rush_order', array('issettlement' => 1), array('id' => $value));
                             }
                         }
                     if($orderType == 'coupon'){
                         foreach($_GPC['ids'] as $key => $value){
                             pdo_update(PDO_NAME . 'order', array('issettlement' => 1), array('id' => $value));
                             }
                         }
                     die(json_encode(array('errno' => 0, 'num' => $_GPC['num'], 'percentMoney' => sprintf("%.2f", $s['percent'] * $_GPC['money']), 'money' => $_GPC['money'], 'message' => '申请成功！')));
                     }
                
                 }
             die(json_encode(array('errno' => 1, 'num' => $_GPC['num'], 'percentMoney' => sprintf("%.2f", $s['percent'] * $_GPC['money']), 'money' => $_GPC['money'], 'message' => '申请失败！')));
             }
        /**
         * 申请结算 E
         */
        
        
         if($_GPC['type'] == 'apply'){
             $psize = 0;
             if($_GPC['num']) $psize = $_GPC['num'];
             if($orderType == 'rush'){
                 $name = '抢购结算';
                 $where = array('uniacid' => $_W['uniacid'], 'sid' => $_W['storeid']);
                 $where['status'] = 2;
                 $where['issettlement'] = 0;
                 $myorder = Rush :: getNumOrder('id,price', $where, 'paytime asc', 1, $psize, 1);
                 }
             if($orderType == 'coupon'){
                 $name = '超级券结算';
                 $where = array('uniacid' => $_W['uniacid'], 'sid' => $_W['storeid']);
                 $where['status'] = 1;
                 $where['issettlement'] = 0;
                 $myorder = Util :: getNumData('id,price', PDO_NAME . 'order', $where, 'paytime asc', 1, $psize, 1);
                 }
             $myorder = $myorder[0];
             $money = 0;
             $num = 0;
             $ids = array();
             foreach ($myorder as $k => & $v){
                 $money += $v['price'];
                 $ids[$num] = $v['id'];
                 $num++;
                 }
             if($_GPC['num']) die(json_encode(array('errno' => 0, 'num' => $num, 'agetMoney' => sprintf("%.2f", $money - $s['percent'] * $money / 100), 'money' => $money, 'ids' => $ids))); //输入订单数量
             }
         if($_GPC['type'] == 'deling' || $_GPC['type'] == 'finish'){
             $where = array('uniacid' => $_W['uniacid'], 'sid' => $_W['storeid'], 'type' => 1);
             if($_GPC['type'] == 'deling') $where['#status#'] = '(1,2,3,4)';
             if($_GPC['type'] == 'finish') $where['status'] = 5;
             $recordData = Util :: getNumData('*', PDO_NAME . 'settlement_record', $where);
             $record = $recordData[0];
             }
         include wl_template('store/cash');
         }
    }
