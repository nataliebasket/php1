<?php
require_once('functions/functions.php');
require_once('functions/helpers.php');
require_once('functions/validation.php');
require_once('db.php');
require_once('model/model.php');

$user_id = 1;

if ($con == false) {
    print("Ошибка подключения к бд: " . mysqli_connect_error());
}
else {

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $errors = [];

        $task['name'] = test_input(filter_input(INPUT_POST, 'name'));
        $task['project_id'] = test_input(filter_input(INPUT_POST, 'project_id'));
        $task['date_make'] = filter_input(INPUT_POST, 'date_make');
        $task['file'] = null;
        $task['user_id'] = $user_id;

        // валидация полей
        $errors['name'] = validate_task_name($task['name']);
        $errors['project_id'] = validate_task_project_id($con, $task['project_id'], $user_id);
        $errors['date_make'] = validate_task_date_make($task['date_make']);

        // сохраняем файл
        if ($_FILES['file']['name'] != null) {
            $current_path = $_FILES['file']['tmp_name'];
            $filename = $_FILES['file']['name'];
            $new_path = 'uploads/' . $filename;
            move_uploaded_file($current_path, $new_path);
            $task['file'] = $filename;
        }

        //удаляем из массива ошибок пустые значения
        $errors = array_diff($errors, array('', NULL, false));

        // если ошибок нет, то отправляем запрос
        if (!count($errors)) {
            $sql = "INSERT INTO task (name, project_id, date_make, file, user_id) VALUES (?, ?, ?, ?, ?)";

            $stmt = db_get_prepare_stmt($con, $sql, $task);
            $res = mysqli_stmt_execute($stmt);

            if ($res) {
//            $task_id = mysqli_insert_id($con);
                header("Location: index.php");
            }
        }
    }

    $page_content = include_template('add-task.php', [
        'projects' => getUserProjects($con, $user_id),
        'errors' => $errors ?? null,
        'task_name' => $task['name'] ?? null,
        'project_id' => $task['project_id'] ?? null,
        'project_date' => $task['date_make'] ?? null,
    ]);


    $layout_content = include_template('layout.php', [
        'content' => $page_content,
        'title' => 'Дела в порядке - Главная'
    ]);

    print ($layout_content);

}

