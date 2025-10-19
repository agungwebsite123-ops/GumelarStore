<!doctype html><html lang="id"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title><?php echo esc($site_name); ?></title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="assets/css/style.css" rel="stylesheet">
</head><body>
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
  <div class="container">
    <a class="navbar-brand fw-bold" href="index.php"><?php echo $site_name; ?></a>
    <div>
      <a class="btn btn-sm btn-outline-secondary me-2" href="index.php?page=cart">Keranjang <span id="cart-count" class="badge bg-primary"><?php echo isset($_SESSION['cart'])?array_sum($_SESSION['cart']):0; ?></span></a>
      <?php if (!empty($_SESSION['username'])): ?>
        <a class="btn btn-sm btn-outline-success me-2" href="index.php?page=user_orders">Halo, <?php echo esc($_SESSION['username']); ?></a>
        <a class="btn btn-sm btn-outline-danger" href="index.php?page=logout">Logout</a>
      <?php else: ?>
        <a class="btn btn-sm btn-primary" href="index.php?page=login">Login / Register</a>
      <?php endif; ?>
    </div>
  </div>
</nav>
<header class="py-4 hero">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-md-6">
        <h1 class="display-5 fw-bold">GumelarStore — Tropical Vibes</h1>
        <p class="lead">Diskon tropis hingga 50% untuk koleksi pilihan. Belanja warna-warni, nikmati gaya hidup cerah!</p>
        <a href="index.php?page=catalog" class="btn btn-lg btn-gradient">Belanja Sekarang</a>
      </div>
      <div class="col-md-6 text-center">
        <img src="assets/img/banner-tropical.svg" class="img-fluid" style="max-height:240px">
      </div>
    </div>
  </div>
</header>
<main class="py-4">