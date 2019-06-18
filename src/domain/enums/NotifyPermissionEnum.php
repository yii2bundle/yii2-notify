<?php

namespace yii2lab\notify\domain\enums;

use yii2rails\extension\enum\base\BaseEnum;

class NotifyPermissionEnum extends BaseEnum
{

    // Управление уведомлениями
    const MANAGE = 'oNotifyManage';

    // Отправка SMS
    const SMS_SEND = 'oNotifySmsSend';

}