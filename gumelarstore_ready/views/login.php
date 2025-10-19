<div class="container" style="max-width:480px"><h2>Login</h2>
<?php if (!empty($err)) echo "<div class='alert alert-danger'>".esc($err)."</div>"; if (!empty($_GET['registered'])) echo "<div class='alert alert-success'>Registrasi berhasil. Silakan login.</div>"; ?>
<form method="post" action="index.php?page=login">
  <div class="mb-3"><label>Username</label><input class="form-control" name="username" required></div>
  <div class="mb-3"><label>Password</label><input class="form-control" type="password" name="password" required></div>
  <button class="btn btn-primary">Login</button>
  <a class="btn btn-link" href="index.php?page=register">Register</a>
</form></div>