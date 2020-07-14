<?php
/**
 * Скрипт запуска phinx
 * Создание нового seed c данными
 * Запуск скрипта: php -f db/scripts/create_seed.php -- -name=NameSeed
 * Параметр name - обязательный, формат записи названия seed - CamelCase
 */
$dir = __DIR__;

foreach ($argv as $v){
    if (preg_match("~\\-name=(\w+)~", $v, $m)){
        $name_seed = $m[1];
    }
}

if (empty($name_seed)){
    echo '!!!Error: Empty name seed';
    exit;
}

echo 'Start: Create seed script'.PHP_EOL;

$command = "php ".$dir."/../../vendor/robmorgan/phinx/bin/phinx --configuration=".$dir."/../config/phinx.yml seed:create ".$name_seed;
echo exec($command).PHP_EOL;

echo 'End: Create seed script'.PHP_EOL;