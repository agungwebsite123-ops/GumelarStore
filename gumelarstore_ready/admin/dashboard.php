<h3>Dashboard</h3>
<div class="row">
  <div class="col-md-4"><div class="card p-3"><h5>Produk</h5><p><?php echo $pdo->query("SELECT COUNT(*) FROM products")->fetchColumn(); ?></p></div></div>
  <div class="col-md-4"><div class="card p-3"><h5>Pesanan</h5><p><?php echo $pdo->query("SELECT COUNT(*) FROM orders")->fetchColumn(); ?></p></div></div>
  <div class="col-md-4"><div class="card p-3"><h5>Users</h5><p><?php echo $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn(); ?></p></div></div>
</div>
<hr>
<h4>Recent Orders</h4>
<?php $rows = $pdo->query("SELECT * FROM orders ORDER BY created_at DESC LIMIT 5")->fetchAll(PDO::FETCH_ASSOC); foreach($rows as $r): ?>
  <div class="card mb-2"><div class="card-body"><strong>Order #<?php echo $r['id']; ?></strong> - <?php echo esc($r['status']); ?><br>Rp <?php echo number_format($r['total'],0,',','.'); ?> - <?php echo $r['created_at']; ?></div></div>
<?php endforeach; ?>