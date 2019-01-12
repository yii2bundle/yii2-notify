<?php

namespace yii2lab\notify\domain\repositories\filedb;

use yii2lab\extension\arrayTools\repositories\base\BaseActiveDiscRepository;
use yii2lab\notify\domain\interfaces\repositories\TestInterface;

class TestRepository extends BaseActiveDiscRepository implements TestInterface {
	
	public $table = 'notify_test';
	public $path = '@common/runtime/data';
	
}