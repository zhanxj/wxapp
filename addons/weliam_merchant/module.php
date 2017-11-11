<?php
defined('IN_IA')or exit('Access Denied');
require_once IA_ROOT . '/addons/weliam_merchant/core/common/defines.php';
require_once PATH_CORE . 'common/autoload.php';
Func_loader :: core('global');
class Weliam_merchantModule extends WeModule{
    public function welcomeDisplay(){
        header('location: ' . web_url('dashboard/dashboard/index'));
        exit();
    }
}
?>