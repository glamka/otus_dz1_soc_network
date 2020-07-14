<div class="container">
    <form action="/addFriend" method="post">
        <div><b>Список пользователей:</b></div>
        <?php foreach ($vars as $var): ?>
            <div class="container">
                <div>Имя: <?php echo $var['firstname']; ?></div>
                <div>Фамилия: <?php echo $var['lastname']; ?></div>
                <div><a href="/user?userId=<?php echo $var['id']; ?>">Страница пользователя</a></div>
                <button name="addFriendId" value="<?php echo $var['id']; ?>" type="submit">Добавить в друзья</button>
            </div>
        <?php endforeach; ?>
        <input type="hidden" name="parentUserId" value="<?php echo $var['parentUserId']; ?>">
    </form>
</div>