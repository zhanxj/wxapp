<?php
defined('IN_IA')or exit('Access Denied');
class token{
    public function vipToken(){
        global $_W, $_GPC;
        $allow = 0;
        $settings = Setting :: wlsetting_read('vipToken');
        $settings['viptype'] = unserialize($settings['viptype']);
        if($settings['vipstatus'] == 1)$allow = 1;
        $listData = Util :: getNumData("*", PDO_NAME . 'member_type', array());
        $types = $listData[0];
        $_GPC['postType'] = $_GPC['postType']?$_GPC['postType'] :'list';
        if($_GPC['postType'] == 'list'){
            $listData = Util :: getNumData("*", PDO_NAME . 'member_type', array());
            $types = $listData[0];
            $where = array('tokentype' => 1);
            $where['aid'] = $_W['aid'];
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
        if($_GPC['postType'] == 'apply'){
            $listData = Util :: getNumData("*", PDO_NAME . 'token_apply', array('aid' => $_W['aid'], 'uniacid' => $_W['uniacid'], 'tokentype' => 1), 'type desc,status asc', 0, 0, 0);
            $applys = $listData[0];
            foreach($applys as & $apply){
                $apply['token'] = Util :: getSingelData("*", PDO_NAME . 'member_type', array('id' => $apply['type']));
                $apply['aName'] = Util :: idSwitch('aid', 'aName', $apply['aid']);
            }
        }
        if($_GPC['postType'] == 'remark'){
            pdo_update(PDO_NAME . 'token', array('remark' => $_GPC['remark']), array('id' => $_GPC['id']));
            die(json_encode(array('message' => '备注成功')));
        }
        if($_GPC['postType'] == 'add'){
            $settings = Setting :: wlsetting_read('vipToken');
            $settings['viptype'] = unserialize($settings['viptype']);
            $listData = Util :: getNumData("*", PDO_NAME . 'member_type', array());
            $types = $listData[0];
            if (checksubmit()){
                $secretkey_type = $_GPC['secretkey_type'];
                if(in_array($secretkey_type, $settings['viptype'])){
                    $allow = 1;
                }else{
                    $allow = 0;
                }
                $type = Util :: getSingelData("*", PDO_NAME . 'member_type', array('id' => $secretkey_type));
                $num = !empty($_GPC['num'])?intval($_GPC['num']):1;
                if($num > 0){
                    if($allow){
                        for($k = 0;$k < $num;$k++){
                            $data['uniacid'] = $_W['uniacid'];
                            $data['days'] = $type['days'];
                            $data['tokentype'] = 1;
                            $data['type'] = $type['id'];
                            $data['typename'] = $type['name'];
                            $data['price'] = $type['price'];
                            $data['number'] = Util :: createConcode(3);
                            $data['aid'] = $_W['aid'];
                            $data['createtime'] = TIMESTAMP;
                            pdo_insert(PDO_NAME . 'token', $data);
                        }
                        message('创建成功!需要创建' . $num . "个，成功创建" . $k . "个。", web_url('member/token/vipToken'), 'success');
                    }else{
                        $data = array('aid' => $_W['aid'], 'uniacid' => $_W['uniacid'], 'type' => $secretkey_type, 'tokentype' => 1, 'createtime' => TIMESTAMP, 'status' => 1, 'num' => $num);
                        pdo_insert(PDO_NAME . 'token_apply', $data);
                        message('申请成功', web_url('member/token/vipToken', array('postType' => 'apply')), 'success');
                    }
                }else{
                    message('数量填写不正确!', web_url('member/token/vipToken'), 'error');
                }
            }
        }
        if($_GPC['postType'] == 'del'){
            pdo_delete(PDO_NAME . 'token', array('id' => $_GPC['id']));
            header('Location:' . web_url('member/token/vipToken', array('postType' => 'list')));
        }
        if($_GPC['postType'] == 'output'){
            $where = array('tokentype' => 1);
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
        include wl_template('member/vipToken');
    }
}
