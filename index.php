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

    $user_project = 0;
    $project_get_id = filter_input(INPUT_GET, 'user_project');

    $user_projects = getUserProjects($con, 1);
    foreach ($user_projects as $project) {
        if ($project["id"] == $project_get_id) { $user_project = $project["id"]; };
    }

    if ()
    http_response_code(404);

    $page_content = include_template('main.php', [
        'categories' => getUserProjects ($con, 1),
        'user_project' => $user_project,
        'tasks' => getUserTasks($con,1, $user_project),
        'show_complete_tasks' => $show_complete_tasks
    ]);

    $layout_content = include_template('layout.php', [
        'content' => $page_content,
        'title' => 'Дела в порядке - Главная'
    ]);

    print ($layout_content);
}



