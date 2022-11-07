<?php
//require_once('functions.php');
require_once('helpers.php');
require_once('db.php');
require_once('model.php');

if ($con == false) {
    print("Ошибка подключения к бд: " . mysqli_connect_error());
}
else {

//    $user_projects = getUserProjects($con, 1);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $errors = [];

        $task = filter_input_array(INPUT_POST, ['name' => FILTER_DEFAULT, 'project_id' => FILTER_DEFAULT, 'date_make' => FILTER_DEFAULT]);

        function test_input($data):string {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        if (!$task['name']) {
            $errors['name'] = 'Заполните это поле';
        } elseif (strlen($task['name'] < 10 ) or strlen($task['name'] > 100 )) {
            $errors['name'] = 'Кол-во символов от 10 до 100';
        } else {
            $task['name'] = test_input($task['name']);
        }

        $task['file'] = null;

        // сохраняем файл
        if ($_FILES['file']['name'] != null) {
            $current_path = $_FILES['file']['tmp_name'];
            $filename = $_FILES['file']['name'];
            $new_path = 'uploads/' . $filename;
            move_uploaded_file($current_path, $new_path);
            print_r($_FILES['file']['name']);
            $task['file'] = $filename;
        }

        $task['user_id'] = 1;

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
        'projects' => getUserProjects($con, 1),
        'project_id' => 0,
        'errors' => $errors ?? null,
    ]);


    $layout_content = include_template('layout.php', [
        'content' => $page_content,
        'title' => 'Дела в порядке - Главная'
    ]);

    print ($layout_content);

}

