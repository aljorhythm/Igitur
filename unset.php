<?php
session_start();
if (isset($_SESSION['user'])) {
    $_SESSION['temp'] = $_SESSION['user'];
    unset($_SESSION['user']);
} else if (isset($_SESSION['temp'])) {
    $_SESSION['user'] = $_SESSION['temp'];
}