</main>
<footer class="py-4 bg-light">
  <div class="container text-center">
    <p>&copy; <?php echo date('Y'); ?> <?php echo esc($site_name); ?>. All rights reserved.</p>
  </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
async function addToCart(id, qty=1){
  const f = new FormData(); f.append('id', id); f.append('qty', qty);
  const r = await fetch('index.php?page=add_to_cart',{method:'POST',body:f}); const j = await r.json();
  if (j.ok){ document.getElementById('cart-count').innerText = j.cart_count; alert('Ditambahkan ke keranjang'); }
}
async function payProcess(order_id){
  const f = new FormData(); f.append('order_id', order_id);
  const r = await fetch('index.php?page=pay_process',{method:'POST',body:f}); const j = await r.json();
  if (j.ok){ alert('Pembayaran sukses'); location.href='index.php?page=user_orders'; }
}
</script>
</body></html>