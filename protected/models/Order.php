<?php

/**
 * 订单模型
 * Class Order
 */
class Order extends CActiveRecord
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
		return '{{order}}';
	}

    public function attributeLabels()
    {
        return array(
            'pk_ord_id'=>'订单编号',
            'ord_cust_id'=>'用户编号',
            'ord_status'=>'订单状态',
            'ord_cust_name'=>'用户姓名',
            'ord_cust_tel'=>'用户电话',
            'ord_cust_addr'=>'用户地址',
            'ord_cust_postcode'=>'用户邮编',
            'ord_pay_way'=>'订单支付方式',
            'ord_upt_time'=>'订单更新时间',
//            'ord_total_discount'=>'总折扣额',
            'ord_deductible'=>'订单应付款中可以用余额抵扣金额',
            'ord_downpay'=>'下单时需支付的预约款',
            'ord_downpay_deductible'=>'预约款中可被抵扣金额',
            'ord_paid_money'=>'已支付总额',
            'ord_paid_net'=>'使用平台支付的付款金额',
            'ord_paid_balance'=>'使用余额抵扣的付款金额',
            'ord_coupon'=>'团购券'
        );
    }

    /**
     * 表单验证规则
     */
    public function rules()
    {
        return array(
            array('ord_cust_tel','match','pattern'=>'/^[0-9]\d*$/','message'=>'电话号码必须是数字！'),
            array('ord_cust_postcode','match','pattern'=>'/^[0-9]\d{5}$/','message'=>'邮编形式不正确！'),
            array('ord_deductible,ord_downpay,ord_downpay_deductible,ord_paid_money,ord_paid_net,ord_paid_balance',
                'match','pattern'=>'/^[0-9]+(.[0-9]{2})?$/','message'=>'金额必须是数字！'),
            array('pk_ord_id,ord_cust_id,ord_status,ord_cust_name,ord_cust_addr,ord_pay_way,ord_upt_time','safe'),
        );
    }
}