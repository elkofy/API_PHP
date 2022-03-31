<?php
// Se connecter à la base de données
include("db_connect.php");
include("randomToken.php");
$request_method = $_SERVER["REQUEST_METHOD"];

function getProducts()
{
  global $conn;
  $query = "SELECT * FROM produit";
  $response = array();
  $result = mysqli_query($conn, $query);

  while ($row = mysqli_fetch_assoc($result)) {
    $response[] = $row;
  }
  header('Content-Type: application/json');
  echo json_encode($response, JSON_PRETTY_PRINT);
}

function getProduct($id)
{
  global $conn;
  $query = "SELECT * FROM produit WHERE id = $id";
  $result = mysqli_query($conn, $query);
  $row = mysqli_fetch_assoc($result);
  header('Content-Type: application/json');
  echo json_encode($row, JSON_PRETTY_PRINT);
}

function insertProduct()
{
  global $conn;
  $data = json_decode(file_get_contents('php://input'), true);
  $query = "INSERT INTO produit (nom, description, token, prix, stock, category_id, created_at, modified) VALUES ('" . $data['nom'] . "', '" . $data['description'] . "', '" . generateRandomString() . "', '" . $data['prix'] . "', '" . $data['stock'] . "', '" . $data['category_id'] . "', '" . $data['created_at'] . "', '" . $data['modified'] . "')";
  $result = mysqli_query($conn, $query);
  if ($result) {
    $response = array(
      'status' => 1,
      'message' => 'Product Added Successfully.' ,
      'data' => $data

    );
  } else {
    $response = array(
      'status' => 0,
      'message' => 'Product Not Added.'
    );
  }
  header('Content-Type: application/json');
  echo json_encode($response, JSON_PRETTY_PRINT);
}



function updateProduct($id)
{
  global $conn;
  $data = json_decode(file_get_contents('php://input'), true);
  $query = "UPDATE produit SET nom = '" . $data['nom'] . "', description = '" . $data['description'] . "', prix = '" . $data['prix'] . "', stock = '" . $data['stock'] . "', category_id = '" . $data['category_id'] . "', created_at = '" . $data['created_at'] . "', modified = '" . $data['modified'] . "' WHERE id = $id";
  $result = mysqli_query($conn, $query);
  if ($result) {
    $response = array(
      'status' => 1,
      'message' => 'Product Updated Successfully.',
      'data' => $data

    );
  } else {
    $response = array(
      'status' => 0,
      'message' => 'Product Not Updated.'
    );
  }
  header('Content-Type: application/json');
  echo json_encode($response, JSON_PRETTY_PRINT);
}

function deleteProduct($id)
{
  global $conn;
  $query = "DELETE FROM produit WHERE id = $id";
  $result = mysqli_query($conn, $query);
  if ($result) {
    $response = array(
      'status' => 1,
      'message' => 'Product Deleted Successfully.'
    );
  } else {
    $response = array(
      'status' => 0,
      'message' => 'Product Not Deleted.'
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
      getProduct($id);
    } else {
      // Récupérer tous les produits
      getProducts();
    }
    break;
  case 'POST':
    // Ajouter un produit
    insertProduct();
    break;
  case 'PUT':
    // Modifier un produit
    $id = intval($_GET["id"]);
    updateProduct($id);
    break;
  case 'DELETE':
    // Supprimer un produit
    $id = intval($_GET["id"]);
    deleteProduct($id);
    break;

  default:
    // Requête invalide
    header("HTTP/1.0 405 Method Not Allowed");
    break;
}
