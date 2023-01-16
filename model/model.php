<?php

//Получить список всех проектов пользователя по id:
function getUserProjects(object $con, int $id): array
{
    $sql_projects = sprintf(
    "SELECT COUNT(p.name) AS name_count, p.id, p.name
    FROM project p INNER JOIN task t ON p.id = t.project_id
    INNER JOIN user u ON t.user_id = u.id
    WHERE u.id = '%s'  GROUP BY p.id;", $id);
    $result_projects = mysqli_query($con, $sql_projects);

    return mysqli_fetch_all($result_projects, MYSQLI_ASSOC);
}

//Получить список всех задач пользователя по id:
function getUserTasks(object $con, int $user_id, int $id_project): array
{
    if (!$id_project) {
        $sql_tasks = sprintf("SELECT * FROM task t WHERE user_id = '%s';", $user_id);
    } else {
        $sql_tasks = sprintf("SELECT * FROM task t WHERE user_id = '%s' AND project_id = '%s';", $user_id, $id_project);
    }
    $result_tasks = mysqli_query($con, $sql_tasks);
    if (!$result_tasks) {
        return [];
    }
    return mysqli_fetch_all($result_tasks, MYSQLI_ASSOC);
}

function checkUserProjects(object $con, int $project_id, int $user_id): array
{
    $sql_projects = sprintf(
        "SELECT id FROM project WHERE id = '%s' AND user_id = '%s';", $project_id, $user_id);
    $result_projects = mysqli_query($con, $sql_projects);

    return mysqli_fetch_all($result_projects, MYSQLI_ASSOC);
}


function isEmailExists(object $con, string $email): bool
{
    $sql_projects = sprintf(
        "SELECT email FROM user WHERE email ='%s'", $email);
    $result = mysqli_query($con, $sql_projects);

    return (bool)mysqli_fetch_assoc($result);
}
