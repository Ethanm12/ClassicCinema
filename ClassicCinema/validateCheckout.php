<?php
session_start();
$authenticate = isset($_SESSION['authenticatedUser']);
if ($authenticate) {


$scriptList = array("jquery-3.2.1.min.js", "cookies.js");
include('header.php');
?>
<div id="main">
    <?php
    session_start();
    $_SESSION["deliveryName"] = $_POST["deliveryName"];
    $_SESSION["deliveryEmail"] = $_POST["deliveryEmail"];
    $_SESSION["deliveryAddress1"] = $_POST["deliveryAddress1"];
    $_SESSION["deliveryAddress2"] = $_POST["deliveryAddress2"];

    $_SESSION["deliveryCity"] = $_POST["deliveryCity"];
    $_SESSION["deliveryPostcode"] = $_POST["deliveryPostcode"];
    $_SESSION["cardType"] = $_POST["cardType"];
    $_SESSION["cardMonth"] = $_POST["cardMonth"];
    $_SESSION["cardYear"] = $_POST["cardYear"];
    $_SESSION["cardNumber"] = $_POST["cardNumber"];
    $_SESSION["cardValidation"] = $_POST["cardValidation"];

    $errors = "";
    $errors = "<ul>";
    if (isEmpty($_POST["deliveryName"])) {
        $errors = $errors . "<li>Please enter Your name";

    }
    if (isEmpty($_POST["deliveryEmail"]) || isEmail($_POST["deliveryEmail"])) {
        $errors = $errors . "<li>Please enter a valid email address ";


    }
    if (isEmpty($_POST["deliveryAddress1"])) {
        $errors = $errors . "<li>Please enter an address";

    }
    if (isEmpty($_POST["deliveryCity"])) {
        $errors = $errors . "<li>Please enter a City";


    }
    if (isEmpty($_POST["deliveryPostcode"]) || !checkLength($_POST["deliveryPostcode"], 4) || !isDigits($_POST["deliveryPostcode"])) {
        $errors = $errors . "<li>Please enter a valid postcode";

    }

    if (!checkCardDate($_POST["cardMonth"], $_POST["cardYear"])) {
        $errors = $errors . "<li>Please enter a valid expiry date";

    }

    if (!checkCardNumber($_POST["cardType"], $_POST["cardNumber"])) {
        $errors = $errors . "<li>Please enter a valid card Number";

    }

    if (!checkCardVerification($_POST["cardType"], $_POST["cardValidation"])) {
        $errors = $errors . "<li>Please enter a valid CVC code";

    }
    echo $errors;


    if ($errors === "<ul>") {
        echo "Successful Validation";
        if (isset($_COOKIE["cart"])) {
            $cart = json_decode($_COOKIE["cart"]);
            $table = "<table><tr><th>Title</th><th>Price</th></tr>";
            $orders = simplexml_load_file("orders.xml");
            $newOrder = $orders->addChild("order");

            $delivery = $newOrder->addChild('delivery');
            $delivery->addChild('name', $_POST['deliveryName']);
            $delivery->addChild('email', $_POST['deliveryEmail']);
            $delivery->addChild('address1', $_POST['deliveryAddress1']);
            $delivery->addChild('address2', $_POST['deliveryAddress2']);
            $delivery->addChild('city', $_POST['deliveryCity']);
            $delivery->addChild('postcode', $_POST['deliveryPostcode']);
            $delivery->addChild('username', $_SESSION['authenticatedUser']);
            $items = $newOrder->addChild('items');


            foreach ($cart as $item) {
                $itemn = $items->addChild('item');

                $price = $item->price;
                $title = $item->title;

                $itemn->addChild('title', $title);
                $itemn->addChild('price', $price);


                $table = $table . "<tr><td>" . $title . "</td><td>" . $price . "</td>";

            }

            $table = $table . "</table>";
            echo $table;
            $_SESSION = array();
            // adds info to xml file


            $orders->saveXML('orders.xml');


            setcookie('cart', '', time() - 3600, '/');
            unset($_COOKIE['cart']);
            session_destroy();

        }
    }
    } else {
        header("Location: index.php");


    }


    ?>

</div>
<?php include("footer.php"); ?>
</body></html>


<?php

function checkCardNumber($cardType, $cardNumber)
{
    if (!isDigits($cardNumber)) {
        return false;
    }

    switch ($cardType) {
        case 'amex':
            return checkLength($cardNumber, 15) && (int)$cardNumber[0] === 3;
            break;
        case 'mcard':
            return checkLength($cardNumber, 16) && (int)$cardNumber[0] === 5;
            break;
        case 'visa':
            return checkLength($cardNumber, 16) && (int)$cardNumber[0] === 4;
            break;
        default:
            return false;
    }
}


function checkCardVerification($cardType, $cardVerify)
{
    if (!isDigits($cardVerify)) {
        return false;
    }

    switch ($cardType) {
        case 'amex':
            return checkLength($cardVerify, 4);
            break;
        case 'mcard':
        case 'visa':
            return checkLength($cardVerify, 3);
            break;
        default:
            return false;
    }
}

function checkCardDate($cardMonth, $cardYear)
{
    $year = (int)date('Y');
    $month = (int)date('n');
    $cardYear = (int)$cardYear;
    $cardMonth = (int)$cardMonth;

    if ($year > $cardYear) {
        return false;
    } elseif ($year === $cardYear && $month >= $cardMonth) {
        return false;
    } else {
        return true;
    }
}


function checkLength($str, $len)
{
    return strlen(trim($str)) === $len;
}

function isDigits($str)
{
    $pattern = '/^[0-9]+$/';
    return preg_match($pattern, $str);
}


function isEmpty($str)
{
    return strlen(trim($str)) == 0;
}

function isEmail($str)
{
    // There's a built in PHP tool that has a go at this
    return filter_var($str, FILTER_VALIDATE_EMAIL);
}

?>


