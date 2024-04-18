<?php
session_start();

// Function to check if the user is authenticated
function isAuthenticated() {
    return isset($_SESSION['user_id']);
}

// Function to redirect the user to the login page if not authenticated
function requireAuthentication() {
    if (!isAuthenticated()) {
        header("Location: login.php");
        exit();
    }
}