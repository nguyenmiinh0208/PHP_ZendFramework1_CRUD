<?php
date_default_timezone_get('Asia/Ho_Chi_Minh');
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap{
    protected function _initAutoload() {
        $arrConfig = array('namespace'=> '',
                            'basePath'=> APPLICATION_PATH);
        $autoload = new Zend_Application_Module_Autoloader($arrConfig);
        return $autoload;
    }

    protected function _initDb() {
        $dbOption = $this->getOption('resources');
        $dbOption = $dbOption['db'];

        $db = Zend_Db::factory($dbOption['adapter'], $dbOption['params']);
        Zend_Registry::set('connectDb', $db);

        Zend_Db_Table::setDefaultAdapter($db);
        return $db;
    }

    protected function _initView() {
        $view = new Zend_View();
        return $view;
    }

    protected function _initSession() {
        Zend_Session::start();
    }

}