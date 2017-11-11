<?php
ini_set('display_errors', 'On');
error_reporting(30719);
require '../../../../framework/bootstrap.inc.php';
require '../../../../addons/weliam_merchant/core/common/defines.php';
require '../../../../addons/weliam_merchant/core/common/autoload.php';
require '../../../../addons/weliam_merchant/core/function/global.func.php';
global $_W;
global $_GPC;
ignore_user_abort();
set_time_limit(0);
$input['time'] = date('Y-m-d H:i:s', time());
$input['siteroot'] = $_W['siteroot'];
Util :: wl_log('sinaTask', PATH_DATA . 'tasklog', $input);
$queue = new Queue;
$queue -> queueMain();
?>