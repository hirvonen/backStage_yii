<?php

/**
 * 商品控制器
 * Class CommodityController
 */
class CommodityController extends Controller
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
				'actions'=>array('addProduct','addService','delProduct','delService','showProduct','showService','updateProduct','updateService','ShowSale'),
				'users'=>array('superadmin'),
			),
			array(
				'allow',
				'actions'=>array('addProduct','addService','showProduct','showService','updateProduct','updateService','ShowSale'),
				'users'=>array('admin'),
			),
			array(
				'deny',
				'users'=>array('*'),
			),
		);
	}

	/**
	 * 服务一览
	 * @throws CException
	 */
	public function actionShowService()
	{
		//通过模型来实现数据表信息查询
		//产生模型对象
		$commodity_model = Commodity::model();
		$query="select * from tbl_commodity where comm_kind<>8";

		//判断Filter是否被用户选择了
		if(isset($_POST["comm_is_show"])){
            if(($_POST["comm_is_show"]!=2)&&($_POST["comm_is_hot"]!=2)) {
	            $query = $query." and comm_is_show=".
		            $_POST["comm_is_show"].
		            " and comm_is_hot=".
		            $_POST["comm_is_hot"];
//				$commodity_info = $commodity_model->findAllByAttributes(array('comm_kind'=>"1",
//                                                                                'comm_is_show'=>$_POST["comm_is_show"],
//                                                                                'comm_is_hot'=>$_POST["comm_is_hot"]));
			}
			elseif($_POST["comm_is_show"]!=2){
				$query = $query." and comm_is_show=".
					$_POST["comm_is_show"];
//                $commodity_info = $commodity_model->findAllByAttributes(array('comm_kind'=>"1",
//                                                                                'comm_is_show'=>$_POST["comm_is_show"]));
			}
            elseif($_POST["comm_is_hot"]!=2){
	            $query = $query." and comm_is_hot=".
		            $_POST["comm_is_hot"];
//                $commodity_info = $commodity_model->findAllByAttributes(array('comm_kind'=>"1",
//                                                                                'comm_is_hot'=>$_POST["comm_is_hot"]));
			}
			else{}
		}
//        else{
//            $commodity_info = $commodity_model->findAllByAttributes(array('comm_kind'=>"1"));
//        }
		$commodity_info = $commodity_model->findAllBySql($query);

		//传递到视图
		$this->renderPartial('showService',array('commodity_info'=>$commodity_info));
	}

	/**
	 * 商品一览
	 * @throws CException
	 */
	public function actionShowProduct()
	{
		//通过模型来实现数据表信息查询
		//产生模型对象
		$commodity_model = Commodity::model();
		$query="select * from tbl_commodity where comm_kind=8";

		//判断Filter是否被用户选择了
		if(isset($_POST["comm_is_show"])){
			if(($_POST["comm_is_show"]!=2)&&($_POST["comm_is_hot"]!=2)) {
				$query = $query." and comm_is_show=".
					$_POST["comm_is_show"].
					" and comm_is_hot=".
					$_POST["comm_is_hot"];
//				$commodity_info = $commodity_model->findAllByAttributes(array('comm_kind'=>"2",
//					'comm_is_show'=>$_POST["comm_is_show"],
//					'comm_is_hot'=>$_POST["comm_is_hot"]));
			}
			elseif($_POST["comm_is_show"]!=2){
				$query = $query." and comm_is_show=".
					$_POST["comm_is_show"];
//				$commodity_info = $commodity_model->findAllByAttributes(array('comm_kind'=>"2",
//					'comm_is_show'=>$_POST["comm_is_show"]));
			}
			elseif($_POST["comm_is_hot"]!=2){
				$query = $query." and comm_is_hot=".
					$_POST["comm_is_hot"];
//				$commodity_info = $commodity_model->findAllByAttributes(array('comm_kind'=>"2",
//					'comm_is_hot'=>$_POST["comm_is_hot"]));
			}
			else{}
		}
//		else{
//			$commodity_info = $commodity_model->findAllByAttributes(array('comm_kind'=>"2"));
//		}
		$commodity_info = $commodity_model->findAllBySql($query);

		//传递到视图
		$this->renderPartial('showProduct',array('commodity_info'=>$commodity_info));
	}

	/**
	 * 服务增加
	 * @throws CException
	 */
	public function actionAddService()
	{
		$commodity_model = new Commodity();
        $commodity_service_model = new Commodity_Service();

		if(isset($_POST["Commodity"]) && isset($_POST["Commodity_Service"])) {

			//foreach ($_POST["Commodity"] as $_name=>$_value) {
			//	$commodity_model->$_name = $_value;
			//}
			$commodity_model->attributes = $_POST["Commodity"];
            $commodity_service_model->attributes = $_POST["Commodity_Service"];

			//DB内的值为1和2，网页上的值为0和1
			$commodity_model->comm_kind = 1;

			//如果商品为表示的，则认定商品已经上架
			if($commodity_model->comm_is_show == 1) {
				$commodity_model->comm_on_shelve_time = date("Y-m-d H:i:s", time());
			}

			//插入DB
			if($commodity_model->save()) {
				//页面重定向
                //Commodity_service的表单主键设置
                $commodity_service_model->pk_serv_id = $commodity_model->pk_comm_id;
                if($commodity_service_model->save()) {
                    $this->redirect('./index.php?r=commodity/showService');
                }
                else{
                    //删除已经插入的数据
                    $commodity_info = $commodity_model->findByPk($commodity_model->pk_comm_id);
                    $commodity_info->delete();

                    //出个警告
                    echo "<script>alert('".$_POST["Commodity"]["comm_name"]." 添加失败');</script>";
                }
			}
			else{
				echo "<script>alert('".$_POST["Commodity"]["comm_name"]." 添加失败');</script>";
			}
            /*echo "<pre>";
            print_r($_POST["Commodity"]);
            print_r($_POST["Commodity_Service"]);
            echo "</pre>";*/
		}
		$this->renderPartial('addService',array('commodity_model'=>$commodity_model,
                                                'commodity_service_model'=>$commodity_service_model));
	}

	/**
	 * 商品增加
	 * @throws CException
	 */
	public function actionAddProduct()
	{
		$commodity_model = new Commodity();
		$commodity_product_model = new Commodity_Product();

		if(isset($_POST["Commodity"]) && isset($_POST["Commodity_Product"])) {

			//foreach ($_POST["Commodity"] as $_name=>$_value) {
			//	$commodity_model->$_name = $_value;
			//}
			$commodity_model->attributes = $_POST["Commodity"];
			$commodity_product_model->attributes = $_POST["Commodity_Product"];

			//DB内的值为1和2，网页上的值为0和1
			$commodity_model->comm_kind = 2;

			//如果商品为表示的，则认定商品已经上架
			if($commodity_model->comm_is_show == 1) {
				$commodity_model->comm_on_shelve_time = date("Y-m-d H:i:s", time());
			}

			//插入DB
			if($commodity_model->save()) {
				//页面重定向
				//Commodity_service的表单主键设置
				$commodity_product_model->pk_prod_id = $commodity_model->pk_comm_id;
				if($commodity_product_model->save()) {
					$this->redirect('./index.php?r=commodity/showProduct');
				}
				else{
					//删除已经插入的数据
					$commodity_info = $commodity_model->findByPk($commodity_model->pk_comm_id);
					$commodity_info->delete();

					//出个警告
					echo "<script>alert('".$_POST["Commodity"]["comm_name"]." 添加失败');</script>";
				}
			}
			else{
				echo "<script>alert('".$_POST["Commodity"]["comm_name"]." 添加失败');</script>";
			}
			/*echo "<pre>";
			print_r($_POST["Commodity"]);
			print_r($_POST["Commodity_Service"]);
			echo "</pre>";*/
		}
		$this->renderPartial('addProduct',array('commodity_model'=>$commodity_model,
			'commodity_product_model'=>$commodity_product_model));
	}



	/**
	 * 服务修改
	 * @throws CException
	 */
	public function actionUpdateService($id)
	{
		$commodity_model = Commodity::model();
		$commodity_info = $commodity_model->findByPk($id);

        if(!isset($commodity_info)){
            echo "<script>alert('commodity表中未找到该条记录！');</script>";
        }

        $commodity_service_model = Commodity_Service::model();
        $commodity_service_info = $commodity_service_model->findByPk($id);

        if(!isset($commodity_service_info)){
            echo "<script>alert('commodity_service表中未找到该条记录！');</script>";
        }

		//修改前先记录商品是否表示的信息，用来判断商品是否下架
		$commodity_show = $commodity_info->comm_is_show;

        if(isset($_POST["Commodity"]) && isset($_POST["Commodity_Service"])) {

            $commodity_info->attributes = $_POST["Commodity"];
            $commodity_service_info->attributes = $_POST["Commodity_Service"];

//            $commodity_info->comm_kind = 1;

			//修改时间
			$commodity_info->comm_update_time = date("Y-m-d H:i:s",time());

			//如果从 不表示变为表示 ，则认为货品下架，需要记录下架时间
			if(($commodity_show == 1) &&
				($commodity_info->comm_is_show != 1)){
				//下架时间更新
				$commodity_info->comm_off_shelve_time = date("Y-m-d H:i:s",time());
			}
			elseif(($commodity_show != 1) &&
				($commodity_info->comm_is_show == 1)){
				//上架时间更新
				$commodity_info->comm_on_shelve_time = date("Y-m-d H:i:s",time());
				//下架时间更新（设空）
				$commodity_info->comm_off_shelve_time = null;
			}

			//插入DB
			if(($commodity_service_info->save())&&($commodity_info->save())) {
				//页面重定向
				$this->redirect('./index.php?r=commodity/showService');
			}
			else{
				echo "<script>alert('".$_POST["Commodity"]["comm_name"]." 修改失败');</script>";
			}
//	        echo "<pre>";
//	        print_r($commodity_info);
//	        echo "</pre>";
		}

		$this->renderPartial('updateService',array("commodity_model"=>$commodity_info,
                                            "commodity_service_model"=>$commodity_service_info));
	}

	/**
	 * 商品修改
	 * @throws CException
	 */
	public function actionUpdateProduct($id)
	{
		$commodity_model = Commodity::model();
		$commodity_info = $commodity_model->findByPk($id);

		if(!isset($commodity_info)){
			echo "<script>alert('commodity表中未找到该条记录！');</script>";
		}

		$commodity_product_model = Commodity_Product::model();
		$commodity_product_info = $commodity_product_model->findByPk($id);

		if(!isset($commodity_product_info)){
			echo "<script>alert('commodity_product表中未找到该条记录！');</script>";
		}

		//修改前先记录商品是否表示的信息，用来判断商品是否下架
		$commodity_show = $commodity_info->comm_is_show;

		if(isset($_POST["Commodity"]) && isset($_POST["Commodity_Product"])) {

			$commodity_info->attributes = $_POST["Commodity"];
			$commodity_product_info->attributes = $_POST["Commodity_Product"];

//			$commodity_info->comm_kind = 2;

			//修改时间
			$commodity_info->comm_update_time = date("Y-m-d H:i:s",time());

			//如果从 不表示变为表示 ，则认为货品下架，需要记录下架时间
			if(($commodity_show == 1) &&
				($commodity_info->comm_is_show != 1)){
				//下架时间更新
				$commodity_info->comm_off_shelve_time = date("Y-m-d H:i:s",time());
			}
			elseif(($commodity_show != 1) &&
				($commodity_info->comm_is_show == 1)){
				//上架时间更新
				$commodity_info->comm_on_shelve_time = date("Y-m-d H:i:s",time());
				//下架时间更新（设空）
				$commodity_info->comm_off_shelve_time = null;
			}

			//插入DB
			if(($commodity_product_info->save())&&($commodity_info->save())) {
				//页面重定向
				$this->redirect('./index.php?r=commodity/showProduct');
			}
			else{
				echo "<script>alert('".$_POST["Commodity"]["comm_name"]." 修改失败');</script>";
			}
		}

		$this->renderPartial('updateProduct',array("commodity_model"=>$commodity_info,
			"commodity_product_model"=>$commodity_product_info));
	}

	/**
	 * 服务删除
	 */
	public function actionDelService($id)
	{
		$commodity_model = Commodity::model();
		$commodity_info = $commodity_model->findByPk($id);
        $commodity_service_model = Commodity_Service::model();
        $commodity_service_info = $commodity_service_model->findByPk($id);

        //如果有单独服务信息的话，先删除单独的服务信息，再删除主表信息
        if(isset($commodity_service_info)){
            if(($commodity_service_info->delete())&&($commodity_info->delete())){
                $this->redirect('./index.php?r=commodity/showService');
            }
            else{
                echo "<script>alert('".$commodity_info->comm_name." 删除失败');</script>";
            }
        }
        else{
            if($commodity_info->delete()){
                $this->redirect('./index.php?r=commodity/showService');
            }
            else{
                echo "<script>alert('".$commodity_info->comm_name." 删除失败');</script>";
            }
        }
	}

	/**
	 * 商品删除
	 */
	public function actionDelProduct($id)
	{
		$commodity_model = Commodity::model();
		$commodity_info = $commodity_model->findByPk($id);
		$commodity_product_model = Commodity_Product::model();
		$commodity_product_info = $commodity_product_model->findByPk($id);

		//如果有单独服务信息的话，先删除单独的服务信息，再删除主表信息
		if(isset($commodity_product_info)){
			if(($commodity_product_info->delete())&&($commodity_info->delete())){
				$this->redirect('./index.php?r=commodity/showProduct');
			}
			else{
				echo "<script>alert('".$commodity_info->comm_name." 删除失败');</script>";
			}
		}
		else{
			if($commodity_info->delete()){
				$this->redirect('./index.php?r=commodity/showProduct');
			}
			else{
				echo "<script>alert('".$commodity_info->comm_name." 删除失败');</script>";
			}
		}
	}

	/**
	 * 销售一览
	 * @throws CException
	 */
	public function actionShowSale()
	{
		//通过模型来实现数据表信息查询
		//产生模型对象
		$commodity_model = Commodity::model();
		$query='select * from tbl_commodity';

		//判断Filter是否被用户选择了
		if(isset($_POST["comm_kind"])){
			if($_POST['comm_kind'] != 9999) {
				$query = $query." where comm_kind=".$_POST["comm_kind"];
			}
		}
		$commodity_info = $commodity_model->findAllBySql($query);

		//传递到视图
		$this->renderPartial('showSale',array('commodity_info'=>$commodity_info));
	}
}