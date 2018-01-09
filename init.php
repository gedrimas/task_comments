<?php

foreach (glob("config/*.php") as $filename) require_once $filename;//автозагрузчик кофигов

spl_autoload_register(function ($class_name) {
    include_once DIRECTORY_SEPARATOR . 'class' . DIRECTORY_SEPARATOR . strtolower($class_name) . '.php';//автозагрузчик классов
});


