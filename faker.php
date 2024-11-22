<?php
require 'vendor/autoload.php';

$faker = Faker\Factory::create();

$host = 'localhost';
$port = '3306';
$db = 'e-commerce-sql';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    for ($i = 0; $i < 10; $i++) {
        $stmt = $pdo->prepare("INSERT INTO Users (username, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$faker->userName, $faker->unique()->email, password_hash('password', PASSWORD_BCRYPT)]);
    }

    for ($i = 1; $i <= 10; $i++) {
        $stmt = $pdo->prepare("INSERT INTO address (id_user, street, city, postal_code, country) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$i, $faker->streetAddress, $faker->city, $faker->postcode, $faker->country]);
    }

    for ($i = 0; $i < 20; $i++) {
        $stmt = $pdo->prepare("INSERT INTO product (name, description, price, stock_quantity) VALUES (?, ?, ?, ?)");
        $stmt->execute([$faker->word, $faker->text, $faker->randomFloat(2, 1, 100), $faker->numberBetween(1, 50)]);
    }

    for ($i = 1; $i <= 10; $i++) {
        $stmt = $pdo->prepare("INSERT INTO cart (id_user) VALUES (?)");
        $stmt->execute([$i]);
    }

    for ($i = 1; $i <= 10; $i++) {
        $stmt = $pdo->prepare("INSERT INTO command (id_user, id_address, total_price, status) VALUES (?, ?, ?, ?)");
        $stmt->execute([$i, $i, $faker->randomFloat(2, 10, 200), $faker->randomElement(['pending', 'shipped', 'delivered'])]);
    }

    for ($i = 1; $i <= 10; $i++) {
        $stmt = $pdo->prepare("INSERT INTO invoice (id_command, invoice_date, total_price) VALUES (?, ?, ?)");
        $stmt->execute([$i, $faker->dateTimeThisMonth()->format('Y-m-d H:i:s'), $faker->randomFloat(2, 10, 200)]);
    }

    for ($i = 1; $i <= 10; $i++) {
        for ($j = 0; $j < 3; $j++) {
            $stmt = $pdo->prepare("INSERT INTO cart_product (id_cart, id_product, quantity) VALUES (?, ?, ?)");
            $stmt->execute([$i, $faker->numberBetween(1, 20), $faker->numberBetween(1, 5)]);
        }
    }

    for ($i = 1; $i <= 10; $i++) {
        for ($j = 0; $j < 3; $j++) {
            $stmt = $pdo->prepare("INSERT INTO command_product (id_command, id_product, quantity) VALUES (?, ?, ?)");
            $stmt->execute([$i, $faker->numberBetween(1, 20), $faker->numberBetween(1, 5)]);
        }
    }

    for ($i = 1; $i <= 20; $i++) {
        $stmt = $pdo->prepare("INSERT INTO photo (id_user, id_product, photo_url) VALUES (?, ?, ?)");
        $stmt->execute([$faker->numberBetween(1, 10), $i, $faker->imageUrl(640, 480, 'products')]);
    }

    for ($i = 1; $i <= 20; $i++) {
        $stmt = $pdo->prepare("INSERT INTO rate (id_user, id_product, rating, comment) VALUES (?, ?, ?, ?)");
        $stmt->execute([$faker->numberBetween(1, 10), $i, $faker->numberBetween(1, 5), $faker->sentence]);
    }

    for ($i = 1; $i <= 10; $i++) {
        $stmt = $pdo->prepare("INSERT INTO payment (id_user, payment_type, payment_info) VALUES (?, ?, ?)");
        $stmt->execute([$i, $faker->randomElement(['Credit Card', 'IBAN']), $faker->creditCardNumber]);
    }

    echo "Données insérées avec succès dans la base de données.";

} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}

$pdo = null;
?>
