Общие принципы
===

Вместо темы или содержания мы можем использовать доступ к переводам

```php
App::$domain->notify->flash->send(['main', 'not_found'], Alert::TYPE_DANGER);
```

SMS и Email Отправляются через очередь по CRON.
