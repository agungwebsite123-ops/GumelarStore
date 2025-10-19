<div class="container"><h2>Riwayat Pesanan</h2>
<?php if (empty($orders)) echo '<p>Belum ada pesanan.</p>'; foreach($orders as $o){ echo "<div class='card mb-2'><div class='card-body'><h5>Order #{$o['id']} - ".esc($o['status'])."</h5><p>{$o['created_at']} | Total Rp ".number_format($o['total'],0,',','.')."</p></div></div>"; } ?>
</div>