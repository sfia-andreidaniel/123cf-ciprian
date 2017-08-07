<?php

// error_reporting(E_ALL);
// ini_set('display_errors', 1);

require_once '../classes/Database.php';
require_once '../classes/Actions.php';

if($_SERVER['REQUEST_METHOD'] === "GET") {

    $action = new Actions();
    $getAction = $_GET['action'];
    $id = isset($_GET['id']) && !empty($_GET['id']) ? $_GET['id'] : '';
    $actionMethod = $action->$getAction($_GET['token'], $id);
}

if($_SERVER['REQUEST_METHOD'] === "POST") {

    if(isset($_POST['action']) && !empty($_POST['action'])) {

        $action = new Actions();
        $postAction = $_POST['action'];

        if($_POST['action'] === 'authenticateUser') {
            $actionMethod = $action->$postAction($_POST['email'], $_POST['password']);
        }
        
        $actionMethod = $action->$postAction();

        $result = $actionMethod;

        echo json_encode($result);
    }

    if(isset($_POST['db']) && !empty($_POST['db'])) {

        $database = new Database();
        $db = $database->getConnection();

        $action = new ActionDatabase($db);
        $postAction = $_POST['db'];
        $actionMethod = $action->$postAction($_POST['table'], isset($_POST['id']) ? $_POST['id'] : '');
        $result = $actionMethod;

        return $result;
    }
}

?>