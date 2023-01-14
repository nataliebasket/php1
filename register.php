<?php
require_once('functions/functions.php');
require_once('functions/helpers.php');
require_once('functions/validation.php');
require_once('db.php');
require_once('model/model.php');

if ($con == false) {
    print("Ошибка подключения к бд: " . mysqli_connect_error());
}
else {

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $errors = [];

        $user['email'] = test_input(filter_input(INPUT_POST, 'email'));
        $user['password'] = test_input(filter_input(INPUT_POST, 'password'));
        $user['name'] = filter_input(INPUT_POST, 'name');

        // валидация полей
        $errors['email'] = validate_user_email($con, $user['email']);
        $errors['password'] = validate_user_password($user['password']);
        $errors['name'] = validate_user_name($user['name']);

        //удаляем из массива ошибок пустые значения
        $errors = array_diff($errors, array('', NULL, false));

        // если ошибок нет, то отправляем запрос
        if (!count($errors)) {
            //хешируем пароль
            $user['password'] = password_hash($user['password'], PASSWORD_DEFAULT);

            $sql = "INSERT INTO user (name, password, email) VALUES (?, ?, ?)";

            $stmt = db_get_prepare_stmt($con, $sql, [$user['name'], $user['password'], $user['email']]);
            $res = mysqli_stmt_execute($stmt);

            if ($res) {
//            $user_id = mysqli_insert_id($con);
                header("Location: index.php");
            }
        }
    }

    $layout_content = include_template('register.php', [
        'errors' => $errors ?? null,
        'user_name' => $user['name'] ?? null,
        'user_email' => $user['email'] ?? null,
    ]);

    print ($layout_content);

}

