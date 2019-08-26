Отправка Call-звонка
===

Звонок является обычным sms c форматом сообщения - 9
Если контент обычный текст он преобразуется в головое сообщение сервисом smsc
Если контент имеет вид <file template_1> то будет браться звуковой файл с названием template_1 с сервиса smsc
(файлы необходимо заранее загрузить в сервис) 

```php
        $smsEntity = new SmsEntity;
        $smsEntity->address = $personEntity->phone;
        $smsEntity->content = $messageEntity->content;
        $smsEntity->format = $type; //$type для звонка равна 9
        
        \App::$domain->notify->sms->sendEntity($smsEntity);
```
