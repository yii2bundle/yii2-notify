<?php

namespace yii2lab\notify\domain\repositories\yii;

use Yii;
use yii\base\InvalidArgumentException;
use yii2rails\domain\Alias;
use yii2rails\extension\arrayTools\repositories\base\BaseActiveArrayRepository;
use yii2rails\extension\yii\helpers\FileHelper;
use yii2lab\notify\domain\entities\EmailEntity;
use yii2lab\notify\domain\helpers\EmlParserHelper;
use yii2lab\notify\domain\interfaces\repositories\EmailInterface;

class EmailRepository extends BaseActiveArrayRepository implements EmailInterface
{

    const ALIAS = '@common/runtime/mail';

    public $email = null;
    /**
     * @var yii\mail\MailerInterface
     */
    private $_mailerInstance;

    public function send(EmailEntity $message)
    {
        $mailer = Yii::$app->mailer->compose();
        if ($message->from != null) {
            $mailer->setFrom($message->from);
        } elseif (!empty($this->email)) {
            $mailer->setFrom($this->email);
        }
        $mailer->setTo($message->address);
        if (!empty($message->copyToAdress)) {
            $mailer->setCc($message->copyToAdress);
        }
        if (!empty($message->blindCopyToAddress)) {
            $mailer->setBcc($message->blindCopyToAddress);
        }
        if (!empty($message->forwardAddress)) {
            $mailer->setHeader('Х-Forwarded-To', $message->forwardAddress);
            //$mailer->addHeader('Х-Forwarded-For', $message->address . ' ' . $message->forwardAddress);
        }

        $mailer->setSubject($message->subject);
        $mailer->setTextBody($message->content);
        $mailer->setHtmlBody($message->content);
        if ($message->attachments) {
            foreach ($message->attachments as $attachmentEntity) {
                if ($attachmentEntity->content) {
                    $mailer->attachContent($attachmentEntity->content, [
                        'fileName' => basename($attachmentEntity->fileName),
                        'contentType' => $attachmentEntity->contentType,
                    ]);
                } else {
                    $mailer->attach($attachmentEntity->fileName);
                }
            }
        }
        return $mailer->send();
    }

    private function getFiles()
    {
        $dir = Yii::getAlias(self::ALIAS);
        try {
            $files = FileHelper::findFiles($dir);
        } catch (InvalidArgumentException $e) {
            $files = [];
        }
        return $files;
    }

    private function mailerInstance()
    {
        if (!$this->_mailerInstance instanceof yii\mail\MailerInterface) {
            $this->_mailerInstance = Yii::createObject('yii2bundle\notify\domain\mailer\Mailer');
        }
        return $this->_mailerInstance;
    }

    public function getCollection()
    {
        $files = $this->getFiles();
        $collection = [];
        foreach ($files as $file) {
            $message = FileHelper::load($file);
            $item = EmlParserHelper::parse($message);
            $emailEntity = $this->forgeEntityItem($item);
            $collection[] = $emailEntity;
        }
        return $collection;
    }

    private function forgeEntityItem($data)
    {
        $alias = new Alias();
        $alias->setAliases([
            'message_id' => 'id',
            'date' => 'created_at',
            'to' => 'address',
        ]);
        $data = $alias->encode($data);
        $emailEntity = new EmailEntity($data);
        return $emailEntity;
    }
}