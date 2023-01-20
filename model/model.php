<?php

//Получить список всех проектов пользователя по id:
function getUserProjects(object $con, int $id): array
{
    $sql_projects = sprintf(
            "SELECT p.user_id, p.id, p.name, COUNT(t.id) AS name_count
    FROM project AS p
    left JOIN task AS t ON t.project_id = p.id WHERE p.user_id = '%s'
    GROUP BY p.id
    ORDER BY p.id;", $id);

//    "SELECT id, name, (SELECT COUNT(id) FROM task WHERE user_id = '%s' AND project_id = p.id) name_count
//    FROM project p
//    WHERE user_id = '%s'  ORDER BY name;", $id, $id);
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
