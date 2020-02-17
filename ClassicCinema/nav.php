<?php
$currentPage = basename($_SERVER["PHP_SELF"]);
$authenticate = isset($_SESSION['authenticatedUser']);


if ($currentPage === "index.php") {
    echo "<li> Home";
} else {
    echo "<li> <a href='index.php''>Home</a>";
}


if ($currentPage === "classic.php") {
    echo "<li> Classics";
} else {
    echo "<li> <a href='classic.php''>Classics</a>";
}


if ($currentPage === "scifi.php") {
    echo "<li> Science Fiction and Horror";
} else {
    echo "<li> <a href='scifi.php''>Science Fiction and Horror</a>";
}

if ($currentPage === "hitchcock.php") {
    echo "<li> Alfred Hitchcock";
} else {
    echo "<li> <a href='hitchcock.php''>Alfred Hitchcock</a>";
}
if($authenticate) {
    if ($currentPage === "checkout.php") {
        echo "<li> Checkout";
    } else {
        echo "<li> <a href='checkout.php'>Checkout</a>";
    }
    if ($currentPage === "orders.php") {
        echo "<li> Orders";
    } else {
        echo "<li> <a href='orders.php'>Orders</a>";
    }
}
else{
    echo "<li>Please login to make an order or view orders";
}



