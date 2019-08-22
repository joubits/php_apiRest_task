<?php
    //headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');


    include_once '../../config/Database.php';
    include_once '../../models/Task.php';

    // Instiantate DB and Connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate task object
    $task = new Task($db);

    // Get raw posted data
    $data = json_decode(file_get_contents("php://input"));

    $task->title = $data->title;
    $task->body = $data->body;
    $task->author = $data->author;
    $task->category_id = $data->category_id;

    //create task
    if($task->create()) {
        echo json_encode(
            array('message' => 'Task created')
        );
    } else {
        echo json_encode(
            array('message' => 'Task not created')
        );
    }

?>