<?php
 class wlPay{
    static function createVipOrder($monthNum){
        global $_W;
        $type = Util :: getSingelData("*", PDO_NAME . 'member_type', array('id' => $monthNum));
        $vipSet = Setting :: wlsetting_read('member_vip_price');
        $num = $type['price'];
        $num2 = $type['days'] / 30;
        $vipInfo = Util :: getSingelData('*', PDO_NAME . "member", array('uniacid' => $_W['uniacid'], 'id' => $_W['mid']));
        $lastviptime = Member :: vip($vipInfo['id']);
        if($lastviptime){
            $limittime = $lastviptime + $num2 * 30 * 24 * 60 * 60;
            $vipleveltime = floor($limittime / 24 * 60 * 60);
        }else{
            $limittime = time() + $num2 * 30 * 24 * 60 * 60;
            $vipleveltime = $num2 * 30;
        }
        $aid = Util :: idSwitch('areaid', 'aid', $_W['areaid']);
        $data = array('aid' => $aid, 'uid' => $vipInfo['uid'], 'uniacid' => $_W['uniacid'], 'unionid' => $_W['unionid'], 'mid' => $_W['mid'], 'openid' => $_W['openid'], 'areaid' => $_W['areaid'], 'orderno' => "VIP_" . createUniontid(), 'status' => 0, 'createtime' => TIMESTAMP, 'price' => $num, 'limittime' => $limittime, 'howlong' => $type['days']);
        pdo_insert(PDO_NAME . 'vip_record', $data);
        return pdo_insertid();
    }
    static function getCash($paytype, $orderno, $name, $price, $payfor, $plugin, $done = ''){
        global $_W;
        load() -> func('communication');
        load() -> model('payment');
        load() -> model('mc');
        $moduels = uni_modules();
        $plugins = getAllPluginsName();
        if(empty($orderno))wl_message(array('errno' => 1, 'message' => "参数错误，缺少订单号."));
        if($price <= 0)wl_message(array('errno' => 1, 'message' => "支付金额错误,支付金额需大于0元."));
        $params['tid'] = $orderno;
        $params['user'] = $_W['openid'];
        $params['fee'] = $price;
        $params['title'] = $name;
        $params['ordersn'] = $orderno;
        $params['module'] = "weliam_merchant";
        $params['plugin'] = $plugin;
        $params['payfor'] = $payfor;
        if(!array_key_exists($params['module'], $moduels))wl_message('模块不存在.');
        if(!in_array($params['plugin'], $plugins))wl_message($plugin . '插件不存在.');
        $pars = array();
        $pars['uniacid'] = $_W['uniacid'];
        $pars['module'] = $params['module'];
        $pars['plugin'] = $params['plugin'];
        $pars['tid'] = $params['tid'];
        $log = pdo_get(PDO_NAME . 'paylog', $pars);
        if($done == 1){
            if(empty($log))wl_debug("log empty!");
            if (!empty($log['tag'])){
                $tag = iunserializer($log['tag']);
                $log['uid'] = $tag['uid'];
            }
            $ret = array();
            $ret['weid'] = $log['uniacid'];
            $ret['uniacid'] = $log['uniacid'];
            $ret['result'] = 'success';
            $ret['type'] = $log['type'];
            $ret['from'] = 'return';
            $ret['tid'] = $log['tid'];
            $ret['uniontid'] = $log['uniontid'];
            $ret['user'] = $log['openid'];
            $ret['fee'] = $log['fee'];
            $ret['tag'] = $tag;
            $ret['is_usecard'] = $log['is_usecard'];
            $ret['card_type'] = $log['card_type'];
            $ret['card_fee'] = $log['card_fee'];
            $ret['card_id'] = $log['card_id'];
            $className = $log['plugin'];
            $functionName = 'pay' . $log['payfor'] . 'Return';
            exit($className :: $functionName($ret));
        }
        $dos = array();
        $setting = uni_setting($_W['uniacid'], array('payment', 'creditbehaviors'));
        if(!is_array($setting['payment']))wl_message(array('errno' => 1, 'message' => "没有有效的支付方式, 请联系网站管理员."));
        if(!empty($setting['payment']['credit']['switch']))$dos[] = 'credit';
        if(!empty($setting['payment']['alipay']['switch']))$dos[] = 'alipay';
        if(!empty($setting['payment']['wechat']['switch']))$dos[] = 'wechat';
        $type = in_array($paytype, $dos)? $paytype : '';
        if(empty($type))wl_message(array('errno' => 1, 'message' => "支付方式错误,请联系商家"));
        $data = array('uniacid' => $_W['uniacid'], 'acid' => $_W['acid'], 'openid' => $_W['openid'], 'module' => $params['module'], 'plugin' => $params['plugin'], 'payfor' => $params['payfor'], 'tid' => $params['tid'], 'fee' => $params['fee'], 'card_fee' => $params['fee'], 'status' => '0', 'is_usecard' => '0', 'type' => $type);
        if (empty($log))pdo_insert(PDO_NAME . 'paylog', $data);
        $log = pdo_get(PDO_NAME . 'paylog', $pars);
        if(!empty($log) && $type != 'credit' && $log['status'] != '0')wl_message(array('errno' => 1, 'message' => "这个订单已经支付(已取消支付)成功！"));
        $uniontid = createUniontid();
        pdo_update(PDO_NAME . 'paylog', array('type' => $type, 'uniontid' => $uniontid), array('plid' => $log['plid']));
        $log = pdo_get(PDO_NAME . 'paylog', $pars);
        if($type == 'wechat'){
            $wechat = $setting['payment']['wechat'];
            $row = pdo_fetch('SELECT `key`,`secret` FROM ' . tablename('account_wechats') . ' WHERE `acid`=:acid', array(':acid' => $wechat['account']));
            $wechat['appid'] = $row['key'];
            $wechat['secret'] = $row['secret'];
            $params = array('tid' => $log['tid'], 'fee' => $log['card_fee'], 'user' => $log['openid'], 'title' => $params['title'], 'uniontid' => $log['uniontid'],);
            $notify_url = MODULE_URL . 'payment/wechat/weixin_notify.php';
            $wOpt = PayBuild :: wechat_build($params, $wechat, $notify_url);
            if (is_error($wOpt)){
                if ($wOpt['message'] == 'invalid out_trade_no' || $wOpt['message'] == 'OUT_TRADE_NO_USED'){
                    $id = date('YmdH');
                    pdo_update(PDO_NAME . 'paylog', array('plid' => $id), array('plid' => $log['plid']));
                    pdo_query('ALTER TABLE ' . tablename(PDO_NAME . 'paylog') . ' auto_increment = ' . ($id + 1) . ";");
                    wl_message(array('errno' => 1, 'message' => '抱歉，发起支付失败，系统已经修复此问题，请重新尝试支付。'));
                }
                wl_message(array('errno' => 1, 'message' => "抱歉，发起支付失败，具体原因为：“{$wOpt['errno']}:{$wOpt['message']}”。请及时联系站点管理员。"));
            }
            die(json_encode(array('errno' => 0, 'message' => '支付成功!', 'data' => $wOpt)));
        }
        if($type == 'credit'){
            $uid = mc_openid2uid($_W['openid']);
            if (empty($uid)){
                $setting['payment']['credit']['switch'] = false;
                wl_message(array('errno' => 1, 'message' => '微擎余额未开启.'));
            }
            if ($setting['payment']['credit']['switch'])$credtis = mc_credit_fetch($uid);
            if(!empty($log) && empty($log['status'])){
                if($credtis['credit2'] < $log['fee'])wl_message(array('errno' => 1, 'message' => "余额不足以支付, 需要 {$log['fee']}, 当前 {$credtis['credit2']}."));
                $result = Member :: credit_update_credit2($uid, 0 - $log['fee'], 1, $name);
                if (!$result)wl_message(array('errno' => 1, 'message' => "余额支付错误."));
                if(pdo_update(PDO_NAME . 'paylog', array('status' => '1'), array('plid' => $log['plid']))){
                    $className = $log['plugin'];
                    $ret = array();
                    $ret['weid'] = $log['uniacid'];
                    $ret['uniacid'] = $log['uniacid'];
                    $ret['result'] = 'success';
                    $ret['type'] = $log['type'];
                    $ret['from'] = 'return';
                    $ret['tid'] = $log['tid'];
                    $ret['uniontid'] = $log['uniontid'];
                    $ret['user'] = $log['openid'];
                    $ret['fee'] = $log['fee'];
                    $ret['tag'] = $tag;
                    $ret['is_usecard'] = $log['is_usecard'];
                    $ret['card_type'] = $log['card_type'];
                    $ret['card_fee'] = $log['card_fee'];
                    $ret['card_id'] = $log['card_id'];
                    $functionName = 'pay' . $log['payfor'] . 'Notify';
                    $functionName2 = 'pay' . $log['payfor'] . 'Return';
                    $className :: $functionName($ret);
                    die(json_encode(array('errno' => 0, 'message' => '支付成功!', 'data' => $backurl)));
                }
            }
        }
    }
    static function refundMoney($id, $money, $remark, $plugin, $type = 3){
        global $_W;
        $refund = FALSE;
        $pluginArray = array('rush', 'vip', 'coupon', 'merchant');
        switch($plugin){
        case 'rush':$orderinfo = Rush :: getSingleOrder($id, '*');
            break;
        default:break;
        }
        $refundRecord = array('sid' => $orderinfo['sid'], 'transid' => $orderinfo['transid'], 'createtime' => TIMESTAMP, 'status' => 0, 'type' => $type, 'orderid' => $id, 'payfee' => $orderinfo['price'], 'refundfee' => $money, 'uniacid' => $orderinfo['uniacid'], 'remark' => $remark, 'plugin' => $plugin);
        pdo_insert(PDO_NAME . 'refund_record', $refundRecord);
        if(!in_array($plugin, $pluginArray)){
        pdo_update(PDO_NAME . 'refund_record', array('errmsg' => '退款订单插件' . $plugin . '错误'), array('orderid' => $orderinfo['id']));
        return array('1', '退款订单插件' . $plugin . '错误');
    }
    if($money <= 0 || $orderinfo['price'] <= 0){
        pdo_update(PDO_NAME . 'refund_record', array('errmsg' => '退款金额小于0'), array('orderid' => $orderinfo['id']));
        return array('2', '退款金额小于0');
    }
    if(empty($orderinfo['transid']) && $orderinfo['paytype'] == 2){
        pdo_update(PDO_NAME . 'refund_record', array('errmsg' => '无微信订单号'), array('orderid' => $orderinfo['id']));
        return array('3', '微信订单无微信订单号');
    }
    if($orderinfo['paytype'] == 1){
    }
    if($orderinfo['paytype'] == 2){
        $pay = new WeixinPay;
        $arr = array('transid' => $orderinfo['transid'], 'totalmoney' => $orderinfo['price'], 'refundmoney' => $money);
        $data = $pay -> refund($arr);
        if($data['refund_id'] && $data['return_code'] == 'SUCCESS'){
            $refund = TRUE;
            pdo_update(PDO_NAME . 'refund_record', array('status' => 1, 'refund_id' => $data['refund_id']), array('orderid' => $orderinfo['id']));
            pdo_update(PDO_NAME . 'rush_order', array('status' => 7), array('id' => $orderinfo['id']));
            SingleMerchant :: updateAmount(0 - $orderinfo['price'], $orderinfo['sid'], $orderinfo['id'], 1, '退款：订单号' . $orderinfo['orderno']);
            Util :: wl_log('refundSuccess', PATH_DATA . $plugin . "/data/log/", $orderinfo);
        }else{
            pdo_update(PDO_NAME . 'refund_record', array('errmsg' => $data['err_code_des']), array('orderid' => $orderinfo['id']));
            $errMsg = $data['err_code_des'];
            Util :: wl_log('refundFail', PATH_DATA . $plugin . "/data/log/", $orderinfo);
        }
    }
    if($refund){
        $res['status'] = true;
        $res['message'] = '退款成功';
    }else{
        $res['status'] = false;
        $res['message'] = $errMsg;
    }
    return $res;
}
static function finance($openid = '', $money = 0, $desc = ''){
    global $_W;
    $pay = new WeixinPay;
    $arr = $pay -> finance($openid, $money, $desc);
    return $arr;
}
}
