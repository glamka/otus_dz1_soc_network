<form action="/register" method="post">
    <header><b>Регистрация пользователя</b></header>
    <div class="regForm">
        <label>Логин <span>*</span></label>
        <input name="login"/>
    </div>
    <div class="regForm">
        <label>Пароль <span>*</span></label>
        <input name="password"/></div>
    <div class="regForm">
        <label>Имя <span>*</span></label>
        <input name="firstname"/></div>
    <div class="regForm">
        <label>Фамилия <span>*</span></label>
        <input name="lastname"/></div>
    <div class="regForm">
        <label>Возраст <span>*</span></label>
        <input name="age"/></div>
    <div class="regForm">
        <label>Пол <span>*</span></label>
        <input type="radio" name="sex" value="male"> Мужской<Br>
        <input type="radio" name="sex" value="female"> Женский<Br>
        <input type="radio" name="sex" value="empty"> Не указывать<Br>
    </div>
    <div class="regForm">
        <label>Интересы <span>*</span></label>
        <input name="interests"/>
    </div>
    <div class="regForm">
        <label>Город <span>*</span></label>
        <input name="city"/>
    </div>
    <button type="submit">Регистрация</button>
</form>