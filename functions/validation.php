<?php

/**
 * Валидация названия задачи
 * @param string $name - задача введенная пользователем в поле
 * @return string - текст ошибки при неверном вводе
 */
function validate_task_name (string $name) : string {
    if (!$name) {
        return 'Заполните это поле';
    } elseif ((strlen($name) < 10)  or (strlen($name) > 100 )) {
        return 'Кол-во символов от 10 до 100';
    } else
        return '';
}


/**
 * Валидация существующего проекта у пользователя
 * @param mysqli $con - соединение
 * @param int $project_id - id проекта, в который нужно добавить задачу
 * @param int $user_id - id пользователя, который хочет добавить задачу
 * @return string - текст ошибки при не нахождении проекта у пользователя
 */
function validate_task_project_id(mysqli $con, int $project_id, int $user_id) : string {
    if (!checkUserProjects($con, $project_id, $user_id)) {
        return 'Такого проекта не существует.';
    } else
        return '';
}


/**
 * Валидация даты выполнения задачи
 * @param string $date - выбранная пользователем дата
 * @return string - текст ошибки
 */
function validate_task_date_make(string $date) : string {
    if (!$date) {
        return 'Заполните это поле';
    } elseif (!is_date_valid($date)) {
        return 'Неверный формат даты';
    } elseif ((strtotime('now') - strtotime($date)) > 0 ) {
        return 'Дата выполнения раньше, чем сейчас.';
    } else
        return '';
}


function validate_user_email(mysqli $con, string $email) : string {
//    print_r($email);
    if (!$email) {
        return 'Заполните это поле';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return 'E-mail введён некорректно';
    } elseif ( isEmailExists($con, $email)) {
        return 'Такой e-mail уже используется';
    } else
        return '';
}

function validate_user_entry_email(mysqli $con, string $email) : string {
    if (!$email) {
        return 'Заполните это поле';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return 'E-mail введён некорректно';
    } else
        return '';
}

function validate_user_password(string $password) : string {
    if (!$password) {
        return 'Заполните это поле';
    } else
        return '';
}

function validate_user_name(string $name) : string {
    if (!$name) {
        return 'Заполните это поле';
    } else
        return '';
}




