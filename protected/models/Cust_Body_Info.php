<?php

/**
 * 顾客身体信息模型
 * Class Cust_Body_Info
 */
class Cust_Body_Info extends CActiveRecord
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
		return '{{cust_body_info}}';
	}
}