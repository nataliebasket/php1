--Добавление записей в таблицу project
INSERT INTO project (name) VALUES ( 'Входящие'), ('Учеба'), ('Работа'), ('Домашние дела'), ('Авто');

--Добавление записей в таблицу task
INSERT INTO task (status, name, date_make, project_id ) VALUES (0, 'Собеседование в IT компании','2023-02-13 12:00:00', 3);
INSERT INTO task (status, name, date_make, project_id ) VALUES (0, 'Выполнить тестовое задание','2023-05-04 12:00:00', 3);
INSERT INTO task (status, name, date_make, project_id ) VALUES (0, 'Сделать задание первого раздела','2022-12-22 12:00:00', 2);
INSERT INTO task (status, name, date_make, project_id ) VALUES (0, 'Встреча с другом','2022-11-11 12:00:00', 1);
INSERT INTO task (status, name, date_make, project_id ) VALUES (0, 'Купить корм для кота','2023-01-12 12:00:00', 4);
INSERT INTO task (status, name, date_make, project_id ) VALUES (0, 'Заказать пиццу','2022-12-12 12:00:00', 4);

--Добавление записей в таблицу users
INSERT INTO user ( name, email, date_reg ) VALUES ('natalie', 'natalie@natalie.com','2022-10-09 12:00:00'), ('dima', 'dima@dima.com','2022-10-09 13:00:00');

--Получить список из всех проектов для пользователя c id = 1:
SELECT p.name FROM project p INNER JOIN task t ON p.id = t.project_id INNER JOIN user u ON t.user_id = u.id WHERE u.id = 1 GROUP BY p.name;

--Получить список из всех задач для проекта с id = 1:
SELECT t.name FROM task t INNER JOIN project p ON t.project_id = p.id WHERE p.id = 1;

--Пометить задачу с id = 1 как выполненную:
UPDATE task SET status = 1 WHERE id = 1;

--Обновить название задачи по её идентификатору (1):
UPDATE task SET name = '' WHERE id = 1;
