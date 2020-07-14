<div class="container">
    <div><b>Список друзей:</b></div>
    <form action="/delFriend" method="post">
        <?php foreach ($vars as $var): ?>
            <div class="container">
                <div>Имя: <?php echo $var['firstname']; ?></div>
                <div>Фамилия: <?php echo $var['lastname']; ?></div>
                <div><a href="/user?userId=<?php echo $var['id']; ?>">Страница пользователя</a></div>
                <button name="delFriendId" value="<?php echo $var['id']; ?>" type="submit">Удалить из друзей</button>
            </div>
        <?php endforeach; ?>
        <input type="hidden" name="parentUserId" value="<?php echo $var['parentUserId']; ?>">
    </form>
</div>