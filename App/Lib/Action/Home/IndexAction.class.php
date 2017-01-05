<?php
// 本类由系统自动生成，仅供测试用途
class IndexAction extends BaseAction {
    public function index(){
		//初始化上传目录
        $webs = array(
				'万步网' => array(
				'url' => 'http://www.wanbu.com.cn',
				'img' => 'wanbu.jpg',
			),
				'禅道项目管理系统' => array(
				'url' => 'http://192.168.92.177/zentao',
				'img' => 'zentao.jpg',
			),
				'技术中心文库' => array(
				'url' => 'http://192.168.92.177/mtceo',
				'img' => 'mtceo.jpg',
			),
				'技术中心论坛' => array(
				'url' => 'http://192.168.92.177/x2',
				'img' => 'discuz.jpg',
			),
				'办公OA系统' => array(
				'url' => 'http://192.168.92.147:8000/seeyon',
				'img' => 'OA.jpg',
			),
				'培训考试系统' => array(
				'url' => 'http://192.168.92.177/ppf',
				'img' => 'ppf.jpg',
			)
		);
		$this->assign('webs',$webs);

		$this->display();
    }
}
