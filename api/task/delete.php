<?php
    //headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: DELETE');
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

    //SET id to delete
    $task->id = $data->id;

    //delete task
    if($task->delete()) {
        echo json_encode(
            array('message' => 'Task deleted')
        );
    } else {
        echo json_encode(
            array('message' => 'Task not deleted')
        );
    }

?>