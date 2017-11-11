<?php
class Message{
    static function paySuccess($openid, $price, $goodsname, $url){
        global $_W;
        $settings = Setting :: wlsetting_read('noticeMessage');
        $notice = unserialize($settings['notice']);
        $message = unserialize($settings['message']);
        if(!$notice['submitOrderSwitch'])return "未开启改模板消息";
        $postdata = array("first" => array("value" => "您已成功付款，请尽快去消费哦", "color" => "#173177"), "orderMoneySum" => array('value' => "￥ " . $price, "color" => "#173177"), "orderProductName" => array('value' => $goodsname, "color" => "#173177"), "remark" => array("value" => '点击可查看订单详情，如有疑问请联系客服。', "color" => "#173177"),);
        return sendtplnotice($openid, $notice['submitOrder'], $postdata, $url);
    }
    static function rushSuccess($openid, $orderid, $url){
        global $_W;
        $settings = Setting :: wlsetting_read('noticeMessage');
        $notice = unserialize($settings['notice']);
        $message = unserialize($settings['message']);
        if(!$notice['RushSuccessSwitch'])return "未开启改模板消息";
        $rushOrder = Rush :: getSingleOrder($orderid, 'sid,activityid,price,checkcode');
        $merchantName = Util :: idSwitch('sid', 'sName', $rushOrder['sid']);
        $goods = Rush :: getSingleActive($rushOrder['activityid'], 'name,cutofftime');
        $postdata = array("first" => array("value" => "恭喜您抢购成功，请尽快去消费哦", "color" => "#173177"), "keyword1" => array('value' => $merchantName, "color" => "#173177"), "keyword2" => array('value' => $goods['name'], "color" => "#173177"), "keyword3" => array('value' => "￥ " . $rushOrder['price'], "color" => "#173177"), "keyword4" => array('value' => " " . $rushOrder['checkcode'], "color" => "#173177"), "keyword5" => array('value' => " " . date('Y年m月d日', $goods['cutofftime']) . "前", "color" => "#173177"), "remark" => array("value" => '请在有效期内到店消费，欢迎您的到来，如有疑问请致电商家！', "color" => "#173177"));
        return sendtplnotice($openid, $notice['RushSuccess'], $postdata, $url);
    }
    static function beVip($openid, $orderid, $url){
        global $_W;
        $settings = Setting :: wlsetting_read('noticeMessage');
        $notice = unserialize($settings['notice']);
        $message = unserialize($settings['message']);
        if(!$notice['VipSwitch'])return "未开启改模板消息";
        $where['id'] = $orderid;
        $order = Util :: getSingelData('openid,limittime', 'wlmerchant_vip_record', $where);
        $where2['openid'] = $order['openid'];
        $member = Util :: getSingelData('id,areaid,nickname,mobile', 'wlmerchant_member', $where2);
        $order['limittime'] = date('Y年m月d日', $order['limittime']);
        $areaName = Util :: idSwitch('areaid', 'areaName', $member['areaid']);
        $postdata = array("first" => array("value" => "恭喜您成为我们的Vip用户", "color" => "#173177"), "cardNumber" => array('value' => "VIP - " . sprintf("%06d", $member['id']), "color" => "#173177"), "address" => array('value' => $areaName, "color" => "#173177"), "VIPName" => array('value' => $member['nickname'], "color" => "#173177"), "VIPPhone" => array('value' => $member['mobile'], "color" => "#173177"), "expDate" => array('value' => $order['limittime'], "color" => "#173177"), "remark" => array("value" => '恭喜您已成为' . $areaName . "地区VIP用户，到店享受VIP专享优惠！", "color" => "#173177"),);
        return sendtplnotice($openid, $notice['Vip'], $postdata, $url);
    }
    static function checkMessage($openid){
        global $_W;
        $settings = Setting :: wlsetting_read('noticeMessage');
        $notice = unserialize($settings['notice']);
        $message = unserialize($settings['message']);
        if(!$notice['MobileSwitch'])return "未开启改模板消息";
        $where2['openid'] = $openid;
        $member = Util :: getSingelData('nickname,mobile', 'wlmerchant_member', $where2);
        $postdata = array("first" => array("value" => "尊敬的" . $member['nickname'] . "用户，恭喜您绑定手机成功。", "color" => "#173177"), "keyword1" => array('value' => $member['mobile'], "color" => "#173177"), "keyword2" => array('value' => date('Y年m月d日', time()), "color" => "#173177"), "remark" => array("value" => '请知悉并确定这是您本人的操作。', "color" => "#173177"),);
        return sendtplnotice($openid, $notice['Mobile'], $postdata, '');
    }
    static function rushFollow($mid, $id){
        global $_W;
        $settings = Setting :: wlsetting_read('noticeMessage');
        $notice = unserialize($settings['notice']);
        $message = unserialize($settings['message']);
        if(!$notice['MobileSwitch'])return "未开启改模板消息";
        $where2['id'] = $mid;
        $member = Util :: getSingelData('nickname,openid', 'wlmerchant_member', $where2);
        $goods = Rush :: getSingleActive($id, "name,starttime");
        $accountname = pdo_fetchcolumn("SELECT name FROM " . tablename('account_wechats') . " WHERE `uniacid`=:uniacid LIMIT 1", array(':uniacid' => $_W['uniacid']));
        $url = app_url('rush/home/detail', array('id' => $id));
        $postdata = array("first" => array("value" => "您好，您关注的抢购即将开始。", "color" => "#173177"), "keyword1" => array('value' => $member['nickname'], "color" => "#173177"), "keyword2" => array('value' => $goods['name'], "color" => "#173177"), "keyword3" => array('value' => date('Y年m月d日 H:i:s', $goods['starttime']), "color" => "#173177"), "keyword4" => array('value' => $accountname, "color" => "#173177"), "remark" => array("value" => '点击立即参加抢购活动，赶快行动吧。', "color" => "#173177"),);
        return sendtplnotice($member['openid'], $notice['follow'], $postdata, $url);
    }
}
