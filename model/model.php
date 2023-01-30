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

// полнотекстовый поиск задач
function getUserSearch (object $con, int $user_id, int $project_id, string $search) {
    if (!$project_id) {
        $sql_tasks = sprintf("SELECT * FROM task WHERE MATCH(name) AGAINST('%s') AND user_id = '%s' ", $search, $user_id);
    } else {
        $sql_tasks = sprintf("SELECT * FROM task WHERE MATCH(name) AGAINST('%s') AND user_id = '%s' AND project_id == '%s' ", $search, $user_id, $project_id);
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

function checkUserTasks(object $con, int $task_id, int $user_id): bool
{
    $sql_projects = sprintf(
        "SELECT id FROM task WHERE id = '%s' AND user_id = '%s';", $task_id, $user_id);
    $result = mysqli_query($con, $sql_projects);

    return (bool)mysqli_fetch_assoc($result);
}


function isEmailExists(object $con, string $email): bool
{
    $sql_projects = sprintf(
        "SELECT email FROM user WHERE email ='%s'", $email);
    $result = mysqli_query($con, $sql_projects);

    return (bool)mysqli_fetch_assoc($result);
}

function completeTask(object $con, int $task_id)
{
    $sql = sprintf(
        "UPDATE task SET is_done = 1 WHERE id = '%s';", $task_id);
    $result = mysqli_query($con, $sql);

}


function removeCompleteTask(object $con, int $task_id)
{
    $sql = sprintf(
        "UPDATE task SET is_done = 0 WHERE id = '%s';", $task_id);
    $result = mysqli_query($con, $sql);

}


function getFilterTasks(object $con, int $user_id, string $filter)
{
    $sql = '';
    switch ($filter) {
        case "today":
//            $date = ' =  DATE(NOW())';
            $sql = 'SELECT * FROM task t WHERE user_id = ' . $user_id . ' AND DATE(date_make) = DATE(NOW())';
            break;
        case "tomorrow":
//            $date = ' = DATE((NOW() + INTERVAL 1 DAY))';
            $sql = 'SELECT * FROM task t WHERE user_id = ' . $user_id . ' AND DATE(date_make) = DATE((NOW() + INTERVAL 1 DAY))';
            break;
        case "overdue":
//            $date = ' < DATE(NOW())';
            $sql = 'SELECT * FROM task t WHERE user_id = ' . $user_id . ' AND DATE(date_make) < DATE(NOW())';
            break;
    }
//    $sql_tasks = sprintf("SELECT * FROM task t WHERE user_id = '%s' AND DATE(date_make) '%s'", $user_id, $date );
    $result = mysqli_query($con, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}
