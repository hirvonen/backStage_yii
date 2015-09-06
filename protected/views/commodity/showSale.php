<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />

	<title>销量一览</title>

	<link href="<?php echo BACK_CSS_URL; ?>mine.css" type="text/css" rel="stylesheet" />
</head>
<body>
<style>
	.tr_color{background-color: #9F88FF}
</style>
<div class="div_head">
            <span>
                <span style="float: left;">当前位置是：数据管理-》销量一览</span>
            </span>
</div>
<div></div>
<div class="div_search">
            <span>
                <?php $form = $this->beginWidget('CActiveForm'); ?>
                <?php
                if(isset($_POST["comm_kind"])) {
                    $select_kind = $_POST["comm_kind"];
                }
                else {
                    $select_kind = 9999;
                }
                ?>
                商品类别<select name="comm_kind" style="width: 100px;">
                    <option <?php
                    if( $select_kind == 9999 ) echo " selected="."'"."selected"."' ";
                    ?> value="9999">全部</option>
                    <option <?php
                    if( $select_kind == 0 ) echo " selected="."'"."selected"."' ";
                    ?> value="0">活动专区</option>
                    <option <?php
                    if( $select_kind == 1 ) echo " selected="."'"."selected"."' ";
                    ?> value="1">产后美体塑形</option>
                    <option <?php
                    if( $select_kind == 2 ) echo " selected="."'"."selected"."' ";
                    ?> value="2">产后调理养生</option>
                    <option <?php
                    if( $select_kind == 3 ) echo " selected="."'"."selected"."' ";
                    ?> value="3">美颜面部呵护</option>
                    <option <?php
                    if( $select_kind == 4 ) echo " selected="."'"."selected"."' ";
                    ?> value="4">特殊产后护理</option>
                    <option <?php
                    if( $select_kind == 8 ) echo " selected="."'"."selected"."' ";
                    ?> value="8">充值卡</option>
                </select>
	                <input value="查询" type="submit" />
                <?php $this->endWidget(); ?>
            </span>
</div>
<div style="font-size: 13px; margin: 10px 5px;">
	<table class="table_a" border="1" width="100%">
		<tbody><tr bgcolor="#4169e1" style="font-weight: bold;">
			<td>商品ID</td>
<!--			<td>顾客编号</td>-->
			<td>商品名称</td>
			<td>商品种类</td>
			<td>销售次数</td>
            <td>销售金额</td>
		</tr>
		<?php
        //查询订单准备
        $order_item_model = Order_Item::model();

        foreach ($commodity_info as $key=>$comm_value) {
        ?>
            <tr
                <?php
                if($key%2 != 0){
                    echo 'bgcolor="#add8e6"';
                }
                else{
                    echo 'bgcolor="#ffffff"';
                }
                ?>
                >
            <td><?php echo $comm_value->pk_comm_id; ?></td>
            <td><?php echo $comm_value->comm_name; ?></td>
            <td><?php
                switch($comm_value->comm_kind) {
                    case 0:
                        echo "活动专区";
                        break;
                    case 1:
                        echo "产后美体塑形";
                        break;
                    case 2:
                        echo "产后调理养生";
                        break;
                    case 3:
                        echo "美颜面部呵护";
                        break;
                    case 4:
                        echo "特殊产后护理";
                        break;
                    case 8:
                        echo "充值卡";
                        break;
                    default:
                        echo "未知";
                        break;
                }
                ?></td>
            <?php
            $query = 'select * from tbl_order_item where ord_item_comm_id='.$comm_value->pk_comm_id;
            $order_item_sel = $order_item_model->findAllBySql($query);
            echo '<td>'.sizeof($order_item_sel).'</td>';
            $sale_price = 0;
            foreach($order_item_sel as $order_item_value){
                $sale_price += $order_item_value->ord_item_price;
            }
            echo '<td>';
            echo number_format($sale_price,2);
            echo '</td>';
            ?>
            </tr>
        <?php
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