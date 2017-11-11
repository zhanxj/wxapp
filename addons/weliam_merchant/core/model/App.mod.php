<?php
defined('IN_IA')or exit('Access Denied');
class App{
    static function getPlugins(){
        $styles = Util :: traversingFiles(PATH_PLUGIN);
        $pluginsset = array();
        foreach ($styles as $key => $value){
            $confile = PATH_PLUGIN . $value . "/config.php";
            if(file_exists($confile)){
                $config = require $confile;
                if(!empty($config) && is_array($config)){
                    unset($config['menus']);
                    $pluginsset[$value] = $config;
                }
            }
        }
        return $pluginsset;
    }
    static function getCategory(){
        return array('market' => array('name' => '营销工具'), 'help' => array('name' => '辅助工具'));
    }
}
?>