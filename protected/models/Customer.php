<?php

/**
 * 顾客信息模型
 * Class Customer
 */
class Customer extends CActiveRecord
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
		return '{{customer}}';
	}

	public function attributeLabels()
	{
		return array(
			'cust_level'=>'客户级别',
			'cust_balance'=>'账户余额',
			'cust_point'=>'剩余积分',
			'cust_realname'=>'真实姓名',
			'cust_mobile1'=>'手机号码1',
			'cust_mobile2'=>'手机号码2',
			'cust_phone'=>'固定电话',
			'cust_sex'=>'性别',
			'cust_birthday'=>'生日',
			'cust_email1'=>'电子邮件1',
			'cust_email2'=>'电子邮件2',
			'cust_child_no'=>'第几胎',
			'cust_childbearing_age'=>'最近一次生育年龄',
			'cust_source'=>'顾客来源',
			'cust_in_time'=>'首次购买疗程日期',
			'cust_baby1_birthday'=>'Baby生日',
			'cust_baby1_sex'=>'Baby性别',
			'cust_baby2_birthday'=>'Baby生日',
			'cust_baby2_sex'=>'Baby性别',
			'cust_baby3_birthday'=>'Baby生日',
			'cust_baby3_sex'=>'Baby性别',
			'cust_profession'=>'职业',
			'cust_prefer'=>'疗程偏好',
			'cust_beautician'=>'服务美疗师',
			'cust_else'=>'其他情况',
			'cust_bear_info'=>'生产情况',
			'cust_lactation_info'=>'哺乳情况',
			'cust_allergy_info'=>'过敏情况',
			'cust_medical_info'=>'病史情况',
			'cust_period_info'=>'例假情况',
			'cust_sleeping_info'=>'睡眠情况',
			'cust_sports_info'=>'运动情况',
			'cust_other_health_info'=>'其他健康相关情况',
		);
	}

	/**
	 * 商品添加表单验证规则
	 */
	public function rules()
	{
		return array(
			array('cust_level','required','message'=>'顾客级别必填！'),
			array('cust_balance','required','message'=>'顾客账户余额必填！'),
			array('cust_point','required','message'=>'顾客积分必填！'),
			array('cust_mobile1,cust_mobile2','match','pattern'=>'/^1\d{10}$/','message'=>'手机号码形式不正确！'),
			array('cust_phone','match','pattern'=>'/^0\d{2,3}-?\d{7,8}$/','message'=>'座机号码形式不正确！请以区号-号码的形式填写'),
			array('cust_birthday','match','pattern'=>'/^[1-2][\d]{3}\-(0\d|1[0-2])\-([0-2]\d|3[0-1])$/','message'=>'生日形式不正确！'),
			array('cust_email1,cust_email2','match','pattern'=>'/^(\w-*\.*)+@(\w-?)+(\.\w{2,})+$/','message'=>'电子邮件形式不正确！'),
			array('cust_child_no,cust_childbearing_age','match','pattern'=>'/^[0-9]\d*$/','message'=>'此处必须填写数字！（可以为0）'),
			array('cust_realname,cust_sex,cust_source,cust_in_time,
			cust_baby1_birthday,cust_baby1_sex,cust_baby2_birthday,cust_baby2_sex,cust_baby3_birthday,cust_baby3_sex,
			cust_profession,cust_prefer,cust_beautician,cust_else,','safe'),
		);
	}
}