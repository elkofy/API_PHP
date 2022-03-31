<?php
include("db_connect.php");
include("randomToken.php");
$request_method = $_SERVER["REQUEST_METHOD"];

function getUsers()
{
    global $conn;
    $query = "SELECT * FROM user";
    $response = array();
    $result = mysqli_query($conn, $query);

    while ($row = mysqli_fetch_assoc($result)) {
        $response[] = $row;
    }
    header('Content-Type: application/json');
    echo json_encode($response, JSON_PRETTY_PRINT);
}

function getUser($id)
{
    global $conn;
    $query = "SELECT * FROM user WHERE id = $id";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    header('Content-Type: application/json');
    echo json_encode($row, JSON_PRETTY_PRINT);
}

function insertUser()
{
    global $conn;
    $data = json_decode(file_get_contents('php://input'), true);
    // {
    //     "id": "1",
    //     "nom": "admin",
    //     "prenom": "admin",
    //     "token": "admin",
    //     "role": "admin",
    //     "created_at": "2019-01-01 00:00:00",
    //     "modified": "2019-01-01 00:00:00"
    // }
    $query = "INSERT INTO user (nom, prenom, token, role, created_at, modified) VALUES ('" . $data['nom'] . "', '" . $data['prenom'] . "', '" . generateRandomString() . "', '" . $data['role'] . "', '" . $data['created_at'] . "', '" . $data['modified'] . "')";
    $result = mysqli_query($conn, $query);
    if ($result) {
        $response = array(
            'status' => 1,
            'message' => 'User Added Successfully.',
            'data' => $data

        );
    } else {
        $response = array(
            'status' => 0,
            'message' => 'User Not Added.'
        );
    }
    header('Content-Type: application/json');
    echo json_encode($response, JSON_PRETTY_PRINT);
}

function updateUser($id)
{
    global $conn;
    $data = json_decode(file_get_contents('php://input'), true);
    // {
    //     "id": "1",
    //     "nom": "admin",
    //     "prenom": "admin",
    //     "token": "admin",
    //     "role": "admin",
    //     "created_at": "2019-01-01 00:00:00",
    //     "modified": "2019-01-01 00:00:00"
    // }

    $query = "UPDATE user SET nom = '" . $data['nom'] . "', prenom = '" . $data['prenom'] . "', role = '" . $data['role'] . "', created_at = '" . $data['created_at'] . "', modified = '" . $data['modified'] . "' WHERE id = $id";


    $result = mysqli_query($conn, $query);
    if ($result) {
        $response = array(
            'status' => 1,
            'message' => 'User Updated Successfully.',
            'data' => $data
        );
    } else {
        $response = array(
            'status' => 0,
            'message' => 'User Not Updated.'
        );
    }
    header('Content-Type: application/json');
    echo json_encode($response, JSON_PRETTY_PRINT);
}

function deleteUser($id)
{
    global $conn;
    $query = "DELETE FROM user WHERE id = $id";
    $result = mysqli_query($conn, $query);
    if ($result) {
        $response = array(
            'status' => 1,
            'message' => 'User Deleted Successfully.'
        );
    } else {
        $response = array(
            'status' => 0,
            'message' => 'User Not Deleted.'
        );
    }
    header('Content-Type: application/json');
    echo json_encode($response, JSON_PRETTY_PRINT);
}

switch ($request_method) {
    case 'GET':
        if (!empty($_GET["id"])) {
            // Récupérer un seul produit
            $id = intval($_GET["id"]);
            getUser($id);
        } else {
            // Récupérer tous les produits
            getUsers();
        }
        break;
    case 'POST':
        // Ajouter un produit
        insertUser();
        break;
    case 'PUT':
        // Modifier un produit
        $id = intval($_GET["id"]);
        updateUser($id);
        break;
    case 'DELETE':
        // Supprimer un produit
        $id = intval($_GET["id"]);
        deleteUser($id);
        break;

    default:
        header("HTTP/1.0 405 Method Not Allowed");
        break;
}
