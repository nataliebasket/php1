<?php
require_once('functions/functions.php');
require_once('functions/helpers.php');
require_once('functions/validation.php');
require_once('db.php');
require_once('model/model.php');


session_start();
if (isset($_SESSION['username'])) {
    $is_session = true;
} else {
    $is_session = false;
}

if ($con == false) {
    print("Ошибка подключения к бд: " . mysqli_connect_error());
}
else {

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $errors = [];

        $email = test_input(filter_input(INPUT_POST, 'email'));
        $password = test_input(filter_input(INPUT_POST, 'password'));

        // валидация полей
        $errors['email'] = validate_user_entry_email($con, $email);
        $errors['password'] = validate_user_password($password);

        if (($errors['email'] == '') && ($errors['password'] == '')) {
            $sql_projects = sprintf(
                "SELECT * FROM user WHERE email ='%s'", $email);
            $result = mysqli_query($con, $sql_projects);

            $user = mysqli_fetch_assoc ($result);

            if (password_verify($password, $user['password'])) {
                $_SESSION['user'] = $user;
                header('Location: index.php');
//                print_r($_SESSION);
                exit();
            } else {
                $errors['password'] = 'Неверно введены почта или пароль';
            }
        }

        //удаляем из массива ошибок пустые значения
        $errors = array_diff($errors, array('', NULL, false));
    }

    $page_content = include_template('auth.php', [
        'errors' => $errors ?? null,
        'user_email' => $user['email'] ?? null,
        'user_password' => $user['password'] ?? null,
    ]);


    $layout_content = include_template('layout.php', [
        'title' => "Вход на сайт",
        'content' => $page_content,
        'is_session' => $is_session,
    ]);

    print ($layout_content);

}



