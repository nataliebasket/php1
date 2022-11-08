<?php
//require_once('functions.php');
require_once('helpers.php');
require_once('db.php');
require_once('model.php');

$user_id = 1;

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

        // валидация названия задачи
        if (!$task['name']) {
            $errors['name'] = 'Заполните это поле';
        } elseif ((strlen($task['name']) < 10)  or (strlen($task['name']) > 100 )) {
            $errors['name'] = 'Кол-во символов от 10 до 100';
        } else {
            $task['name'] = test_input($task['name']);
        }


        // валидация выбранного проекта
          if (!checkUserProjects($con, $task['project_id'], $user_id)) {
              $errors['project_id'] = 'Такого проекта не существует.';
          }

          // валидация даты выполнения задачи
        if (!$task['date_make']) {
            $errors['date_make'] = 'Заполните это поле';
        } elseif (!is_date_valid($task['date_make'])) {
            $errors['date_make'] = 'Неверный формат даты';
        } elseif ((strtotime('now') - strtotime($task['date_make'])) > 0 ) {
            $errors['date_make'] = 'Дата выполнения раньше, чем сейчас.';
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

