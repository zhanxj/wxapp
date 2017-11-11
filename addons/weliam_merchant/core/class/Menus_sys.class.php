<?php
defined('IN_IA')or exit('Access Denied');
class Menus_sys{
    static function color($n){
        if($n == 0)$s = 'danger';
        if($n > 0 && $n < 10)$s = 'warning';
        if($n >= 10)$s = 'success';
        return '<span class="text-' . $s . '" >' . $n . '</span>';
    }
    static function _calc_current_frames2(& $frames){
        global $_W, $_GPC;
        $i = 0;
        if(!empty($frames) && is_array($frames)){
            foreach($frames as & $frame){
                foreach($frame['items'] as $k => & $fr){
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
        $frames['dashboard']['title'] = '<i class="fa fa-desktop"></i>&nbsp;&nbsp; 概况';
        $frames['dashboard']['url'] = web_url('dashboard/dashboard');
        $frames['dashboard']['active'] = 'dashboard';
        $frames['member']['title'] = '<i class="fa fa-user"></i>&nbsp;&nbsp; 会员';
        $frames['member']['url'] = web_url('member/wlMember');
        $frames['member']['active'] = 'member';
        $frames['area']['title'] = '<i class="fa fa-map"></i>&nbsp;&nbsp; 代理';
        $frames['area']['url'] = web_url('area/areaagent/agentIndex');
        $frames['area']['active'] = 'area';
        $frames['finance']['title'] = '<i class="fa fa-money"></i>&nbsp;&nbsp; 财务';
        $frames['finance']['url'] = web_url('finace/wlCash/cashSurvey');
        $frames['finance']['active'] = 'finace';
        $frames['setting']['title'] = '<i class="fa fa-gear"></i>&nbsp;&nbsp; 设置';
        $frames['setting']['url'] = web_url('setting/shopset/base');
        $frames['setting']['active'] = 'setting';
        if($_W['isfounder']){
            $frames['cloud']['title'] = '<i class="fa fa-cloud"></i>&nbsp;&nbsp; 云服务';
            $frames['cloud']['url'] = web_url('cloud/auth/index');
            $frames['cloud']['active'] = 'cloud';
        }
        return $frames;
    }
    static function getdashboardFrames(){
        global $_W;
        $frames = array();
        return $frames;
    }
    static function getstoreFrames(){
        global $_W, $_GPC;
        $frames = array();
        $frames['register']['title'] = '<i class="fa fa-globe"></i>&nbsp;&nbsp; 入驻管理';
        $frames['register']['items'] = array();
        $frames['register']['items']['register']['url'] = web_url('store/register/index', array('status' => 1));
        $frames['register']['items']['register']['title'] = '待审核';
        $frames['register']['items']['register']['actions'] = array('ac', 'register', 'status', '1');
        $frames['register']['items']['register']['active'] = '';
        $frames['register']['items']['setting']['url'] = web_url('store/register/index', array('status' => 0));
        $frames['register']['items']['setting']['title'] = '未通过';
        $frames['register']['items']['setting']['actions'] = array('ac', 'register', 'status', '0');
        $frames['register']['items']['setting']['active'] = '';
        $frames['user']['title'] = '<i class="fa fa-inbox"></i>&nbsp;&nbsp; 商户管理';
        $frames['user']['items'] = array();
        $frames['user']['items']['index']['url'] = web_url('store/user/index', array('enabled' => ''));
        $frames['user']['items']['index']['title'] = '商户列表';
        $frames['user']['items']['index']['actions'] = array('ac', 'user', 'do', 'index');
        $frames['user']['items']['index']['active'] = '';
        $frames['user']['items']['edit']['url'] = web_url('store/user/edit');
        $frames['user']['items']['edit']['title'] = !empty($_GPC['id'])? '编辑商户' : '添加商户';
        $frames['user']['items']['edit']['actions'] = array('ac', 'user', 'do', 'edit');
        $frames['user']['items']['edit']['active'] = '';
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
        $frames['member']['title'] = '<i class="fa fa-globe"></i>&nbsp;&nbsp; 概况';
        $frames['member']['items'] = array();
        $frames['member']['items']['register']['url'] = web_url('member/wlMember/index');
        $frames['member']['items']['register']['title'] = '会员概况';
        $frames['member']['items']['register']['actions'] = array('ac', 'wlMember', 'do', 'index');
        $frames['member']['items']['register']['active'] = '';
        $frames['user']['title'] = '<i class="fa fa-inbox"></i>&nbsp;&nbsp; 会员管理';
        $frames['user']['items'] = array();
        $frames['user']['items']['notice']['url'] = web_url('member/wlMember/memberIndex');
        $frames['user']['items']['notice']['title'] = '会员列表';
        $frames['user']['items']['notice']['actions'] = array('ac', 'wlMember', 'do', 'memberIndex');
        $frames['user']['items']['notice']['active'] = '';
        $frames['user']['items']['adv']['url'] = web_url('member/wlMember/vipRecord');
        $frames['user']['items']['adv']['title'] = '开通记录';
        $frames['user']['items']['adv']['actions'] = array('ac', 'wlMember', 'do', 'vipRecord');
        $frames['user']['items']['adv']['active'] = '';
        $frames['user']['items']['setting']['url'] = web_url('member/memberset/index');
        $frames['user']['items']['setting']['title'] = '会员设置';
        $frames['user']['items']['setting']['actions'] = array('ac', 'memberset', 'do', 'index');
        $frames['user']['items']['setting']['active'] = '';
        $frames['user']['items']['type']['url'] = web_url('member/memberset/memberType');
        $frames['user']['items']['type']['title'] = '会员类别';
        $frames['user']['items']['type']['actions'] = array('ac', 'memberset', 'do', 'memberType');
        $frames['user']['items']['type']['active'] = '';
        $frames['token']['title'] = '<i class="fa fa-inbox"></i>&nbsp;&nbsp;激活码';
        $frames['token']['items'] = array();
        $frames['token']['items']['tokenSet']['url'] = web_url('member/token/setting');
        $frames['token']['items']['tokenSet']['title'] = '激活码设置';
        $frames['token']['items']['tokenSet']['actions'] = array('ac', 'token', 'do', 'setting');
        $frames['token']['items']['tokenSet']['active'] = '';
        $frames['token']['items']['tokenMade']['url'] = web_url('member/token/vipToken');
        $frames['token']['items']['tokenMade']['title'] = '激活码';
        $frames['token']['items']['tokenMade']['actions'] = array('ac', 'token', 'do', 'vipToken');
        $frames['token']['items']['tokenMade']['active'] = '';
        return $frames;
    }
    static function getareaFrames(){
        global $_W;
        $frames = array();
        $frames['user']['title'] = '<i class="fa fa-inbox"></i>&nbsp;&nbsp; 代理列表';
        $frames['user']['items'] = array();
        $frames['user']['items']['notice']['url'] = web_url('area/areaagent/agentIndex');
        $frames['user']['items']['notice']['title'] = '代理列表';
        $frames['user']['items']['notice']['actions'] = array('ac', 'areaagent', 'do', 'agentIndex');
        $frames['user']['items']['notice']['active'] = '';
        $frames['user']['items']['agentEdit']['url'] = web_url('area/areaagent/agentEdit');
        $frames['user']['items']['agentEdit']['title'] = '添加代理';
        $frames['user']['items']['agentEdit']['actions'] = array('ac', 'areaagent', 'do', 'agentEdit');
        $frames['user']['items']['agentEdit']['active'] = '';
        $frames['group']['title'] = '<i class="fa fa-inbox"></i>&nbsp;&nbsp; 代理分组';
        $frames['group']['items'] = array();
        $frames['group']['items']['adv']['url'] = web_url('area/areaagent/groupIndex');
        $frames['group']['items']['adv']['title'] = '代理分组';
        $frames['group']['items']['adv']['actions'] = array('ac', 'areaagent', 'do', 'groupIndex');
        $frames['group']['items']['adv']['active'] = '';
        $frames['group']['items']['groupEdit']['url'] = web_url('area/areaagent/groupEdit');
        $frames['group']['items']['groupEdit']['title'] = '添加分组';
        $frames['group']['items']['groupEdit']['actions'] = array('ac', 'areaagent', 'do', 'groupEdit');
        $frames['group']['items']['groupEdit']['active'] = '';
        $frames['selfarea']['title'] = '<i class="fa fa-inbox"></i>&nbsp;&nbsp; 地区管理';
        $frames['selfarea']['items'] = array();
        $frames['selfarea']['items']['notice']['url'] = web_url('area/hotarea/index');
        $frames['selfarea']['items']['notice']['title'] = '地区列表';
        $frames['selfarea']['items']['notice']['actions'] = array('ac', 'hotarea', 'do', 'index');
        $frames['selfarea']['items']['notice']['active'] = '';
        $frames['selfarea']['items']['custom']['url'] = web_url('area/custom/index');
        $frames['selfarea']['items']['custom']['title'] = '自定义地区';
        $frames['selfarea']['items']['custom']['actions'] = array('ac', 'custom');
        $frames['selfarea']['items']['custom']['active'] = '';
        $frames['agentcover']['title'] = '<i class="fa fa-inbox"></i>&nbsp;&nbsp; 入口设置';
        $frames['agentcover']['items'] = array();
        $frames['agentcover']['items']['notice']['url'] = web_url('area/areaagent/agentCover');
        $frames['agentcover']['items']['notice']['title'] = '代理入口';
        $frames['agentcover']['items']['notice']['actions'] = array('ac', 'areaagent', 'do', 'agentCover');
        $frames['agentcover']['items']['notice']['active'] = '';
        return $frames;
    }
    static function getfinaceFrames(){
        global $_W, $_GPC;
        $where = array();
        $where['status'] = 2;
        $list2 = Util :: getNumData('id', PDO_NAME . 'settlement_record', $where);
        $where['status'] = 3;
        $list3 = Util :: getNumData('id', PDO_NAME . 'settlement_record', $where);
        $where['status'] = 4;
        $list4 = Util :: getNumData('id', PDO_NAME . 'settlement_record', $where);
        $where['status'] = 5;
        $list5 = Util :: getNumData('id', PDO_NAME . 'settlement_record', $where);
        $where['status'] = -1;
        $list = Util :: getNumData('id', PDO_NAME . 'settlement_record', $where);
        $frames = array();
        $frames['cashSurvey']['title'] = '<i class="fa fa-database"></i>&nbsp;&nbsp; 财务概况';
        $frames['cashSurvey']['items'] = array();
        $frames['cashSurvey']['items']['datemana']['url'] = web_url('finace/wlCash/cashSurvey');
        $frames['cashSurvey']['items']['datemana']['title'] = '财务概况';
        $frames['cashSurvey']['items']['datemana']['actions'] = array();
        $frames['cashSurvey']['items']['datemana']['active'] = '';
        $frames['cashApply']['title'] = '<i class="fa fa-globe"></i>&nbsp;&nbsp; 提现申请';
        $frames['cashApply']['items'] = array();
        $frames['cashApply']['items']['display1']['url'] = web_url('finace/wlCash/cashApply', array('status' => '2'));
        $frames['cashApply']['items']['display1']['title'] = '待审核';
        $frames['cashApply']['items']['display1']['actions'] = array('do', 'cashApply', 'status', '2');
        $frames['cashApply']['items']['display1']['active'] = '';
        $frames['cashApply']['items']['display1']['append'] = self :: color(count($list2[0]));
        $frames['cashApply']['items']['display2']['url'] = web_url('finace/wlCash/cashApply', array('status' => '3'));
        $frames['cashApply']['items']['display2']['title'] = '待打款';
        $frames['cashApply']['items']['display2']['actions'] = array('do', array('cashApply', 'settlement'), 'status', '3');
        $frames['cashApply']['items']['display2']['active'] = '';
        $frames['cashApply']['items']['display2']['append'] = self :: color(count($list3[0]));
        $frames['cashApply']['items']['display3']['url'] = web_url('finace/wlCash/cashApply', array('status' => '4'));
        $frames['cashApply']['items']['display3']['title'] = '已结算到代理';
        $frames['cashApply']['items']['display3']['actions'] = array('do', 'cashApply', 'status', '4');
        $frames['cashApply']['items']['display3']['active'] = '';
        $frames['cashApply']['items']['display3']['append'] = self :: color(count($list4[0]));
        $frames['cashApply']['items']['display4']['url'] = web_url('finace/wlCash/cashApply', array('status' => '5'));
        $frames['cashApply']['items']['display4']['title'] = '已结算到商家';
        $frames['cashApply']['items']['display4']['actions'] = array('do', 'cashApply', 'status', '5');
        $frames['cashApply']['items']['display4']['active'] = '';
        $frames['cashApply']['items']['display4']['append'] = self :: color(count($list5[0]));
        $frames['cashApply']['items']['display5']['url'] = web_url('finace/wlCash/cashApply', array('status' => '-1'));
        $frames['cashApply']['items']['display5']['title'] = '未通过审核';
        $frames['cashApply']['items']['display5']['actions'] = array('do', 'cashApply', 'status', '-1');
        $frames['cashApply']['items']['display5']['active'] = '';
        $frames['cashApply']['items']['display5']['append'] = self :: color(count($list[0]));
        return $frames;
    }
    static function getsettingFrames(){
        global $_W, $_GPC;
        if($_GPC['ac'] == 'shopset' || $_GPC['ac'] == 'payset' || $_GPC['ac'] == 'coverset' || $_GPC['do'] == 'notice'){
            $frames = array();
            $frames['setting']['title'] = '<i class="fa fa-globe"></i>&nbsp;&nbsp; 设置';
            $frames['setting']['items'] = array();
            $frames['setting']['items']['base']['url'] = web_url('setting/shopset/base');
            $frames['setting']['items']['base']['title'] = '基础设置';
            $frames['setting']['items']['base']['actions'] = array('ac', 'shopset', 'do', 'base');
            $frames['setting']['items']['base']['active'] = '';
            $frames['setting']['items']['share']['url'] = web_url('setting/shopset/share');
            $frames['setting']['items']['share']['title'] = '分享关注';
            $frames['setting']['items']['share']['actions'] = array('ac', 'shopset', 'do', 'share');
            $frames['setting']['items']['share']['active'] = '';
            $frames['setting']['items']['templat']['url'] = web_url('setting/shopset/templat');
            $frames['setting']['items']['templat']['title'] = '模板设置';
            $frames['setting']['items']['templat']['actions'] = array('ac', 'shopset', 'do', 'templat');
            $frames['setting']['items']['templat']['active'] = '';
            $frames['setting']['items']['api']['url'] = web_url('setting/shopset/api');
            $frames['setting']['items']['api']['title'] = '接口设置';
            $frames['setting']['items']['api']['actions'] = array('ac', 'shopset', 'do', 'api');
            $frames['setting']['items']['api']['active'] = '';
            $frames['setting']['items']['halfcard']['url'] = web_url('setting/shopset/halfcard');
            $frames['setting']['items']['halfcard']['title'] = '五折卡设置';
            $frames['setting']['items']['halfcard']['actions'] = array('ac', 'shopset', 'do', 'halfcard');
            $frames['setting']['items']['halfcard']['active'] = '';
            $frames['payset']['title'] = '<i class="fa fa-inbox"></i>&nbsp;&nbsp; 支付';
            $frames['payset']['items'] = array();
            $frames['payset']['items']['payset']['url'] = web_url('setting/payset/index');
            $frames['payset']['items']['payset']['title'] = '支付方式';
            $frames['payset']['items']['payset']['actions'] = array('ac', 'payset');
            $frames['payset']['items']['payset']['active'] = '';
            $frames['notice']['title'] = '<i class="fa fa-inbox"></i>&nbsp;&nbsp; 消息';
            $frames['notice']['items'] = array();
            $frames['notice']['items']['message']['url'] = web_url('setting/noticeset/smslist');
            $frames['notice']['items']['message']['title'] = '短信消息';
            $frames['notice']['items']['message']['actions'] = array('ac', 'noticeset', 'do', 'smslist');
            $frames['notice']['items']['message']['active'] = '';
            $frames['notice']['items']['notice']['url'] = web_url('setting/noticeset/notice');
            $frames['notice']['items']['notice']['title'] = '模板消息';
            $frames['notice']['items']['notice']['actions'] = array('ac', 'noticeset', 'do', 'notice');
            $frames['notice']['items']['notice']['active'] = '';
            $frames['cover']['title'] = '<i class="fa fa-inbox"></i>&nbsp;&nbsp; 入口';
            $frames['cover']['items'] = array();
            $frames['cover']['items']['index']['url'] = web_url('setting/coverset/index');
            $frames['cover']['items']['index']['title'] = '首页入口';
            $frames['cover']['items']['index']['actions'] = array('ac', 'coverset', 'do', 'index');
            $frames['cover']['items']['index']['active'] = '';
            $frames['cover']['items']['vip']['url'] = web_url('setting/coverset/vip');
            $frames['cover']['items']['vip']['title'] = 'VIP开通入口';
            $frames['cover']['items']['vip']['actions'] = array('ac', 'coverset', 'do', 'vip');
            $frames['cover']['items']['vip']['active'] = '';
            $frames['cover']['items']['member']['url'] = web_url('setting/coverset/member');
            $frames['cover']['items']['member']['title'] = '会员中心入口';
            $frames['cover']['items']['member']['actions'] = array('ac', 'coverset', 'do', 'member');
            $frames['cover']['items']['member']['active'] = '';
            $frames['cover']['items']['store']['url'] = web_url('setting/coverset/store');
            $frames['cover']['items']['store']['title'] = '商户列表入口';
            $frames['cover']['items']['store']['actions'] = array('ac', 'coverset', 'do', 'store');
            $frames['cover']['items']['store']['active'] = '';
        }
        if($_GPC['ac'] == 'noticeset' && $_GPC['do'] != 'notice'){
            $frames['sms']['title'] = '<i class="fa fa-cloud"></i>&nbsp;&nbsp; 自定义短信';
            $frames['sms']['items'] = array();
            $frames['sms']['items']['note_display']['url'] = web_url('setting/noticeset/smslist');
            $frames['sms']['items']['note_display']['title'] = '短信模板';
            $frames['sms']['items']['note_display']['actions'] = array('ac', 'noticeset', 'do', 'smslist');
            $frames['sms']['items']['note_display']['active'] = '';
            $frames['sms']['items']['note_add']['url'] = web_url('setting/noticeset/smsadd');
            $frames['sms']['items']['note_add']['title'] = '添加模板';
            $frames['sms']['items']['note_add']['actions'] = array('ac', 'noticeset', 'do', 'smsadd');
            $frames['sms']['items']['note_add']['active'] = '';
            $frames['note_setting_title']['title'] = '<i class="fa fa-cloud"></i>&nbsp;&nbsp; 短信设置';
            $frames['note_setting_title']['items'] = array();
            $frames['note_setting_title']['items']['note_setting']['url'] = web_url('setting/noticeset/smsset');
            $frames['note_setting_title']['items']['note_setting']['title'] = '短信设置';
            $frames['note_setting_title']['items']['note_setting']['actions'] = array('ac', 'noticeset', 'do', 'smsset');
            $frames['note_setting_title']['items']['note_setting']['active'] = '';
            $frames['note_setting_title']['items']['note_param']['url'] = web_url('setting/noticeset/smsparams');
            $frames['note_setting_title']['items']['note_param']['title'] = '参数设置';
            $frames['note_setting_title']['items']['note_param']['actions'] = array('ac', 'noticeset', 'do', 'smsparams');
            $frames['note_setting_title']['items']['note_param']['active'] = '';
        }
        return $frames;
    }
    static function getcloudFrames(){
        global $_W, $_GPC;
        $frames = array();
        $frames['member']['title'] = '<i class="fa fa-globe"></i>&nbsp;&nbsp; 云服务';
        $frames['member']['items'] = array();
        $frames['member']['items']['setting']['url'] = web_url('cloud/auth/index');
        $frames['member']['items']['setting']['title'] = '系统授权';
        $frames['member']['items']['setting']['actions'] = array();
        $frames['member']['items']['setting']['active'] = '';
        $frames['member']['items']['display']['url'] = web_url('cloud/auth/upgrade');
        $frames['member']['items']['display']['title'] = '系统更新';
        $frames['member']['items']['display']['actions'] = array();
        $frames['member']['items']['display']['active'] = '';
        $frames['database']['title'] = '<i class="fa fa-database"></i>&nbsp;&nbsp; 数据管理';
        $frames['database']['items'] = array();
        $frames['database']['items']['datemana']['url'] = web_url('cloud/database/datemana');
        $frames['database']['items']['datemana']['title'] = '数据管理';
        $frames['database']['items']['datemana']['actions'] = array();
        $frames['database']['items']['datemana']['active'] = '';
        $frames['database']['items']['run']['url'] = web_url('cloud/database/run');
        $frames['database']['items']['run']['title'] = '运行SQL';
        $frames['database']['items']['run']['actions'] = array();
        $frames['database']['items']['run']['active'] = '';
        $frames['sysset']['title'] = '<i class="fa fa-database"></i>&nbsp;&nbsp; 系统设置';
        $frames['sysset']['items'] = array();
        $frames['sysset']['items']['base']['url'] = web_url('cloud/wlsysset/base');
        $frames['sysset']['items']['base']['title'] = '系统信息';
        $frames['sysset']['items']['base']['actions'] = array();
        $frames['sysset']['items']['base']['active'] = '';
        $frames['sysset']['items']['datemana']['url'] = web_url('cloud/wlsysset/taskcover');
        $frames['sysset']['items']['datemana']['title'] = '计划任务';
        $frames['sysset']['items']['datemana']['actions'] = array();
        $frames['sysset']['items']['datemana']['active'] = '';
        return $frames;
    }
}
