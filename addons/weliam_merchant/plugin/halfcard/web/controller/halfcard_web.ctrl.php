<?php
defined('IN_IA')or exit('Access Denied');
class halfcard_web{
    function halfcardList(){
        global $_W, $_GPC;
        $pindex = max(1, intval($_GPC['page']));
        $psize = 10;
        $data = array();
        $data['uniacid'] = $_W['uniacid'];
        $data['aid'] = $_W['aid'];
        $sel1 = array(array('id' => 1, 'name' => '按星期'), array('id' => 2, 'name' => '五折标题'), array('id' => 3, 'name' => '按月天数'), array('id' => 4, 'name' => '按平日折扣'));
        $sel2 = array(1 => array(array('id' => 1, 'name' => '星期一'), array('id' => 2, 'name' => '星期二'), array('id' => 3, 'name' => '星期三'), array('id' => 4, 'name' => '星期四'), array('id' => 5, 'name' => '星期五'), array('id' => 6, 'name' => '星期六'), array('id' => 7, 'name' => '星期天')), 4 => array(array('id' => 1, 'name' => '有平时折扣'), array('id' => 2, 'name' => '无平时折扣')));
        if ($_GPC['sel']['parentid'] == 1){
            $flag1 = intval($_GPC['sel']['childid']);
            $data['datestatus'] = 1;
            $data['week@'] = '"' . $flag1 . '"';
        }
        if ($_GPC['sel']['parentid'] == 2){
            $keyword = trim($_GPC['keyword']);
            $data['title@'] = $keyword;
        }
        if ($_GPC['sel']['parentid'] == 3){
            $keyword = intval($_GPC['keyword']);
            $data['datestatus'] = 2;
            $data['day@'] = '"' . $keyword . '"';
        }
        if ($_GPC['sel']['parentid'] == 4){
            $daily = intval($_GPC['sel']['childid']);
            if($daily == 1){
                $data['daily'] = 1;
            }else{
                $data['daily'] = 0;
            }
        }
        $halfcard = Halfcard :: getNumActive('*', $data, 'ID DESC', $pindex, $psize, 1);
        $pager = $halfcard[1];
        $halfcard = $halfcard[0];
        foreach ($halfcard as $key => & $value){
            $detail = pdo_fetch("select * from " . tablename('wlmerchant_merchantdata') . " where uniacid={$_W['uniacid']} and id={$value['merchantid']}");
            if ($value['datestatus'] == 1){
                $value['week'] = unserialize($value['week']);
            }else{
                $value['day'] = unserialize($value['day']);
            }
            $halfcard[$key]['logo'] = $detail['logo'];
            $halfcard[$key]['storename'] = $detail['storename'];
        }
        include wl_template('halfcard/halfcard_list');
    }
    function createHalfcard(){
        global $_W, $_GPC;
        if (checksubmit('submit')){
            $halfcard = $_GPC['halfcard'];
            $halfcard['datestatus'] = $_GPC['datestatus'];
            $halfcard['createtime'] = time();
            if ($halfcard['status'] == 'on'){
                $halfcard['status'] = 1;
            }else{
                $halfcard['status'] = 0;
            }
            if ($halfcard['daily'] == 'on'){
                $halfcard['daily'] = 1;
            }else{
                $halfcard['daily'] = 0;
            }
            $halfcard['adv'] = serialize($halfcard['adv']);
            if ($halfcard['datestatus'] == 1){
                $halfcard['week'] = serialize($halfcard['week']);
                $halfcard['day'] = '';
            }
            if ($halfcard['datestatus'] == 2){
                $halfcard['day'] = serialize($halfcard['day']);
                $halfcard['week'] = '';
            }
            $halfcard['discount'] = round($halfcard['discount'], 1);
            $halfcard['detail'] = htmlspecialchars_decode($halfcard['detail']);
            $res = Halfcard :: saveHalfcard($halfcard);
            if ($res){
                wl_message('创建五折优惠成功', web_url('halfcard/halfcard_web/halfcardList'), 'success');
            }else{
                wl_message('创建五折优惠失败', referer(), 'success');
            }
        }
        include wl_template('halfcard/create_halfcard');
    }
    function deleteHalfcard(){
        global $_W, $_GPC;
        $id = $_GPC['id'];
        $ids = $_GPC['ids'];
        if ($id){
            $res = Halfcard :: deleteHalfcard(array('id' => $id));
            if ($res){
                die(json_encode(array('errno' => 0, 'message' => $res, 'id' => $id)));
            }else{
                die(json_encode(array('errno' => 2, 'message' => $res, 'id' => $id)));
            }
        }
        if ($ids){
            foreach ($ids as $key => $id){
                Halfcard :: deleteHalfcard(array('id' => $id));
            }
            die(json_encode(array('errno' => 0, 'message' => '', 'id' => '')));
        }
    }
    function deleteHalfcardRecord(){
        global $_W, $_GPC;
        $id = $_GPC['id'];
        $ids = $_GPC['ids'];
        if ($id){
            $res = Halfcard :: deleteHalfcardRecord(array('id' => $id));
            if ($res){
                die(json_encode(array('errno' => 0, 'message' => $res, 'id' => $id)));
            }else{
                die(json_encode(array('errno' => 2, 'message' => $res, 'id' => $id)));
            }
        }
        if ($ids){
            foreach ($ids as $key => $id){
                Halfcard :: deleteHalfcardRecord(array('id' => $id));
            }
            die(json_encode(array('errno' => 0, 'message' => '', 'id' => $ids)));
        }
    }
    function inspect(){
        global $_W, $_GPC;
        $id = $_GPC['id'];
        $res = pdo_get('wlmerchant_halfcardlist', array('merchantid' => $id), array('id'));
        if ($res){
            die(json_encode(array('errno' => 1, 'message' => $id)));
        }else{
            die(json_encode(array('errno' => 0, 'message' => $id)));
        }
    }
    function editHalfcard(){
        global $_W, $_GPC;
        $id = $_GPC['id'];
        $halfcard = Halfcard :: getSingleHalfcard($_GPC['id'], '*');
        $storename = pdo_get('wlmerchant_merchantdata', array('id' => $halfcard['merchantid']));
        $halfcard['storename'] = $storename['storename'];
        $halfcard['logo'] = $storename['logo'];
        $halfcard['adv'] = unserialize($halfcard['adv']);
        if ($halfcard['datestatus'] == 1){
            $halfcard['week'] = unserialize($halfcard['week']);
        }
        if ($halfcard['datestatus'] == 2){
            $halfcard['day'] = unserialize($halfcard['day']);
        }
        if (checksubmit('submit')){
            $halfcard = $_GPC['halfcard'];
            if ($halfcard['status'] == 'on'){
                $halfcard['status'] = 1;
            }else{
                $halfcard['status'] = 0;
            }
            if ($halfcard['daily'] == 'on'){
                $halfcard['daily'] = 1;
            }else{
                $halfcard['daily'] = 0;
            }
            $halfcard['datestatus'] = $_GPC['datestatus'];
            $halfcard['adv'] = serialize($halfcard['adv']);
            if ($halfcard['datestatus'] == 1){
                $halfcard['week'] = serialize($halfcard['week']);
                $halfcard['day'] = '';
            }
            if ($halfcard['datestatus'] == 2){
                $halfcard['day'] = serialize($halfcard['day']);
                $halfcard['week'] = '';
            }
            $halfcard['discount'] = round($halfcard['discount'], 1);
            $halfcard['detail'] = htmlspecialchars_decode($halfcard['detail']);
            $res = Halfcard :: updateHalfcard($halfcard, array('id' => $id));
            if ($res){
                wl_message('更新五折卡成功', web_url('halfcard/halfcard_web/halfcardList'), 'success');
            }else{
                wl_message('更新五折卡失败', referer(), 'success');
            }
        }
        include wl_template('halfcard/create_halfcard');
    }
    function userhalfcardlist(){
        global $_W, $_GPC;
        $keyword = trim($_GPC['keyword']);
        $pindex = max(1, intval($_GPC['page']));
        $psize = 10;
        $data = array();
        $data['uniacid'] = $_W['uniacid'];
        $data['aid'] = $_W['aid'];
        if (!empty($_GPC['title']) && !empty($_GPC['sel']['childid'])){
            $where .= " AND title = :title";
            $params[':title'] = $_GPC['title'];
        }
        $sel1 = array(array('id' => 1, 'name' => '五折卡信息'), array('id' => 2, 'name' => '商户信息'), array('id' => 3, 'name' => '用户信息'),);
        $sel2 = array();
        if (empty($_GPC['sel']['parentid'])){
            $halfcard = Halfcard :: getNumActive1('*', $data, 'ID DESC', $pindex, $psize, 1);
            $pager = $halfcard[1];
            $halfcard = $halfcard[0];
        }
        if ($_GPC['sel']['parentid'] == 1){
            $where .= " AND title LIKE :title";
            $params[':title'] = "%{$keyword}%";
            $halfcard = pdo_fetch("SELECT * FROM " . tablename('wlmerchant_halfcardlist') . " where uniacid= {$_W['uniacid']} and aid={$_W['aid']} $where", $params);
            $data['activeid'] = $halfcard['id'];
        }
        if ($_GPC['sel']['parentid'] == 2){
            $where .= " AND storename LIKE :storename";
            $params[':storename'] = "%{$keyword}%";
            $halfcard = pdo_fetch("SELECT * FROM " . tablename('wlmerchant_merchantdata') . " where uniacid= {$_W['uniacid']} and aid={$_W['aid']} $where", $params);
            $data['merchantid'] = $halfcard['id'];
        }
        if ($_GPC['sel']['parentid'] == 3){
            $where .= " AND nickname LIKE :nickname";
            $params[':nickname'] = "%{$keyword}%";
            $halfcard = pdo_fetch("SELECT * FROM " . tablename('wlmerchant_member') . " where uniacid= {$_W['uniacid']} and aid={$_W['aid']} $where", $params);
            $data['mid'] = $halfcard['mid'];
        }
        if (!empty($_GPC['id'])){
            $data['activeid'] = $_GPC['id'];
        }
        $halfcard = Halfcard :: getNumActive1('*', $data, 'ID DESC', $pindex, $psize, 1);
        $pager = $halfcard[1];
        $halfcard = $halfcard[0];
        foreach ($halfcard as $key => & $v){
            $active = pdo_get('wlmerchant_halfcardlist', array('id' => $v['activeid']));
            $v['title'] = $active['title'];
            $merchant = pdo_get('wlmerchant_merchantdata', array('id' => $v['merchantid']));
            $v['storename'] = $merchant['storename'];
            $v['logo'] = $merchant['logo'];
            $member = pdo_get('wlmerchant_member', array('id' => $v['mid'], 'uniacid' => $_W['uniacid']));
            $v['avatar'] = $member['avatar'];
            $v['nickname'] = $member['nickname'];
            $v['mobile'] = $member['mobile'];
        }
        include wl_template('halfcard/userHalfcardList');
    }
    function qrcodeimg(){
        global $_W, $_GPC;
        $url = $_GPC['url'];
        m('qrcode/QRcode') -> png($url, false, QR_ECLEVEL_H, 4);
    }
    function entry(){
        global $_W, $_GPC;
        $set['url'] = app_url('halfcard/halfcard_app/halfcardList');
        include wl_template('halfcard/entry');
    }
    function open(){
        global $_W, $_GPC;
        $set['url'] = app_url('halfcard/halfcardopen/open');
        include wl_template('halfcard/entry');
    }
    function base(){
        global $_W, $_GPC;
        $allow = 0;
        $_GPC['postType'] = $_GPC['postType']?$_GPC['postType'] :'setting';
        $base = Setting :: agentsetting_read('halfcard');
        $base['qa'] = unserialize($base['qanda']);
        $base['hcprice'] = unserialize($base['hcprice']);
        $settings = Setting :: wlsetting_read('halfcard');
        if($settings['halfcardtype'] == 1 && $settings['halfstatus'] == 1)$allow = 1;
        if($_GPC['postType'] == 'setting'){
            if (checksubmit('submit')){
                $question = $_GPC['question'];
                $answer = $_GPC['answer'];
                $len = count($question);
                $tag = array();
                for ($k = 0;$k < $len;$k++){
                    $tag[$k]['question'] = $question[$k];
                    $tag[$k]['answer'] = $answer[$k];
                }
                $base = $_GPC['base'];
                $base['qanda'] = serialize($tag);
                $hcname = $_GPC['hcname'];
                $howlong = $_GPC['howlong'];
                $hcprice = $_GPC['hcprice'];
                $len2 = count($hcname);
                $tag2 = array();
                for ($k = 0;$k < $len2;$k++){
                    $tag2[$k]['hcname'] = $hcname[$k];
                    $tag2[$k]['howlong'] = $howlong[$k];
                    $tag2[$k]['hcprice'] = $hcprice[$k];
                }
                $base['hcprice'] = serialize($tag2);
                $res1 = Setting :: agentsetting_save($base, 'halfcard');
                if ($res1){
                    wl_message('保存设置成功！', referer(), 'success');
                }else{
                    wl_message('保存设置失败！', referer(), 'error');
                }
            }
        }
        if($_GPC['postType'] == 'list'){
            $listData = Util :: getNumData("*", PDO_NAME . 'halfcard_type', array('aid' => $_W['aid']));
            $types = $listData[0];
            $where = array('tokentype' => 2, 'aid' => $_W['aid']);
            if($_GPC['vipType'])$where['type'] = $_GPC['vipType'];
            if($_GPC['status']){
                if($_GPC['status'] == 1)$where['status'] = 1;
                if($_GPC['status'] == 2)$where['status'] = 0;
            }
            if (!empty($_GPC['keyword'])){
                if(!empty($_GPC['keywordtype'])){
                    switch($_GPC['keywordtype']){
                    case 1: $where['days'] = $_GPC['keyword'];
                        break;
                    case 2: $member = Util :: getSingelData("id", PDO_NAME . 'member', array('@nickname@' => $_GPC['keyword']));
                        if($member)$where['mid'] = $member['id'];
                    case 3: $where['@remark@'] = $_GPC['keyword'];
                        break;
                    default:break;
                    }
                }
            }
            $pindex = max(1, $_GPC['page']);
            $listData = Util :: getNumData("*", PDO_NAME . 'token', $where, 'type desc', $pindex, 20, 1);
            $list = $listData[0];
            $pager = $listData[1];
            foreach($list as$key => & $value){
                if(!empty($value['mid']))$value['member'] = Member :: getMemberByMid($value['mid']);
                if(!empty($value['aid']))$value['aName'] = Util :: idSwitch('aid', 'aName', $value['aid']);
            }
        }
        if($_GPC['postType'] == 'add'){
            $where = array();
            if($_GPC['applyid']){
                $apply = Util :: getSingelData("*", PDO_NAME . 'token_apply', array('id' => $_GPC['applyid']));
                $apply['token'] = Util :: getSingelData("*", PDO_NAME . 'halfcard_type', array('id' => $apply['type']));
            }
            $listData = Util :: getNumData("*", PDO_NAME . 'halfcard_type', $where);
            $types = $listData[0];
            if (checksubmit()){
                $secretkey_type = $_GPC['secretkey_type'];
                $type = Util :: getSingelData("*", PDO_NAME . 'halfcard_type', array('id' => $secretkey_type));
                $num = !empty($_GPC['num'])?intval($_GPC['num']):1;
                if($num > 0){
                    if($allow){
                        for($k = 0;$k < $num;$k++){
                            $data['uniacid'] = $_W['uniacid'];
                            $data['days'] = $type['days'];
                            $data['tokentype'] = 2;
                            $data['type'] = $type['id'];
                            $data['typename'] = $type['name'];
                            $data['price'] = $type['price'];
                            $data['number'] = Util :: createConcode(3);
                            $data['aid'] = $_W['aid'];
                            $data['createtime'] = TIMESTAMP;
                            pdo_insert(PDO_NAME . 'token', $data);
                        }
                        message('创建成功!需要创建' . $num . "个，成功创建" . $k . "个。", web_url('halfcard/halfcard_web/base', array('postType' => 'list')), 'success');
                    }else{
                        $data = array('aid' => $_W['aid'], 'uniacid' => $_W['uniacid'], 'type' => $secretkey_type, 'tokentype' => 2, 'createtime' => TIMESTAMP, 'status' => 1, 'num' => $num);
                        pdo_insert(PDO_NAME . 'token_apply', $data);
                        message('申请成功', web_url('halfcard/halfcard_web/base', array('postType' => 'apply')), 'success');
                    }
                }else{
                    message('数量填写不正确!', web_url('halfcard/halfcard_web/base', array('postType' => 'add')), 'error');
                }
            }
        }
        if($_GPC['postType'] == 'del'){
            pdo_delete(PDO_NAME . 'token', array('id' => $_GPC['id']));
            header('Location:' . web_url('member/token/vipToken', array('postType' => 'list')));
        }
        if($_GPC['postType'] == 'remark'){
            pdo_update(PDO_NAME . 'token', array('remark' => $_GPC['remark']), array('id' => $_GPC['id']));
            die(json_encode(array('message' => '备注成功')));
        }
        if($_GPC['postType'] == 'apply'){
            $listData = Util :: getNumData("*", PDO_NAME . 'token_apply', array('uniacid' => $_W['uniacid'], 'aid' => $_W['aid'], 'tokentype' => 2), 'type desc,status asc', 0, 0, 0);
            $applys = $listData[0];
            foreach($applys as & $apply){
                $apply['token'] = Util :: getSingelData("*", PDO_NAME . 'halfcard_type', array('id' => $apply['type']));
                $apply['aName'] = Util :: idSwitch('aid', 'aName', $apply['aid']);
            }
        }
        if($_GPC['postType'] == 'type'){
            $where = array();
            if($settings['halfcardtype'] == 2)$where['aid'] = $_W['aid'];
            if($settings['halfcardtype'] == 1)$where['aid'] = 0;
            $pindex = max(1, $_GPC['page']);
            $listData = Util :: getNumData("*", PDO_NAME . 'halfcard_type', $where , 'id desc', $pindex, 10, 1);
            $list = $listData[0];
        }
        if($_GPC['postType'] == 'addType'){
            $memberType = $_GPC['data'];
            if($_GPC['id'])$data = Util :: getSingelData("*", PDO_NAME . 'halfcard_type', array('id' => $_GPC['id']));
            if($_GPC['data']){
                $memberType['uniacid'] = $_W['uniacid'];
                $memberType['aid'] = $_W['aid'];
                if($_GPC['id'])pdo_update(PDO_NAME . 'halfcard_type', $memberType, array('id' => $_GPC['id']));
                else pdo_insert(PDO_NAME . 'halfcard_type', $memberType);
                message('操作成功！', web_url('halfcard/halfcard_web/base', array('postType' => 'type')), 'success');
            }
        }
        if($_GPC['postType'] == 'delType'){
            pdo_delete(PDO_NAME . 'halfcard_type', array('id' => $_GPC['id']));
            message('操作成功！', web_url('halfcard/halfcard_web/base', array('postType' => 'type')), 'success');
        }
        if($_GPC['postType'] == 'output'){
            $where = array('tokentype' => 2);
            if($_GPC['status']){
                if($_GPC['status'] == 1)$where['status'] = 1;
                if($_GPC['status'] == 2)$where['status'] = 0;
            }
            if (!empty($_GPC['keyword'])){
                if(!empty($_GPC['keywordtype'])){
                    switch($_GPC['keywordtype']){
                    case 1: $where['days'] = $_GPC['keyword'];
                        break;
                    case 2: $member = Util :: getSingelData("id", PDO_NAME . 'member', array('@nickname@' => $_GPC['keyword']));
                        if($member)$where['mid'] = $member['id'];
                    case 3: $where['@remark@'] = $_GPC['keyword'];
                        break;
                    default:break;
                    }
                }
            }
            $listData = Util :: getNumData("*", PDO_NAME . 'token', $where);
            $list = $listData[0];
            foreach($list as$key => & $value){
                if(!empty($value['mid']))$value['member'] = Member :: getMemberByMid($value['mid']);
            }
            $html = "\xEF\xBB\xBF";
            $filter = array('aa' => '类型', 'bb' => '时长(天)', 'cc' => '激活码', 'dd' => '备注', 'ee' => '使用详情', 'ff' => '生成时间');
            foreach ($filter as $key => $title){
                $html .= $title . "\t,";
            }
            $html .= "\n";
            foreach ($list as $k => $v){
                $list[$k]['aa'] = $v['typename'];
                $list[$k]['bb'] = $v['days'];
                $list[$k]['cc'] = $v['number'];
                $list[$k]['dd'] = $v['remark'];
                $list[$k]['ee'] = $v['member']['nickname'];
                $list[$k]['ff'] = date('Y-m-d H:i:s', $v['createtime']);
                foreach ($filter as $key => $title){
                    $html .= $list[$k][$key] . "\t,";
                }
                $html .= "\n";
            }
            header('Content-type:text/csv');
            header('Content-Disposition:attachment; filename=VIP激活码.csv');
            echo $html;
            exit();
        }
        include wl_template('halfcard/base');
    }
    function memberlist(){
        global $_W, $_GPC;
        $pindex = max(1, intval($_GPC['page']));
        $psize = 10;
        $keywordtype = $_GPC['keywordtype'];
        if($keywordtype == 1){
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
                $where['mid#'] = $mids;
            }else{
                $where['mid#'] = "(0)";
            }
        }else if($keywordtype == 2){
            $keyword = $_GPC['keyword'];
            $params[':mobile'] = "%{$keyword}%";
            $member = pdo_fetchall("SELECT * FROM " . tablename('wlmerchant_member') . "WHERE uniacid = {$_W['uniacid']} AND aid = {$_W['aid']} AND mobile LIKE :mobile", $params);
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
                $where['mid#'] = $mids;
            }else{
                $where['mid#'] = "(0)";
            }
        }else if($keywordtype == 3){
            $keyword = $_GPC['usetype'];
            if($keyword == 1){
                $where['expiretime>'] = time();
            }else{
                $where['expiretime<'] = time();
            }
        }
        $where['uniacid'] = $_W['uniacid'];
        $where['aid'] = $_W['aid'];
        $member = Halfcard :: getNumhalfcardmember('*', $where, 'ID DESC', $pindex, $psize, 1);
        $pager = $member[1];
        $member = $member[0];
        foreach ($member as $key => & $v){
            $user = pdo_get('wlmerchant_member', array('id' => $v['mid']));
            $v['nickname'] = $user['nickname'];
            $v['avatar'] = $user['avatar'];
            $v['mobile'] = $user['mobile'];
            if($v['expiretime'] > time()){
                $v['status'] = 1;
            }else{
                $v['status'] = 2;
            }
        }
        include wl_template('halfcard/halfcardmemberlist');
    }
    function payhalfcardlist(){
        global $_W, $_GPC;
        $pindex = max(1, intval($_GPC['page']));
        $psize = 10;
        $keywordtype = $_GPC['keywordtype'];
        if($keywordtype == 1){
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
                $where['mid#'] = $mids;
            }else{
                $where['mid#'] = "(0)";
            }
        }else if($keywordtype == 2){
            $keyword = $_GPC['keyword'];
            $params[':mobile'] = "%{$keyword}%";
            $member = pdo_fetchall("SELECT * FROM " . tablename('wlmerchant_member') . "WHERE uniacid = {$_W['uniacid']} AND aid = {$_W['aid']} AND mobile LIKE :mobile", $params);
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
                $where['mid#'] = $mids;
            }else{
                $where['mid#'] = "(0)";
            }
        }else if($keywordtype == 3){
            $keyword = $_GPC['howlong'];
            $where['howlong'] = $keyword;
        }
        $where['uniacid'] = $_W['uniacid'];
        $where['aid'] = $_W['aid'];
        $where['status'] = 1;
        $pay = Halfcard :: getNumhalfcardpay('*', $where, 'ID DESC', $pindex, $psize, 1);
        $pager = $pay[1];
        $pay = $pay[0];
        foreach ($pay as $key => & $v){
            $user = pdo_get('wlmerchant_member', array('id' => $v['mid']));
            $v['nickname'] = $user['nickname'];
            $v['avatar'] = $user['avatar'];
            $v['mobile'] = $user['mobile'];
        }
        include wl_template('halfcard/payhalfcardlist');
    }
    function QandA(){
        include wl_template('halfcard/QandA');
    }
    function halfcardprice(){
        include wl_template('halfcard/pricepage');
    }
    function selectMerchant(){
        global $_W, $_GPC;
        $where = array();
        $where['uniacid'] = $_W['uniacid'];
        $where['aid'] = $_W['aid'];
        if($_GPC['keyword'])$where['@storename@'] = $_GPC['keyword'];
        $merchants = Rush :: getNumMerchant('id,storename,logo', $where, 'ID DESC', 0, 0, 0);
        $merchants = $merchants[0];
        foreach ($merchants as $key => & $va){
            $va['logo'] = tomedia($va['logo']);
            $res = pdo_get('wlmerchant_halfcardlist', array('merchantid' => $va['id']), array('id'));
            if($res){
                unset($merchants[$key]);
            }
        }
        include wl_template('goodshouse/selectMerchant');
    }
}
?>