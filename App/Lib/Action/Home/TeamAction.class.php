<?php
// 本类由系统自动生成，仅供测试用途
class TeamAction extends BaseAction {
    public function index(){
		//按照部门来展示视图，默认是技术部
		$deptid = ($_REQUEST['dept']) ? $_REQUEST['dept'] : 2;

		//获取公司部门结构、当前部门的下级部门、当前部门的路径
G('run0');		
		$dept = D('Dept');
		$dept->getDeptTree();
trace('getDeptTree:'.G('run0','en1').'s');
		$res = $dept->getDeptChilds($deptid);
trace('getDeptChilds:'.G('run0','en2').'s');
		$this->assign('Depts',$res);
		$res = (!$res) ? 0 : count($res);
		$this->assign('DeptNum',$res);
		$res = $dept->getDeptPath($deptid);
trace('getDeptPath:'.G('run0','en3').'s');
		$this->assign('DeptPath',$res);

		//获取当前部门，以及当前部门的下级部门的人员
		$user = D('User');
		$res = $user->getDeptUserList($deptid);
trace('getDeptUserList:'.G('run0','en4').'s');
		$this->assign('Users',$res);
//		dump($res); exit();

		$this->display();
    }

    private function init_seats(){
		for ($i=1;$i<7;$i++){
			for ($j=1;$j<16;$j++){
				$seats[$i][$j]='a';
			}
		}
		return $seats;
	}

    public function seat(){
		$this->assign('Seats',$this->init_seats());
		$this->display();
	}

}
