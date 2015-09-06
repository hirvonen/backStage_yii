<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />

	<title>订单列表</title>

	<link href="<?php echo BACK_CSS_URL; ?>mine.css" type="text/css" rel="stylesheet" />
</head>
<body>
<style>
	.tr_color{background-color: #9F88FF}
</style>
<div class="div_head">
            <span>
                <span style="float: left;">当前位置是：订单管理-》订单一览（买卡）</span>
                <span style="float: right; margin-right: 8px; font-weight: bold;">
                    <a style="text-decoration: none;" href="./index.php?r=order/add&usr_id=0&ord_itm_id=0">【添加订单】</a>
                </span>
            </span>
</div>
<div></div>
<div class="div_search">
            <span>
                <?php $form = $this->beginWidget('CActiveForm'); ?>
                <?php
                if(isset($_POST["ord_status"])) {
                    $select_status = $_POST["ord_status"];
                }
                else {
                    $select_status = 0;
                }
                ?>
                订单状态<select name="ord_status" style="width: 100px;">
                    <option <?php
                    if( $select_status == 0 ) echo " selected="."'"."selected"."' ";
                    ?> value="0">全部</option>
                    <option <?php
                    if( $select_status == 100 ) echo " selected="."'"."selected"."' ";
                    ?> value="100">等待付款</option>
                    <option <?php
                    if( $select_status == 200 ) echo " selected="."'"."selected"."' ";
                    ?> value="200">等待确认</option>
                    <option <?php
                    if( $select_status == 300 ) echo " selected="."'"."selected"."' ";
                    ?> value="300">等待服务</option>
                    <option <?php
                    if( $select_status == 400 ) echo " selected="."'"."selected"."' ";
                    ?> value="400">订单取消</option>
                    <option <?php
                    if( $select_status == 500 ) echo " selected="."'"."selected"."' ";
                    ?> value="500">等待评价</option>
                    <option <?php
                    if( $select_status == 600 ) echo " selected="."'"."selected"."' ";
                    ?> value="600">订单完成</option>
                </select>
	                <input value="查询" type="submit" />
                <?php $this->endWidget(); ?>
            </span>
</div>
<div style="font-size: 13px; margin: 10px 5px;">
	<table class="table_a" border="1" width="100%">
		<tbody><tr bgcolor="#4169e1" style="font-weight: bold;">
			<td align="center">操作</td>
			<td>订单编号</td>
<!--			<td>顾客编号</td>-->
			<td>订单状态</td>
			<td>顾客姓名</td>
			<td>支付方法</td>
            <td>订单金额</td>
            <td>更新时间</td>
		</tr>
		<?php
        $i = 0;
        $order_model = Order_Item::model();
		foreach (array_reverse($order_info) as $_v) {
            $price = 0;
			?>
			<tr <?php
                if($i%2 != 0){
                    echo 'bgcolor="#add8e6"';
                }
                else{
                    echo 'bgcolor="#ffffff"';
                }
                ?> id="user1">
				<td><a href="./index.php?r=order/detail&id=<?php echo $_v->pk_ord_id ?>">详细</a></td>
				<td><?php echo $_v->pk_ord_id ?></td>
<!--				<td>--><?php //echo $_v->ord_cust_id ?><!--</td>-->
				<td><?php
					switch($_v->ord_status) {
                        case 100:
    						echo "等待付款";
                            break;
                        case 200:
                            echo "等待确认";
                            break;
                        case 300:
                            echo "等待服务";
                            break;
                        case 400:
                            echo "订单取消";
                            break;
                        case 500:
                            echo "等待评价";
                            break;
                        case 600:
                            echo "订单完成";
                            break;
                        default:
                            break;
					}
					?></td>
				<td><?php echo $_v->ord_cust_name; ?></td>
				<td><?php
                    switch($_v->ord_pay_way) {
                        case 1:
                            echo "支付宝支付";
                            break;
                        case 2:
                            echo "微信支付";
                            break;
                        case 3:
                            echo "余额支付";
                            break;
                        case 4:
                            echo "上门到付";
                            break;
                        case 5:
                            echo "团购支付";
                            break;
                        default:
                            echo '其他(组合支付)';
                            break;
                    }
                    ?></td>
                <td><?php
                    $query = 'select * from tbl_order_item where pk_ord_itm_ord_id = '.$_v->pk_ord_id;
                    $order_item_info = $order_model->findAllBySql($query);
                    if(isset($order_item_info)){
                        foreach($order_item_info as $_value_price){
                            $price += $_value_price->ord_item_price * $_value_price->ord_item_num;
                        }
                    }
                    echo number_format($price,2);
                    ?></td>
				<td><?php echo $_v->ord_upt_time; ?></td>
			</tr>
		<?php
		    $i++;
        }
		?>
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