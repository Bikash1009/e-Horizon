<?php
ob_start();
$action = $_GET['action'] ?? null;
include 'admin_class.php';
$crud = new Action();

// List of allowed actions
$allowedActions = [
    'login',
    'login2',
    'logout',
    'logout2',
    'save_user',
    'delete_user',
    'signup',
    'save_settings',
    'save_venue',
    'save_book',
    'delete_book',
    'save_register',
    'delete_register',
    'update_order',
    'delete_order',
    'save_event',
    'delete_event',
    'save_artist',
    'delete_artist',
    'get_audience_report',
    'get_venue_report',
    'save_art_fs',
    'delete_art_fs',
    'get_pdetails'
];

if (in_array($action, $allowedActions) && method_exists($crud, $action)) {
    $result = $crud->$action();
    if ($result) {
        echo $result;
    }
} else {
    echo "Invalid action.";
}
?>


<?php
include('db_connect.php');

if (isset($_GET['action']) && $_GET['action'] == 'delete_venue') {
    $id = $_POST['id'];
    $delete = $conn->query("DELETE FROM venue WHERE id = ".$id);
    if ($delete) {
        echo 1;
    } else {
        echo 0;
    }
    exit();
}
?>
