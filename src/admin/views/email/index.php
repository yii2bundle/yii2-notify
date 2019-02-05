<?php

/* @var $this yii\web\View */

use yii\grid\GridView;
use yii\helpers\Html;
use yii2rails\extension\web\helpers\ControllerHelper;

$this->title = Yii::t('notify/main', 'email');

$baseUrl = ControllerHelper::getUrl();

$columns = [
	[
		'attribute' => 'address',
		'label' => Yii::t('notify/main', 'address'),
	],
	[
		'attribute' => 'subject',
		'label' => Yii::t('notify/main', 'subject'),
	],
	[
		'attribute' => 'content',
		'label' => Yii::t('notify/main', 'content'),
	],
	/*[
		'attribute' => 'created_at',
		'label' => Yii::t('main', 'created_at'),
	],*/
];

?>

<?= GridView::widget([
	'dataProvider' => $dataProvider,
	'layout' => '{summary}{items}',
	'columns' => $columns,
]); ?>

<?= Html::a(Yii::t('action', 'create'), $baseUrl . 'create', ['class' => 'btn btn-success']) ?>