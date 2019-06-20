<?php

namespace yii2lab\notify\domain\enums;

use yii2rails\extension\enum\base\BaseEnum;

class SmsStatusEnum extends BaseEnum
{

    const DISABLE = 0;
    const NEW = 100;
    const SENDED = 200;
    const ERROR = 300;
    const DELIVERED = 400;

}