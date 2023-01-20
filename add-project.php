<?php
require_once('functions/functions.php');
require_once('functions/helpers.php');
require_once('functions/validation.php');
require_once('db.php');
require_once('model/model.php');

session_start();
if (isset($_SESSION['user'])) {
    $is_session = true;
} else {
    $is_session = false;
    header('Location: auth.php');
}

if ($con == false) {
    print("Ошибка подключения к бд: " . mysqli_connect_error());
}
else {

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $errors = [];

        $project_name = test_input(filter_input(INPUT_POST, 'project_name'));

        // валидация полей
        $errors['name'] = validate_task_name($project_name);


        //удаляем из массива ошибок пустые значения
        $errors = array_filter($errors);

        // если ошибок нет, то отправляем запрос
        if (!count($errors)) {
            $sql = "INSERT INTO project (name, user_id) VALUES (?, ?)";

            $stmt = db_get_prepare_stmt($con, $sql, [$project_name, $_SESSION['user']['id']]);//!!!!!!
            $res = mysqli_stmt_execute($stmt);

            if ($res) {
//            $task_id = mysqli_insert_id($con);
                header("Location: index.php");
            }
        }
    }

    $page_content = include_template('add-project.php', [
        'projects' => getUserProjects($con, $_SESSION['user']['id']),
        'errors' => $errors ?? null,
        'project_name' => $project['name'] ?? null,

//        'project_id' => $task['project_id'] ?? null,
//        'project_date' => $task['date_make'] ?? null,
    ]);


    $layout_content = include_template('layout.php', [
        'content' => $page_content,
        'title' => 'Дела в порядке - Добавление проекта',
        'is_session' => true,
        'user_name' => $_SESSION['user']['name'],
    ]);

    print ($layout_content);

}

