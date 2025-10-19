<!doctype html><html><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Admin - GumelarStore</title><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"></head><body>
<nav class="navbar navbar-expand-lg navbar-light bg-light px-4">
  <a class="navbar-brand fw-bold text-primary" href="index.php">GumelarStore</a>
  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav me-auto">
      <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
      <li class="nav-item"><a class="nav-link" href="index.php?page=products">Produk</a></li>
      <li class="nav-item"><a class="nav-link" href="index.php?page=cart">Keranjang</a></li>
    </ul>

    <ul class="navbar-nav ms-auto">
      <?php if (!isset($_SESSION['user_id'])): ?>
        <li class="nav-item"><a class="btn btn-outline-primary me-2" href="index.php?page=login">Login</a></li>
        <li class="nav-item"><a class="btn btn-primary" href="index.php?page=register">Register</a></li>
      <?php else: ?>
        <li class="nav-item"><a class="nav-link" href="#">👋 Halo, <?= $_SESSION['user_name']; ?></a></li>
        <li class="nav-item"><a class="btn btn-danger" href="index.php?page=logout">Logout</a></li>
      <?php endif; ?>
    </ul>
  </div>
</nav>

<div class="container my-4"><div class="row"><div class="col-md-3"><div class="list-group">
<a class="list-group-item" href="index.php?page=admin&sub=dashboard">Dashboard</a>
<a class="list-group-item" href="index.php?page=admin&sub=products">Products</a>
<a class="list-group-item" href="index.php?page=admin&sub=orders">Orders</a>
<a class="list-group-item" href="index.php?page=admin&sub=users">Users</a>
<a class="list-group-item" href="index.php?page=admin&sub=reports">Reports</a>
<a class="list-group-item" href="index.php?page=admin&sub=export_sales">Export Sales (CSV)</a>
<a class="list-group-item text-danger" href="index.php?page=admin&action=logout">Logout</a>
</div></div><div class="col-md-9">