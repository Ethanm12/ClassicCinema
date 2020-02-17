<?php if (session_id() === "") {
    session_start();
}
$_SESSION['lastPage'] = $_SERVER['PHP_SELF'];
?>
<!DOCTYPE html>

<html lang="en">

<head>
    <title>Classic Cinema</title>
    <link rel="stylesheet" href="style.css">
    <meta charset="utf-8">
    <?php if (isset($scriptList) && is_array($scriptList)) {
        foreach ($scriptList as $script) {
            echo "<script src='$script'></script>";
        }
    }
    ?>


</head>

<body>

<header>
    <h1>Classic Cinema</h1>
</header>

<div id="user">

    <?php if (isset($_SESSION['authenticatedUser'])) { ?>
        <div id="logout">
            <p>Welcome, <?php echo $_SESSION['authenticatedUser']; ?>, <?php echo $_SESSION['role']; ?>
                <span id="logoutUser"></span></p>
            <form id="logoutForm" action="logout.php" method="post">
                <input type="submit" id="logoutSubmit" value="Logout">
            </form>
        </div>    <?php } else { ?>
        <div id="login">
            <form id="loginForm" action="login.php" method="POST">
                <label for="loginUser">Username: </label>
                <input type="text" name="loginUser" id="loginUser">
                <label for="loginPassword">Password: </label>
                <input type="password" name="loginPassword" id="loginPassword">
                <input type="submit" id="loginSubmit" value="Login">
                <a id="registerlink" href="register.php">Register</a>
            </form>
        </div>    <?php } ?>



</div>

<nav>
    <ul>
        <?php include("nav.php"); ?>
    </ul>
</nav>









