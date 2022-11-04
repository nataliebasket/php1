<?php
//require_once('functions.php');
require_once('helpers.php');
require_once('db.php');
require_once('model.php');

if ($con == false) {
    print("Ошибка подключения к бд: " . mysqli_connect_error());
}
else {

    $user_projects = getUserProjects($con, 1);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $task = $_POST;

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

        $sql = "INSERT INTO task (name, project_id, date_make, file, user_id) VALUES (?, ?, ?, ?, ?)";

        $stmt = db_get_prepare_stmt($con, $sql, $task);
        $res = mysqli_stmt_execute($stmt);
//        var_dump($task);

        if ($res) {
//            $task_id = mysqli_insert_id($con);
            header("Location: index.php");
        }

    }

    $page_content = include_template('add-task.php', [
        'projects' => $user_projects,
        'project_id' => 0,
    ]);


    $layout_content = include_template('layout.php', [
        'content' => $page_content,
        'title' => 'Дела в порядке - Главная'
    ]);

    print ($layout_content);

}

