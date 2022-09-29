<?php


/**
 * Подсчет одинаковых категорий в задачах
 * @param array $list - двумерный массив задач из ассоциатиыных массивов
 * @param string $name - название категории
 * @return integer - число категорий
 */
function countCategories (array $list, $name) {
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
