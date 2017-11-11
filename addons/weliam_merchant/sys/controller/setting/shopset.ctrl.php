<?php
defined('IN_IA')or exit('Access Denied');
class shopset{
    public function base(){
        global $_W, $_GPC;
        $settings = Setting :: wlsetting_read('base');
        if (checksubmit('submit')){
            $base = Util :: trimWithArray($_GPC['shop']);
            Setting :: wlsetting_save($base, 'base');
            wl_message('更新设置成功！', web_url('setting/shopset/base'));
        }
        include wl_template('setting/shopBase');
    }
    public function share(){
        global $_W, $_GPC;
        $settings = Setting :: wlsetting_read('share');;
        if (checksubmit('submit')){
            $base = Util :: trimWithArray($_GPC['share']);
            Setting :: wlsetting_save($base, 'share');
            wl_message('更新设置成功！', web_url('setting/shopset/share'));
        }
        include wl_template('setting/shopShare');
    }
    public function templat(){
        global $_W, $_GPC;
        $settings = Setting :: wlsetting_read('templat');;
        $styles = Util :: traversingFiles(PATH_APP . "view/");
        if (checksubmit('submit')){
            $base = Util :: trimWithArray($_GPC['templat']);
            Setting :: wlsetting_save($base, 'templat');
            wl_message('更新设置成功！', web_url('setting/shopset/templat'));
        }
        include wl_template('setting/shopTemplat');
    }
    public function api(){
        global $_W, $_GPC;
        $settings = Setting :: wlsetting_read('api');;
        if (checksubmit('submit')){
            $base = array('gdkey' => $_GPC['gdkey']);
            Setting :: wlsetting_save($base, 'api');
            wl_message('更新设置成功！', web_url('setting/shopset/api'));
        }
        include wl_template('setting/shopApi');
    }
    public function wap(){
        global $_W, $_GPC;
        $settings = Setting :: wlsetting_read('wap');;
        if (checksubmit('submit')){
            $base = array('share_title' => $_GPC['share_title'], 'share_image' => $_GPC['share_image'], 'share_desc' => $_GPC['share_desc']);
            Setting :: wlsetting_save($base, 'wap');
            wl_message('更新设置成功！', web_url('setting/shopset/wap'));
        }
        include wl_template('setting/shopTemplat');
    }
    public function halfcard(){
        global $_W, $_GPC;
        $_GPC['postType'] = $_GPC['postType']?$_GPC['postType'] :'setting';
        if($_GPC['postType'] == 'setting'){
            $listData = Util :: getNumData("*", PDO_NAME . 'halfcard_type', array('aid' => 0, 'status' => 1));
            $types = $listData[0];
            $settings = Setting :: wlsetting_read('halfcard');
            $settings['qa'] = unserialize($settings['qanda']);
            if (checksubmit('submit')){
                $base = array('halfcardtype' => intval($_GPC['halfcardtype']), 'monthprice' => Util :: currency_format($_GPC['monthprice']), 'seasonprice' => Util :: currency_format($_GPC['seasonprice']), 'halfyearprice' => Util :: currency_format($_GPC['halfyearprice']), 'yearprice' => Util :: currency_format($_GPC['yearprice']), 'halfcardtypeids' => $_GPC['type'], 'halfstatus' => intval($_GPC['halfstatus']));
                $question = $_GPC['question'];
                $answer = $_GPC['answer'];
                $len = count($question);
                $tag = array();
                for ($k = 0;$k < $len;$k++){
                    $tag[$k]['question'] = $question[$k];
                    $tag[$k]['answer'] = $answer[$k];
                }
                $base['qanda'] = serialize($tag);
                Setting :: wlsetting_save($base, 'halfcard');
                wl_message('更新设置成功！', web_url('setting/shopset/halfcard'));
            }
        }
        if($_GPC['postType'] == 'list'){
            $listData = Util :: getNumData("*", PDO_NAME . 'halfcard_type', array('aid' => 0));
            $types = $listData[0];
            $where = array('tokentype' => 2);
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
            $where = array('aid' => 0);
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
                    for($k = 0;$k < $num;$k++){
                        $data['uniacid'] = $_W['uniacid'];
                        $data['days'] = $type['days'];
                        $data['tokentype'] = 2;
                        $data['type'] = $type['id'];
                        $data['typename'] = $type['name'];
                        $data['price'] = $type['price'];
                        $data['number'] = Util :: createConcode(3);
                        $data['createtime'] = TIMESTAMP;
                        if($_GPC['applyid'])$data['aid'] = $apply['aid'];
                        pdo_insert(PDO_NAME . 'token', $data);
                    }
                    if($_GPC['applyid'])pdo_update(PDO_NAME . 'token_apply', array('status' => 2), array('id' => $_GPC['applyid']));
                    message('创建成功!需要创建' . $num . "个，成功创建" . $k . "个。", web_url('setting/shopset/halfcard', array('postType' => 'list')), 'success');
                }else{
                    message('数量填写不正确!', web_url('setting/shopset/halfcard', array('postType' => 'add')), 'error');
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
            $listData = Util :: getNumData("*", PDO_NAME . 'token_apply', array('uniacid' => $_W['uniacid'], 'tokentype' => 2), 'type desc,status asc', 0, 0, 0);
            $applys = $listData[0];
            foreach($applys as & $apply){
                $apply['token'] = Util :: getSingelData("*", PDO_NAME . 'halfcard_type', array('id' => $apply['type']));
                $apply['aName'] = Util :: idSwitch('aid', 'aName', $apply['aid']);
            }
        }
        if($_GPC['postType'] == 'type'){
            $pindex = max(1, $_GPC['page']);
            $listData = Util :: getNumData("*", PDO_NAME . 'halfcard_type', array('aid' => 0), 'id desc', $pindex, 10, 1);
            $list = $listData[0];
        }
        if($_GPC['postType'] == 'addType'){
            $memberType = $_GPC['data'];
            if($_GPC['id'])$data = Util :: getSingelData("*", PDO_NAME . 'halfcard_type', array('id' => $_GPC['id']));
            if($_GPC['data']){
                $memberType['uniacid'] = $_W['uniacid'];
                if($_GPC['id'])pdo_update(PDO_NAME . 'halfcard_type', $memberType, array('id' => $_GPC['id']));
                else pdo_insert(PDO_NAME . 'halfcard_type', $memberType);
                message('操作成功！', web_url('setting/shopset/halfcard', array('postType' => 'type')), 'success');
            }
        }
        if($_GPC['postType'] == 'delType'){
            pdo_delete(PDO_NAME . 'halfcard_type', array('id' => $_GPC['id']));
            message('操作成功！', web_url('setting/shopset/halfcard', array('postType' => 'type')), 'success');
        }
        if($_GPC['postType'] == 'output'){
            $where = array('tokentype' => 2);
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
        include wl_template('setting/shopHalfcard');
    }
    function halfcardqa(){
        include wl_template('setting/halfcardqa');
    }
}
