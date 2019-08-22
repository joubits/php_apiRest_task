<?php
    //headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    include_once '../../config/Database.php';
    include_once '../../models/Task.php';

    // Instiantate DB and Connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate task object
    $task = new Task($db);

    // Get ID
    $task->id = isset($_GET['id']) ? $_GET['id'] : die();

    // Read a task
    $task->read_single();

    // create array
    $task_array = array(
        'id' => $task->id,
        'title' => $task->title,
        'body' => $task->body,
        'author' => $task->author,
        'category_id' => $task->category_id,
        'category_name' => $task->category_name

    );

    //Make json
    print_r(json_encode($task_array));