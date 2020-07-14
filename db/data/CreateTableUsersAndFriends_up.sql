create table users
(
	id int not null,
	firstname varchar(1000) null comment 'Имя',
	lastname varchar(1000) null comment 'Фамилия',
	age integer null comment 'Возраст',
	sex enum('empty', 'male', 'female') null comment 'Пол',
	interests varchar(5000) null comment 'Интересы',
	city varchar(1000) null comment 'Город',
	login varchar(100) null comment 'Логин для авторизации',
	password varchar(32) null comment 'Пароль для авторизации в хеше md5',
    cookie varchar(64) null comment 'Сохраненные куки пользователя',
	constraint users_pk
		primary key (id)
)
comment 'Таблица пользователей';

alter table users modify id int auto_increment;

create unique index users_id_uindex
    on users (id);

create table friends
(
	user_one int not null comment 'ID пользователя из таблицы Users (инициатор добавления в друзья)',
	user_two int not null comment 'ID пользователя из таблицы Users (кого добавляют в друзья)',
	status enum('0', '1', '2') null comment 'Статус заявки добавления в друзья:
0 - заявка отклонена
1 - заявка отправлена
2 - заявка принята',
	constraint friends_pk
		primary key (user_one, user_two),
	constraint friends_users_id_fk
		foreign key (user_one) references users (id),
	constraint friends_users_id_fk_2
		foreign key (user_two) references users (id)
)
comment 'Таблица взаимосвязей друзей';