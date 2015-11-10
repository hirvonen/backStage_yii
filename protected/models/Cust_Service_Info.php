<?php

/**
 * 客户疗程项目服务记录
 * Class Cust_Service_Info
 */
class Cust_Service_Info extends CActiveRecord
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
		return '{{cust_service_info}}';
	}
}