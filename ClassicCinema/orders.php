<?php
session_start();
$authenticate = isset($_SESSION['authenticatedUser']);
$realuser = $_SESSION['authenticatedUser'];

$role = $_SESSION['role'];
if ($authenticate) {

    $scriptList = array("jquery-3.2.1.min.js", "carousel.js");
    include("header.php");
    ?>

    <div id="main">
        <?php
        echo "<h1>Current orders</h1>";
        $counter = 1;
        $orderss = 'orders.xml';
        $orders = simplexml_load_file($orderss);
        foreach ($orders->order as $order) {
            $user = $order->delivery->username;

            if ($user == $realuser || $role == 'admin') {
                $printed = 1;
                echo "<h3>Order: $counter </h3>";

                $name = $order->delivery->name;

                $email = $order->delivery->email;

                $address1 = $order->delivery->address1;
                $address2 = $order->delivery->address2;

                $city = $order->delivery->city;
                $postcode = $order->delivery->postcode;


                echo "<ul>";
                echo "<li>Name: $name</li>";
                echo "<li>Username: $user</li>";

                echo "<li>Email: $email</li>";

                echo "<li>Address: $address1 $address2</li>";
                echo "<li>City: $city</li>";
                echo "<li>Postcode: $postcode</li>";

                $items = $order->items;

                echo "<p>Purchases:</p>";

                foreach ($items->item as $item) {

                    $title = $item->title;
                    $price = $item->price;


                    echo "<ul>";
                    echo "<li>Title: $title</li>";
                    echo "<li>Price: $price</li>";
                    echo "</ul>";


                }

                echo "</ul>";
                $counter = $counter + 1;
            } else {
                $empty = "<p>You have not made any Orders</p>";
                $printed = 0;

            }
        }
        if (!$printed) {
            echo $empty;
        }

        ?>
    </div>


    <?php include("footer.php"); ?>
    </body>
    </html>

    <?php
} else {
    header("Location: index.php");


}