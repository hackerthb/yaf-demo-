<?php
class AdminModel extends Zend_Db_Table {

    protected $_name = 'admin';
    protected $_primary = 'id';     
    protected $_db;
    private $_table = "admin";

    /*
     *用户登录判断
     *@param $username,$password
     *return $user_info | false 
     */
    public function login_sign($username,$password)
    {
  		$this->_db = $this->getAdapter();
  		$select = $this->_db->select();
  		$select->from($this->_table)
                 ->where('username = ?', $username)
                 ->where('password = ?',$password);		
  		return $this->_db->fetchRow($select);
    }

    /*
     *所有用户信息显示
     *
     */
    public function show_admins()
    {
        $this->_db = $this->getAdapter();
         $select = $this->_db->select();
         $select->from($this->_table)
         ->where('is_del','0');
         return $this->_db->fetchAll($select);
    }

    /*
     *添加新用户
     *
     */
    public function insert_admin($data)
    {
        $data['password'] = md5($data['password']);
        $this->_db = $this->getAdapter();
        $this->_db->insert($this->_table,$data);
        return $this->_db->lastInsertId();
    }

    /*
     *删除用户
     *
     */
    public function del_admin($id){
        $this->_db = $this->getAdapter();
        $where = $this->_db->quoteInto('id = ?', $id);//条件
        return $this->_db->delete($this->_table, $where);
    }

    /*
     *获取用户信息
     *
     */
    public function get_info($id)
    {
      $this->_db = $this->getAdapter();
      $select = $this->_db->select();
      $select->from($this->_table)
                 ->where('id = ?', $id);
      return $this->_db->fetchRow($select);      
    }
    
    /*
     *修改用户信息
     *
     */
    public function update_admin($data,$id)
    {
      $this->_db = $this->getAdapter();
      $where = $this->_db->quoteInto('id = ?', $id);//条件
      return $this->_db->update($this->_table,$data,$where);      
    }
}
