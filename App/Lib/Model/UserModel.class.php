<?php
class UserModel extends Model{
	protected $connection = 'DB_ZT';
	protected $trueTableName = 'zt_user'; 

	public function loginVerify($username, $password){
		//限制为技术部登录

		$users = $this->query("
			select u.id, u.dept, u.account, u.email, u.mobile, u.password 
			from zt_user u, zt_dept d
			where 
				u.dept = d.id and 
				d.path like ',2,%' and
				u.deleted = '0' and u.account = '".$username."' 
			limit 1");

		$res['userinfo']=$users[0];
		$res['code']=0;	//鉴权通过

		if (!$users[0]['id'])
		{
			$res['code']=1;	//用户不存在
			$res['msg']="用户不存在";
		}
		else if ($users[0]['password']!=$password)
		{
			$res['code']=2;	//密码不正确
			$res['msg']="密码不正确-".$users[0]['password']."-".md5($password);
		}
		Log::write('登录：'.$username.':'.$password, Log::DEBUG);

		return $res;
	}
	
	private $_userList = array();
	private $_userList_P = array();
	private $_dept;

    /**
     * 依据部门id获取部门成员列表
     * @param integer $deptid 部门id
     * @param bool $fresh 是否需要从缓存刷新用户列表
     * @return array
     */
	public function getDeptUserList($deptid, $fresh=false){
		global $_userList, $_userList_P, $_dept;

		$_dept = D('Dept');
		$_dept->getDeptTree($fresh);
		$this->getUserList($fresh);

		$res = $this->collectDeptUser($deptid);
//		echo("1.".$deptid); dump($res); 

		return (!$res) ? false : $res;
	}

	private function collectDeptUser($deptid){
		global $_userList_P, $_dept;

		//获取当前部门的成员
		$users = $_userList_P[$deptid];
//		echo("1.".$deptid); dump($users); 

		//获取下级部门的成员
		$res = $_dept->getDeptChilds($deptid);
		foreach ($res as $key=>$val)
		{
			$users += $this->collectDeptUser($val['id']);
		}
//		echo("2.".$deptid); dump($users); 

		return $users;
	}

	private function getUserList($fresh=false){
		global $_userList, $_userList_P, $_dept;

		if (!$fresh && count($_userList)>0)
			return $_userList;

//		unset($_userList, $_userList_P);
		$res = $this->
			field('id, dept, account, realname, email, mobile, phone, join')->
			where("deleted='0'")->
			order('dept, id')->select();

		if(is_array($res) && count($res)>0)
		{
			foreach ($res as $key=>$val)
			{
				$userDept = $_dept->getDept($val['dept']);
				$userDeptPath = $_dept->getDeptPath($val['dept']);
				$val['deptname'] = $userDept['name'];
				$val['deptpath'] = $userDeptPath;
				$_userList[$val['id']] = $val;
				$_userList_P[$val['dept']][$val['id']] = $val;
			}
		}
//dump($_dept); exit();
		return $_userList;
	}
}
?>