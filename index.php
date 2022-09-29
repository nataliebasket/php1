<?php
require_once('templates/functions.php');
require_once('templates/data.php');

require_once('helpers.php');

$page_content = include_template('main.php', [
    'categories' => $categories,
    'tasks' => $tasks,
    'show_complete_tasks' => $show_complete_tasks
]);

$layout_content = include_template('layout.php', [
   'content' => $page_content,
    'title' => 'Дела в порядке - Главная'
]);

print ($layout_content);

