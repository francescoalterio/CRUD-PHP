<?php

    include('services.php');
    include('db.config.php');

    if($_POST) {
        if(!isset($_POST['edit']) && isset($_POST['task-name']) && isset($_POST['task-description'])) {
            $task_name = $_POST['task-name'];
            $task_description = $_POST['task-description'];
            create_task($task_name, $task_description);
        } 

        if(isset($_POST['complete'])) {
            $task_id = $_POST['complete'];
            complete_task($task_id);
        } elseif(isset($_POST['edit'])) {
            $task_id = $_POST['edit'];
            $task_name = $_POST['task-name'];
            $task_description = $_POST['task-description'];
            update_task($task_name, $task_description, $task_id);
        } elseif(isset($_POST['delete'])) {
            $task_id = $_POST['delete'];
            delete_task($task_id, 'tasks');
        } elseif(isset($_POST['delete-completed'])) {
            $task_id = $_POST['delete-completed'];
            delete_task($task_id, 'completed_tasks');
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

    <form action='' method='post' class='container bg-secondary bg-opacity-10 text-center border border-2 rounded mt-4 pb-2' style='min-height: 50px'>
       <?php
            include('./components/task.php');
            $tasks = get_table_data('tasks');

            foreach($tasks  as $name=>$value) {
                $id = $value['id'];
                $name = $value['name'];
                $description = $value['description'];

                echo task($id, $name, $description);
            }

            
       ?>
    </form>

    <form action='' method='post' class='container bg-success bg-opacity-50 text-center border border-success border-2 rounded mt-4 pb-2' style='min-height: 50px'>
       <?php
            include('./components/completed_task.php');
             $completed_tasks = get_table_data('completed_tasks');

            foreach($completed_tasks  as $name=>$value) {
                $id = $value['id'];
                $name = $value['name'];
                $description = $value['description'];

                echo completed_task($id, $name, $description);
            }    
       ?>
    </form>

    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js' integrity='sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3' crossorigin='anonymous'></script>

</body>
</html>