<?php

namespace yii2lab\notify\admin\controllers;

use Yii;
use yii2rails\domain\data\Query;
use yii2rails\extension\web\helpers\Behavior;
use yii2lab\notify\domain\entities\TestEntity;
use yii2lab\notify\domain\enums\TypeEnum;

class SmsController extends BaseController
{
	
	const RENDER_INDEX = '@yii2lab/notify/admin/views/sms/index';
	
	public $formClass = 'yii2lab\notify\admin\forms\SmsForm';

	public function behaviors()
    {
        return [
            Behavior::verb([
                'clean' => ['POST'],
            ]),
        ];
    }

    public function actions() {
		$actions = parent::actions();
		$actions['index'] = [
			'class' => self::ACTION_INDEX,
			'render' => self::RENDER_INDEX,
			'query' => Query::forge()->where('type', TestEntity::TYPE_SMS)->orderBy(['created_at' => SORT_DESC]),
		];
		$actions['create'] = [
			'class' => self::ACTION_CREATE,
			'render' => self::RENDER_CREATE,
			'service' => \App::$domain->notify->sms,
			'serviceMethod' => 'send',
			'serviceMethodParams' => ['address', 'content'],
		];
		return $actions;
	}

	public function actionClean() {
        \App::$domain->notify->test->truncate(TypeEnum::SMS);
	    \App::$domain->navigation->alert->create(\Yii::t('notify/main', 'messages_deleted'));
	    return $this->redirect('/notify/sms');
    }

}
