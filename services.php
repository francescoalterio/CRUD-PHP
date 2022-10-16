<?php


function get_task_by_id($task_id, $table, $connection) {
    $stmt = $connection->prepare('SELECT * FROM tasks WHERE id = ?');
    $stmt->execute([$task_id]);
    $task = $stmt->fetch();
    return $task;
}

function delete_task_by_id($task_id, $table, $connection) {
    $sql = "DELETE FROM $table WHERE id = ?";
    try {           
        $connection->prepare($sql)->execute([$task_id]);
    } catch (\PDOException $e) {
        throw new \PDOException($e->getMessage(), (int)$e->getCode());
    }
}

function create_task($task_name, $task_description) {
    include('db.config.php');
    $sql = 'INSERT INTO `tasks` (`id`, `name`, `description`) VALUES (NULL, ?, ?);';
    try {
        $connection = new PDO($dsn, $user, $password, $options);
        $connection->prepare($sql)->execute([$task_name, $task_description]);  
    } catch (\PDOException $e) {
        throw new \PDOException($e->getMessage(), (int)$e->getCode());
    }
}

function complete_task($task_id) {
    include('db.config.php');
    try {
        $connection = new PDO($dsn, $user, $password, $options);
        $task = get_task_by_id($task_id, 'tasks', $connection);
        $sql = 'INSERT INTO `completed_tasks` (`id`, `name`, `description`) VALUES (?, ?, ?);';
        $connection->prepare($sql)->execute([$task['id'],$task['name'], $task['description']]);
        delete_task_by_id($task['id'], 'tasks', $connection);
    } catch (\PDOException $e) {
        throw new \PDOException($e->getMessage(), (int)$e->getCode());
    }
}

function update_task($task_name, $task_description, $task_id) {
    include('db.config.php');
    $sql = 'UPDATE tasks SET name = ?, description = ? WHERE id = ?';
        try {
        $connection = new PDO($dsn, $user, $password, $options);
        $connection->prepare($sql)->execute([$task_name, $task_description, $task_id]);   
    } catch (\PDOException $e) {
        throw new \PDOException($e->getMessage(), (int)$e->getCode());
    }
}

function delete_task($task_id, $table) {
    include('db.config.php');
    try {
        $connection = new PDO($dsn, $user, $password, $options);
        delete_task_by_id($task_id, $table, $connection);
    } catch (\PDOException $e) {
        throw new \PDOException($e->getMessage(), (int)$e->getCode());
    }
}

function get_table_data($table) {
    include('db.config.php');
    try {
        $connection = new PDO($dsn, $user, $password, $options);
        $stmt = $connection->prepare("SELECT * FROM $table");
        $stmt->execute([]);
        $tasks = $stmt->fetchAll();
        return $tasks;                       
    } catch (\PDOException $e) {
        throw new \PDOException($e->getMessage(), (int)$e->getCode());
    }
}