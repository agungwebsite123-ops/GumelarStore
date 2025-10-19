<?php
function require_login(){ if (empty($_SESSION['user_id'])){ header('Location: index.php?page=login'); exit; } }
?>