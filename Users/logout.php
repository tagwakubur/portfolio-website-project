<?php
session_start();

$redirectPage = "home.html";

if (isset($_SESSION['learner_name'])) {
    $redirectPage = "login_learner.html";
} elseif (isset($_SESSION['chef_name'])) {
    $redirectPage = "login_chef.html";
}

$_SESSION = array();
session_destroy();

header("Location: $redirectPage");
exit();
?>
