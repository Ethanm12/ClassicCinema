
<?php
if (isset($_POST['submit'])) {
    $conn = new mysqli('sapphire', 'emorgan', 'ethan11', 'emorgan_dev');
    if ($conn->connect_errno) {
        echo "failed connection\n";
    }

    $user = $conn->real_escape_string($_POST['Username']);
    $email = $conn->real_escape_string($_POST['Email']);


    $query = "SELECT * FROM Users WHERE username = '" . $user . "'";

    $result = $conn->query($query);

    if ($result->num_rows === 0) {

        $password = sha1(htmlentities($conn->real_escape_string($_POST['Password'])));
        $query = "INSERT INTO Users (username, password, email, role) " .
            "VALUES ('$user', '$password', '$email', 'user')";
        $conn->query($query);

        if ($conn->error) {
            echo "Query incorrect";
        }
    } else {
        echo "Username is already in use, please try another one";

    }

    $result->free();
    $conn->close();
    header("Location: index.php");

} else {
    ?>
    <?php $scriptList = array("jquery-3.2.1.min.js", "reviews.js", "cart.js", "cookies.js", "showHide.js");
    include("header.php");
    ?>
    <div id="main">

        <form name="newUserForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <fieldset>


                <legend>New User Details</legend>
                <p>
                    <label for="Username">New Users Name</label>
                    <input type="text" name="Username" id="Username" required>
                </p>
                <p>
                    <label for="Password">Password</label>
                    <input type="password" name="Password" id="Password" required>
                </p>
                <p>
                    <label for="Email">Email</label>
                    <input type="text" name="Email" id="Email" required>
                </p>

            </fieldset>
            <input type="submit" name="submit" value="Submit">
        </form>
    </div>
    </body>
    </html>

    <?php include("footer.php");
} ?>
