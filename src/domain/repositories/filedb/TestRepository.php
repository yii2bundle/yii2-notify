<?php

namespace yii2lab\notify\domain\repositories\filedb;

use yii2rails\domain\data\Query;
use yii2rails\extension\arrayTools\repositories\base\BaseActiveDiscRepository;
use yii2lab\notify\domain\interfaces\repositories\TestInterface;

class TestRepository extends BaseActiveDiscRepository implements TestInterface {
	
	public $table = 'notify_test';
	public $path = '@common/runtime/data';

    public function truncateData($type) {
        $query = Query::forge();
        $query->andWhere(['type' => $type]);
        $collection = $this->all();
        foreach ($collection as $index => $value) {
            unset($collection[$index]);
        }
        $this->setCollection($collection);
    }

}