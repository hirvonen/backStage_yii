<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />

	<title>用户列表</title>

	<link href="<?php echo BACK_CSS_URL; ?>mine.css" type="text/css" rel="stylesheet" />
</head>
<body>
<style>
	.tr_color{background-color: #9F88FF}
</style>
<div class="div_head">
            <span>
                <span style="float: left;">当前位置是：用户管理-》用户一览</span>
                <span style="float: right; margin-right: 8px; font-weight: bold;">
                    <a style="text-decoration: none;" href="./index.php?r=user/add_step1">【添加用户】</a>
                </span>
            </span>
</div>
<div></div>
<?php
	$customer_model = Customer::model();
	$beautician_model = Beautician::model();
?>
<div class="div_search">
            <span>
                <?php $form = $this->beginWidget('CActiveForm'); ?>
	            <?php
		            if(isset($_POST["usr_kind"])) {
			            $select_kind = $_POST["usr_kind"];
		            }
		            else {
			            $select_kind = 0;
		            }
	            ?>
	            种别<select name="usr_kind" style="width: 100px;">
		            <option <?php
		            if( $select_kind == 0 ) echo " selected="."'"."selected"."' ";
		            ?> value="0">全部</option>
		            <option <?php
		            if( $select_kind == 1 ) echo " selected="."'"."selected"."' ";
		            ?> value="1">管理员</option>
		            <option <?php
		            if( $select_kind == 2 ) echo " selected="."'"."selected"."' ";
		            ?> value="2">理疗师</option>
		            <option <?php
		            if( $select_kind == 3 ) echo " selected="."'"."selected"."' ";
		            ?> value="3">顾客</option>
	            </select>
	                <input value="查询" type="submit" />
	            <?php $this->endWidget(); ?>
            </span>
</div>
<div style="font-size: 13px; margin: 10px 5px;">
<!--	<table class="table_a" border="1" width="100%">-->
	<table class="table_show_color" border="1" width="100%">
		<tbody><tr class="alt" style="font-weight: bold;">
			<th>用户编号</th>
			<th>用户种别</th>
			<th>用户姓名</th>
			<th>用户名</th>
			<th>创建时间</th>
		</tr>
		<?php
        $i=0;
		foreach (array_reverse($user_info) as $_v) {
			?>
			<tr <?php
                if($i%2 != 0){
                    echo 'class="alt"';
                }
                ?>
                id="user1">
<!--				<td><a href="./index.php?r=user/detail&id=--><?php //echo $_v->pk_usr_id ?><!--">详细</a></td>-->
<!--				<td>--><?php //echo $_v->pk_usr_id ?><!--</td>-->
				<td><a href="./index.php?r=user/update&id=<?php echo $_v->pk_usr_id ?>"><?php echo $_v->pk_usr_id ?></a></td>
				<td><?php
					if($_v->usr_kind == 0) {
						echo "管理员";
					}
					elseif($_v->usr_kind == 1){
						echo "理疗师";
					}
					elseif($_v->usr_kind == 2){
						echo "顾客";
					}
					else{
						echo "未知";
					}
					?></a></td>
				<td>
					<?php
					switch($_v->usr_kind){
						case 2:
							//顾客的话，取姓名来显示
							$customer_info = $customer_model->findByPk($_v->pk_usr_id);
							if(isset($customer_info)){
								echo $customer_info->cust_realname;
							}
							else{
								echo '未知顾客';
							}
							break;
						case 1:
							//理疗师的话，取姓名来显示
							$beautician_info = $beautician_model->findByPk($_v->pk_usr_id);
							if(isset($beautician_info)){
								echo $beautician_info->beau_realname;
							}
							else{
								echo '未知理疗师';
							}
							break;
						case 0:
							echo '管理员';
							break;
						default:
							echo '出错啦！';
							break;
					}
					?>
				</td>
<!--				<td>--><?php
//					if($_v->usr_reg_kind == 0) {
//						echo "微信用户";
//					}
//					elseif($_v->usr_reg_kind == 1){
//						echo "新浪微博用户";
//					}
//					elseif($_v->usr_reg_kind == 2){
//						echo "QQ用户";
//					}
//					elseif($_v->usr_reg_kind == 3){
//						echo "腾讯微博用户";
//					}
//					elseif($_v->usr_reg_kind == 4){
//						echo "网站注册用户";
//					}
//					else{
//						echo "未知";
//					}
//					?><!--</a></td>-->
				<td><?php echo $_v->usr_username; ?></a></td>
				<td><?php echo $_v->usr_create_time; ?></a></td>
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