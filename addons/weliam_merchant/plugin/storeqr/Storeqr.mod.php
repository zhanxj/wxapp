<?php
defined('IN_IA')or exit('Access Denied');
class Storeqr{
    static function creatstoreqr($qrctype = 2, $remark = '自动获取'){
        global $_W, $_GPC;
        load() -> func('communication');
        $barcode = array('expire_seconds' => '', 'action_name' => '', 'action_info' => array('scene' => array(),),);
        $qrcid = pdo_fetchcolumn("SELECT COUNT(id) FROM " . tablename(PDO_NAME . 'qrcode') . " WHERE uniacid = :uniacid AND model in(2,3) ", array(':uniacid' => $_W['uniacid']));
        $sstr = !empty($qrcid)? ($qrcid + 1): 1;
        if ($qrctype == 2){
            $uniacccount = WeAccount :: create($_W['acid']);
            $scene_str = 'STOREQR' . $sstr;
            $is_exist = pdo_fetchcolumn('SELECT id FROM ' . tablename('qrcode') . ' WHERE uniacid = :uniacid AND acid = :acid AND scene_str = :scene_str AND model = 2', array(':uniacid' => $_W['uniacid'], ':acid' => $_W['acid'], ':scene_str' => $scene_str));
            if(!empty($is_exist)){
                $scene_str = 'YJ' . date('md') . substr(time(), -5) . substr(microtime(), 2, 5) . sprintf('%02d', rand(0, 99));
            }
            $barcode['action_info']['scene']['scene_str'] = $scene_str;
            $barcode['action_name'] = 'QR_LIMIT_STR_SCENE';
            $result = $uniacccount -> barCodeCreateFixed($barcode);
        }
        if(!is_error($result)){
            $insert = array('uniacid' => $_W['uniacid'], 'acid' => $_W['acid'], 'qrcid' => $barcode['action_info']['scene']['scene_id'], 'scene_str' => $barcode['action_info']['scene']['scene_str'], 'keyword' => 'weliam_merchant_storeqr', 'name' => '智慧城市商户二维码', 'model' => $qrctype, 'ticket' => $result['ticket'], 'url' => $result['url'], 'expire' => $result['expire_seconds'], 'createtime' => TIMESTAMP, 'status' => '1', 'type' => 'scene',);
            pdo_insert('qrcode', $insert);
            $qrid = pdo_insertid();
            $qrinsert = array('uniacid' => $_W['uniacid'], 'aid' => $_W['aid'], 'qrid' => $qrid, 'model' => $qrctype, 'cardsn' => 'STOREQR-' . $sstr, 'salt' => random(8), 'createtime' => TIMESTAMP, 'status' => '1', 'remark' => $remark);
            pdo_insert(PDO_NAME . 'qrcode', $qrinsert);
            return array('result' => 1, 'qrid' => $qrid);
        }else{
            $success = "公众平台返回接口错误. <br />错误代码为: {$result['errorcode']} <br />错误信息为: {$result['message']}";
            return array('result' => 2, 'message' => $success);
        }
    }
    static function qr_createkeywords(){
        global $_W;
        $rid = pdo_fetchcolumn("select id from " . tablename('rule') . 'where uniacid=:uniacid and module=:module and name=:name', array(':uniacid' => $_W['uniacid'], ':module' => 'weliam_merchant', ':name' => "智慧城市商户二维码"));
        if (empty($rid)){
            $rule_data = array('uniacid' => $_W['uniacid'], 'name' => '智慧城市商户二维码', 'module' => 'weliam_merchant', 'displayorder' => 0, 'status' => 1);
            pdo_insert('rule', $rule_data);
            $rid = pdo_insertid();
            $keyword_data = array('uniacid' => $_W['uniacid'], 'rid' => $rid, 'module' => 'weliam_merchant', 'content' => 'weliam_merchant_storeqr', 'type' => 1, 'displayorder' => 0, 'status' => 1);
            pdo_insert('rule_keyword', $keyword_data);
        }
        return $rid;
    }
    static function check_qrcode($cardsn, $salt){
        global $_W;
        if(empty($cardsn) || empty($salt)){
            wl_message('二维码缺少关键参数，请联系管理员进行处理！', 'close');
        }
        $qrcode = pdo_get(PDO_NAME . 'qrcode', array('cardsn' => $cardsn, 'uniacid' => $_W['uniacid']));
        if(empty($qrcode) || $qrcode['salt'] != $salt){
            wl_message('二维码不存在或存在异常，请联系管理员进行处理！', 'close');
        }
        return $qrcode;
    }
    static function filter_url($params){
        global $_W;
        if(empty($params)){
            return '';
        }
        $query_arr = array();
        $parse = parse_url($_W['siteurl']);
        if(!empty($parse['query'])){
            $query = $parse['query'];
            parse_str($query, $query_arr);
        }
        $params = explode(',', $params);
        foreach($params as $val){
            if(!empty($val)){
                $data = explode(':', $val);
                $query_arr[$data[0]] = trim($data[1]);
            }
        }
        $query_arr['page'] = 1;
        $query = http_build_query($query_arr);
        return './agent.php?' . $query;
    }
    static function Processor($message){
        global $_W;
        if (strtolower($message['msgtype']) == 'event'){
            $returnmess = array();
            $qrid = self :: get_qrid($message);
            $data = self :: get_member($message, $qrid);
            $card = $data['card'];
            $storedata = $data['store'];
            $member = $data['member'];
            $base = Setting :: agentsetting_read('storeqr');
            if($card['status'] == 1){
                $returnmess[] = array('title' => urlencode("店铺快速入驻"), 'description' => '', 'picurl' => tomedia($base['enterfast']), 'url' => app_url('storeqr/bdstoreqr/enterfast', array('cardsn' => $card['cardsn'], 'salt' => $card['salt'], 'areaid' => $card['areaid'])));
                if($member['storeid']){
                    $returnmess[] = array('title' => urlencode("店铺二维码绑定"), 'description' => '', 'picurl' => tomedia($base['binding']), 'url' => app_url('storeqr/bdstoreqr/binding', array('cardsn' => $card['cardsn'], 'salt' => $card['salt'], 'areaid' => $card['areaid'])));
                }
                self :: send_news($returnmess, $message);
            }
            if($card['status'] == 2){
                $returnmess[] = array('title' => urlencode($storedata['storename']), 'description' => urlencode($storedata['address']), 'picurl' => tomedia($storedata['logo']), 'url' => app_url('store/merchant/detail', array('id' => $storedata['id'])));
                self :: send_news($returnmess, $message);
            }
            if($card['status'] == 3){
                self :: send_text('抱歉，此二维码已失效！', $message);
            }
        }
    }
    static function get_qrid($message){
        global $_W;
        if(!empty($message['ticket'])){
            if (is_numeric($message['scene'])){
                $qrid = pdo_fetchcolumn('select id from ' . tablename('qrcode') . ' where uniacid=:uniacid and qrcid=:qrcid', array(':uniacid' => $_W['uniacid'], ':qrcid' => $message['scene']));
            }else{
                $qrid = pdo_fetchcolumn('select id from ' . tablename('qrcode') . ' where uniacid=:uniacid and scene_str=:scene_str', array(':uniacid' => $_W['uniacid'], ':scene_str' => $message['scene']));
            }
            if($message['event'] == 'subscribe'){
                self :: qr_log($qrid, $message['from'], 1);
            }else{
                self :: qr_log($qrid, $message['from'], 2);
            }
        }else{
            self :: send_text('欢迎关注我们!', $message);
        }
        return $qrid;
    }
    static function get_member($message, $qrid){
        global $_W;
        $card = pdo_get(PDO_NAME . 'qrcode', array('uniacid' => $_W['uniacid'], 'qrid' => $qrid));
        $card['areaid'] = pdo_getcolumn(PDO_NAME . 'oparea', array('uniacid' => $_W['uniacid'], 'aid' => $card['aid']), 'areaid');
        $_W['aid'] = $card['aid'];
        $member = pdo_get(PDO_NAME . 'member', array('uniacid' => $_W['uniacid'], 'openid' => $message['from']), array('id'));
        if(empty($member['id'])){
            $member = array('uniacid' => $_W['uniacid'], 'openid' => $message['from'], 'createtime' => time());
            pdo_insert(PDO_NAME . 'member', $member);
            $member['id'] = pdo_insertid();
        }
        $member['storeid'] = pdo_getcolumn(PDO_NAME . 'merchantuser', array('uniacid' => $_W['uniacid'], 'aid' => $card['aid'], 'mid' => $member['id'], 'status' => 2, 'enabled' => 1), 'storeid');
        if($card['sid']){
            $storedata = pdo_get(PDO_NAME . 'merchantdata', array('uniacid' => $_W['uniacid'], 'id' => $card['sid']), array('id', 'storename', 'logo', 'address'));
            $fansst = pdo_getcolumn(PDO_NAME . 'storefans', array('uniacid' => $_W['uniacid'], 'sid' => $storedata['id'], 'mid' => $member['id']), 'id');
            if(empty($fansst)){
                pdo_insert(PDO_NAME . 'storefans', array('uniacid' => $_W['uniacid'], 'sid' => $storedata['id'], 'mid' => $member['id'], 'source' => 3, 'createtime' => time()));
                self :: send_text('恭喜您成为' . $storedata['storename'] . "的粉丝", $message, 2);
            }
        }
        return array('card' => $card, 'store' => $storedata, 'member' => $member);
    }
    static function qr_log($qrid, $openid, $type){
        global $_W;
        if(empty($qrid) || empty($openid)){
            return;
        }
        $qrcode = pdo_get('qrcode', array('id' => $qrid), array('scene_str', 'name'));
        $log = array('uniacid' => $_W['uniacid'], 'acid' => $_W['acid'], 'qid' => $qrid, 'openid' => $openid, 'type' => $type, 'scene_str' => $qrcode['scene_str'], 'name' => $qrcode['name'], 'createtime' => time());
        pdo_insert('qrcode_stat', $log);
    }
    static function send_news($returnmess, $message, $end = 1){
        global $_W;
        $send['touser'] = $message['from'];
        $send['msgtype'] = 'news';
        $send['news']['articles'] = $returnmess;
        $acc = WeAccount :: create($_W['acid']);
        $data = $acc -> sendCustomNotice($send);
        if(is_error($data)){
            self :: salerEmpty();
        }else{
            if($end == 1){
                self :: salerEmpty();
            }
        }
    }
    static function send_text($mess, $message, $end = 1){
        global $_W;
        $send['touser'] = $message['from'];
        $send['msgtype'] = 'text';
        $send['text'] = array('content' => urlencode($mess));
        $acc = WeAccount :: create($_W['acid']);
        $data = $acc -> sendCustomNotice($send);
        if(is_error($data)){
            self :: salerEmpty();
        }else{
            if($end == 1){
                self :: salerEmpty();
            }
        }
    }
    static function salerEmpty(){
        ob_clean();
        ob_start();
        echo '';
        ob_flush();
        ob_end_flush();
        exit(0);
    }
}
?>