<h3>Reports</h3>
<p>Download laporan penjualan:</p>
<p><a class="btn btn-sm btn-primary" href="index.php?page=admin&sub=export_sales">Export Sales (CSV)</a></p>
<hr>
<?php $totalSales=$pdo->query("SELECT SUM(total) FROM orders")->fetchColumn(); echo "<p>Total sales: Rp ".number_format($totalSales?:0,0,',','.')."</p>"; ?>