<?php
header('Content-Type: application/json');

// Konfigurasi database
$host = "localhost";
$user = "root";
$password = "";
$database = "sweetbook";

// Membuat koneksi ke MySQL
$conn = new mysqli($host, $user, $password, $database);

// Periksa koneksi
if ($conn->connect_error) {
    echo json_encode(['error' => 'Database connection failed: ' . $conn->connect_error]);
    exit;
}

// Mendapatkan metode HTTP
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        $query = "SELECT * FROM products";
        $result = $conn->query($query);
        $products = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $products[] = $row;
            }
        }
        echo json_encode($products);
        break;

    case 'POST':
        $input = json_decode(file_get_contents('php://input'), true);

        $name = $conn->real_escape_string($input['name']);
        $description = $conn->real_escape_string($input['description']);
        $price = $conn->real_escape_string($input['price']);

        $query = "INSERT INTO products (name, description, price) VALUES ('$name', '$description', '$price')";

        if ($conn->query($query) === TRUE) {
            echo json_encode(['message' => 'Product added']);
        } else {
            echo json_encode(['error' => 'Failed to add product: ' . $conn->error]);
        }
        break;

    case 'PUT':
        $input = json_decode(file_get_contents('php://input'), true);

        $id = $conn->real_escape_string($input['id']);
        $name = $conn->real_escape_string($input['name']);
        $description = $conn->real_escape_string($input['description']);
        $price = $conn->real_escape_string($input['price']);

        $query = "UPDATE products SET name='$name', description='$description', price='$price' WHERE id='$id'";

        if ($conn->query($query) === TRUE) {
            echo json_encode(['message' => 'Product updated']);
        } else {
            echo json_encode(['error' => 'Failed to update product: ' . $conn->error]);
        }
        break;

    case 'DELETE':
        $id = $conn->real_escape_string($_GET['id']);

        $query = "DELETE FROM products WHERE id='$id'";

        if ($conn->query($query) === TRUE) {
            echo json_encode(['message' => 'Product deleted']);
        } else {
            echo json_encode(['error' => 'Failed to delete product: ' . $conn->error]);
        }
        break;

    default:
        echo json_encode(['error' => 'Invalid request method']);
}

// Menutup koneksi
$conn->close();
?>
