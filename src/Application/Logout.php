<?php
/**
 * Created by PhpStorm.
 * User: enzo
 * Date: 26/11/16
 * Time: 16:56
 */

session_destroy();
header("Location: ../../login.php?logout=ok");