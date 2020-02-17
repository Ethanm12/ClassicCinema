<?php
/**
 * Created by PhpStorm.
 * User: emorgan
 * Date: 9/23/17
 * Time: 6:43 PM
 */
session_start();
$authenticate = isset($_SESSION['authenticatedUser']);

if ($authenticate) {

    $xml = $_POST["xmlFileName"];
    $reviews = simplexml_load_file($xml);
    $newReview = $reviews->addChild("review");
    $newReview->addChild("user", $_SESSION['authenticatedUser']);
    $newReview->addChild("rating", $_POST['newReview']);
    $reviews->saveXML($xml);
    $page = $_SESSION['lastPage'];

    header("Location: $page");




} else{
    header("Location: index.php");
}