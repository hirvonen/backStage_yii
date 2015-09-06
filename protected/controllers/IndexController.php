<?php

/**
 * 后台整体架构控制器
 * Class IndexController
 */
class IndexController extends Controller
{
	/**
	 * 后台主页面头部
	 * @throws CException
	 */
	public function actionHead()
	{
		$this->renderPartial('head');
	}

	/**
	 * 后台主页面左侧菜单
	 * @throws CException
	 */
	public function actionLeft()
	{
		$this->renderPartial('left');
	}

	/**
	 * 后台主页面右侧具体内容
	 * @throws CException
	 */
	public function actionRight()
	{
		$this->renderPartial('right');
	}

	/**
	 * 将头部，左侧，右侧三者结合
	 * @throws CException
	 */
	public function actionIndex()
	{
		$this->renderPartial('index');
	}
}