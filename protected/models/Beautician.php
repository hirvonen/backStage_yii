<?php

/**
 * 美疗师模型
 * Class Beautician
 */
class Beautician extends CActiveRecord
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
		return '{{beautician}}';
	}

	public function attributeLabels()
	{
		return array(
			'beau_realname'=>'真实姓名',
			'beau_nickname'=>'昵称',
			'beau_idcard_id'=>'身份证号码',
			'beau_level'=>'理疗师级别',
			'beau_tel1'=>'联系电话1',
			'beau_tel2'=>'联系电话2',
			'beau_valid'=>'在岗状态',
			'beau_sex'=>'性别',
			'beau_birthday'=>'生日',
			'beau_email'=>'电子邮件',
			'beau_intro'=>'简介',
		);
	}

	/**
	 * 表单验证规则
	 */
	public function rules()
	{
		return array(
			array('beau_realname','required','message'=>'美容师姓名必填！'),
			array('beau_idcard_id','required','message'=>'美容师身份证号码必填！'),
			array('beau_level','required','message'=>'美容师级别必填！'),
			array('beau_tel1','required','message'=>'美容师联系电话必填！'),
			array('beau_sex','required','message'=>'美容师性别必填！'),
			array('beau_birthday','required','message'=>'美容师生日必填！'),
			array('beau_birthday','match','pattern'=>'/^[1-2][\d]{3}\-(0\d|1[0-2])\-([0-2]\d|3[0-1])$/','message'=>'生日形式不正确！'),
			array('beau_tel1,beau_tel2','match','pattern'=>'/^1\d{10}$/','message'=>'手机号码形式不正确！'),
			array('beau_email','match','pattern'=>'/^(\w-*\.*)+@(\w-?)+(\.\w{2,})+$/','message'=>'电子邮件形式不正确！'),
			array('beau_intro','required','message'=>'美容师简介必填！'),
			array('beau_nickname,beau_valid','safe'),
		);
	}
}