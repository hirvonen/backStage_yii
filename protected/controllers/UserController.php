<?php

/**
 * 用户控制器
 * Class UserController
 */
class UserController extends Controller
{
	/**
	 * 用户访问过滤
	 */
	public function filters(){
		return array(
			'accessControl',
		);
	}

	/**
	 * 为具体方法设置具体访问条件
	 * * 全部用户(无论登录与否)
	 * ? 匿名用户
	 * 用户名 具体用户
	 * @ 登录用户
	 */
	public function accessRules(){
		return array(
			array(
				'allow',
				'actions'=>array('del','detail','initPassword','logout','show','chgpwd','update','add_step1','add_step2'),
				'users'=>array('superadmin'),
			),
			array(
				'allow',
				'actions'=>array('detail','logout','show','chgpwd','update'),
				'users'=>array('admin','zhangli','shenjia','zengkan','wangjiayi','weixuejiao'),
			),
			array(
				'allow',
				'actions'=>array('login'),
				'users'=>array('*'),
			),
			array(
				'deny',
				'users'=>array('*'),
			),
		);
	}

	/**
	 * 登陆
	 * @throws CException
	 */
	public function actionLogin()
	{
		$user_login = new LoginForm;

		if(isset($_POST['LoginForm'])){
			//收集表单信息
			$user_login->attributes = $_POST['LoginForm'];

			//校验数据，最终走的是rules()方法
			if($user_login->validate() && $user_login->login()){
				$this->redirect('./index.php?r=index/index');
			}

		}

		$this->renderPartial("login",array('user_login'=>$user_login));
	}

	/**
	 * 用户退出系统，删除session信息
	 */
	public function actionLogout()
	{
		Yii::app()->session->clear();
		Yii::app()->session->destroy();
		$this->redirect('./index.php?r=user/login');
	}

	/**
	 * 用户一览
	 */
	public function actionShow()
	{
		$user_model = User::model();

		if(isset($_POST["usr_kind"])){
			if($_POST["usr_kind"]==0){
				$findByFilter = 0;  //用户没有选择，只是单纯刷新页面，需要查询所有记录
			}
			else{
				$findByFilter = 1;  //需要按照filter查询记录
			}
		}
		else{
			$findByFilter = 0;  //首次进入页面，需要查询所有记录
		}

		if($findByFilter != 0){
			if ($_POST["usr_kind"] != 0) {
				$user_kind = $_POST["usr_kind"]-1;
				$user_info = $user_model->findAllByAttributes(array('usr_kind' => $user_kind));
			}
			else{
				$user_info = $user_model->findAll();
			}
		}
		else{
			$user_info = $user_model->findAll();
		}

		$this->renderPartial("show",array('user_info'=>$user_info));
	}

	/**
	 * 用户详细信息
	 */
	public function actionDetail($id)
	{
		$user_model = User::model();
		$user_info = $user_model->findByPk($id);
		if(isset($user_info)){
			switch($user_info->usr_kind){
				case 0:
					//管理员详细信息
					$admin_model = Admin::model();
					$admin_info = $admin_model->findByPk($id);
					if(isset($admin_info)){
						$this->renderPartial('detail',array("user_info"=>$user_info,"admin_info"=>$admin_info));
					}
					else{
						echo "<script>alert('tbl_admin表中未找到该用户！');</script>";
					}
					break;
				case 1:
					//理疗师详细信息
					$beautician_model = Beautician::model();
					$beautician_info = $beautician_model->findByPk($id);
					if(isset($beautician_info)){
						$this->renderPartial('detail',array("user_info"=>$user_info,"beautician_info"=>$beautician_info));
					}
					else{
						echo "<script>alert('tbl_beautician表中未找到该用户！');</script>";
					}
					break;
				case 2:
					//顾客详细信息
					$customer_model = Customer::model();
					$customer_info = $customer_model->findByPk($id);
					if(isset($customer_info)){
						$this->renderPartial('detail',array("user_info"=>$user_info,"customer_info"=>$customer_info));
					}
					else{
						echo "<script>alert('tbl_customer表中未找到该用户！');</script>";
						$customer_info = new Customer();
						$this->renderPartial('detail',array("user_info"=>$user_info,"customer_info"=>$customer_info));
					}
					break;
				default:
					break;
			}
		}
	}

	/**
	 * 删除用户
	 */
	public function actionDel($id)
	{
		/*
		$user_model = User::model();
		$user_info = $user_model->findByPk($id);
		if($user_info->delete()){
			$this->redirect('./index.php?r=user/show');
		}
		else{
			echo "<script>alert('".$user_model->usr_name." 删除失败');</script>";
		}*/
		//因为pk_usr_id被很多表当做外键使用，所以无法简单删除
		//本功能暂时不用
		//$this->redirect('./index.php?r=user/show');
		echo "<script>alert('因为pk_usr_id被很多表当做外键使用，所以无法简单删除。本功能暂时封印。');</script>";
	}

	/**
	 * 初始化用户密码
	 */
	public function actionInitPassword($id,$page)
	{
		$user_model = User::model();
		$user_info = $user_model->findByPk($id);
		$user_info->usr_password = md5("xyz123456");

		$user_info->user_chg_pwd_old = "oldpassword";
		$user_info->user_chg_pwd_new = "newpassword";
		$user_info->user_chg_pwd_new_cfm = "newpassword";

		if($user_info->save()) {
			echo "<script>alert('用户密码已被初始化为“xyz123456”。请尽快登录修改密码。');</script>";
		}
		else {
			echo "<script>alert('密码修改失败！');</script>";
		}

		//重新页面
		switch($page){
			case 1:
				//从用户详细页面调用，显示用户详细页面
				$this->actionDetail($id);
				break;
			case 2:
				//从修改用户详细页面调用，显示修改用户详细页面
				$this->actionUpdate($id);
				break;
			default:
				break;
		}
	}

	/**
	 * 更改用户密码
	 */
	public function actionChgPwd($username)
	{
		$user_model = User::model();
		$user_info = $user_model->findByAttributes(array('usr_username'=>$username));
		if(isset($user_info)){
			if(isset($_POST['User'])){
				//验证旧密码
				if($user_info->usr_password === md5($_POST['User']['user_chg_pwd_old'])){
					//验证新密码
					$user_info->usr_password = md5($_POST['User']['user_chg_pwd_new_cfm']);

					$user_info->user_chg_pwd_old = $_POST['User']['user_chg_pwd_old'];
					$user_info->user_chg_pwd_new = $_POST['User']['user_chg_pwd_new'];
					$user_info->user_chg_pwd_new_cfm = $_POST['User']['user_chg_pwd_new_cfm'];

					//保存新密码
					if($user_info->save()) {
						$this->redirect('./index.php?r=index/index');
					}
					else {
						echo "<script>alert('密码修改失败！');</script>";
					}
				}
				else {
					echo "<script>alert('现在密码填写错误！');</script>";
				}
			}
			$this->renderPartial("chgpwd",array('user_info'=>$user_info));
		}
	}

	/**
	 * 修改用户信息
	 */
	public function actionUpdate($id)
	{
		$user_model = User::model();
		$user_info = $user_model->findByPk($id);

		if(isset($user_info)) {
			if($user_info->usr_kind == 0) {
				//管理员详细信息
				$this->updateAdmin($id);
			}
			elseif($user_info->usr_kind == 1) {
				//理疗师详细信息
				$this->updateBeautician($id);
			}
			elseif($user_info->usr_kind == 2) {
				//顾客详细信息
				$this->updateCustomer($id);
			}
		}
	}

	private function updateAdmin($id)
	{
		$user_model = User::model();
		$user_info = $user_model->findByPk($id);

		$admin_model = Admin::model();
		$admin_info = $admin_model->findByPk($id);

		$image_model = Image::model();

		if(isset($user_info)&&isset($admin_info)) {
			if (isset($_POST["User"]) && isset($_POST["Admin"])) {
				$user_info->attributes = $_POST["User"];
				$admin_info->attributes = $_POST["Admin"];

				$user_info->user_chg_pwd_old = "oldpassword";
				$user_info->user_chg_pwd_new = "newpassword";
				$user_info->user_chg_pwd_new_cfm = "newpassword";

				//设置用户头像的默认值
				if($user_info->usr_pic_id == ''){
					$user_info->usr_pic_id = '100000';
				}

				if($admin_info->save()&&$user_info->save()){
//					$this->redirect("./index.php?r=user/detail&id=$id");
					$this->redirect("./index.php?r=user/show");
				}
				else {
					//var_dump($user_info->getErrors());
					//var_dump($customer_info->getErrors());
					echo "<script>alert('用户信息修改失败！');</script>";
				}
			}
		}

		$this->renderPartial('update', array("user_info" => $user_info, "admin_info" => $admin_info,"image_model"=>$image_model));
	}
	private function updateBeautician($id)
	{
		$user_model = User::model();
		$user_info = $user_model->findByPk($id);

		$beautician_model = Beautician::model();
		$beautician_info = $beautician_model->findByPk($id);

		$image_model = Image::model();

		if(isset($user_info)&&isset($beautician_info)) {
			if (isset($_POST["User"]) && isset($_POST["Beautician"])) {
				$user_info->attributes = $_POST["User"];
				$beautician_info->attributes = $_POST["Beautician"];

				$user_info->user_chg_pwd_old = "oldpassword";
				$user_info->user_chg_pwd_new = "newpassword";
				$user_info->user_chg_pwd_new_cfm = "newpassword";

				//设置用户头像的默认值
				if($user_info->usr_pic_id == ''){
					$user_info->usr_pic_id = '100000';
				}

				if($beautician_info->save()&&$user_info->save()){
//					$this->redirect("./index.php?r=user/detail&id=$id");
					$this->redirect("./index.php?r=user/show");
				}
				else {
					//var_dump($user_info->getErrors());
					//var_dump($customer_info->getErrors());
					echo "<script>alert('用户信息修改失败！');</script>";
				}
			}
		}

		$this->renderPartial('update', array("user_info" => $user_info, "beautician_info" => $beautician_info,"image_model"=>$image_model));
	}
	private function updateCustomer($id)
	{
		$user_model = User::model();
		$user_info = $user_model->findByPk($id);

		$customer_model = Customer::model();
		$customer_info = $customer_model->findByPk($id);

		$image_model = Image::model();

		if(isset($user_info)&&isset($customer_info)) {
			if (isset($_POST["User"]) && isset($_POST["Customer"])) {
				$user_info->attributes = $_POST["User"];
				$customer_info->attributes = $_POST["Customer"];

				$user_info->user_chg_pwd_old = "oldpassword";
				$user_info->user_chg_pwd_new = "newpassword";
				$user_info->user_chg_pwd_new_cfm = "newpassword";

				//设置用户头像的默认值
				if($user_info->usr_pic_id == ''){
					$user_info->usr_pic_id = '100000';
				}

				if($customer_info->save()&&$user_info->save()){
//					$this->redirect("./index.php?r=user/detail&id=$id");
					$this->redirect("./index.php?r=user/show");
				}
				else {
					//var_dump($user_info->getErrors());
					//var_dump($customer_info->getErrors());
					echo "<script>alert('用户信息修改失败！');</script>";
				}
			}
		}

		$this->renderPartial('update', array("user_info" => $user_info, "customer_info" => $customer_info,"image_model"=>$image_model));
	}

	/**
	 * 用户增加：第一步（选择用户种别）
	 * @throws CException
	 */
	public function actionAdd_step1()
	{
		$user_model = new User();

		if(isset($_POST["User"])) {
			$user_kind = $_POST["User"]["usr_kind"];
			$this->redirect("./index.php?r=user/add_step2&user_kind=$user_kind");
		}
		$this->renderPartial('add_step1',array('user_model'=>$user_model));
	}

	/**
	 * 用户增加：第二步（完善用户信息）
	 * @throws CException
	 */
	public function actionAdd_step2($user_kind)
	{
		switch($user_kind){
			case 0:
				$this->addAdmin();
				break;
			case 1:
				$this->addBeautician();
				break;
			case 2:
				$this->addCustomer();
				break;
			default:
				break;
		}
	}

	private function addAdmin()
	{
		$user_model = new User();
		$admin_model = new Admin();

		$image_model = Image::model();

		if (isset($_POST["User"]) && isset($_POST["Admin"])) {
			$user_model->attributes = $_POST["User"];
			$admin_model->attributes = $_POST["Admin"];

			//设定用户种别为：管理员
			$user_model->usr_kind = 0;

			//设定用户密码为：xyz123456
			$user_model->usr_password = md5("xyz123456");

			$user_model->user_chg_pwd_old = "oldpassword";
			$user_model->user_chg_pwd_new = "newpassword";
			$user_model->user_chg_pwd_new_cfm = "newpassword";

			//设置用户头像的默认值
			if($user_model->usr_pic_id == ''){
				$user_model->usr_pic_id = '100000';
			}

			if($user_model->save()){
				$admin_model->pk_adm_id = $user_model->pk_usr_id;
				if($admin_model->save()) {
					$this->redirect("./index.php?r=user/show");
				}
				else{
					$user_model->delete();
				}
			}
			else {
				//var_dump($user_model->getErrors());
				//var_dump($customer_info->getErrors());
				echo "<script>alert('用户添加失败！');</script>";
			}
		}

		$this->renderPartial('add_step2', array("user_info" => $user_model, "admin_info" => $admin_model,"image_model"=>$image_model,"user_kind"=>0));
	}
	private function addBeautician()
	{
		$user_model = new User();
		$beautician_model = new Beautician();

		$image_model = Image::model();

		if (isset($_POST["User"]) && isset($_POST["Beautician"])) {
			$user_model->attributes = $_POST["User"];
			$beautician_model->attributes = $_POST["Beautician"];

			//设定用户种别为：美容师
			$user_model->usr_kind = 1;

			//设定用户密码为：xyz123456
			$user_model->usr_password = md5("xyz123456");

			$user_model->user_chg_pwd_old = "oldpassword";
			$user_model->user_chg_pwd_new = "newpassword";
			$user_model->user_chg_pwd_new_cfm = "newpassword";

			//设置用户头像的默认值
			if($user_model->usr_pic_id == ''){
				$user_model->usr_pic_id = '100000';
			}

			if($user_model->save()){
				$beautician_model->pk_beau_id = $user_model->pk_usr_id;
				if($beautician_model->save()) {
					$this->redirect("./index.php?r=user/show");
				}
				else{
					echo "<script>alert('用户添加失败！');</script>";
					$user_model->delete();
				}
			}
			else {
				//var_dump($user_model->getErrors());
				//var_dump($customer_info->getErrors());
				echo "<script>alert('用户添加失败！');</script>";
			}
		}

		$this->renderPartial('add_step2', array("user_info" => $user_model, "beautician_info" => $beautician_model,"image_model"=>$image_model,"user_kind"=>1));
	}
	private function addCustomer()
	{
		$user_model = new User();
		$customer_model = new Customer();

		$image_model = Image::model();

		if (isset($_POST["User"]) && isset($_POST["Customer"])) {
			$user_model->attributes = $_POST["User"];
			$customer_model->attributes = $_POST["Customer"];

			//设定用户种别为：顾客
			$user_model->usr_kind = 2;

			//设定用户密码为：xyz123456
			$user_model->usr_password = md5("xyz123456");

			$user_model->user_chg_pwd_old = "oldpassword";
			$user_model->user_chg_pwd_new = "newpassword";
			$user_model->user_chg_pwd_new_cfm = "newpassword";

			//设置用户头像的默认值
			if($user_model->usr_pic_id == ''){
				$user_model->usr_pic_id = '100000';
			}

			if($user_model->save()){
				$customer_model->pk_cust_id = $user_model->pk_usr_id;
				if($customer_model->save()) {
					$this->redirect("./index.php?r=user/show");
				}
				else{
					$user_model->delete();
				}
			}
			else {
				//var_dump($user_model->getErrors());
				//var_dump($customer_info->getErrors());
				echo "<script>alert('用户添加失败！');</script>";
			}
		}

		$this->renderPartial('add_step2', array("user_info" => $user_model, "customer_info" => $customer_model,"image_model"=>$image_model,"user_kind"=>2));
	}
}