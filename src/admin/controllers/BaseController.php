<?php

namespace yii2lab\notify\admin\controllers;

use yii2rails\domain\web\ActiveController as Controller;

class BaseController extends Controller
{
	
	public $service = 'notify.test';
	
	public function actions() {
		$actions = parent::actions();
		$actions['index']['render'] = 'index';
		$actions['view']['render'] = 'view';
		return $actions;
	}
	
}
