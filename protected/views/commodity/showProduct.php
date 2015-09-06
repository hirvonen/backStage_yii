<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />

	<title>服务列表</title>

	<link href="<?php echo BACK_CSS_URL; ?>mine.css" type="text/css" rel="stylesheet" />
</head>
<body>
<style>
	.tr_color{background-color: #9F88FF}
</style>
<div class="div_head">
            <span>
                <span style="float: left;">当前位置是：商品管理-》商品一览</span>
                <span style="float: right; margin-right: 8px; font-weight: bold;">
                    <a style="text-decoration: none;" href="./index.php?r=commodity/addProduct">【添加商品】</a>
                </span>
            </span>
</div>
<div></div>
<div class="div_search">
            <span>
                <?php $form = $this->beginWidget('CActiveForm'); ?>
	            <?php
	            if(isset($_POST["comm_is_show"])) {
		            $select_show = $_POST["comm_is_show"];
	            }
	            else {
		            $select_show = 2;
	            }
	            if(isset($_POST["comm_is_hot"])){
		            $select_hot = $_POST["comm_is_hot"];
	            }
	            else{
		            $select_hot = 2;
	            }

	            ?>
	            显示<select name="comm_is_show" style="width: 100px;">
		            <option <?php
		            if( $select_show == 2 ) echo " selected="."'"."selected"."' ";
		            ?> value="2">全部</option>
		            <option <?php
		            if( $select_show == 1 ) echo " selected="."'"."selected"."' ";
		            ?> value="1">显示</option>
		            <option <?php
		            if( $select_show == 0 ) echo " selected="."'"."selected"."' ";
		            ?> value="0">未显示</option>
	            </select>
                热门<select name="comm_is_hot" style="width: 100px;">
		            <option <?php
		            if( $select_hot == 2 ) echo " selected="."'"."selected"."' ";
		            ?> value="2">全部</option>
		            <option <?php
		            if( $select_hot == 1 ) echo " selected="."'"."selected"."' ";
		            ?> value="1">热门</option>
		            <option <?php
		            if( $select_hot == 0 ) echo " selected="."'"."selected"."' ";
		            ?> value="0">非热门</option>
	            </select>
	                <input value="查询" type="submit" />
	            <?php $this->endWidget(); ?>
            </span>
</div>
<div style="font-size: 13px; margin: 10px 5px;">
	<table class="table_a" border="1" width="100%">
		<tbody><tr bgcolor="#4169e1" style="font-weight: bold;">
			<td align="center">操作</td>
			<td>商品编号</td>
			<td>种别</td>
			<td>商品名称</td>
			<td>价格</td>
			<td>折扣价格</td>
			<td>上架时间</td>
			<td>下架时间</td>
			<td>变更时间</td>
			<td>点击次数</td>
			<td>热门</td>
			<td>是否显示</td>
<!--			<td>排序</td>-->
		</tr>
		<?php
        $i = 0;
		foreach ($commodity_info as $_v) {
			?>
			<tr <?php
                if($i%2 != 0){
                    echo 'bgcolor="#add8e6"';
                }
                else{
                    echo 'bgcolor="#ffffff"';
                }
                ?>
                id="product1">
				<td><a href="./index.php?r=commodity/updateProduct&id=<?php echo $_v->pk_comm_id ?>">详细</a></td>
				<td><?php echo $_v->pk_comm_id ?></td>
				<td><?php
					switch($_v->comm_kind) {
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
					?></a></td>
				<td><?php echo $_v->comm_name; ?></td>
				<td><?php echo $_v->comm_price; ?></a></td>
				<td><?php echo $_v->comm_discount; ?></a></td>
				<td><?php echo $_v->comm_on_shelve_time; ?></a></td>
				<td><?php echo $_v->comm_off_shelve_time; ?></a></td>
				<td><?php echo $_v->comm_update_time; ?></a></td>
				<td><?php echo $_v->comm_check_times; ?></a></td>
				<td><?php
					if($_v->comm_is_hot == 1) {
						echo "热门";
					}
					else{
						echo "非热门";
					}
					?></a></td>
				<td><?php
					if($_v->comm_is_show == 1) {
						echo "显示";
					}
					else{
						echo "隐藏";
					}
					?></a></td>
<!--				<td>--><?php //echo $_v->comm_sort_order; ?><!--</a></td>-->
				<td>
					<script language="javascript">
						function delcfm() {
							if (!confirm("确认要删除？")) {
								window.event.returnValue = false;
							}
						}
					</script>
					<a href="./index.php?r=commodity/delProduct&id=<?php echo $_v->pk_comm_id ?>" onClick="delcfm()">删除</a>
				</td>
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