<?php

// requérir base de donnée et les infos généraux
require_once 'core/init.php';

// détruire la session
$session->destroy();

// Rédiriger vers index.php
new Redirect($_DOMAIN);