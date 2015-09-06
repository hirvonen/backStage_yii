<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
	<title>订单详细信息</title>
	<meta http-equiv="content-type" content="text/html;charset=utf-8">
	<link href="<?php echo BACK_CSS_URL; ?>mine.css" type="text/css" rel="stylesheet">
</head>

<body>

<div class="div_head">
            <span>
                <span style="float:left">当前位置是：订单管理-》订单详细信息</span>
	            <span style="float:right;margin-right: 8px;font-weight: bold">
                    <a style="text-decoration: none" href="./index.php?r=order/show">【返回】</a>
                </span>
	            <span style="float:right;margin-right: 8px;font-weight: bold">
                    <a style="text-decoration: none" href="./index.php?r=order/update&id=<?php echo $order_info->pk_ord_id; ?>&ordItmID=FFFFFFFF">【修改订单信息】</a>
                </span>
            </span>
</div>
<div></div>

<div style="font-size: 13px;margin: 10px 5px">
	<?php $form = $this->beginWidget('CActiveForm'); ?>
	<table border="1" width="100%" class="table_a">
		<tr bgcolor="#add8e6">
			<td width='300'>
				<?php echo $form->label($order_info, 'pk_ord_id'); ?>
			</td>
			<td>
				<?php echo $order_info->pk_ord_id; ?>
			</td>
		</tr>
		<tr bgcolor="#ffffff">
			<td>
				<?php echo $form->label($order_info, 'ord_cust_id'); ?>
			</td>
			<td>
				<?php echo $order_info->ord_cust_id; ?>
			</td>
		</tr>
		<tr bgcolor="#add8e6">
			<td>
				<?php echo $form->label($order_info, 'ord_status'); ?>
			</td>
			<td>
				<?php
                switch($order_info->ord_status) {
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
				?>
			</td>
		</tr>
		<tr bgcolor="#ffffff">
			<td>
				<?php echo $form->label($order_info, 'ord_cust_name'); ?>
			</td>
			<td>
				<?php echo $order_info->ord_cust_name; ?>
			</td>
		</tr>
		<tr bgcolor="#add8e6">
			<td>
				<?php echo $form->label($order_info, 'ord_cust_tel'); ?>
			</td>
			<td>
                <?php echo $order_info->ord_cust_tel; ?>
			</td>
		</tr>
		<tr bgcolor="#ffffff">
			<td>
				<?php echo $form->label($order_info, 'ord_cust_addr'); ?>
			</td>
			<td>
                <?php echo $order_info->ord_cust_addr; ?>
			</td>
		</tr>
		<tr bgcolor="#add8e6">
            <td>
                <?php echo $form->label($order_info, 'ord_cust_postcode'); ?>
            </td>
            <td>
                <?php echo $order_info->ord_cust_postcode; ?>
            </td>
		</tr>
		<tr bgcolor="#ffffff">
            <td>
                <?php echo $form->label($order_info, 'ord_pay_way'); ?>
            </td>
            <td>
	            <?php
	            switch($order_info->ord_pay_way) {
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
	            ?>
            </td>
		</tr>
		<tr bgcolor="#add8e6">
			<td>
				<?php echo "订单总金额"; ?>
			</td>
			<td>
				<?php
				$price = 0;
				foreach($order_item_info as $_value_price){
					$price += $_value_price->ord_item_price * $_value_price->ord_item_num;
				}
				echo number_format($price,2);
				?>
			</td>
		</tr>
		<tr>
			<td bgcolor="#6495ed">
			</td>
			<td bgcolor="#6495ed">
			</td>
		</tr>
<!--		<tr bgcolor="#add8e6">-->
<!--			<td>-->
<!--				--><?php //echo $form->label($order_info, 'ord_total_discount'); ?>
<!--			</td>-->
<!--			<td>-->
<!--				--><?php //echo $order_info->ord_total_discount; ?>
<!--			</td>-->
<!--		</tr>-->
		<tr bgcolor="#ffffff">
			<td>
				<?php echo $form->label($order_info, 'ord_deductible'); ?>
			</td>
			<td>
				<?php echo $order_info->ord_deductible; ?>
			</td>
		</tr>
		<tr bgcolor="#add8e6">
			<td>
				<?php echo $form->label($order_info, 'ord_downpay'); ?>
			</td>
			<td>
				<?php echo $order_info->ord_downpay; ?>
			</td>
		</tr>
		<tr bgcolor="#ffffff">
			<td>
				<?php echo $form->label($order_info, 'ord_downpay_deductible'); ?>
			</td>
			<td>
				<?php echo $order_info->ord_downpay_deductible; ?>
			</td>
		</tr>
		<tr bgcolor="#add8e6">
			<td>
				<?php echo $form->label($order_info, 'ord_paid_money'); ?>
			</td>
			<td>
				<?php echo $order_info->ord_paid_money; ?>
			</td>
		</tr>
		<tr bgcolor="#ffffff">
			<td>
				<?php echo $form->label($order_info, 'ord_paid_net'); ?>
			</td>
			<td>
				<?php echo $order_info->ord_paid_net; ?>
			</td>
		</tr>
		<tr bgcolor="#add8e6">
			<td>
				<?php echo $form->label($order_info, 'ord_paid_balance'); ?>
			</td>
			<td>
				<?php echo $order_info->ord_paid_balance; ?>
			</td>
		</tr>
		<tr bgcolor="#ffffff">
			<td>
				<?php echo $form->label($order_info, 'ord_coupon'); ?>
			</td>
			<td>
				<?php echo $order_info->ord_coupon; ?>
			</td>
		</tr>
		<tr bgcolor="#add8e6">
            <td>
                <?php echo $form->label($order_info, 'ord_upt_time'); ?>
            </td>
            <td>
                <?php echo $order_info->ord_upt_time; ?>
            </td>
		</tr>
		<tr>
			<td bgcolor="#6495ed">
			</td>
			<td bgcolor="#6495ed">
			</td>
		</tr>
		<?php
		$index = 0;
		$comm_model = Commodity::model();
		foreach ($order_item_info as $order_item_single) {
			echo '<tr><td bgcolor="add8e6">'.'订单商品'.($index+1).'</td></tr>';
			$query = 'select * from tbl_commodity where pk_comm_id = '.$order_item_single->ord_item_comm_id;
			$comm_info = $comm_model->findBySql($query);
			echo '<tr>'.
				'<td>'.
				$form->label($comm_info, 'comm_name').
				'</td>'.
				'<td>'.
				$comm_info->comm_name.
				'</td>'.
				'</tr>';
			echo '<tr>'.
				'<td>'.
				$form->label($order_item_single, 'ord_item_num').
				'</td>'.
				'<td>'.
				$order_item_single->ord_item_num.
				'</td>'.
				'</tr>';
			echo '<tr>'.
				'<td>'.
				$form->label($order_item_single, 'ord_item_price').
				'</td>'.
				'<td>'.
				$order_item_single->ord_item_price.
				'</td>'.
				'</tr>';
			$index++;
		}
		?>
	</table>
	<a style="text-decoration: none" href="./index.php?r=order/addOrderItem&ord_id=<?php echo $order_info->pk_ord_id;?>&item_id=0">【添加商品】</a>
	<?php $this->endWidget(); ?>
</div>

</body>
</html>