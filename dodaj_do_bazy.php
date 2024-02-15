<?php
$dsn = "mysql:host=localhost;dbname=Dane_db";
$username = "root";
$password = "";

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $login = $_POST['login'];
    $haslo = password_hash($_POST['haslo'], PASSWORD_DEFAULT); 

    
    $stmt = $pdo->prepare("SELECT * FROM dane WHERE login=:login");
    $stmt->bindParam(':login', $login);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        echo "<script>alert('Użytkownik z takim loginem już istnieje!');</script>";
        echo "<script>window.location.href = 'index.html';</script>";
    } else {
        
        $stmt = $pdo->prepare("INSERT INTO dane (login, hasło) VALUES (:login, :haslo)");
        $stmt->bindParam(':login', $login);
        $stmt->bindParam(':haslo', $haslo);

        if ($stmt->execute()) {
            echo "<script>alert('Rejestracja udana!');</script>";
            echo "<script>window.location.href = 'index.html';</script>"; 
        } else {
            echo "<script>alert('Błąd podczas rejestracji!');</script>";
            echo "<script>window.location.href = 'index.html';</script>"; 
        }
    }
} catch (PDOException $e) {
    echo "Błąd połączenia: " . $e->getMessage();
}
?>
