<div class="container">
    <h2>Keranjang</h2>
    <?php 
    if (empty($_SESSION['cart'])) { 
        echo "<p>Keranjang kosong</p>"; 
    } else {
        $ids = implode(',', array_map('intval', array_keys($_SESSION['cart'])));
        $stmt = $pdo->query("SELECT * FROM products WHERE id IN ($ids)");
        $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $total = 0;

        echo "<form method='post' action='index.php?page=checkout'>";
        echo "<table class='table'>
                <tr>
                    <th>Produk</th>
                    <th>Qty</th>
                    <th>Harga</th>
                    <th>Subtotal</th>
                </tr>";

        foreach ($items as $it) { 
            $q = $_SESSION['cart'][$it['id']]; 
            $sub = $it['price'] * $q; 
            $total += $sub;
            echo "<tr>
                    <td>".esc($it['name'])."</td>
                    <td>$q</td>
                    <td>Rp ".number_format($it['price'],0,',','.')."</td>
                    <td>Rp ".number_format($sub,0,',','.')."</td>
                  </tr>";
        }

        echo "<tr>
                <td colspan='3'><strong>Total</strong></td>
                <td><strong>Rp ".number_format($total,0,',','.')."</strong></td>
              </tr>
              </table>";

        // Buat ringkasan untuk WhatsApp
        $parts = array();
        foreach ($items as $it) { 
            $parts[] = $it['name'].' x'.$_SESSION['cart'][$it['id']];
        }
        $summary = urlencode(implode(', ', $parts));
        $wa_link = 'https://wa.me/' . $WHATSAPP_NUMBER . '?text=' . urlencode('Halo, saya ingin memesan: ') . $summary;

        echo "<div class='d-flex gap-2'>
                <a class='btn btn-success' href='".$wa_link."' target='_blank'>Pesan via WhatsApp</a>
                <a class='btn btn-secondary' href='index.php?page=cart_empty_all' onclick=\"return confirm('Yakin kosongkan keranjang?')\">Kosongkan Keranjang</a>
                <button class='btn btn-primary' type='submit'>Checkout</button>
              </div>";
        echo "</form>";
    }
    ?>
</div>
