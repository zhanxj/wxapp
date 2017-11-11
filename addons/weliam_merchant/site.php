<?php
 defined('IN_IA')or exit('Access Denied');
require_once IA_ROOT . '/addons/weliam_merchant/core/common/defines.php';
require_once PATH_CORE . 'common/autoload.php';
Func_loader :: core('global');
class Weliam_merchantModuleSite extends WeModuleSite{
    public function __call($name, $arguments){
        global $_W, $_GPC;
        $isWeb = stripos($name, 'doWeb') === 0;
        $isMobile = stripos($name, 'doMobile') === 0;
        $catalog = !empty($isWeb)? 'sys' : 'app';
        $_W['plugin'] = $plugin = !empty($_GPC['p'])? $_GPC['p'] : 'dashboard';
        $_W['controller'] = $controller = !empty($_GPC['ac'])? $_GPC['ac'] : 'dashboard';
        $_W['method'] = $method = !empty($_GPC['do'])? $_GPC['do'] : 'index';
        $_W['wlsetting'] = Setting :: wlsetting_load();
        Func_loader :: $catalog('cover');
        if($isWeb || $isMobile){
            $dir = IA_ROOT . '/addons/' . $this -> modulename . '/';
            $file = $dir . $catalog . '/controller/' . $plugin . '/' . $controller . '.ctrl.php';
            if(file_exists($file)){
                require_once $file;
            }else{
                $file = $dir . 'plugin/' . $plugin . '/' . $catalog . '/controller/' . $controller . '.ctrl.php';
                if(file_exists($file)){
                    require_once $file;
                }else{
                    trigger_error("访问的模块 {$plugin} 不存在.", E_USER_WARNING);
                }
            }
            $instance = new $controller();
            if (!method_exists($instance, $method)){
                trigger_error('控制器 ' . $controller . ' 方法 ' . $method . ' 未找到!');
            }
            $instance -> $method();
            exit();
        }
        trigger_error("访问的模块 {$plugin} 不存在.", E_USER_WARNING);
        return null;
    }
}
