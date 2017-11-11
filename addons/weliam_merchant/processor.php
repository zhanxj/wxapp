<?php
defined('IN_IA')or exit('Access Denied');
require_once IA_ROOT . '/addons/weliam_merchant/core/common/defines.php';
require_once PATH_CORE . 'common/autoload.php';
Func_loader :: core('global');
class Weliam_merchantModuleProcessor extends WeModuleProcessor{
    public function respond(){
        global $_W;
        $message = $this -> message;
        file_put_contents(PATH_DATA . 'storeqr.log', var_export($message, true) . PHP_EOL, FILE_APPEND);
        if($message['content'] == 'weliam_merchant_storeqr'){
            Storeqr :: Processor($message);
        }
    }
}
