<?php

/**
 * 用户模型
 * Class User
 */
class User extends CActiveRecord
{
	public $user_chg_pwd_old;
	public $user_chg_pwd_new;
	public $user_chg_pwd_new_cfm;

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
		return '{{user}}';
	}

	public function attributeLabels()
	{
		return array(
			'pk_usr_id'=>'用户ID',
			'usr_kind'=>'用户种别',
			'usr_reg_kind'=>'用户注册方式',
			'usr_open_id'=>'openid',
			'usr_username'=>'用户名',
			'usr_password'=>'密码',
			'usr_create_time'=>'用户创建时间',
			'usr_last_login'=>'最后登录时间',
			'usr_status'=>'用户状态',
			'usr_pic_id'=>'用户头像',
			'user_chg_pwd_old'=>'现在密码',
			'user_chg_pwd_new'=>'新密码',
			'user_chg_pwd_new_cfm'=>'确认新密码',
		);
	}

	/**
	 * 表单验证规则
	 */
	public function rules()
	{
		return array(
			array('user_chg_pwd_old','required','message'=>'现在密码必填'),
			array('user_chg_pwd_new','required','message'=>'新密码必填'),
			array('user_chg_pwd_new_cfm','required','message'=>'新密码确认必填'),
			array('user_chg_pwd_new_cfm','compare','compareAttribute'=>'user_chg_pwd_new','message'=>'两次新密码不一致！'),
			array('user_chg_pwd_new','rules_not_equal'),
			array('usr_username','unique','message'=>'该用户名已被使用！请换一个用户名！'),
			array('pk_usr_id,usr_kind,usr_reg_kind,usr_open_id,usr_password,usr_create_time,usr_last_login,usr_status,usr_pic_id','safe'),
		);
	}

	/**
	 * @param $attribute
	 * 自定义验证规则
	 */
	public function rules_not_equal($attribute){
		if($this->user_chg_pwd_old === $this->user_chg_pwd_new){
			$this->addError($attribute, '新旧密码不能一样！');
		}
	}
}