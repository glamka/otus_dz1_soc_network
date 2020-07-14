<?php
/**
 * Скрипт запуска phinx
 * Применение всех миграций, которые еще не были применены
 * Запуск скрипта: php -f db/scripts/apply_migration.php -- -e=development
 * Параметр e - не обязательный, определяет пространство, куда будет загружаться миграция (см. конфиг файл phinx)
 */
$dir = __DIR__;

foreach ($argv as $v){
    if (preg_match("~\\-e=(\w+)~", $v, $m)){
        $name_environments = $m[1];
    }
}

$name_environments = empty($name_environments) ? $name_environments = "" : " -e ".$name_environments;

echo 'Start: Apply migration script'.PHP_EOL;

$command = "php ".$dir."/../../vendor/robmorgan/phinx/bin/phinx --configuration=".$dir."/../config/phinx.yml migrate ".$name_environments;
echo exec($command).PHP_EOL;

echo 'End: Apply migration script'.PHP_EOL;
