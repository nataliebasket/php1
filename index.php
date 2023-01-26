<?php
require_once('functions/functions.php');
require_once('functions/helpers.php');
require_once('db.php');
require_once('model/model.php');


session_start();

if (isset($_SESSION['user'])) {
    $is_session = true;
} else {
    $is_session = false;
}

if ($is_session) { // если пользователь зарегистрирован
    $show_complete_tasks = filter_input(INPUT_GET, 'show_completed', FILTER_SANITIZE_NUMBER_INT);

    if ($con == false) {
        print("Ошибка подключения к бд: " . mysqli_connect_error());
    }
    else {



        // получение проектов
        $project_id = 0;
        $project_get_id = filter_input(INPUT_GET, 'project_id', FILTER_SANITIZE_NUMBER_INT) ?? 0;
        $user_projects = getUserProjects($con, $_SESSION['user']['id']);
        $is_project_found = false;
        foreach ($user_projects as $project) {
            if ($project["id"] == $project_get_id) {
                $project_id = $project["id"];
                $is_project_found = true;
            };
        }

        // получение задач
        if (getUserTasks($con,$_SESSION['user']['id'], $project_id) == [] ) {
            $page_content = include_template('404.php', ['text404' => 'В проекте ещё нет задач!',]);
        }
        elseif ((!$is_project_found and $project_get_id) ) {
            http_response_code(404);
            $page_content = include_template('404.php', ['text404' => '404 Такого проекта не существует',]);
        } else {
            $page_content = include_template('main.php', [
                'projects' => getUserProjects ($con, $_SESSION['user']['id']),
                'project_id' => $project_id,
                'tasks' => getUserTasks($con, $_SESSION['user']['id'], $project_id),
                'show_complete_tasks' => $show_complete_tasks
            ]);
        }

        // завершенные / незавершенные задачи
        $task_id = filter_input(INPUT_GET, 'task_id', FILTER_SANITIZE_NUMBER_INT);
        $is_task_check = filter_input(INPUT_GET, 'check', FILTER_SANITIZE_NUMBER_INT);

        if ($task_id && checkUserTasks($con, $task_id,  $_SESSION['user']['id'])) {
            $is_task_check ? completeTask($con, $task_id) : removeCompleteTask($con, $task_id);
            header('Location: index.php');
            exit();
        }


        // получение задач по поиску
        $text_search = filter_input(INPUT_GET, 'text_search');
        if (($text_search) && getUserSearch($con, $_SESSION['user']['id'], $project_get_id, $text_search) == [] ) {
            http_response_code(404);
            $page_content = include_template('404.php', ['text404' => 'Ничего не найдено по вашему запросу',]);
        } elseif (($text_search) && getUserSearch($con, $_SESSION['user']['id'], $project_get_id, $text_search)) {
            $page_content = include_template('main.php', [
                'projects' => getUserProjects ($con, $_SESSION['user']['id']),
                'project_id' => $project_id,
                'tasks' => getUserSearch($con, $_SESSION['user']['id'], $project_get_id, $text_search),
                'show_complete_tasks' => $show_complete_tasks,
                'user_search' => $text_search,
            ]);
        }

        $layout_content = include_template('layout.php', [
            'user_name' => $_SESSION['user']['name'],
            'content' => $page_content,
            'title' => 'Дела в порядке - Главная',
            'is_session' => $is_session,
        ]);

        print ($layout_content);
    }
} else { // если пользователь не зарегистрирован
    $page_content = include_template('guest.php');
    $layout_content = include_template('layout.php', [
        'title' => 'Дела в порядке - Главная',
        'content' => $page_content,
        'is_session' => $is_session,
    ]);

    print ($layout_content);
}




