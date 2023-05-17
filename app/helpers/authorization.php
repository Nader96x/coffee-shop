<?php

function isAdmin()
{
    if (isset($_SESSION['user_id']) && $_SESSION['user_role'] == 'Admin') {
        return true;
    } else {
        return false;
    }
}

function isUser()
{
    if (isset($_SESSION['user_id']) && $_SESSION['user_role'] == 'User') {
        return true;
    } else {
        return false;
    }
}

function isGuest()
{
    if (!isset($_SESSION['user_id'])) {
        return true;
    } else {
        return false;
    }
}