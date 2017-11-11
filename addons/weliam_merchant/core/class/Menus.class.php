<?php
defined('IN_IA')or exit('Access Denied');
class Menus{
    public static function __callStatic($method, $arg){
        global $_W, $_GPC;
        $method = substr($method, 3, -6);
        $confile = PATH_PLUGIN . $method . "/config.php";
        if(file_exists($confile)){
            $config = require $confile;
            if(empty($config) || !is_array($config)){
                wl_message('模块文件缺失，请检查系统是否存在异常');
            }
        }else{
            wl_message('模块文件缺失，请检查系统是否存在异常');
        }
        return $config['menus'];
    }
    static function _calc_current_frames2(& $frames){
        global $_W, $_GPC;
        if(!empty($frames) && is_array($frames)){
            foreach($frames as & $frame){
                foreach($frame['items'] as & $fr){
                    if(count($fr['actions']) == 2){
                        if(is_array($fr['actions']['1'])){
                            $fr['active'] = in_array($_GPC[$fr['actions']['0']], $fr['actions']['1'])? 'active' : '';
                        }else{
                            if($fr['actions']['1'] == $_GPC[$fr['actions']['0']]){
                                $fr['active'] = 'active';
                            }
                        }
                    }elseif(count($fr['actions']) == 3){
                        if(($fr['actions']['1'] == $_GPC[$fr['actions']['0']] || @in_array($_GPC[$fr['actions']['0']], $fr['actions']['1'])) && ($fr['actions']['2'] == $_GPC['do'] || @in_array($_GPC['do'], $fr['actions']['2']))){
                            $fr['active'] = 'active';
                        }
                    }elseif(count($fr['actions']) == 4){
                        if(($fr['actions']['1'] == $_GPC[$fr['actions']['0']] || @in_array($_GPC[$fr['actions']['0']], $fr['actions']['1'])) && ($fr['actions']['3'] == $_GPC[$fr['actions']['2']] || @in_array($_GPC[$fr['actions']['2']], $fr['actions']['3']))){
                            $fr['active'] = 'active';
                        }
                    }elseif(count($fr['actions']) == 5){
                        if($fr['actions']['1'] == $_GPC[$fr['actions']['0']] && $fr['actions']['3'] == $_GPC[$fr['actions']['2']] && $fr['actions']['4'] == $_GPC['status']){
                            $fr['active'] = 'active';
                        }
                    }else{
                        $query = parse_url($fr['url'], PHP_URL_QUERY);
                        parse_str($query, $urls);
                        if(defined('ACTIVE_FRAME_URL')){
                            $query = parse_url(ACTIVE_FRAME_URL, PHP_URL_QUERY);
                            parse_str($query, $get);
                        }else{
                            $get = $_GET;
                        }
                        if(!empty($_GPC['a'])){
                            $get['a'] = $_GPC['a'];
                        }
                        if(!empty($_GPC['c'])){
                            $get['c'] = $_GPC['c'];
                        }
                        if(!empty($_GPC['do'])){
                            $get['do'] = $_GPC['do'];
                        }
                        if(!empty($_GPC['ac'])){
                            $get['ac'] = $_GPC['ac'];
                        }
                        if(!empty($_GPC['status'])){
                            $get['status'] = $_GPC['status'];
                        }
                        if(!empty($_GPC['p'])){
                            $get['p'] = $_GPC['p'];
                        }
                        if(!empty($_GPC['op'])){
                            $get['op'] = $_GPC['op'];
                        }
                        if(!empty($_GPC['m'])){
                            $get['m'] = $_GPC['m'];
                        }
                        $diff = array_diff_assoc($urls, $get);
                        if(empty($diff)){
                            $fr['active'] = 'active';
                        }else{
                            $fr['active'] = '';
                        }
                    }
                }
            }
        }
    }
    static function topmenus(){
        global $_W;
        $frames = array();
        $appact = Util :: traversingFiles(PATH_PLUGIN);
        $appact[] = 'app';
        $frames['dashboard']['title'] = '<i class="fa fa-desktop"></i>&nbsp;&nbsp; 首页';
        $frames['dashboard']['url'] = web_url('dashboard/dashboard');
        $frames['dashboard']['active'] = 'dashboard';
        $frames['store']['title'] = '<i class="fa fa-users"></i>&nbsp;&nbsp; 商户';
        $frames['store']['url'] = web_url('store/merchant/index', array('enabled' => ''));
        $frames['store']['active'] = 'store';
        $frames['finance']['title'] = '<i class="fa fa-money"></i>&nbsp;&nbsp; 财务';
        $frames['finance']['url'] = web_url('finace/wlCash/cashSurvey');
        $frames['finance']['active'] = 'finace';
        $frames['member']['title'] = '<i class="fa fa-user"></i>&nbsp;&nbsp; 会员';
        $frames['member']['url'] = web_url('member/wlMember/memberIndex');
        $frames['member']['active'] = 'member';
        $frames['goodshouse']['title'] = '<i class="fa fa-database"></i>&nbsp;&nbsp; 仓库';
        $frames['goodshouse']['url'] = web_url('goodshouse/goodshouse/goodslist');
        $frames['goodshouse']['active'] = 'goodshouse';
        $frames['app']['title'] = '<i class="fa fa-cubes"></i>&nbsp;&nbsp; 应用';
        $frames['app']['url'] = web_url('app/plugins');
        $frames['app']['active'] = $appact;
        $frames['setting']['title'] = '<i class="fa fa-gear"></i>&nbsp;&nbsp; 设置';
        $frames['setting']['url'] = web_url('agentset/userset/profile');
        $frames['setting']['active'] = 'agentset';
        return $frames;
    }
    static function getdashboardFrames(){
        global $_W;
        $frames = array();
        $frames['member']['title'] = '<i class="fa fa-dashboard"></i>&nbsp;&nbsp; 概况';
        $frames['member']['items'] = array();
        $frames['member']['items']['setting']['url'] = web_url('dashboard/dashboard/index');
        $frames['member']['items']['setting']['title'] = '运营概况';
        $frames['member']['items']['setting']['actions'] = array('ac', 'dashboard');
        $frames['member']['items']['setting']['active'] = '';
        $frames['page']['title'] = '<i class="fa fa-inbox"></i>&nbsp;&nbsp; 主页管理';
        $frames['page']['items'] = array();
        $frames['page']['items']['notice']['url'] = web_url('dashboard/notice/index');
        $frames['page']['items']['notice']['title'] = '公告';
        $frames['page']['items']['notice']['actions'] = array('ac', 'notice');
        $frames['page']['items']['notice']['active'] = '';
        $frames['page']['items']['adv']['url'] = web_url('dashboard/adv/index');
        $frames['page']['items']['adv']['title'] = '幻灯片';
        $frames['page']['items']['adv']['actions'] = array('ac', 'adv');
        $frames['page']['items']['adv']['active'] = '';
        $frames['page']['items']['nav']['url'] = web_url('dashboard/nav/index');
        $frames['page']['items']['nav']['title'] = '导航栏';
        $frames['page']['items']['nav']['actions'] = array('ac', 'nav');
        $frames['page']['items']['nav']['active'] = '';
        $frames['page']['items']['banner']['url'] = web_url('dashboard/banner/index');
        $frames['page']['items']['banner']['title'] = '广告栏';
        $frames['page']['items']['banner']['actions'] = array('ac', 'banner');
        $frames['page']['items']['banner']['active'] = '';
        $frames['page']['items']['cube']['url'] = web_url('dashboard/cube/index');
        $frames['page']['items']['cube']['title'] = '商品魔方';
        $frames['page']['items']['cube']['actions'] = array('ac', 'cube');
        $frames['page']['items']['cube']['active'] = '';
        return $frames;
    }
    static function getfinaceFrames(){
        global $_W, $_GPC;
        $where = array();
        $where['aid'] = $_W['aid'];
        $where['type'] = 1;
        $where['status'] = 1;
        $list1 = Util :: getNumData('id', PDO_NAME . 'settlement_record', $where);
        $where['status'] = 2;
        $list2 = Util :: getNumData('id', PDO_NAME . 'settlement_record', $where);
        $where['status'] = 4;
        $list4 = Util :: getNumData('id', PDO_NAME . 'settlement_record', $where);
        $where['status'] = 5;
        $list5 = Util :: getNumData('id', PDO_NAME . 'settlement_record', $where);
        unset($where['status']);
        unset($where['type']);
        $where['#type#'] = '(2,3)';
        $where['#status#'] = '(2,3,4)';
        $list = Util :: getNumData('id', PDO_NAME . 'settlement_record', $where);
        $frames = array();
        $frames['cashSurvey']['title'] = '<i class="fa fa-database"></i>&nbsp;&nbsp; 财务概况';
        $frames['cashSurvey']['items'] = array();
        $frames['cashSurvey']['items']['datemana']['url'] = web_url('finace/wlCash/cashSurvey');
        $frames['cashSurvey']['items']['datemana']['title'] = '财务概况';
        $frames['cashSurvey']['items']['datemana']['actions'] = array();
        $frames['cashSurvey']['items']['datemana']['active'] = '';
        $frames['cashApply']['title'] = '<i class="fa fa-globe"></i>&nbsp;&nbsp; 商家提现申请';
        $frames['cashApply']['items'] = array();
        $frames['cashApply']['items']['display1']['url'] = web_url('finace/wlCash/cashApply', array('status' => '1'));
        $frames['cashApply']['items']['display1']['title'] = '待审核-代理';
        $frames['cashApply']['items']['display1']['actions'] = array('do', 'cashApply', 'status', '1');
        $frames['cashApply']['items']['display1']['active'] = '';
        $frames['cashApply']['items']['display1']['append']['title'] = self :: color(count($list1[0]));
        $frames['cashApply']['items']['display2']['url'] = web_url('finace/wlCash/cashApply', array('status' => '2'));
        $frames['cashApply']['items']['display2']['title'] = '待审核-系统';
        $frames['cashApply']['items']['display2']['actions'] = array('do', 'cashApply', 'status', '2');
        $frames['cashApply']['items']['display2']['active'] = '';
        $frames['cashApply']['items']['display2']['append']['title'] = self :: color(count($list2[0]));
        $frames['cashApply']['items']['display4']['url'] = web_url('finace/wlCash/cashApply', array('status' => '4'));
        $frames['cashApply']['items']['display4']['title'] = '待结算到商家';
        $frames['cashApply']['items']['display4']['actions'] = array('do', 'cashApply', 'status', '4');
        $frames['cashApply']['items']['display4']['active'] = '';
        $frames['cashApply']['items']['display4']['append']['title'] = self :: color(count($list4[0]));
        $frames['cashApply']['items']['display5']['url'] = web_url('finace/wlCash/cashApply', array('status' => '5'));
        $frames['cashApply']['items']['display5']['title'] = '已完成';
        $frames['cashApply']['items']['display5']['actions'] = array('do', 'cashApply', 'status', '5');
        $frames['cashApply']['items']['display5']['active'] = '';
        $frames['cashApply']['items']['display5']['append']['title'] = self :: color(count($list5[0]));
        $frames['cashApplyAgent']['title'] = '<i class="fa fa-globe"></i>&nbsp;&nbsp; 我的提现申请';
        $frames['cashApplyAgent']['items'] = array();
        $frames['cashApplyAgent']['items']['display2']['url'] = web_url('finace/wlCash/cashApplyAgentRecord');
        $frames['cashApplyAgent']['items']['display2']['title'] = '提现记录';
        $frames['cashApplyAgent']['items']['display2']['actions'] = array('do', 'cashApplyAgentRecord');
        $frames['cashApplyAgent']['items']['display2']['active'] = '';
        $frames['cashApplyAgent']['items']['display2']['append']['title'] = self :: color(count($list[0]));
        $frames['cashApplyAgent']['items']['display1']['url'] = web_url('finace/wlCash/cashApplyAgent', array('status' => '1'));
        $frames['cashApplyAgent']['items']['display1']['title'] = '提现申请';
        $frames['cashApplyAgent']['items']['display1']['actions'] = array('do', 'cashApplyAgent', 'status', '1');
        $frames['cashApplyAgent']['items']['display1']['active'] = '';
        return $frames;
    }
    static function getstoreFrames(){
        global $_W, $_GPC;
        $registerData1 = Util :: getNumData("id", PDO_NAME . 'merchantuser', array('aid' => $_W['aid'], 'status' => 1));
        $registerData2 = Util :: getNumData("id", PDO_NAME . 'merchantuser', array('aid' => $_W['aid'], 'status' => 0));
        $frames = array();
        $frames['user']['title'] = '<i class="fa fa-inbox"></i>&nbsp;&nbsp; 商户管理';
        $frames['user']['items'] = array();
        $frames['user']['items']['index']['url'] = web_url('store/merchant/index', array('enabled' => ''));
        $frames['user']['items']['index']['title'] = '商户列表';
        $frames['user']['items']['index']['actions'] = array('ac', 'merchant', 'do', 'index');
        $frames['user']['items']['index']['active'] = '';
        $frames['user']['items']['edit']['url'] = web_url('store/merchant/edit');
        $frames['user']['items']['edit']['title'] = !empty($_GPC['id'])? '编辑商户' : '添加商户';
        $frames['user']['items']['edit']['actions'] = array('ac', 'merchant', 'do', 'edit');
        $frames['user']['items']['edit']['active'] = '';
        $frames['register']['title'] = '<i class="fa fa-globe"></i>&nbsp;&nbsp; 入驻管理';
        $frames['register']['items'] = array();
        $frames['register']['items']['register']['url'] = web_url('store/register/index', array('status' => 1));
        $frames['register']['items']['register']['title'] = '待审核';
        $frames['register']['items']['register']['actions'] = array('ac', 'register', 'status', '1');
        $frames['register']['items']['register']['active'] = '';
        $frames['register']['items']['register']['append']['title'] = self :: color(count($registerData1[0]));
        $frames['register']['items']['register1']['url'] = web_url('store/register/index', array('status' => 0));
        $frames['register']['items']['register1']['title'] = '未通过';
        $frames['register']['items']['register1']['actions'] = array('ac', 'register', 'status', '0');
        $frames['register']['items']['register1']['active'] = '';
        $frames['register']['items']['register1']['append']['title'] = self :: color(count($registerData2[0]));;
        $frames['register']['items']['setting']['url'] = web_url('store/register/set');
        $frames['register']['items']['setting']['title'] = '入驻设置';
        $frames['register']['items']['setting']['actions'] = array('ac', 'register', 'do', 'set');
        $frames['register']['items']['setting']['active'] = '';
        $frames['group']['title'] = '<i class="fa fa-inbox"></i>&nbsp;&nbsp; 商户类别';
        $frames['group']['items'] = array();
        $frames['group']['items']['group']['url'] = web_url('store/group/index');
        $frames['group']['items']['group']['title'] = '商户分组';
        $frames['group']['items']['group']['actions'] = array('ac', 'group');
        $frames['group']['items']['group']['active'] = '';
        $frames['group']['items']['category']['url'] = web_url('store/category/index');
        $frames['group']['items']['category']['title'] = '商户分类';
        $frames['group']['items']['category']['actions'] = array('ac', 'category');
        $frames['group']['items']['category']['active'] = '';
        return $frames;
    }
    static function getmemberFrames(){
        global $_W;
        $frames = array();
        $frames['user']['title'] = '<i class="fa fa-inbox"></i>&nbsp;&nbsp; 会员管理';
        $frames['user']['items'] = array();
        $frames['user']['items']['type']['url'] = web_url('member/wlMember/memberType');
        $frames['user']['items']['type']['title'] = '会员类别';
        $frames['user']['items']['type']['actions'] = array('ac', 'wlMember', 'do', 'memberType');
        $frames['user']['items']['type']['active'] = '';
        $frames['user']['items']['notice']['url'] = web_url('member/wlMember/memberIndex');
        $frames['user']['items']['notice']['title'] = 'VIP会员';
        $frames['user']['items']['notice']['actions'] = array('do', 'memberIndex');
        $frames['user']['items']['notice']['active'] = '';
        $frames['user']['items']['adv']['url'] = web_url('member/wlMember/vipRecord');
        $frames['user']['items']['adv']['title'] = '开通记录';
        $frames['user']['items']['adv']['actions'] = array('do', 'vipRecord');
        $frames['user']['items']['adv']['active'] = '';
        $frames['token']['title'] = '<i class="fa fa-inbox"></i>&nbsp;&nbsp; 邀请码';
        $frames['token']['items'] = array();
        $frames['token']['items']['tokenMade']['url'] = web_url('member/token/vipToken');
        $frames['token']['items']['tokenMade']['title'] = '激活码';
        $frames['token']['items']['tokenMade']['actions'] = array('ac', 'token', 'do', 'vipToken');
        $frames['token']['items']['tokenMade']['active'] = '';
        return $frames;
    }
    static function getappFrames(){
        global $_W;
        $frames = array();
        $frames['app']['title'] = '<i class="fa fa-globe"></i>&nbsp;&nbsp; 应用';
        $frames['app']['items'] = array();
        $frames['app']['items']['plugins']['url'] = web_url('app/plugins/index');
        $frames['app']['items']['plugins']['title'] = '应用列表';
        $frames['app']['items']['plugins']['actions'] = array('ac', 'plugins');
        $frames['app']['items']['plugins']['active'] = '';
        $pluginsset = App :: getPlugins();
        $category = App :: getCategory();
        foreach ($category as $key => $value){
            $frames[$key]['title'] = '<i class="fa fa-inbox"></i>&nbsp;&nbsp; ' . $value['name'];
            $frames[$key]['items'] = array();
            foreach ($pluginsset as $pk => $plug){
                if($plug['category'] == $key){
                    $frames[$key]['items'][$plug['ident']]['url'] = $plug['cover'];
                    $frames[$key]['items'][$plug['ident']]['title'] = $plug['name'];
                    $frames[$key]['items'][$plug['ident']]['actions'] = array('ac', $plug['ident']);
                    $frames[$key]['items'][$plug['ident']]['active'] = '';
                }
            }
        }
        return $frames;
    }
    static function getgoodshouseFrames(){
        global $_W;
        $frames = array();
        $frames['goodshouse']['title'] = '<i class="fa fa-globe"></i>&nbsp;&nbsp; 仓库';
        $frames['goodshouse']['items'] = array();
        $frames['goodshouse']['items']['list']['url'] = web_url('goodshouse/goodshouse/goodslist');
        $frames['goodshouse']['items']['list']['title'] = '仓库商品';
        $frames['goodshouse']['items']['list']['actions'] = array('do', 'goodslist');
        $frames['goodshouse']['items']['list']['active'] = '';
        $frames['goodshouse']['items']['creategoods']['url'] = web_url('goodshouse/goodshouse/creategoods');
        $frames['goodshouse']['items']['creategoods']['title'] = '增加商品';
        $frames['goodshouse']['items']['creategoods']['actions'] = array('do', 'creategoods');
        $frames['goodshouse']['items']['creategoods']['active'] = '';
        return $frames;
    }
    static function getagentsetFrames(){
        global $_W, $_GPC;
        $frames = array();
        $frames['setting']['title'] = '<i class="fa fa-globe"></i>&nbsp;&nbsp; 设置';
        $frames['setting']['items'] = array();
        $frames['setting']['items']['base']['url'] = web_url('agentset/userset/profile');
        $frames['setting']['items']['base']['title'] = '账号信息';
        $frames['setting']['items']['base']['actions'] = array('ac', 'userset', 'do', 'profile');
        $frames['setting']['items']['base']['active'] = '';
        $frames['cover']['title'] = '<i class="fa fa-inbox"></i>&nbsp;&nbsp; 入口设置';
        $frames['cover']['items'] = array();
        $frames['cover']['items']['index']['url'] = web_url('agentset/coverset/index');
        $frames['cover']['items']['index']['title'] = '首页入口';
        $frames['cover']['items']['index']['actions'] = array('ac', 'coverset', 'do', 'index');
        $frames['cover']['items']['index']['active'] = '';
        $frames['cover']['items']['vip']['url'] = web_url('agentset/coverset/vip');
        $frames['cover']['items']['vip']['title'] = 'VIP开通入口';
        $frames['cover']['items']['vip']['actions'] = array('ac', 'coverset', 'do', 'vip');
        $frames['cover']['items']['vip']['active'] = '';
        $frames['cover']['items']['member']['url'] = web_url('agentset/coverset/member');
        $frames['cover']['items']['member']['title'] = '会员中心入口';
        $frames['cover']['items']['member']['actions'] = array('ac', 'coverset', 'do', 'member');
        $frames['cover']['items']['member']['active'] = '';
        $frames['cover']['items']['store']['url'] = web_url('agentset/coverset/store');
        $frames['cover']['items']['store']['title'] = '商户列表入口';
        $frames['cover']['items']['store']['actions'] = array('ac', 'coverset', 'do', 'store');
        $frames['cover']['items']['store']['active'] = '';
        return $frames;
    }
    static function color($n){
        if($n == 0)$s = 'danger';
        if($n > 0 && $n < 10)$s = 'warning';
        if($n >= 10)$s = 'success';
        return '<span class="text-' . $s . '" >' . $n . '</span>';
    }
}
