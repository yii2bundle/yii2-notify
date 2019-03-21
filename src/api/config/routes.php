<?php

$version = API_VERSION_STRING;

return [
    "DELETE {$version}/notify-test" => "notify/test/clean",
    ["class" => "yii\\rest\UrlRule", "controller" => ["{$version}/notify-test" => "notify/test"]],
];
