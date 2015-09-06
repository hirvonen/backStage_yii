<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
	<title>订单详细信息修改</title>
	<meta http-equiv="content-type" content="text/html;charset=utf-8">
	<link href="<?php echo BACK_CSS_URL; ?>mine.css" type="text/css" rel="stylesheet">
</head>

<body>

<div class="div_head">
            <span>
                <span style="float:left">当前位置是：订单管理-》修改订单详细信息</span>
	            <span style="float:right;margin-right: 8px;font-weight: bold">
                    <a style="text-decoration: none" href="./index.php?r=order/detail&id=<?php echo $order_info->pk_ord_id ?>">【返回】</a>
                </span>
            </span>
</div>
<div></div>

<div style="font-size: 13px;margin: 10px 5px">
	<?php $form = $this->beginWidget('CActiveForm'); ?>
	<table border="1" width="100%" class="table_a">
        <tr bgcolor="#add8e6">
            <td>
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
                $options = array ('100'=>'等待付款',
                    '200'=>'等待确认',
                    '300'=>'等待服务',
                    '400'=>'订单取消',
                    '500'=>'等待评价',
                    '600'=>'订单完成',);
                echo $form->dropDownList($order_info,'ord_status',$options);
                ?>
            </td>
        </tr>
        <tr bgcolor="#ffffff">
            <td>
                <?php echo $form->label($order_info, 'ord_cust_name'); ?>
            </td>
            <td>
                <?php echo $form->textField($order_info, 'ord_cust_name'); ?>
            </td>
        </tr>
        <tr bgcolor="#add8e6">
            <td>
                <?php echo $form->label($order_info, 'ord_cust_tel'); ?>
            </td>
            <td>
                <?php echo $form->textField($order_info, 'ord_cust_tel'); ?>
                <?php echo $form->error($order_info, 'ord_cust_tel'); ?>
            </td>
        </tr>
        <tr bgcolor="#ffffff">
            <td>
                <?php echo $form->label($order_info, 'ord_cust_addr'); ?>
            </td>
            <td>
                <?php echo $form->textArea($order_info, 'ord_cust_addr',array('cols'=>100,'rows'=>5)); ?>
            </td>
        </tr>
        <tr bgcolor="#add8e6">
            <td>
                <?php echo $form->label($order_info, 'ord_cust_postcode'); ?>
            </td>
            <td>
                <?php echo $form->textField($order_info, 'ord_cust_postcode'); ?>
                <?php echo $form->error($order_info, 'ord_cust_postcode'); ?>
            </td>
        </tr>
        <tr bgcolor="#ffffff">
            <td>
                <?php echo $form->label($order_info, 'ord_pay_way'); ?>
            </td>
            <td>
                <?php
//                $pay_way_options = array (
//                    '1'=>'支付宝支付',
//                    '2'=>'微信支付',
//                    '3'=>'余额支付',
//                    '4'=>'上门到付',
//                    '5'=>'团购支付',);
//                echo $form->dropDownList($order_info,'ord_pay_way',$pay_way_options);
                switch($order_info->ord_pay_way) {
                    case 1:
                        echo '支付宝支付';
                        break;
                    case 2:
                        echo '微信支付';
                        break;
                    case 3:
                        echo '余额支付';
                        break;
                    case 4:
                        echo '上门到付';
                        break;
                    case 5:
                        echo '团购支付';
                        break;
                    default:
                        echo '其他（组合支付方式）';
                        break;
                }
                ?>
            </td>
        </tr>
        <tr>
            <td bgcolor="#6495ed">
            </td>
            <td bgcolor="#6495ed">
            </td>
        </tr>
<!--        <tr bgcolor="#add8e6">-->
<!--            <td>-->
<!--                --><?php //echo $form->label($order_info, 'ord_total_discount'); ?>
<!--            </td>-->
<!--            <td>-->
<!--                --><?php //echo $form->textField($order_info, 'ord_total_discount'); ?>
<!--            </td>-->
<!--        </tr>-->
        <tr bgcolor="#ffffff">
            <td>
                <?php echo $form->label($order_info, 'ord_deductible'); ?>
            </td>
            <td>
                <?php echo $form->textField($order_info, 'ord_deductible'); ?>
            </td>
        </tr>
        <tr bgcolor="#add8e6">
            <td>
                <?php echo $form->label($order_info, 'ord_downpay'); ?>
            </td>
            <td>
                <?php echo $form->textField($order_info, 'ord_downpay'); ?>
            </td>
        </tr>
        <tr bgcolor="#ffffff">
            <td>
                <?php echo $form->label($order_info, 'ord_downpay_deductible'); ?>
            </td>
            <td>
                <?php echo $form->textField($order_info, 'ord_downpay_deductible'); ?>
            </td>
        </tr>
        <tr bgcolor="#add8e6">
            <td>
                <?php echo $form->label($order_info, 'ord_paid_money'); ?>
            </td>
            <td>
                <?php echo $form->textField($order_info, 'ord_paid_money'); ?>
            </td>
        </tr>
        <tr bgcolor="#ffffff">
            <td>
                <?php echo $form->label($order_info, 'ord_paid_net'); ?>
            </td>
            <td>
                <?php echo $form->textField($order_info, 'ord_paid_net'); ?>
            </td>
        </tr>
        <tr bgcolor="#add8e6">
            <td>
                <?php echo $form->label($order_info, 'ord_paid_balance'); ?>
            </td>
            <td>
                <?php echo $form->textField($order_info, 'ord_paid_balance'); ?>
            </td>
        </tr>
        <tr bgcolor="#ffffff">
            <td>
                <?php echo $form->label($order_info, 'ord_coupon'); ?>
            </td>
            <td>
                <?php echo $form->textField($order_info, 'ord_coupon'); ?>
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
            echo '<tr>'.
                '<td bgcolor="add8e6">'.'订单商品'.($index+1).'</td>'.
                '<td>'.
                    "<a style='text-decoration: none' href='./index.php?r=order/update&id=".
                        $order_info->pk_ord_id.
                        "&ordItmID=".
                        $order_item_single->pk_ord_itm_id.
                        "'>删除</a>".
                '</td>'.
                '</tr>';
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
                $form->textField($order_item_single, 'ord_item_num').
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
        <tr>
            <td bgcolor="#6495ed">
            </td>
            <td bgcolor="#6495ed">
            </td>
        </tr>
        <tr>
            <td colspan="2" align="center">
                <input type="submit" value="修改">
            </td>
        </tr>
	</table>
	<?php $this->endWidget(); ?>
</div>

</body>
</html>