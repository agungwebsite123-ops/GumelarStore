<div class="container">
  <div class="row my-4">
    <div class="col-md-8">
      <div class="card p-4 colorful-hero">
        <h3>Promo Tropis: Summer Sale</h3>
        <p>Belanja sekarang dan dapatkan diskon spesial untuk koleksi terbatas.</p>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card p-3">
        <h5>Kategori</h5>
        <div class="d-flex flex-wrap gap-2">
          <?php $cats = $pdo->query("SELECT * FROM categories")->fetchAll(PDO::FETCH_ASSOC); foreach($cats as $c) echo '<a class="badge bg-info text-dark" href="index.php?page=catalog&cat='.$c['id'].'">'.esc($c['name']).'</a> '; ?>
        </div>
      </div>
    </div>
  </div>
  <h4>Produk Pilihan</h4>
  <div class="row g-3">
    <?php foreach($products as $p): ?>
    <div class="col-md-3">
      <div class="card h-100">
        <img src="<?php echo esc($p['image']); ?>" class="card-img-top" style="height:160px;object-fit:cover">
        <div class="card-body">
          <h6 class="card-title"><?php echo esc($p['name']); ?></h6>
          <p class="text-muted small"><?php echo esc($p['category']); ?></p>
          <p class="fw-bold">Rp <?php echo number_format($p['price'],0,',','.'); ?></p>
          <div class="d-flex gap-2">
            <a href="index.php?page=product&id=<?php echo $p['id']; ?>" class="btn btn-sm btn-outline-primary">Detail</a>
            <button class="btn btn-sm btn-primary" onclick="addToCart(<?php echo $p['id']; ?>)">Add</button>
          </div>
        </div>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
</div>