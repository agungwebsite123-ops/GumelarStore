<?php
require 'config.php';
if ($_SERVER['REQUEST_METHOD']==='POST'){
    $username = $_POST['username'];
    $password = $_POST['password'];
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("SELECT id FROM admins WHERE username = ? LIMIT 1");
    $stmt->execute([$username]);
    if ($stmt->fetch()){
        $pdo->prepare("UPDATE admins SET password = ? WHERE username = ?")->execute([$hash, $username]);
        echo "Admin updated.";
    } else {
        $pdo->prepare("INSERT INTO admins (username,password) VALUES (?,?)")->execute([$username,$hash]);
        echo "Admin created.";
    }
    exit;
}
?>
<form method="post">
Admin username: <input name="username" value="Agung"><br>
Password: <input name="password" value="Agung123"><br>
<button>Set Admin</button>
</form>