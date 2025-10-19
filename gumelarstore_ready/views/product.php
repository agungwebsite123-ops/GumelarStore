<div class="container">
<?php if ($product): ?>
  <div class="row">
    <div class="col-md-6"><img src="<?php echo esc($product['image']); ?>" class="img-fluid" style="max-height:400px;object-fit:cover"></div>
    <div class="col-md-6">
      <h2><?php echo esc($product['name']); ?></h2>
      <p class="text-muted"><?php echo esc($product['category']); ?></p>
      <p class="fw-bold display-6">Rp <?php echo number_format($product['price'],0,',','.'); ?></p>
      <p><?php echo nl2br(esc($product['description'])); ?></p>
      <div class="d-flex gap-2">
        <input id="qty" type="number" value="1" min="1" class="form-control" style="width:100px">
        <button class="btn btn-primary" onclick="addToCart(<?php echo $product['id']; ?>, document.getElementById('qty').value)">Tambah ke Keranjang</button>
        <?php $wa = 'https://wa.me/'.$WHATSAPP_NUMBER.'?text='.urlencode('Halo, saya ingin memesan '. $product['name'] .' sebanyak 1.'); ?>
        <a class="btn btn-success" href="<?php echo $wa; ?>" target="_blank">Pesan via WhatsApp</a>
      </div>
    </div>
  </div>
<?php else: echo '<p>Produk tidak ditemukan.</p>'; endif; ?>
</div>