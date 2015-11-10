<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />

	<title>订单一览（好慷）</title>

	<link href="<?php echo BACK_CSS_URL; ?>mine.css" type="text/css" rel="stylesheet" />
</head>
<body>
<style>
	.tr_color{background-color: #9F88FF}
</style>
<div class="div_head">
            <span>
                <span style="float: left;">当前位置是：订单管理-》订单一览（好慷）</span>
                <span style="float: right; margin-right: 8px; font-weight: bold;">
                    <a style="text-decoration: none;" href="./index.php?r=order/addOther&kind=<?php echo OTHER_KIND_HAOKANG ?>">【添加好慷订单】</a>
                </span>
            </span>
</div>
<div></div>
<!--<div class="div_search">-->
<!--            <span>-->
<!--                --><?php //$form = $this->beginWidget('CActiveForm'); ?>
<!--                --><?php
//                if(isset($_POST["ord_status"])) {
//                    $select_status = $_POST["ord_status"];
//                }
//                else {
//                    $select_status = 0;
//                }
//                ?>
<!--                订单状态<select name="ord_status" style="width: 100px;">-->
<!--                    <option --><?php
//                    if( $select_status == 0 ) echo " selected="."'"."selected"."' ";
//                    ?><!-- value="0">全部</option>-->
<!--                    <option --><?php
//                    if( $select_status == 100 ) echo " selected="."'"."selected"."' ";
//                    ?><!-- value="100">等待付款</option>-->
<!--                    <option --><?php
//                    if( $select_status == 200 ) echo " selected="."'"."selected"."' ";
//                    ?><!-- value="200">等待确认</option>-->
<!--                    <option --><?php
//                    if( $select_status == 300 ) echo " selected="."'"."selected"."' ";
//                    ?><!-- value="300">等待服务</option>-->
<!--                    <option --><?php
//                    if( $select_status == 400 ) echo " selected="."'"."selected"."' ";
//                    ?><!-- value="400">订单取消</option>-->
<!--                    <option --><?php
//                    if( $select_status == 500 ) echo " selected="."'"."selected"."' ";
//                    ?><!-- value="500">等待评价</option>-->
<!--                    <option --><?php
//                    if( $select_status == 600 ) echo " selected="."'"."selected"."' ";
//                    ?><!-- value="600">订单完成</option>-->
<!--                </select>-->
<!--	                <input value="查询" type="submit" />-->
<!--                --><?php //$this->endWidget(); ?>
<!--            </span>-->
<!--</div>-->
<div style="font-size: 13px; margin: 10px 5px;">
	<table class="table_a" border="1" width="100%">
		<tbody><tr bgcolor="#4169e1" style="font-weight: bold;">
            <td>订单编号</td>
            <td>顾客姓名</td>
            <td>顾客电话</td>
            <td>项目</td>
            <td>上门时间</td>
            <td>上门地址</td>
            <td>区名</td>
            <td>是否付款</td>
            <td>推荐人</td>
            <td>订单状态</td>
            <td>更新时间</td>
        </tr>
        <?php
        $i = 0;
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
<!--                <td>--><?php //echo $_v->pk_contact_id ?><!--</td>-->
                <td><a href="./index.php?r=order/updateOther&id=<?php echo $_v->pk_contact_id ?>"><?php echo $_v->pk_contact_id ?></a></td>
                <td><?php echo $_v->con_name ?></td>
                <td><?php echo $_v->con_mobile ?></td>
                <td><?php
                    switch($_v->con_prefer) {
                        case 4:
                            echo "经络养生";
                            break;
                        case 5:
                            echo "透润美肤";
                            break;
                        default:
                            echo "出错啦001!！";
                            break;
                    }
                    ?></td>
                <td><?php echo $_v->con_time; ?></td>
                <td><?php echo $_v->con_address; ?></td>
                <td><?php
                    switch($_v->con_district) {
                        case 1:
                            echo '黄浦';
                            break;
                        case 2:
                            echo '静安';
                            break;
                        case 3:
                            echo '徐汇';
                            break;
                        case 4:
                            echo '卢湾';
                            break;
                        case 5:
                            echo '长宁';
                            break;
                        case 6:
                            echo '闸北';
                            break;
                        case 7:
                            echo '虹口';
                            break;
                        case 8:
                            echo '杨浦';
                            break;
                        case 9:
                            echo '浦东';
                            break;
                        case 10:
                            echo '普陀';
                            break;
                        case 11:
                            echo '闵行';
                            break;
                        case 12:
                            echo '宝山';
                            break;
                        case 13:
                            echo '嘉定';
                            break;
                        case 14:
                            echo '松江';
                            break;
                        case 15:
                            echo '青浦';
                            break;
                        case 16:
                            echo '奉贤';
                            break;
                        case 17:
                            echo '金山';
                            break;
                        case 18:
                            echo '崇明';
                            break;
                    }
                    ?></td>
                <td><?php
                    switch($_v->con_flag) {
                        case 1:
                            echo "已付款";
                            break;
                        case 0:
                            echo "未付款";
                            break;
                        default:
                            echo "出错啦002!";
                            break;
                    }
                    ?></td>
                <td><?php echo $_v->con_referee; ?></td>
                <td><?php
                    switch($_v->con_status) {
                        case 0:
                            echo "未完成";
                            break;
                        case 1:
                            echo "已完成";
                            break;
                        default:
                            echo "出错啦003!";
                            break;
                    }
                    ?></td>
                <td><?php echo $_v->con_upt_time; ?></td>
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