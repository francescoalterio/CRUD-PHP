<?php

    $dsn = 'mysql:host=127.0.0.1;dbname=crud-php';
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    $user = 'root';
    $password = '';

    function delete_task_by_id($task_id, $table, $connection) {
         $sql = "DELETE FROM $table WHERE id = ?";
            try {
               
                $connection->prepare($sql)->execute([$task_id]);
            } catch (\PDOException $e) {
                throw new \PDOException($e->getMessage(), (int)$e->getCode());
            }
    }

    function get_task_by_id($task_id, $table, $connection) {
        $stmt = $connection->prepare('SELECT * FROM tasks WHERE id = ?');
        $stmt->execute([$task_id]);
        $task = $stmt->fetch();
        return $task;
    }

    if($_POST) {
        if(!isset($_POST['edit']) && isset($_POST['task-name']) && isset($_POST['task-description'])) {
            $task_name = $_POST['task-name'];
            $task_description = $_POST['task-description'];
            $sql = 'INSERT INTO `tasks` (`id`, `name`, `description`) VALUES (NULL, ?, ?);';

             try {
                $connection = new PDO($dsn, $user, $password, $options);
                $connection->prepare($sql)->execute([$task_name, $task_description]);

                
            } catch (\PDOException $e) {
                throw new \PDOException($e->getMessage(), (int)$e->getCode());
            }
        } 

        if(isset($_POST['complete'])) {
            $task_id = $_POST['complete'];
            try {
                $connection = new PDO($dsn, $user, $password, $options);
                $task = get_task_by_id($task_id, 'tasks', $connection);
                $sql = 'INSERT INTO `completed_tasks` (`id`, `name`, `description`) VALUES (?, ?, ?);';
                $connection->prepare($sql)->execute([$task['id'],$task['name'], $task['description']]);
                delete_task_by_id($task['id'], 'tasks', $connection);
            } catch (\PDOException $e) {
                throw new \PDOException($e->getMessage(), (int)$e->getCode());
            }

        } elseif(isset($_POST['edit'])) {
            $task_id = $_POST['edit'];
            $task_name = $_POST['task-name'];
            $task_description = $_POST['task-description'];
            $sql = 'UPDATE tasks SET name = ?, description = ? WHERE id = ?';

             try {
                $connection = new PDO($dsn, $user, $password, $options);
                $connection->prepare($sql)->execute([$task_name, $task_description, $task_id]);   
            } catch (\PDOException $e) {
                throw new \PDOException($e->getMessage(), (int)$e->getCode());
            }
        } elseif(isset($_POST['delete'])) {
            $task_id = $_POST['delete'];
            try {
                $connection = new PDO($dsn, $user, $password, $options);
                delete_task_by_id($task_id, 'tasks', $connection);
            } catch (\PDOException $e) {
                throw new \PDOException($e->getMessage(), (int)$e->getCode());
            }
        } elseif(isset($_POST['delete-completed'])) {
            $task_id = $_POST['delete-completed'];
            try {
                $connection = new PDO($dsn, $user, $password, $options);
                delete_task_by_id($task_id, 'completed_tasks', $connection);
            } catch (\PDOException $e) {
                throw new \PDOException($e->getMessage(), (int)$e->getCode());
            }
        }
    };
?>


<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Document</title>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi' crossorigin='anonymous'>

</head>
<body>
    <form action='' method='post' class='container bg-secondary bg-opacity-10 border border-2 rounded mt-3 pt-4 pb-4'>
        <div class='row'>
            <div class='col d-flex justify-content-center align-items-center'>
                <div class='input-group'>
                    <span class='input-group-text'>Name</span>
                    <input class='form-control' type='text' name='task-name' id=''>
                </div>
            </div>
            <div class='col-6 d-flex justify-content-center align-items-center'>
                <div class='input-group'>
                    <span class='input-group-text'>Description</span>
                    <input class='form-control' type='text' name='task-description' id=''>
                </div>
            </div>
             <div class='col-2 d-flex justify-content-center align-items-center'>
                 <button class='btn btn-warning'>Create</button>
            </div> 
        </div>
    </form>

    <form action='' method='post' class='container bg-secondary bg-opacity-10 text-center border border-2 rounded mt-4 pb-2'>
       <?php

            try {
                $connection = new PDO($dsn, $user, $password, $options);
                $stmt = $connection->prepare('SELECT * FROM tasks');
                $stmt->execute([]);
                $tasks = $stmt->fetchAll();

                    foreach($tasks  as $name=>$value) {
                        $id = $value['id'];
                        $name = $value['name'];
                        $description = $value['description'];

                        echo "<div class='row mt-2 '>
                                <div class='col d-flex justify-content-center align-items-center'>
                                    $name
                                </div>
                                <div class='col-6 d-flex justify-content-center align-items-center'>
                                    $description
                                </div>
                                <div class='col d-flex justify-content-center align-items-center gap-1'>
                                    <button type='submit' class='btn btn-success' name='complete' value='$id'>
                                        <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-check-circle-fill' viewBox='0 0 16 16'>
                                            <path d='M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z'/>
                                        </svg>
                                    </button>
                                    <a href='edit.php?task_id=$id' class='btn btn-primary' name='edit' value='$id'>
                                        <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-pencil-square' viewBox='0 0 16 16'>
                                            <path d='M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z'/>
                                            <path fill-rule='evenodd' d='M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z'/>
                                        </svg>
                                    </a>
                                    <button type='submit' class='btn btn-danger' name='delete' value='$id'>
                                        <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-trash-fill' viewBox='0 0 16 16'>
                                            <path d='M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z'/>
                                        </svg>
                                    </button>
                                </div>
                          </div>  ";
                    }    
            } catch (\PDOException $e) {
                throw new \PDOException($e->getMessage(), (int)$e->getCode());
            }

            
       ?>
    </form>

    <form action='' method='post' class='container bg-success bg-opacity-50 text-center border border-success border-2 rounded mt-4 pb-2'>
       <?php

            try {
                $connection = new PDO($dsn, $user, $password, $options);
                $stmt = $connection->prepare('SELECT * FROM completed_tasks');
                $stmt->execute([]);
                $tasks = $stmt->fetchAll();

                    foreach($tasks  as $name=>$value) {
                        $id = $value['id'];
                        $name = $value['name'];
                        $description = $value['description'];

                        echo "<div class='row mt-2 '>
                                <div class='col d-flex justify-content-center align-items-center'>
                                    $name
                                </div>
                                <div class='col-6 d-flex justify-content-center align-items-center'>
                                    $description
                                </div>
                                <div class='col d-flex justify-content-center align-items-center gap-1'>         
                                        <button type='submit' class='btn btn-danger' name='delete-completed' value='$id'>
                                        <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-trash-fill' viewBox='0 0 16 16'>
                                            <path d='M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z'/>
                                        </svg>
                                    </button>
                                </div>
                          </div>  ";
                    }    
            } catch (\PDOException $e) {
                throw new \PDOException($e->getMessage(), (int)$e->getCode());
            }

            
       ?>
    </form>

    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js' integrity='sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3' crossorigin='anonymous'></script>

</body>
</html>