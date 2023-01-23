<?php

/**
 * Подсчет одинаковых категорий в задачах
 * @param array $list - двумерный массив задач из ассоциатиыных массивов
 * @param string $name - название категории
 * @return integer - число категорий
 */
function countCategories(array $list, $name) : int {
    $count = 0;
    foreach ($list as $value) {
        foreach ($value as $item) {
            if ($item === $name) {
                $count++;
            }
        }
    }
    return ($count);
}

/**
 * Проверка кол-ва часов до выполнения задачи. Если меньше 24 часов, то true.
 * @param string $date - дата выполнения задачи
 * @return boolean - меньше или больше 24 часов
 */
function isDateImportant(string $date) : bool {
    $isImportant = false;
    $currentDate = strtotime(date('Y-m-d H:i:s'));
    $userDate = strtotime($date);

    if (floor(($userDate - $currentDate) / 3600) <= 24) {
        $isImportant = true;
    }
    return ($isImportant);
}

/**
 * Форматирование введенной пользователем строки
 * @$data string - строка для форматирования
 * @return string - отформатированная строка
 */
function test_input(string $data) : string {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}



