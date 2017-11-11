<?php
defined('IN_IA')or exit('Access Denied');
define('IN_SYS', true);
global $_W, $_GPC;
load() -> web('common');
load() -> web('template');
load() -> func('tpl');
$_W['token'] = token();
$session = json_decode(base64_decode($_GPC['__wlagent_session']), true);
if(is_array($session)){
    $user = User :: agentuser_single(array('id' => $session['id']));
    if(is_array($user) && $session['hash'] == md5($user['password'] . $user['salt'])){
        $_W['aid'] = $user['id'];
        $_W['uniacid'] = $user['uniacid'];
        $_W['agent'] = $user;
    }else{
        isetcookie('__wlagent_session', false, -100);
    }
    unset($user);
}
unset($session);
if(!empty($_W['uniacid'])){
    $_W['uniaccount'] = $_W['account'] = uni_fetch($_W['uniacid']);
    $_W['acid'] = $_W['account']['acid'];
}
if((empty($_W['aid']) || empty($_W['uniacid'])) && $_W['controller'] != 'login'){
    wl_message('抱歉，您无权进行该操作，请先登录！', web_url('user/login/agent_login'), 'warning');
}
