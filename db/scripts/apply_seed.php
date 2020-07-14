<?php
/**
 * Скрипт запуска phinx
 * Применение выбранного seed
 * Запуск скрипта: php -f db/scripts/apply_seed.php -- -name=NameSeed
 * Параметр name - обязательный, формат записи названия seed - CamelCase
 */
$dir = __DIR__;

foreach ($argv as $v){
    if (preg_match("~\\-name=(\w+)~", $v, $m)){
        $name_seed = $m[1];
    }
}

if (empty($name_seed)){
    echo '!!!Error: Empty name seed'.PHP_EOL;
    exit;
}
else $name_seed = "-s ".$name_seed;

echo 'Start: Apply seed script'.PHP_EOL;

$command = "php ".$dir."/../../vendor/robmorgan/phinx/bin/phinx --configuration=".$dir."/../config/phinx.yml seed:run ".$name_seed;
echo exec($command).PHP_EOL;

echo 'End: Apply seed script'.PHP_EOL;
