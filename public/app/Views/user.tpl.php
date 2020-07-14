<div class="container">
    <div><b>Анкета пользователя:</b></div>
    <div>Имя: <?php echo $firstname; ?></div>
    <div>Фамилия: <?php echo $lastname; ?></div>
    <div>Возраст: <?php echo $age; ?></div>
    <div>Пол: <?php
        switch ($sex) {
            case 'male':
                echo "Мужской";
                break;
            case 'female':
                echo "Женский";
                break;
            case 'empty':
                echo "Не указано";
                break;
        }
        ?></div>
    <div>Интересы: <?php echo $interests; ?></div>
    <div>Город: <?php echo $city; ?></div>
</div>