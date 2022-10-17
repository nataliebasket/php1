<?php
// показывать или нет выполненные задачи


$categories = [
    'entry' => 'Входящие',
    'study' => 'Учеба',
    'work' => 'Работа',
    'home' => 'Домашние дела',
    'auto' => 'Авто'
];

$tasks = [
    [
        'name' => 'Собеседование в IT компании',
        'date' => '01.12.2019',
        'category' => $categories['work'],
        'status' => false
    ],
    [
        'name' => 'Выполнить тестовое задание',
        'date' => '03.10.2022',
        'category' => $categories['work'],
        'status' => false
    ],
    [
        'name' => 'Сделать задание первого раздела',
        'date' => '21.12.2019',
        'category' => $categories['study'],
        'status' => true
    ],
    [
        'name' => 'Встреча с другом',
        'date' => '22.12.2019',
        'category' =>  $categories['entry'],
        'status' => false
    ],
    [
        'name' => 'Купить корм для кота',
        'date' => null,
        'category' =>  $categories['home'],
        'status' => false
    ],
    [
        'name' => 'Заказать пиццу',
        'date' => null,
        'category' =>  $categories['home'],
        'status' => false
    ]
];

