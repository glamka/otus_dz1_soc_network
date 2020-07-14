<?php
/**
 * Скрипт запуска phinx
 * Создание миграции
 * Запуск скрипта: php -f db/scripts/create_migration.php -- -name=NameMigration
 * Параметр name - обязательный, формат записи названия миграции - CamelCase
 */
$dir = __DIR__;

foreach ($argv as $v){
    if (preg_match("~\\-name=(\w+)~", $v, $m)){
        $name_migration = $m[1];
    }
}

if (empty($name_migration)){
    echo '!!!Error: Empty name migration'.PHP_EOL;
    exit;
}

echo 'Start: Create migration script'.PHP_EOL;

$command = "php ".$dir."/../../vendor/robmorgan/phinx/bin/phinx --configuration=".$dir."/../config/phinx.yml create ".$name_migration;
echo exec($command).PHP_EOL;

echo 'End: Create migration script'.PHP_EOL;

