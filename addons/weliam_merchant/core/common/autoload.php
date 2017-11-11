<?php
 function Weliam_AutoLoad($class_name){
    global $_W;
    if($class_name == 'CURLFile')return false;
    $file = PATH_CORE . 'model/' . $class_name . '.mod.php';
    if(!file_exists($file))$file = PATH_CORE . 'class/' . $class_name . '.class.php';
    if(!file_exists($file))$file = PATH_PLUGIN . strtolower($class_name) . '/' . $class_name . '.mod.php';
    if(!file_exists($file))trigger_error("访问的类 {$class_name} 不存在.");
    require_once $file;
    return false;
}
spl_autoload_register('Weliam_AutoLoad');
