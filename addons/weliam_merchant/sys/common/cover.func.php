<?php
defined('IN_IA')or exit('Access Denied');
define('IN_SYS', true);
global $_W, $_GPC;
$auth = Cloud :: wl_syssetting_read('auth');
$auth['ip'] = $_W['clientip'];
		$auth['domain'] = $_W['siteroot'];
		$auth['siteid'] = $siteid;
		$auth['code'] = '1111111111111';
		$auth['family'] = 'base';
$tmpdir = IA_ROOT . '/addons/' . MODULE_NAME . '/core/common';
$f = file_get_contents($tmpdir . '/common.log');
$commonlog = json_decode($f, true);
if (!empty($commonlog) && $commonlog['domain'] != $_W['siteroot']){
    file_put_contents($tmpdir . '/common.log', json_encode($auth));
    $commonlog['nowurl'] = $_W['siteroot'];
    Util :: httpPost(WL_URL_AUTH, array('type' => 'uplog', 'module' => MODULE_NAME, 'data' => $commonlog), null, 1);
}
if (empty($auth) && $_W['plugin'] != 'cloud'){
    header("Location: " . web_url('cloud/auth/index'));
    exit;
}
