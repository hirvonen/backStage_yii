<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />

	<title>预约列表</title>

	<link href="<?php echo BACK_CSS_URL; ?>mine.css" type="text/css" rel="stylesheet" />
</head>
<body>
<style>
	.tr_color{background-color: #9F88FF}
</style>
<div class="div_head">
            <span>
                <span style="float: left;">当前位置是：预约管理-》预约一览</span>
                <span style="float: right; margin-right: 8px; font-weight: bold;">
                    <a style="text-decoration: none;" href="./index.php?r=aptm/add&ord_itm_id=0">【添加预约】</a>
                </span>
            </span>
</div>
<div></div>
<!--<pre><div class="Input">-->
<!--        <label>time:<span class="required">(*)</span></label>-->
<!--        --><?php
//        Yii::getPathOfAlias('zii');
//        Yii::import ('zii.*');
//        $test_info = $aptm_info->findByPk('90000015');
//        $this->widget("zii.widgets.jui.CJuiDatePicker", array(
//            'model'=>$test_info,
//            'attribute'=>'aptm_time',
//            'options' => array(
//                'dateFormat'=>'yy-mm-dd', //database save format
//                'altFormat'=>'mm-dd-yy', //display format
//                'showAnim'=>'fold',
//                'yearRange'=>'-3:+3',
//            ),
//            'htmlOptions'=>array(
//                'readonly'=>'readonly',
//                'style'=>'width:90px;',
//            )
//        ));?>
<!--    </div></pre>-->

<div class="div_search">
            <span>
                <?php $form = $this->beginWidget('CActiveForm'); ?>
                <?php
                if(isset($_POST["aptm_status"])) {
                    $select_status = $_POST["aptm_status"];
                    $select_beau = $_POST["aptm_beau_id"];
                }
                else {
                    $select_status = 0;
                    $select_beau = 0;
                }
                ?>
                预约状态<select name="aptm_status" style="width: 100px;">
                    <option <?php
//                    if( $select_status == 0 ) echo " selected="."'"."selected"."' ";
                    if( $select_status == 0 ) echo " selected='selected' ";
                    ?> value="0">全部</option>
                    <option <?php
                    if( $select_status == 1 ) echo " selected='selected' ";
                    ?> value="1">等待付款</option>
                    <option <?php
                    if( $select_status == 2 ) echo " selected='selected' ";
                    ?> value="2">等待确认</option>
                    <option <?php
                    if( $select_status == 3 ) echo " selected='selected' ";
                    ?> value="3">等待服务</option>
                    <option <?php
                    if( $select_status == 4 ) echo " selected='selected' ";
                    ?> value="4">预约取消</option>
                    <option <?php
                    if( $select_status == 5 ) echo " selected='selected' ";
                    ?> value="5">等待评价</option>
                    <option <?php
                    if( $select_status == 6 ) echo " selected='selected' ";
                    ?> value="6">评价完毕</option>
                </select>
                理疗师<select name="aptm_beau_id" style="width: 100px;">
                    <?php
                    echo '<option';
                    if($select_beau == 0){
                        echo " selected='selected'";
                    }
                    echo " value='0'>未选择</option>";

                    //构建dropDownList的option用的数组
                    foreach($beau_info as $key=>$_beau_v){
                        echo '<option';

                        if($select_beau == $_beau_v->pk_beau_id){
                            echo " selected='selected'";
                        }
                        echo " value='".$_beau_v->pk_beau_id."'>";
                        echo $_beau_v->beau_realname;
                        echo '</option>';
                    }
                    ?>
                </select>
	                <input value="查询" type="submit" />
                <?php $this->endWidget(); ?>
            </span>
</div>
<div style="font-size: 13px; margin: 10px 5px;">
	<table class="table_a" border="1" width="100%">
		<tbody><tr bgcolor="#4169e1" style="font-weight: bold;">
			<td align="center">操作</td>
			<td>预约单号</td>
			<td>预约状态</td>
			<td>理疗师</td>
			<td>预约时间</td>
			<td>服务名称</td>
            <td>顾客姓名</td>
            <td>第几次</td>
		</tr>
        <?php $form = $this->beginWidget('CActiveForm'); ?>
		<?php
        $i = 0;
        $beau_model = Beautician::model();

		foreach (array_reverse($aptm_info) as $_v) {
			?>
			<tr <?php
                if($i%2 != 0){
                    echo 'bgcolor="#add8e6"';
                }
                else{
                    echo 'bgcolor="#ffffff"';
                }
                ?> id="user1">
				<td><a href="./index.php?r=aptm/detail&id=<?php echo $_v->pk_aptm_id ?>&source_page=show">详细</a></td>
				<td><?php echo $_v->pk_aptm_id ?></td>
				<td>
                    <?php
//                    $options = array ('1'=>'等待付款',
//                        '2'=>'等待确认',
//                        '3'=>'等待服务',
//                        '4'=>'预约取消',
//                        '5'=>'等待评价',
//                        '6'=>'评价完毕',);
//                    echo $form->dropDownList($_v,'aptm_status',$options);
                    switch($_v->aptm_status) {
                        case 1:
                            echo "等待付款";
                            break;
                        case 2:
                            echo "等待确认";
                            break;
                        case 3:
                            echo "等待服务";
                            break;
                        case 4:
                            echo "预约取消";
                            break;
                        case 5:
                            echo "等待评价";
                            break;
                        case 6:
                            echo "评价完毕";
                            break;
                    }
                    ?>
                </td>
				<td><?php
                    $aptm_beau_info = $beau_model->findByPk($_v->aptm_beau_id);
                    if(isset($aptm_beau_info)) {
                        //echo $form->dropDownList($_v,'aptm_beau_id',$beau_options);
                        echo $aptm_beau_info->beau_realname;
                    }
                    else {
                        echo $_v->aptm_beau_id;
                    }
                    ?>
                </td>
<!--				<td>--><?php //echo $form->textField($_v,'aptm_time'); ?><!--</td>-->
                <td>
                    <?php
                    echo $_v->aptm_time;
                    ?>
                </td>
                <td><?php
                    $ord_item_model = Order_Item::model();
                    $ord_item_info = $ord_item_model->findByPk($_v->aptm_ord_item_id);
                    if(isset($ord_item_info)) {
                        $comm_model = Commodity::model();
                        $comm_info = $comm_model->findByPk($ord_item_info->ord_item_comm_id);
                        if(isset($comm_info)) {
                            echo $comm_info->comm_name;
                        }
                        else {
                            echo $_v->aptm_ord_item_id;
                        }
                    }
                    else {
                        echo $_v->aptm_ord_item_id;
                    }
                ?></td>
                <td><?php echo $_v->aptm_cust_name; ?></td>
                <td><?php echo $_v->aptm_course_no; ?></td>
<!--                <td><input value="修改" type="submit" /></td>-->
			</tr>
		<?php
		    $i++;
        }
		?>
        <?php $this->endWidget(); ?>
		<tr>
			<td colspan="20" style="text-align: center;">
				[1]
			</td>
		</tr>
		</tbody>
	</table>
</div>
</body>
</html>