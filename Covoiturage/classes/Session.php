<?php

class Session
{
    public function start() {
        session_start();
    }

    public function destroy() {
        session_destroy();
    }

    public function get() {
        if (isset($_SESSION['user'])) {
            $user = $_SESSION['user'];
        }
        else {
            $user = '';
        }
        return $user;
    }

    public function set($user) {
        $_SESSION['user'] = $user;
    }
}