<?php
class IndexController extends Yaf_Controller_Abstract {

    private $_layout;

    public function init(){
        $this->_layout = Yaf_Registry::get('layout');
    }

    public function indexAction() {
        /*layout*/
        $this->_layout->meta_title = '前台首页';
    }
    
}
