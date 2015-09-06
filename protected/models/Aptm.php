<?php

/**
 * 预约表模型
 * Class Appointment
 */
class Aptm extends CActiveRecord
{
	/**
	 * 创建模型对象
	 * @param string $className
	 * @return static
	 */
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * 返回数据表名字
	 * @return string
	 */
	public function tableName()
	{
		return '{{appointment}}';
	}

	public function attributeLabels()
	{
		return array(
			'pk_aptm_id'=>'预约单号',
			'aptm_beau_id'=>'理疗师',
			'aptm_time'=>'预约时间',
			'aptm_ord_item_id'=>'预约项目名',
			'aptm_status'=>'预约状态',
			'aptm_course_no'=>'疗程内的次数',
			'aptm_cust_name'=>'用户姓名',
			'aptm_cust_tel'=>'用户电话',
			'aptm_cust_addr'=>'用户地址',
		);
	}

	/**
	 * 表单验证规则
	 */
	public function rules()
	{
		return array(
			array('pk_aptm_id,aptm_beau_id,aptm_time,aptm_ord_item_id,aptm_status,aptm_course_no,aptm_cust_name,
			aptm_cust_tel,aptm_cust_addr','safe'),
		);
	}
}