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

    $project_id = 0;
    $project_get_id = filter_input(INPUT_GET, 'project_id', FILTER_SANITIZE_NUMBER_INT);

    $user_projects = getUserProjects($con, 1);
    $is_project_found = false;
    foreach ($user_projects as $project) {
        if ($project["id"] == $project_get_id) {
            $project_id = $project["id"];
            $is_project_found = true;
        };
    }

    if ((!$is_project_found and $project_get_id) or (getUserTasks($con,1, $project_id) == [])) {
        http_response_code(404);
        $page_content = include_template('404.php', ['text404' => '404 Такого проекта не существует',]);
    } else {
        $page_content = include_template('main.php', [
            'projects' => getUserProjects ($con, 1),
            'project_id' => $project_id,
            'tasks' => getUserTasks($con,1, $project_id),
            'show_complete_tasks' => $show_complete_tasks
        ]);
    }

    $layout_content = include_template('layout.php', [
        'content' => $page_content,
        'title' => 'Дела в порядке - Главная'
    ]);

    print ($layout_content);
}



