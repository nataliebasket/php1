<?php
require_once('functions.php');
require_once('helpers.php');
require_once('db.php');
require_once('model.php');

$show_complete_tasks = rand(0, 1);

if ($con == false) {
    print("Ошибка подключения к бд: " . mysqli_connect_error());
}
else {
    $page_content = include_template('main.php', [
        'categories' => getUserProjects ($con, 1),
        'tasks' => getUserTasks($con,1),
        'show_complete_tasks' => $show_complete_tasks
    ]);

    $layout_content = include_template('layout.php', [
        'content' => $page_content,
        'title' => 'Дела в порядке - Главная'
    ]);

    print ($layout_content);
}



