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

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $task = $_POST; // получаем данные из формы

        // сохраняем файл
        if (isset($_FILES['file'])) {
            $filename = $_FILES['file']['name'];
            move_uploaded_file($_FILES['file']['tmp_name'], 'uploads/' . $filename);
        }

        $name = $_POST['name'];
        $project_id = $_POST['project'];
        $date_make = $_POST['date'];
        $file = 'uploads/' . $_FILES['file']['name'];
        $user_id = 1;

        $sql = 'INSERT INTO task (name, file, date_make, user_id, project_id) VALUES (?, ?, ?, ?, ?)';

        $stmt = db_get_prepare_stmt($con, $sql, [$name, $file, $date_make, $user_id, $project_id]);
        $res = mysqli_stmt_execute($stmt);


        if ($res) {
            $task_id = mysqli_insert_id($con);

            header('Location: /index.php');
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



