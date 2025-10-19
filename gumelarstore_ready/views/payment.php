<div class="container"><h2>Pembayaran</h2>
<?php if ($order): ?>
  <p>Order ID: <?php echo $order['id']; ?></p>
  <p>Total: Rp <?php echo number_format($order['total'],0,',','.'); ?></p>
  <p>Status: <?php echo esc($order['status']); ?></p>
  <p>Simulasikan pembayaran dengan tombol di bawah:</p>
  <button class="btn btn-success" onclick="payProcess(<?php echo $order['id']; ?>)">Bayar Sekarang (Dummy)</button>
<?php else: echo '<p>Order tidak ditemukan.</p>'; endif; ?>
</div>