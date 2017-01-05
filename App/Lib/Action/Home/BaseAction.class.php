<?php
// 本类由系统自动生成，仅供测试用途
class BaseAction extends Action {
	public function actionlog(){
		//每个用户在redis里有一个操作记录的队列
	}

    public function _initialize(){

		//新打开浏览器，session为空，用cookie来建立session
		if(session('userinfo'))
		{ 
			return true;
		}

		//鉴权
		$userinfo = cookie('userinfo');
		if ($userinfo)
		{
			$user = D('User');
			$res = $user->loginVerify($userinfo['account'], $userinfo['password']);
			if ($res['code']==0)
			{
				//鉴权通过，更新cookie和session
				cookie('userinfo',$res['userinfo'],60*60*24*30);
				session('userinfo',$res['userinfo']);
				return true;
			}
		}
		header("Location:".U('Home/Login/login'));
	}
}
