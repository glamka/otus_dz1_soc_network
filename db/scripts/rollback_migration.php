<?php
/**
 * Скрипт запуска phinx
 * Откат миграций
 * Запуск скрипта: php -f db/scripts/rollback_migration.php -- -e=development
 * Параметр e - не обязательный, определяет пространство, куда будет загружаться миграция (см. конфиг файл phinx)
 */
$dir = __DIR__;

foreach ($argv as $v){
    if (preg_match("~\\-e=(\w+)~", $v, $m)){
        $name_environments = $m[1];
    }
}

$name_environments = empty($name_environments) ? $name_environments = "" : " -e ".$name_environments;

echo 'Start: Rollback migration script'.PHP_EOL;

$command = "php ".$dir."/../../vendor/robmorgan/phinx/bin/phinx --configuration=".$dir."/../config/phinx.yml rollback ".$name_environments;
echo exec($command).PHP_EOL;

echo 'End: Rollback migration script'.PHP_EOL;

