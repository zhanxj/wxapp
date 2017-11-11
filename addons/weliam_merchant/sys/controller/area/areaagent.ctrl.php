<?php
defined('IN_IA')or exit('Access Denied');
class areaagent{
    public function agentIndex(){
        global $_W, $_GPC;
        $pindex = max(1, intval($_GPC['page']));
        $psize = 10;
        $agentes = Area :: getAllAgent($pindex-1, $psize);
        $agents = $agentes['data'];
        if(!empty($agents)){
            foreach($agents as $key => $value){
                $group = Area :: getSingleGroup($value['groupid']);
                $agents[$key]['groupname'] = $group['name'];
            }
        }
        $pager = pagination($agentes['count'], $pindex, $psize);
        include wl_template('area/agentIndex');
    }
    public function agentEdit(){
        global $_W, $_GPC;
        if (checksubmit('submit')){
            $agent = $_GPC['agent'];
            if(empty($_GPC['node_ids']))wl_message('您需要选择代理区域');
            if(empty($_GPC['id'])){
                load() -> model('user');
                if(!preg_match(REGULAR_USERNAME, $agent['username'])){
                    wl_message('必须输入用户名，格式为 3-15 位字符，可以包括汉字、字母（不区分大小写）、数字、下划线和句点。');
                }
                if(User :: agentuser_single(array('username' => $agent['username']))){
                    wl_message('非常抱歉，此用户名已经被注册，你需要更换注册名称！');
                }
                if(istrlen($agent['password']) < 8){
                    wl_message('必须输入密码，且密码长度不得低于8位。');
                }
                $agent['joindate'] = time();
                $agent['joinip'] = $_W['clientip'];
                $agent['starttime'] = time();
                $agent['salt'] = Util :: createSalt(8);
                $agent['password'] = Util :: encryptedPassword($agent['password'], $agent['salt']);
                $agent['username'] = trim($agent['username']);
            }else{
                if(!empty($_GPC['password']) && istrlen($_GPC['password']) < 8){
                    wl_message('必须输入密码，且密码长度不得低于8位。');
                }
                if(!empty($_GPC['password'])){
                    $agent['salt'] = Util :: createSalt(8);
                    $agent['password'] = Util :: encryptedPassword($_GPC['password'], $agent['salt']);
                }
            }
            $agent['cashopenid'] = $_GPC['openid'];
            $agent['agentname'] = trim($agent['agentname']);
            $agent['realname'] = trim($agent['realname']);
            $agent['mobile'] = trim($agent['mobile']);
            $agent['status'] = $_GPC['status'];
            $agent['endtime'] = strtotime($agent['endtime']) + 86400;
            $agent['percent'] = serialize($_GPC['percent']);
            $agentid = Area :: editAgent($agent, $_GPC['id']);
            if(Area :: save_agent_area($_GPC['node_ids'], $agentid))wl_message('保存成功！', web_url('area/areaagent/agentIndex'), 'success');
            wl_message('保存失败！', referer(), 'error');
        }
        $agent = Area :: getSingleAgent(intval($_GPC['id']));
        $allgroups = Area :: getAllGroup(0, 10, 1);
        $allgroup = $allgroups['data'];
        $m['openid'] = $agent['cashopenid'];
        if($m['openid']){
            $member = Util :: getSingelData('nickname', PDO_NAME . 'member', array('openid' => $m['openid']));
            $m['nickname'] = $member['nickname'];
        }
        if(!empty($_GPC['id'])){
            $roles = Area :: get_agent_area($_GPC['id']);
            foreach($roles as $key => $value)$provs[$key] = intval($value / 10000);
            $nodes = Area :: address_tree_in_use($_GPC['id']);
        }else{
            $nodes = Area :: address_tree_in_use();
        }
        include wl_template('area/agentEdit');
    }
    public function agentDelete(){
        global $_W, $_GPC;
        if(Area :: deleteAgent($_GPC['id']))wl_message('删除成功！', web_url('area/areaagent/agentIndex'), 'success');
        wl_message('删除失败！', web_url('area/areaagent/agentIndex'), 'error');
    }
    public function groupIndex(){
        global $_W, $_GPC;
        $pindex = max(1, intval($_GPC['page']));
        $psize = 10;
        $groupes = Area :: getAllGroup($pindex-1, $psize);
        $groups = $groupes['data'];
        $pager = pagination($groups['count'], $pindex, $psize);
        include wl_template('area/groupIndex');
    }
    public function groupEdit(){
        global $_W, $_GPC;
        if (checksubmit('submit')){
            $arr['name'] = trim($_GPC['name']);
            $arr['isdefault'] = $_GPC['isdefault'];
            $arr['enabled'] = $_GPC['enabled'];
            if (empty($arr['name']))wl_message('分组名称不能为空');
            if (Area :: editGroup($arr, intval($_GPC['id']))){
                wl_message('代理分组更新成功', web_url('area/areaagent/groupIndex'), 'success');
            }else{
                wl_message('代理分组更新失败', web_url('area/areaagent/groupIndex'), 'error');
            }
        }
        $category = Area :: getSingleGroup(intval($_GPC['id']));
        include wl_template('area/groupEdit');
    }
    public function groupDelete(){
        global $_W, $_GPC;
        if(empty($_GPC['id']))wl_message('未找到该分组', referer(), 'error');
        if(Area :: deleteGroup($_GPC['id']))wl_message('分组删除成功', web_url('area/areaagent/groupIndex'), 'success');
        wl_message('分组删除失败', web_url('area/areaagent/groupIndex'), 'error');
    }
    public function agentCover(){
        global $_W, $_GPC;
        include wl_template('area/cover');
    }
    public function agentDetail(){
        global $_W, $_GPC;
        $_GPC['recordType'] = $_GPC['recordType']?$_GPC['recordType']:'settlement';
        $agent = Area :: getSingleAgent(intval($_GPC['id']));
        $pindex = max(1, $_GPC['page']);
        $psize = 10;
        if($_GPC['recordType'] == 'settlement'){
        }
        if($_GPC['recordType'] == 'VIP'){
            $VIPData = Util :: getNumData('*', PDO_NAME . 'vip_record', array('aid' => $_GPC['id'], 'status' => 1), 'paytime desc', $pindex, $psize, 1);
            $VIP = $VIPData[0];
            $pager = $VIPData[1];
            foreach($VIP as $key => & $value){
                $value['member'] = Member :: getMemberByMid($value['mid']);
                $value['area'] = Util :: idSwitch('areaid', 'areaName', $value['areaid']);
            }
        }
        if($_GPC['recordType'] == 'half'){
            $where = array('aid' => $_GPC['id'], 'status' => 1);
            if($_GPC['keyword'])$where['orderno^mid'] = $_GPC['keyword'];
            $halfCardData = Util :: getNumData('*', PDO_NAME . 'halfcard_record', $where , 'paytime desc', $pindex, $psize, 1);
            $half = $halfCardData[0];
            $pager = $halfCardData[1];
            foreach($half as $key => & $value){
                $value['member'] = Member :: getMemberByMid($value['mid']);
            }
        }
        include wl_template('area/agentDetail');
    }
    public function manage(){
        global $_W, $_GPC;
        $agent = Area :: getSingleAgent(intval($_GPC['id']));
        if(empty($agent)){
            wl_message('未找到代理信息，请重试');
        }
        $cookie = array();
        $cookie['id'] = $agent['id'];
        $cookie['uniacid'] = $agent['uniacid'];
        $cookie['hash'] = md5($agent['password'] . $agent['salt']);
        $session = base64_encode(json_encode($cookie));
        isetcookie('__wlagent_session', $session, 7 * 86400, true);
        header('location: ' . $_W['siteroot'] . "web/agent.php?p=dashboard&ac=dashboard&do=index&");
    }
}
