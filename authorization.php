<?php
session_start();

if(isset($_SESSION['user'])) {
    $currentUser = $_SESSION['user'];
} else {
    $currentUser = null;
}