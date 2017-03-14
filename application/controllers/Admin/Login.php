<?php
class Admin_LoginController extends Yaf_Controller_Abstract
{

    private $_layout;

    public function init(){
        $this->_layout = Yaf_Registry::get('layout');
    }	
	/*
	 *登录首页
	 */
	public function IndexAction()
	{
		$this->_view->title =  "某系统后台";
		/*layout*/
        $this->_layout->meta_title = '管理员登录';
	}

	/*
	 *登录判断 
	 */
	public function LoginsAction()
	{
		$username = ($_POST['username'])?htmlspecialchars($_POST['username']):"";
		$password = ($_POST['password'])?htmlspecialchars($_POST['password']):"";
		$captcha = ($_POST['captcha'])?htmlspecialchars($_POST['captcha']):"";
		if(empty($captcha)){
			echo '101:请填写验证码';exit;
		}
		if(strtolower($_SESSION['admin_captcha'])!=strtolower($captcha))
		{
			echo '101:验证码错误';exit;
		}
		$password = md5($password);
		$login_status = new AdminModel();
		$info = $login_status->login_sign($username,$password);
		if(!empty($info)){
			$_SESSION['info'] = $info;
			unset($info);
			echo '1:登录成功！';exit;
		}else{
			echo '101:用户名或密码错误';exit;
		}

	}
	/*
	 *后台用户退出
	 * 
	 */
	public function LogoutAction()
	{
		unset($_SESSION['info']);
		header('Location:../admin_login');
	}
}