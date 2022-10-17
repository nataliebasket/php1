<?php

//Получить список всех проектов пользователя по id:
function getUserProjects(object $con, int $id): array
{
    $sql_projects = sprintf(
    "SELECT COUNT(p.name) AS name_count, p.name
    FROM project p INNER JOIN task t ON p.id = t.project_id
    INNER JOIN user u ON t.user_id = u.id
    WHERE u.id = '%s'  GROUP BY p.name;", $id);
    $result_projects = mysqli_query($con, $sql_projects);

    return mysqli_fetch_all($result_projects, MYSQLI_ASSOC);
}

//Получить список всех задач пользователя по id:
function getUserTasks(object $con, int $id): array
{
    $sql_tasks = sprintf("SELECT * FROM task t WHERE user_id = '%s';", $id);
    $result_tasks = mysqli_query($con, $sql_tasks);

    return mysqli_fetch_all($result_tasks, MYSQLI_ASSOC);
}
