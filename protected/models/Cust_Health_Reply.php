<?php

/**
 * 疗程中健康信息反馈
 * Class Cust_Health_Reply
 */
class Cust_Health_Reply extends CActiveRecord
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
		return '{{cust_health_reply}}';
	}

	public function attributeLabels()
	{
		return array(
			'pk_custhr_id'=>'ID',
			'custhr_cust_id'=>'客户姓名',
			'custhr_reply_date'=>'反馈日期',
			'custhr_reply_beau_name'=>'反馈人',
			'custhr_reply'=>'反馈内容',
		);
	}

	/**
	 * 商品添加表单验证规则
	 */
	public function rules()
	{
		return array(
			array('custhr_reply_beau_name','required','message'=>'反馈人必填'),
			array('pk_custhr_id,custhr_cust_id,custhr_reply_date,custhr_reply','safe'),
		);
	}
}