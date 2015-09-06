<?php

/**
 * 订单控制器
 * Class AppointmentController
 */
class InfoByDay{
    public $aptm_id;
    public $cust_name;
    public $comm_name;
    public $price;
    function __construct() {
        $this->aptm_id = 0;
        $this->cust_name = "未知用户";
        $this->comm_name = "未知商品";
        $this->price = 0;
    }
}

class AptmController extends Controller
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
				'actions'=>array('show','cal','detail','dayCal','add','selectCust',
                            'selectOrderItem','detailOther','selectAptmByDay','showAptmByDay'),
				'users'=>array('superadmin','admin'),
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
        $aptm_model = Aptm::model();
        $query = 'select * from tbl_appointment';

        if(isset($_POST['aptm_status'])){
            if($_POST['aptm_status']!=0){
                $query=$query.' where aptm_status = '.$_POST['aptm_status'];
            }
            if($_POST['aptm_beau_id']!=0){
                if(strpos($query,'where')) {
                    $query = $query . ' and aptm_beau_id = ' . $_POST['aptm_beau_id'];
                }
                else{
                    $query = $query . ' where aptm_beau_id = ' . $_POST['aptm_beau_id'];
                }
            }
        }
        $aptm_info = $aptm_model->findAllBySql($query);

        //理疗师姓名查找用数据准备
        $beau_model = Beautician::model();
        $query = 'select * from tbl_beautician';
        $beau_info = $beau_model->findAllBySql($query);

        $this->renderPartial("show",array('aptm_info'=>$aptm_info, 'beau_info'=>$beau_info));
	}

    /**
     * 添加预约
     */
    public function actionAdd($ord_itm_id)
    {
        $aptm_model = new Aptm();

        if(isset($_POST["Aptm"])){
//            var_dump($_POST['Aptm']);
            $aptm_model->attributes = $_POST["Aptm"];
            $aptm_model->aptm_ord_item_id = $ord_itm_id;
            $aptm_model->aptm_status = 3;
            if ($aptm_model->save()) {
                $this->redirect("./index.php?r=aptm/show");
            } else {
                //var_dump($user_info->getErrors());
                //var_dump($customer_info->getErrors());
                echo "<script>alert('预约添加失败！');</script>";
            }
        }

        $ord_itm_model = Order_Item::model();
        $ord_itm_info = null;
        $ord_model = Order::model();
        $ord_info = null;
        $comm_model = Commodity::model();
        $comm_info = null;
        if($ord_itm_id != 0) {
            $ord_itm_info = $ord_itm_model->findByPk($ord_itm_id);
            if($ord_itm_info) {
                $ord_info = $ord_model->findByPk($ord_itm_info->pk_ord_itm_ord_id);
                $comm_info = $comm_model->findByPk($ord_itm_info->ord_item_comm_id);

                //赋值
                $aptm_model->aptm_cust_name = $ord_info->ord_cust_name;
                $aptm_model->aptm_cust_tel = $ord_info->ord_cust_tel;
                $aptm_model->aptm_cust_addr = $ord_info->ord_cust_addr;
//                $aptm_model->aptm_ord_item_id = $ord_itm_id;
//                $aptm_model->aptm_status = 3;

                //为了查出这是第几次
                $aptm_sch_model = Aptm::model();
                $query = 'select * from tbl_appointment where aptm_ord_item_id = '.$ord_itm_id;
                $aptm_sch_info = $aptm_sch_model->findAllBySql($query);
                $aptm_model->aptm_course_no = count($aptm_sch_info) + 1;
            }
        }
        $this->renderPartial('add', array('aptm_info'=>$aptm_model,'comm_info'=>$comm_info,));
    }

    /**
     * 添加预约->选择顾客
     */
    public function actionSelectCust()
    {
        $this->renderPartial('selectCust');
    }

    /**
     * 添加预约->选择订单(orderitem)
     */
    public function actionSelectOrderItem($usr_id)
    {
        if($usr_id != 0) {
            $order_model = Order::model();

            $query = 'select * from tbl_order where ord_cust_id = '.$usr_id;
            $order_info = $order_model->findAllBySql($query);

            if($order_info) {
                $ord_itm_model = Order_Item::model();
                $ord_itm_info[] = null;
                foreach ($order_info as $_v) {
                    $query = 'select * from tbl_order_item where pk_ord_itm_ord_id = '.$_v->pk_ord_id;
                    $tmp_ord_itm_info = $ord_itm_model->findAllBySql($query);
                    if($tmp_ord_itm_info) {
                        $ord_itm_info = array_merge($ord_itm_info,$tmp_ord_itm_info);
                    }
                }
                if($ord_itm_info) {
                    $this->renderPartial('selectOrderItem', array('ord_itm_info' => $ord_itm_info));
                } else {
                    echo "<script>alert('该用户的订单均是空订单！');</script>";
                }
            } else {
                echo "<script>alert('该用户没有订单！');</script>";
            }
        } else {
            echo "<script>alert('该用户不存在！');</script>";
        }
    }

    /**
     * 预约详细页面（可修改）
     */
    public function actionDetail($id, $source_page)
    {
        $aptm_model = Aptm::model();
        $aptm_info = $aptm_model->findByPk($id);
        if(isset($aptm_info)) {
            if (isset($_POST["Aptm"])) {
                $aptm_info->aptm_beau_id = $_POST["Aptm"]["aptm_beau_id"];
                $time = $_POST["Aptm"]["aptm_time"];
                $aptm_info->aptm_time = date("Y-m-d H:i",strtotime("$time"));
                $aptm_info->aptm_status = $_POST["Aptm"]["aptm_status"];
                $aptm_info->aptm_course_no = $_POST["Aptm"]["aptm_course_no"];
                $aptm_info->aptm_cust_name = $_POST["Aptm"]["aptm_cust_name"];
                $aptm_info->aptm_cust_tel = $_POST["Aptm"]["aptm_cust_tel"];
                $aptm_info->aptm_cust_addr = $_POST["Aptm"]["aptm_cust_addr"];

                //判断时间是否冲突
                $time_judge_result = $this->judgeTime($time, $id);

                if($time_judge_result == false){
                    echo "<script>alert('预约时间冲突，请修改预约时间！');</script>";
                }
                else {
                    if ($aptm_info->save()) {
                        if (isset($_GET["source_page"])) {
                            switch ($_GET["source_page"]) {
                                case "cal":
                                    $this->redirect("./index.php?r=aptm/cal");
                                    break;
                                case "show":
                                default:
                                    $this->redirect("./index.php?r=aptm/show");
                                    break;
                            }
                        }
                    } else {
                        //var_dump($user_info->getErrors());
                        //var_dump($customer_info->getErrors());
                        echo "<script>alert('订单信息修改失败！');</script>";
                    }
                }
            }

            //订单详细信息
            $this->renderPartial('detail', array("aptm_info"=>$aptm_info, "source_page"=>$source_page));
        }
        else{
            echo "<script>alert('未找到该预约！');</script>";
        }
    }

    /**
     * 预约详细页面_特殊预约（如1元体验等）（可修改）
     */
    public function actionDetailOther($id, $source_page)
    {
        //默认查询tbl_contact表（id为主键）
        $contact_model = Contact::model();
        $contact_info = $contact_model->findByPk($id);

        if(isset($contact_info)) {
            if (isset($_POST["Contact"])) {
//                var_dump($_POST);
                $contact_info->con_beau_id = $_POST['Contact']['con_beau_id'];
                $contact_info->con_name = $_POST['Contact']['con_name'];
                $contact_info->con_mobile = $_POST['Contact']['con_mobile'];
                $contact_info->con_prefer = $_POST['Contact']['con_prefer'];
                $time = $_POST["Contact"]["con_time"];
                $contact_info->con_time = date("Y-m-d H:i",strtotime("$time"));
                $contact_info->con_address = $_POST['Contact']['con_address'];
                $contact_info->con_district = $_POST['Contact']['con_district'];
                $contact_info->con_flag = $_POST['Contact']['con_flag'];
                $contact_info->con_upt_time = date("Y-m-d H:i:s", time());

                if ($contact_info->save()) {
                    if (isset($_GET["source_page"])) {
                        switch ($_GET["source_page"]) {
                            case "cal":
                                $this->redirect("./index.php?r=aptm/cal");
                                break;
                            case "show":
                            default:
                                $this->redirect("./index.php?r=order/showOtherOrder");
                                break;
                        }
                    }
                } else {
                    //var_dump($user_info->getErrors());
                    //var_dump($customer_info->getErrors());
                    echo "<script>alert('预约信息修改失败！');</script>";
                }
            }

            //订单详细信息
            $this->renderPartial('detailOther', array("contact_info"=>$contact_info, "source_page"=>$source_page));
        }
        else {
            echo "<script>alert('未找到该预约！');</script>";
        }
    }

    /**
     * 预约视图（以视图方式显示预约情况以便查询）
     */
    public function actionCal()
    {
//        $order_model = Order::model();
//        $query = 'select * from tbl_order where ord_status!=400 & ord_status!=500 & ord_status!=600';
//        $order_info = $order_model->findAllBySql($query);

        $aptm_model = Aptm::model();
        $aptm_info = $aptm_model->findAll();

        $beau_model = Beautician::model();
        $beau_info = $beau_model->findAll();

        $this->renderPartial("cal",array('aptm_info'=>$aptm_info,'beau_info'=>$beau_info));
    }

    /**
     * 每日预约视图（以视图方式显示预约情况以便查询）
     */
    public function actionDayCal($day)
    {
        $aptm_model = Aptm::model();
        $aptm_info = $aptm_model->findAll();

        $beau_model = Beautician::model();
        $beau_info = $beau_model->findAll();

        $contact_model = Contact::model();
        $contact_info = $contact_model->findAll();

        $this->renderPartial("dayCal",array('aptm_info'=>$aptm_info,
            'beau_info'=>$beau_info,
            'contact_info'=>$contact_info,
            'day'=>$day));
    }

    /**
     * 按照选定的日期和美疗师来显示预约（包括普通预约和1元预约），用以计算金额
     * @throws CException
     */
    public function actionSelectAptmByDay()
    {
        define('APTM_ID',0);
        define('COMM_NAME',1);
        define('CUST_NAME',2);
        define('PRICE',3);
        if( isset($_POST['beau_id']) &&
            ($_POST['beau_id'] != 0) &&
            isset($_POST['from_date_year']) &&
            isset($_POST['from_date_month']) &&
            isset($_POST['from_date_day']) &&
            isset($_POST['to_date_year']) &&
            isset($_POST['to_date_month']) &&
            isset($_POST['to_date_day']) ) {
            //整理日期
            $from_date = $_POST['from_date_year'].'-'.$_POST['from_date_month'].'-'.$_POST['from_date_day'];
            $to_date = $_POST['to_date_year'].'-'.$_POST['to_date_month'].'-'.$_POST['to_date_day'];
            $from_date = date("Y-m-d H:i:s",strtotime("$from_date"));
            $to_date = date('Y-m-d H:i:s',strtotime("$to_date +1 day"));
            if($from_date > $to_date) {
                echo "<script>alert('起始日期应该早于或等于终了日期！');</script>";
            }

            //TODO:金额信息较复杂，应该需要再建一张表来计算，需要讨论
            //传递形式：
            /*
             xxxx-xx-xx
             ------------------------------------------
             |aptmid|aaaa                             |
             |项目名 |aaaa                             |
             |客户名 |bbbb                             |
             |金额： |111                              |
             ------------------------------------------
             xxxx-xx-xx
             ------------------------------------------
             |aptmid|aaaa                             |
             |项目名 |aaaa                             |
             |客户名 |bbbb                             |
             |金额： |111                              |
             ------------------------------------------
             |aptmid|aaaa                             |
             |项目名 |aaaa                             |
             |客户名 |bbbb                             |
             |金额： |111                              |
             ------------------------------------------
             */

            //定义数组
            $day_count = $this->countDays($from_date,$to_date);
            $aptm_info_by_day = array($day_count);

            //查询普通预约
            //（从tbl_appointment的预约日期入手,包括关联的tbl_order_item,tbl_commodity以获取客户名，项目名等信息）
            $aptm_model = Aptm::model();
            $query = 'select * from tbl_appointment where aptm_beau_id = '.$_POST['beau_id'].
                                                    ' and aptm_time >= "'.$from_date.'"'.
                                                    ' and aptm_time < "'.$to_date.'"';
            $aptm_info = $aptm_model->findAllBySql($query);
            if(isset($aptm_info)) {
                for($cnt_day=0;$cnt_day<$day_count;$cnt_day++) {
                    $counter_by_day = 0;
                    foreach ($aptm_info as $_v_aptm_info) {
                        $day_selected = date('Y-m-d',strtotime("$from_date".' +'.$cnt_day.' day'));
                        $day_compare = date('Y-m-d',strtotime($_v_aptm_info->aptm_time));
                        if($day_selected == $day_compare) {
//                            $info_by_day[APTM_ID] = $_v_aptm_info->pk_aptm_id;
//                            $info_by_day[CUST_NAME] = $_v_aptm_info->aptm_cust_name;
//                            $info_by_day[COMM_NAME] = '未取得';
//                            $info_by_day[PRICE] = 0;
                            $info_by_day = new InfoByDay();
                            $info_by_day->aptm_id = $_v_aptm_info->pk_aptm_id;
                            $info_by_day->cust_name = $_v_aptm_info->aptm_cust_name;

                            //查询tbl_order_item表以取得commodity_id
                            $order_item_model = Order_Item::model();
                            $order_item_info = $order_item_model->findByPk($_v_aptm_info->aptm_ord_item_id);
                            if (isset($order_item_info)) {
                                $comm_model = Commodity::model();
                                $comm_info = $comm_model->findByPk($order_item_info->ord_item_comm_id);
                                if (isset($comm_info)) {
//                                    $info_by_day[COMM_NAME] = $comm_info->comm_name;
                                    $info_by_day->comm_name = $comm_info->comm_name;
                                }
                                //TODO:此处为暂定处理，在修改金额的时候需要修改！
//                                $info_by_day[PRICE] = $order_item_info->ord_item_price;
                                $info_by_day->price = $order_item_info->ord_item_price;
                            }

                            $aptm_info_by_day[$cnt_day][$counter_by_day] = $info_by_day;
                            $counter_by_day++;
                        }
                    }
                }
            }

            //查询1元特殊预约
            $contact_model = Contact::model();
            $query = 'select * from tbl_contact where con_beau_id = '.$_POST['beau_id'].
                                                ' and con_time >="'.$from_date.'"'.
                                                ' and con_time <"'.$to_date.'"';
            $contact_info = $contact_model->findAllBySql($query);
            $contact_info_by_day = array($day_count);

            if(isset($contact_info)) {
                for ($cnt_day = 0; $cnt_day < $day_count; $cnt_day++) {
                    $counter_by_day = 0;
                    foreach ($contact_info as $_v_contact_info) {
//                        $info_by_day[APTM_ID] = $_v_contact_info->pk_contact_id;
//                        $info_by_day[CUST_NAME] = $_v_contact_info->con_name;
//                        $info_by_day[COMM_NAME] = '未取得';
//                        //TODO:此处为暂定处理，在修改金额的时候需要修改！
//                        $info_by_day[PRICE] = 0;
                        $info_by_day = new InfoByDay();
                        $info_by_day->aptm_id = $_v_contact_info->pk_contact_id;
                        $info_by_day->cust_name = $_v_contact_info->con_name;

                        //查询tbl_code表以获取COMM_NAME
                        $code_model = Code::model();
                        $query = 'select * from tbl_code where code_tbl_name="tbl_contact" and code_name="con_prefer" and code_value='.
                            $_v_contact_info->con_prefer;
                        $code_info = $code_model->findBySql($query);
                        if(isset($code_info)) {
//                            $info_by_day[COMM_NAME] = $code_info->code_meaning;
                            $info_by_day->comm_name = $code_info->code_meaning;
                        }
                        $contact_info_by_day[$cnt_day][$counter_by_day] = $info_by_day;
                        //TODO:此处的三维数组改为自定义类试试看
                        $counter_by_day++;
                    }
                }
            }

            //获取美疗师姓名
            $beau_model = Beautician::model();
            $beau_info = $beau_model->findByPk($_POST['beau_id']);
            $beau_name = '没名字';
            if(isset($beau_info)) {
                $beau_name = $beau_info->beau_realname;
            }

//            //转向列表显示页面
//            $this->redirect('./index.php?r=aptm/showAptmByDay&beau_name='.$beau_name.
//                            'from_date='.$from_date.
//                            'to_date='.$to_date.
//                            'day_count='.$day_count.
//                            'aptm_info_by_day='.$aptm_info_by_day.
//                            'contact_info_by_day='.$contact_info_by_day);
            $this->actionShowAptmByDay($beau_name,$from_date,$to_date,$day_count,$aptm_info_by_day,$contact_info_by_day);
            return;
        }

        //有东西没有选择的话，依旧描绘当前的选择视图
        //TODO:需要将已经选择的内容回传给视图以便修改
        $this->renderPartial('selectAptmByDay');
    }

    /**
     * 按照选定的日期和美疗师来显示预约（包括普通预约和1元预约），用以计算金额
     * @throws CException
     */
    public function actionShowAptmByDay($beau_name,$from_date,$to_date,$day_count,$aptm_info_by_day,$contact_info_by_day) {
        $this->renderPartial('showAptmByDay',array('beau_name'=>$beau_name,
            'from_date'=>$from_date,
            'to_date'=>$to_date,
            'day_count'=>$day_count,
            'aptm_info_by_day'=>$aptm_info_by_day,
            'contact_info_by_day'=>$contact_info_by_day));
    }

    /**
     * 计算日期相差天数
     */
    private function countDays($a, $b) {
        $Date_1 = date('Y-m-d',strtotime($a));
        $Date_2 = date('Y-m-d',strtotime($b));
        $d1 = strtotime($Date_1);
        $d2 = strtotime($Date_2);
        return round(($d2-$d1)/3600/24);
    }

    /**
     * 判断修改的时间是否可行
     * @param $time
     * 刚刚修改的时间
     * @return bool
     */
    private function judgeTime($time, $id){
        //一共4名理疗师，所以一个时段(上午，下午，晚上)内如果有4个预约，则认为该时段已满
        $aptm_search_date = date('Y-m-d',strtotime("$time"));
        $aptm_model = Aptm::model();
        $aptm_info = $aptm_model->findAll();

        /*
         * count[0]:上午
         * count[1]:下午
         * count[2]:晚上
         * 三个成员，任意一个超过了4，就认为当天的上午/下午/晚上已经预约满了
         */
        $count = array();
        $count[0] = 0;
        $count[1] = 0;
        $count[2] = 0;
        foreach ($aptm_info as $_v) {
            $date_judge = date('Y-m-d',strtotime($_v->aptm_time));
            if(($date_judge == $aptm_search_date)&&($_v->aptm_beau_id != null)){
                $time_judge = date('H',strtotime($_v->aptm_time));
                if($time_judge < 12){
                    $count[0] += 1;
                }
                elseif(($time_judge >= 12)&&($time_judge < 17)){
                    $count[1] += 1;
                }
                elseif($time_judge >= 17){
                    $count[2] += 1;
                }
            }
        }

        $aptm_search_time = date('H',strtotime("$time"));
        if($aptm_search_time < 12){
            //上午
            $aptm_judge = 0;
        }
        elseif(($aptm_search_time >= 12)&&($aptm_search_time < 17)){
            //下午
            $aptm_judge = 1;
        }
        elseif($aptm_search_time >= 17){
            //傍晚
            $aptm_judge = 2;
        }
        else{
            $aptm_judge = 0;
        }

        //判断是否冲突
        //afz 需要修改：不是总数超过12，而是每个美疗师不能超过3？
        if($count[$aptm_judge] > 12){
            return false;
        }

        //维护Schedule表
        $this->maintainSchedule($id, $time, $count[$aptm_judge]);

        return true;
    }

	/**
     * @param $id
     *      准备修改的预约id
     * @param $time_modify
     *      修改后的时间
     * @param $modify_time_count
     *      准备修改的时间段的已安排预约数
     */
    private function maintainSchedule($id, $time_modify, $modify_time_count){
        define("AM_AVAILABLE",0x00000004);          //上午可用
        define("AM_NOT_AVAILABLE",0x00000003);      //上午不可用
        define("PM_AVAILABLE",0x00000002);          //下午可用
        define("PM_NOT_AVAILABLE",0x00000005);      //下午不可用
        define("NT_AVAILABLE",0x00000001);          //傍晚可用
        define("NT_NOT_AVAILABLE",0x00000006);      //傍晚不可用

        $aptm_model = Aptm::model();
        $schedule_model = Schedule::model();

        //取得修改前的日期的tbl_schedule的flag
        $query = 'select * from tbl_appointment where pk_aptm_id='.$id;
        $aptm_info = $aptm_model->findBySql($query);
        $date_original = '0000';
        $hour_original = 0;
        if(isset($aptm_info)){
            $time_original = $aptm_info->aptm_time;
            $date_original = date('md',strtotime("$time_original"));
            $hour_original = date('H',strtotime("$time_original"));
//            echo "<br>"."time_original: ".$aptm_info->aptm_time;  //log
        }
        $query = 'select * from tbl_schedule where sch_date='.$date_original;
        $schedule_info_before = $schedule_model->findBySql($query);

        //变更修改前的flag
        //对于修改前的预约来说，肯定是减少，所以只需要无脑的把flag去掉就行（变为1）
        if(isset($schedule_info_before)) {
//            echo "<br>"."schedule_info_before: ".$schedule_info_before->sch_flag;  //log
            if ($hour_original < 12) {
                $schedule_info_before->sch_flag |= AM_AVAILABLE;
            } elseif (($hour_original >= 12) && ($hour_original < 17)) {
                $schedule_info_before->sch_flag |= PM_AVAILABLE;
            } elseif ($hour_original >= 17) {
                $schedule_info_before->sch_flag |= NT_AVAILABLE;
            } else {
            }
//            echo "<br>"."schedule_info_before_change: ".$schedule_info_before->sch_flag;  //log
        }

        //因为变更前后有可能是同一天，所以要先save一下
        $schedule_info_before->save();

        //取得修改后的日期的tbl_schedule的flag
//        echo "<br>"."time_modify: ".$time_modify;   //log
        $date_modify = date('md',strtotime("$time_modify"));
        $query = 'select * from tbl_schedule where sch_date='.$date_modify;
        $schedule_info_after = $schedule_model->findBySql($query);

        //变更修改后的flag
        //对于修改后的预约来说，需要看同一时间段的预约是否会到4个，如果到了4个才需要修改flag
        if(isset($schedule_info_after)){
//            echo "<br>"."schedule_info_after: ".$schedule_info_after->sch_flag;  //log
//            echo "<br>"."modify_time_count: ".$modify_time_count;  //log
            if($modify_time_count >= 3) {
                $hour_modify = date('H', strtotime("$time_modify"));
                if ($hour_modify < 12) {
                    $schedule_info_after->sch_flag &= AM_NOT_AVAILABLE;
                } elseif (($hour_modify >= 12) && ($hour_modify < 17)) {
                    $schedule_info_after->sch_flag &= PM_NOT_AVAILABLE;
                } elseif ($hour_modify >= 17) {
                    $schedule_info_after->sch_flag &= NT_NOT_AVAILABLE;
                } else {
                }
            }
//            echo "<br>"."schedule_info_after_change: ".$schedule_info_after->sch_flag;  //log
        }

        $schedule_info_after->save();

        return;
    }
}