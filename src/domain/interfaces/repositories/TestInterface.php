<?php

namespace yii2lab\notify\domain\interfaces\repositories;

use yii2rails\domain\interfaces\repositories\CrudInterface;

interface TestInterface extends CrudInterface {

    public function truncate($type);

}