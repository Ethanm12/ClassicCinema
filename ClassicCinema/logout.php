<?php
/**
 * Created by PhpStorm.
 * User: emorgan
 * Date: 9/21/17
 * Time: 1:15 PM
 */


session_start();
unset($_SESSION['authenticatedUser']);
unset($_SESSION['role']);

header("Location: index.php");
