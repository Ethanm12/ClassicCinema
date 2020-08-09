<?php
    session_start();
// Generate the response to the form submission
    $conn = new mysqli('sapphire', 'emorgan', 'Ethan1', 'emorgan_dev');
    if ($conn->connect_errno) {
        echo "failed connection\n";
// Something went wrong connecting
    }


    $user = $conn->real_escape_string($_POST['loginUser']);


    $password = sha1(htmlentities($conn->real_escape_string($_POST['loginPassword'])));
    $query = "SELECT * FROM Users WHERE username = '$user' AND password = '$password'";

    $result = $conn->query($query);


    if ($result->num_rows === 1) {
        $_SESSION['authenticatedUser'] = $user;
        $row = $result->fetch_assoc();
        $role = $row['role'];
        $_SESSION['role'] = $role;

        $page = $_SESSION['lastPage'];
        $_SESSION['Username'] = $user;

        echo $page;
        header("Location: $page");
        echo "Login Successful";

        exit;


    } else {
        $page = $_SESSION['lastPage'];

        header("Location: $page");

        echo "Username or password is incorrect";

    }

    $result->free();

    $conn->close();
