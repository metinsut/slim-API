<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App;

//Get all costumers
$app->get("/api/personel", function(Request $request, Response $response){
  $sql = "SELECT * FROM personel";
  try {
    // Get DB Object
    $db = new db();
    // Connect
    $db = $db->connect();
    $stmt = $db->query($sql);
    $users = $stmt->fetchAll(PDO::FETCH_OBJ);
    $db = null;
    echo json_encode($users);
  } catch (PDOException $e) {
    echo '{"error": {"text": '.$e->getMessage().'}';
  }
});

//Get single costumers
$app->get("/api/personel/{id}", function(Request $request, Response $response){
  $id = $request->getAttribute("id");
  $sql = "SELECT * FROM personel WHERE id=$id";
  try {
    // Get DB Object
    $db = new db();
    // Connect
    $db = $db->connect();
    $stmt = $db->query($sql);
    $users = $stmt->fetchAll(PDO::FETCH_OBJ);
    $db = null;
    echo json_encode($users);
  } catch (PDOException $e) {
    echo '{"error": {"text": '.$e->getMessage().'}';
  }
});

// Add Customer
$app->post('/api/personel/add', function(Request $request, Response $response){
    $name = $request->getParam('name');
    $email = $request->getParam('email');
    $gender = $request->getParam('gender');
    $phone = $request->getParam('phone');
    $city = $request->getParam('city');
    $sql = "INSERT INTO personel (name,email,gender,phone,city) VALUES
    (:name,:email,:gender,:phone,:city)";
    try{
        // Get DB Object
        $db = new db();
        // Connect
        $db = $db->connect();
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':name',       $name);
        $stmt->bindParam(':email',      $email);
        $stmt->bindParam(':gender',     $gender);
        $stmt->bindParam(':phone',      $phone);
        $stmt->bindParam(':city',       $city);
        $stmt->execute();
        echo '{"notice": {"text": "Personel Added"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Update Customer
$app->put('/api/personel/update/{id}', function(Request $request, Response $response){
    $id = $request->getAttribute('id');
    $name = $request->getParam('name');
    $email = $request->getParam('email');
    $gender = $request->getParam('gender');
    $phone = $request->getParam('phone');
    $city = $request->getParam('city');
    $sql = "UPDATE personel SET name = :name, email = :email, gender = :gender, phone = :phone, city = :city WHERE id = $id";
    try{
        // Get DB Object
        $db = new db();
        // Connect
        $db = $db->connect();
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':gender', $gender);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':city', $city);
        $stmt->execute();
        echo '{"notice": {"text": "Personel Updated"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});


// Delete Customer
$app->delete('/api/personel/delete/{id}', function(Request $request, Response $response){
    $id = $request->getAttribute('id');
    $sql = "DELETE FROM personel WHERE id = $id";
    try{
        // Get DB Object
        $db = new db();
        // Connect
        $db = $db->connect();
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $db = null;
        echo '{"notice": {"text": "Personel Deleted"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});
