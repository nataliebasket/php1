<?php
require_once('templates/functions.php');
require_once('templates/data.php');
require_once('helpers.php');

$con = mysqli_connect("localhost", "root", "root","doingsdone");

if ($con == false) {
    print("Ошибка подключения к бд: " . mysqli_connect_error());
}
else {
    mysqli_set_charset($con, "utf8");

    //Получить список из всех проектов для пользователя
    $sql_projects = "SELECT t.user_id, p.name FROM project p INNER JOIN task t ON p.id = t.project_id INNER JOIN user u ON t.user_id = u.id WHERE u.id = 1 GROUP BY p.name;";
    $result_projects = mysqli_query($con, $sql_projects);
    $rows_projects = mysqli_fetch_all($result_projects, MYSQLI_ASSOC);

    print_r($rows_projects);


    //Получить список из всех задач для проекта с id = 1:
    $sql_tasks = "SELECT t.name FROM task t INNER JOIN project p ON t.project_id = p.id WHERE p.id = 1;";
    $result_tasks = mysqli_query($con, $sql_tasks);
    $rows_tasks = mysqli_fetch_all($result_tasks, MYSQLI_ASSOC);

    $page_content = include_template('main.php', [
        'categories' => $rows_projects,
        'tasks' => $rows_tasks,
        'show_complete_tasks' => $show_complete_tasks
    ]);

    $layout_content = include_template('layout.php', [
        'content' => $page_content,
        'title' => 'Дела в порядке - Главная'
    ]);

    print ($layout_content);
}



