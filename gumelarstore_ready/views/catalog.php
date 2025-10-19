<div class="container">
  <div class="d-flex mb-3">
    <form class="flex-grow-1 me-2" method="get" action="index.php">
      <input type="hidden" name="page" value="catalog">
      <div class="input-group">
        <input class="form-control" name="q" placeholder="Cari produk..." value="<?php echo esc($_GET['q'] ?? ''); ?>">
        <button class="btn btn-primary">Cari</button>
      </div>
    </form>
    <a href="index.php?page=catalog" class="btn btn-outline-secondary">Reset</a>
  </div>
  <div class="row g-3">
    <?php foreach($products as $p): ?>
    <div class="col-md-3">
      <div class="card h-100">
        <img src="<?php echo esc($p['image']); ?>" class="card-img-top" style="height:160px;object-fit:cover">
        <div class="card-body">
          <h6 class="card-title"><?php echo esc($p['name']); ?></h6>
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