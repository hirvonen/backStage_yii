<?php

/**
 * 订单控制器
 * Class OrderController
 */
class OrderController extends Controller
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
				'actions'=>array('show','detail','update','add','showOtherOrder','selectCust','AddOrderItem','addOther','UpdateOther'),
				'users'=>array('superadmin'),
			),
            array(
				'allow',
				'actions'=>array('show','detail','update','add','showOtherOrder','selectCust','AddOrderItem','addOther','UpdateOther'),
                'users'=>array('admin','zhangli','shenjia','zengkan','wangjiayi','weixuejiao'),
			),
			array(
				'deny',
				'users'=>array('*'),
			),
		);
	}

	/**
	 * 一览表示
	 * @throws CException
	 */
	public function actionShow()
	{
        $order_model = Order::model();

        if(isset($_POST["ord_status"])){
            if($_POST["ord_status"]==0){
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
            if ($_POST["ord_status"]!=0) {
                $order_sts = $_POST["ord_status"];
                $order_info = $order_model->findAllByAttributes(array('ord_status' => $order_sts));
            }
            else{
                $order_info = $order_model->findAll();
            }
        }
        else{
            $order_info = $order_model->findAll();
        }

        $this->renderPartial("show",array('order_info'=>$order_info));
	}

    /**
     * 其他订单一览表示
     * @throws CException
     */
    public function actionShowOtherOrder($kind)
    {
        //一元体验的订单一览
        $order_model = Contact::model();

//        if(isset($_POST["ord_status"])){
//            if($_POST["ord_status"]==0){
//                $findByFilter = 0;  //用户没有选择，只是单纯刷新页面，需要查询所有记录
//            }
//            else{
//                $findByFilter = 1;  //需要按照filter查询记录
//            }
//        }
//        else{
//            $findByFilter = 0;  //首次进入页面，需要查询所有记录
//        }

//        if($findByFilter != 0){
//            if ($_POST["ord_status"]!=0) {
//                $order_sts = $_POST["ord_status"];
//                $order_info = $order_model->findAllByAttributes(array('ord_status' => $order_sts));
//            }
//            else{
//                $order_info = $order_model->findAll();
//            }
//        }
//        else{
//            $order_info = $order_model->findAll();
//        }
        $query = 'select * from tbl_contact where con_kind = '.$kind;
        $order_info = $order_model->findAllBySql($query);
        switch($kind) {
            case OTHER_KIND_1YUAN:
                $this->renderPartial("showOtherOrder1", array('order_info' => $order_info));
                break;
            case OTHER_KIND_88YUAN:
                $this->renderPartial("showOtherOrder88", array('order_info' => $order_info));
                break;
            case OTHER_KIND_SGB:
                $this->renderPartial("showOtherOrderSGB", array('order_info' => $order_info));
                break;
            case OTHER_KIND_168YUAN:
                $this->renderPartial("showOtherOrder168", array('order_info' => $order_info));
                break;
            case OTHER_KIND_LY168YUAN:
                $this->renderPartial("showOtherOrderLY168", array('order_info' => $order_info));
                break;
            case OTHER_KIND_1111:
                $this->renderPartial("showOtherOrder1111", array('order_info' => $order_info));
                break;
            case OTHER_KIND_HAOKANG:
                $this->renderPartial("showOtherOrderHaoKang", array('order_info' => $order_info));
                break;
            default:
                echo '<script>alert("出错啦！并没有这样的订单类型！")';
                break;
        }
    }

    /**
     * 新建订单
     */
    public function actionAdd($usr_id)
    {
        $order_model = new Order();

        if(isset($_POST["Order"])){
            $order_model->attributes = $_POST["Order"];

            //订单用户检证
            $cust_model = Customer::model();
            if(!$cust_model->findByPk($order_model->ord_cust_id)) {
                echo "<script>alert('该用户不存在！');</script>";
            }
            else {
                //订单更新时间更新
                $order_model->ord_upt_time = date("Y-m-d H:i:s", time());

                if ($order_model->save()) {
                    $this->redirect("./index.php?r=order/show");
                } else {
                    //var_dump($user_info->getErrors());
                    //var_dump($customer_info->getErrors());
                    echo "<script>alert('订单添加失败！');</script>";
                }
            }
        }

        //取得用户情报
        $usr_model = User::model();
        $usr_info = null;
        $cust_model = Customer::model();
        $cust_info = null;
        if($usr_id != 0) {
            $usr_info = $usr_model->findByPk($usr_id);
            if($usr_info) {
                $cust_info = $cust_model->findByPk($usr_id);
            }
        }

        $this->renderPartial('add', array('order_info'=>$order_model, 'usr_info'=>$usr_info, 'cust_info'=>$cust_info));
    }

    /**
     * 新建订单（特殊活动）
     */
    public function actionAddOther($kind)
    {
        $contact_model = new Contact();
        $contact_model->con_kind = $kind;

        if(isset($_POST["Contact"])){
            $contact_model->attributes = $_POST["Contact"];
//            var_dump($_POST);

            //订单更新时间更新
            $contact_model->con_upt_time = date("Y-m-d H:i:s", time());

            if ($contact_model->save()) {
                $this->redirect("./index.php?r=order/showOtherOrder&kind=$kind");
            } else {
                //var_dump($user_info->getErrors());
                //var_dump($customer_info->getErrors());
                echo "<script>alert('订单添加失败！');</script>";
            }
        }

        $this->renderPartial('addOther', array('kind'=>$kind, 'contact_info'=>$contact_model));
    }

    /**
     * 新建订单_选择用户
     */
    public function actionSelectCust()
    {
        $this->renderPartial('selectCust');
    }

    /**
    * 订单详细信息
     */
    public function actionDetail($id)
    {
        $order_model = Order::model();
        $order_info = $order_model->findByPk($id);

        //查找出本订单相关的所有订单商品
        $query = 'select * from tbl_order_item where pk_ord_itm_ord_id = '.$order_info->pk_ord_id;
        $order_model = Order_Item::model();
        $order_item_info = $order_model->findAllBySql($query);

        if(isset($order_info)) {
            //订单详细信息
            $this->renderPartial('detail', array('order_info'=>$order_info, 'order_item_info'=>$order_item_info));
        }
        else{
            echo "<script>alert('未找到该订单！');</script>";
        }
    }

    /**
     * 订单商品添加
     */
    public function actionAddOrderItem($ord_id, $item_id)
    {
        $comm_model = Commodity::model();

        if($item_id != 0) {
            //已经选择了item
            $ord_item_model = new Order_Item();

            //为了这个奇葩的id（要用ord_id来算，还要从0开始计数）
            $ord_item_model->pk_ord_itm_id = ($ord_id-80000000)*1000;
            $query = 'select * from tbl_order_item where pk_ord_itm_ord_id = '.$ord_id;
            $ord_item_info = $ord_item_model->findAllBySql($query);
            $ord_item_model->pk_ord_itm_id += count($ord_item_info);

            $ord_item_model->pk_ord_itm_ord_id = $ord_id;
            $ord_item_model->ord_item_comm_id = $item_id;
            $ord_item_model->ord_item_num = 1;

            $comm_info = $comm_model->findByPk($item_id);
            if($comm_info) {
                $ord_item_model->ord_item_price = $comm_info->comm_price;
            }

            if ($ord_item_model->save()) {
                $this->redirect("./index.php?r=order/detail&id=$ord_id");
            } else {
                //var_dump($user_info->getErrors());
                //var_dump($customer_info->getErrors());
                echo "<script>alert('出错啦003！');</script>";
            }
        }

        $comm_info = $comm_model->findAll();
        $this->renderPartial('addOrderItem', array('ord_id'=>$ord_id, 'comm_info'=>$comm_info));
    }

    /**
     * 订单详细信息修改
     */
    public function actionUpdate($id, $ordItmID)
    {
        $order_model = Order::model();
        $order_info = $order_model->findByPk($id);

        //查找出本订单相关的所有订单商品
        $query = 'select * from tbl_order_item where pk_ord_itm_ord_id = '.$order_info->pk_ord_id;
        $order_model = Order_Item::model();
        $order_item_info = $order_model->findAllBySql($query);

        if(isset($order_info)) {
            if ($ordItmID != 'FFFFFFFF'){
                //订单内商品删除用处理
                $order_item = $order_model->findByPk($ordItmID);
                if(isset($order_item)){
                    $aptm_model = Aptm::model();
                    $query_aptm = 'select * from tbl_appointment where aptm_ord_item_id = '.$ordItmID;
                    $aptm_info = $aptm_model->findAllBySql($query_aptm);
                    foreach ($aptm_info as $_v) {
                        $_v->delete();
                    }
                    $order_item->delete();
                }
            }
            else if (isset($_POST["Order"])) {
                //保存变更之前的订单状态
                $ord_status_org = $order_info->ord_status;

                $order_info->attributes = $_POST["Order"];

                //订单更新时间更新
                $order_info->ord_upt_time = date("Y-m-d H:i:s", time());

                //订单收货信息更新
                //如果用户没有设置订单收货信息（姓名地址邮编电话），则从customer表中查询信息
//                $cust_model = Customer::model();
//                $cust_info = $cust_model->findByPk($order_model->ord_cust_id);
//                if(isset($cust_info)) {
//                    if($order_info->ord_cust_name == '') {
//                        $order_info->ord_cust_name = $cust_info->cust_realname;
//                    }
//                    if($order_info->ord_cust_tel == '') {
//                        $order_info->ord_cust_tel = $cust_info->cust_mobile1;
//                    }
//                }

                if($order_info->save()){
                    //保存变更之后的订单状态
                    $ord_status_mod = $order_info->ord_status;

                    /*
                     * 如果是从 非完成 变为 完成
                     *  则向该用户账户余额里增加金额相应积分
                     * 如果是从 完成 变为 非完成
                     *  则从该用户账户余额里扣除金额相应积分，不足以抵扣的，将积分归0
                     * 但是订单金额里面，需要去除用户用积分抵扣的部分
                     */
                    //计算金额（扣除积分抵扣的部分）
                    $total_price = 0;
                    foreach ($order_item_info as $_v) {
                        $total_price += $_v->ord_item_price;
                    }
                    $total_price -= $order_info->ord_deductible;
                    if($total_price < 0){
                        $total_price = 0;
                    }

                    //查找用户
                    $query = 'select * from tbl_customer where pk_cust_id='.$order_info->ord_cust_id;
                    $cust_info = Customer::model()->findBySql($query);

                    //积分处理
                    if(isset($cust_info)) {
                        if ($ord_status_org != 600) {
                            if ($ord_status_mod == 600) {
                                //从 非完成 变为 完成，订单金额进入用户积分（1元1分）
                                $cust_info->cust_point += $total_price;
                            }
                        }
                        else{
                            if($ord_status_mod != 600){
                                //从 完成 变为 非完成，从用户积分扣除订单金额（1元1分）
                                $cust_info->cust_point -= $total_price;

                                //如果积分为负数，则变为0
                                if($cust_info->cust_point < 0){
                                    $cust_info->cust_point = 0;
                                }
                            }
                        }
                    }

                    $cust_info->save();

                    //画面转向
                    $this->redirect("./index.php?r=order/detail&id=$id");
                }
                else {
                    //var_dump($user_info->getErrors());
                    //var_dump($customer_info->getErrors());
                    echo "<script>alert('订单信息修改失败！');</script>";
                }
            }
            $this->renderPartial('update', array("order_info" => $order_info, 'order_item_info'=>$order_item_info));
        }
        else{
            echo "<script>alert('未找到该订单！');</script>";
        }
    }

    /**
     * 活动订单详细信息修改
     */
    public function actionUpdateOther($id)
    {
        $contact_model = Contact::model();
        $contact_info = $contact_model->findByPk($id);
        if(!$contact_info) {
            echo "<script>alert('未找到该订单！');</script>";
            return;
        }

        if(isset($_POST['Contact'])) {
            $contact_info->attributes = $_POST['Contact'];
            //订单更新时间更新
            $contact_info->con_upt_time = date("Y-m-d H:i:s", time());
            if($contact_info->save()) {
                $this->redirect("./index.php?r=order/showOtherOrder&kind=$contact_info->con_kind");
            } else {
                echo "<script>alert('订单信息修改失败！');</script>";
            }
        }

        $this->renderPartial('updateOther',array('contact_info'=>$contact_info));
    }
}