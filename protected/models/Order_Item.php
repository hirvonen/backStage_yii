<?php

/**
 * 订单详细模型
 * Class Order_Item
 */
class Order_Item extends CActiveRecord
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
		return '{{order_item}}';
	}

	public function attributeLabels()
	{
		return array(
			'pk_ord_itm_id'=>'订单商品id',
			'pk_ord_itm_ord_id'=>'订单号',
			'ord_item_comm_id'=>'商品ID',
			'ord_item_num'=>'商品数量',
			'ord_item_price'=>'商品单价'
		);
	}
}