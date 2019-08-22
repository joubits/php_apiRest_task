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

    // Read a task
    $result = $task->read();

    // Get num task
    $num = $result->rowCount();

    if($num > 0) {
        //Post Array
        $tasks_array = array();
        $tasks_array['data'] = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $task_item = array(
                'id' => $id,
                'title' => $title,
                'body' => html_entity_decode($body),
                'author' => $author,
                'category_id' => $category_id,
                'category_name' => $category_name
            );

            // PUSH TO data
            array_push($tasks_array['data'], $task_item);
            //array_push($tasks_array, $task_item);
            //$task_array[] = $task_item;
        }
        // Turn to json and output

        echo json_encode($tasks_array['data']);
        //echo json_encode($tasks_array);

    } else {
        // No post
        echo json_encode(
            array('message' => 'No Tasks found')
        );

    }

?>