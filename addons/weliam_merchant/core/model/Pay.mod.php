<?php
 class Pay{
    static function createVipOrder(){
        global $_W;
        $activity = self :: getSingleActive($id, '*');
        $random = Util :: createSalt();
        $vipInfo = Util :: getSingelData('*', PDO_NAME . "member", array('uniacid' => $_W['uniacid'], 'mid' => $_W['mid']));
        $data = array('uid' => $vipInfo['uid'], 'uniacid' => $_W['uniacid'], 'unionid' => $_W['unionid'], 'mid' => $_W['mid'], 'openid' => $_W['openid'], 'areaid' => $_W['areaid'], 'orderno' => "VIP_" . createUniontid(), 'status' => 0, 'createtime' => TIMESTAMP, 'price' => $activity['price']);
        pdo_insert(PDO_NAME . 'vip_record', $data);
        return pdo_insertid();
    }
    static function getCash($paytype, $orderno, $name, $price, $plugin, $done = ''){
        global $_W;
        load() -> func('communication');
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
        if(!array_key_exists($params['module'], $moduels))wl_message('模块不存在.');
        if(!in_array($params['plugin'], $plugins))wl_message('插件不存在.');
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
            exit(self :: payReturn($ret));
        }
        if ($_W['isajax']){
            $dos = array();
            $setting = uni_setting($_W['uniacid'], array('payment', 'creditbehaviors'));
            if(!is_array($setting['payment']))wl_message(array('errno' => 1, 'message' => "没有有效的支付方式, 请联系网站管理员."));
            if(!empty($setting['payment']['credit']['switch']))$dos[] = 'credit';
            if(!empty($setting['payment']['alipay']['switch']))$dos[] = 'alipay';
            if(!empty($setting['payment']['wechat']['switch']))$dos[] = 'wechat';
            $type = in_array($paytype, $dos)? $paytype : '';
            if(empty($type))wl_message(array('errno' => 1, 'message' => "支付方式错误,请联系商家"));
            $data = array('uniacid' => $order['uniacid'], 'acid' => $_W['acid'], 'openid' => $_W['openid'], 'module' => $params['module'], 'plugin' => $params['plugin'], 'tid' => $params['tid'], 'fee' => $params['fee'], 'card_fee' => $params['fee'], 'status' => '0', 'is_usecard' => '0', 'type' => $type);
            if (empty($log))pdo_insert(PDO_NAME . 'paylog', $data);
            $log = pdo_get(PDO_NAME . 'paylog', $pars);
            if(!empty($log) && $type != 'credit' && $log['status'] != '0')wl_message(array('errno' => 1, 'message' => "这个订单已经支付成功, 不需要重复支付!"));
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
            }
            die(json_encode(array('errno' => 0, 'message' => '支付成功!', 'data' => $wOpt)));
        }
    }
}
