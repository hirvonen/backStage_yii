<?php

/**
 * 地址模型
 * Class Address
 */
class Address extends CActiveRecord
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
		return '{{address}}';
	}

	public function attributeLabels()
	{
		return array(
			'addr_addr'=>'顾客地址',
			'addr_district'=>'区域',
		);
	}

	public function rules()
	{
		return array(
			array('addr_addr,addr_district','safe'),
		);
	}
}