<?php
   
    include('services.php');
    include('db.config.php');

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
    <div class='d-flex justify-content-center align-items-center' style='width: 100%; height: 100vh;'>
        
        <form action='index.php' method='post' class='container bg-secondary bg-opacity-10 border border-2 rounded pt-4 pb-4 d-flex flex-column align-items-center' style='width: 600px;'>
            <h1>Edit task</h1>
            <?php
                $task_id = $_GET['task_id'];
                try {
                    $connection = new PDO($dsn, $user, $password, $options);
                    $task = get_task_by_id($task_id, 'tasks', $connection);
                    $task_name = $task['name'];
                    $task_description = $task['description'];
                     echo "<div class='input-group mb-3'>
                            <span class='input-group-text' id='basic-addon1'>Task name &nbsp</span>
                            <input type='text' class='form-control' name='task-name' value='$task_name' aria-label='Username' aria-describedby='basic-addon1'>
                        </div>

                        <div class='input-group mb-3'>
                            <span class='input-group-text' id='basic-addon2'>Description</span>
                            <input type='text' class='form-control' name='task-description' value='$task_description' aria-label='Recipient's username' aria-describedby='basic-addon2'>   
                        </div>
                        <div class=''><button class='btn btn-primary' type='submit' name='edit' value='$task_id'>Edit</button></div>";
                } catch (\PDOException $e) {
                    throw new \PDOException($e->getMessage(), (int)$e->getCode());
                }

               
            ?>
    </form>
    </div>


     <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js' integrity='sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3' crossorigin='anonymous'></script>

</body>
</html>