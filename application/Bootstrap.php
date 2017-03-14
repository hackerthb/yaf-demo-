<?php 
class Bootstrap extends Yaf_Bootstrap_Abstract {

    private $_config;

    /*get a copy of the config*/
    public function _initBootstrap(){
        $this->_config = Yaf_Application::app()->getConfig();
    }

    /*
     * initIncludePath is only required because zend components have a shit load of
     * include_once calls everywhere. Other libraries could probably just use
     * the autoloader (see _initNamespaces below).
     */
    public function _initIncludePath(){
        set_include_path(get_include_path() . PATH_SEPARATOR . $this->_config->application->library);
    }

    public function _initErrors(){
        if($this->_config->application->showErrors){
            error_reporting (-1);
            ini_set('display_errors','On');
        }
    }

    public function _initNamespaces(){
        Yaf_Loader::getInstance()->registerLocalNameSpace(array("Zend"));
    }

    public function _initRoutes(){

        //this does nothing useful but shows the regex router in action...
        Yaf_Dispatcher::getInstance()->getRouter()->addRoute(
            "paging_example",
            new Yaf_Route_Regex(
                "#^/index/page/(\d+)#",
                array('controller' => "index"),
                array(1 => "page")
            )
        );
        
    }
    
    public function _initLayout(Yaf_Dispatcher $dispatcher){
       /*layout allows boilerplate HTML to live in /views/layout rather than every script*/
        $layout = new LayoutPlugin('layout.phtml');

        /* Store a reference in the registry so values can be set later.
         * This is a hack to make up for the lack of a getPlugin
         * method in the dispatcher.
         */
        Yaf_Registry::set('layout', $layout);

        /*add the plugin to the dispatcher*/
        $dispatcher->registerPlugin($layout);
    }


    /*
    public function _initDefaultDbAdapter(){
        $dbAdapter = new Zend_Db_Adapter_Pdo_Sqlite(
            $this->_config->database->params->toArray()
        );

        Zend_Db_Table::setDefaultAdapter($dbAdapter);
    }
     */
    public function _initDefaultDbAdapter(){
        $dbAdapter = new Zend_Db_Adapter_Pdo_Mysql(
            $this->_config->database->params->toArray()
        );

        Zend_Db_Table::setDefaultAdapter($dbAdapter);
    }
    /*
     *link memcache
     */
    /*不知道方法是否正确，可以实现链接和使用
    public function _initMemcache()
    {
        $memcache = new Memcache();
        $memhost = $this->_config->get("memcache")->params->host;
        $memport = $this->_config->get("memcache")->params->port;
        $memtimeout = $this->_config->get("memcache")->params->timeout;
        $mempre =  $this->_config->get("memcache")->params->pre;
        $memcache->connect($memhost,$memport,$memtimeout);

        Yaf_Registry::set('memcache', $memcache);
        Yaf_Registry::set('mempre', $mempre);
        Yaf_Registry::set('memtimeout', $memtimeout);
    }    
    */

}
