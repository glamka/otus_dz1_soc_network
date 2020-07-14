#Инструкция по установке

##Требования:
 - php v.7
 - MySQL v.8.
 
##Установка:
- установка вышеперечисленного актуального ПО
- клонирование проекта
- прописывание в конфиги хоста пути к папки фронтанда: `/public`
    - проверка, возможно сбрасывание конфига
- установка composer пакетов без пакетов для разработки: `composer update --no-dev`
- прописывание доступов к БД для Фронтентда Системы на основе sample в файл: `public/app/config.php`
- прописывание доступов к БД для phinx на основе sample в файл: `db/config/phinx.yml`
- применение миграций DB используя `phinx: php -f db/scripts/apply_migration.php` (* возможно применение другой версии PHP, чем нативная, при возникновении ошибки)
см. параметры выполняемого файла
- применение установки первоначальных данных в DB используя `phinx: php -f db/scripts/apply_seed.php`
см. параметры выполняемого файла
- включить адаптер mysql  в настройках расширений PHP