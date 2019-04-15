<?php

namespace yii2lab\notify\domain\repositories\smsc;

use yii\helpers\ArrayHelper;
use yii2rails\app\domain\helpers\EnvService;
use yii2rails\domain\repositories\BaseRepository;
use yii2rails\domain\values\TimeValue;
use yii2lab\notify\domain\entities\SmsEntity;
use yii2lab\notify\domain\interfaces\repositories\SmsInterface;
use yii2lab\notify\domain\helpers\SmscTransfer;

class SmsRepository extends BaseRepository implements SmsInterface {

    /**
     * @var SmscTransfer
     */
    private $smscTransfer;

    public function init() {
        $smscServerConfig = EnvService::getServer('smsc');
        $this->smscTransfer = new SmscTransfer($smscServerConfig['login'], $smscServerConfig['password']);
        parent::init();
    }

    public function send(SmsEntity $message) {
        $this->smscTransfer->send($message->address, $message->content, 0, 0, $message->id);
	}

	public function isDelivered($id, $phone) {
        $data = $this->smscTransfer->getStatus($id, $phone);
        $status = ArrayHelper::getValue($data, '0');
        $isDelivered = $status > 0;
        if(!$isDelivered) {
            return false;
        }
        $timestamp = intval(ArrayHelper::getValue($data, '1'));
        $timeValue = new TimeValue($timestamp);
        return $timeValue;
    }
}
