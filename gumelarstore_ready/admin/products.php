<h3>Products</h3>
<?php
// Tambah produk
if (isset($_GET['action']) && $_GET['action'] === 'add' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $price = (float)$_POST['price'];
    $desc = $_POST['description'];
    $cat = (int)$_POST['category_id'];

    // Folder upload (buat otomatis kalau belum ada)
    $upload_dir = __DIR__ . '/../uploads/';
    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    // Upload gambar (gunakan default jika kosong)
    if (!empty($_FILES['image']['name'])) {
        $filename = time() . '_' . basename($_FILES['image']['name']);
        $target = $upload_dir . $filename;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            $t = 'uploads/' . $filename; // path yang disimpan di database
        } else {
            echo "<div class='alert alert-danger'>Gagal mengunggah gambar.</div>";
            $t = 'assets/img/product-placeholder.svg';
        }
    } else {
        $t = 'assets/img/product-placeholder.svg';
    }

    $stmt = $pdo->prepare("INSERT INTO products (name, description, price, image, category_id, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
    $stmt->execute([$name, $desc, $price, $t, $cat]);

    echo "<div class='alert alert-success'>Produk ditambahkan</div>";
}

// Hapus produk
if (isset($_GET['action']) && $_GET['action'] === 'delete') {
    $id = (int)$_GET['id'];
    $pdo->prepare("DELETE FROM products WHERE id = ?")->execute([$id]);
    echo "<div class='alert alert-warning'>Produk dihapus</div>";
}

// Ambil data kategori & produk
$cats = $pdo->query("SELECT * FROM categories")->fetchAll();
$allp = $pdo->query("SELECT p.*, c.name as category 
                     FROM products p 
                     LEFT JOIN categories c ON p.category_id = c.id 
                     ORDER BY p.id DESC")->fetchAll();
?>

<p><a class="btn btn-sm btn-success" data-bs-toggle="collapse" href="#addForm">Tambah Produk</a></p>

<div class="collapse" id="addForm">
    <div class="card card-body">
        <form method="post" action="index.php?page=admin&sub=products&action=add" enctype="multipart/form-data">
            <div class="mb-3">
                <label>Nama</label>
                <input class="form-control" name="name" required>
            </div>
            <div class="mb-3">
                <label>Deskripsi</label>
                <textarea class="form-control" name="description"></textarea>
            </div>
            <div class="mb-3">
                <label>Harga</label>
                <input class="form-control" name="price" required>
            </div>
            <div class="mb-3">
                <label>Kategori</label>
                <select class="form-control" name="category_id">
                    <?php foreach ($cats as $c) echo '<option value="'.$c['id'].'">'.esc($c['name']).'</option>'; ?>
                </select>
            </div>
            <div class="mb-3">
                <label>Gambar</label>
                <input type="file" name="image">
            </div>
            <button class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>

<table class="table mt-3">
    <tr>
        <th>ID</th>
        <th>Nama</th>
        <th>Kategori</th>
        <th>Harga</th>
        <th>Aksi</th>
    </tr>
    <?php foreach ($allp as $p): ?>
    <tr>
        <td><?php echo $p['id']; ?></td>
        <td><?php echo esc($p['name']); ?></td>
        <td><?php echo esc($p['category']); ?></td>
        <td>Rp <?php echo number_format($p['price'], 0, ',', '.'); ?></td>
        <td>
            <a class="btn btn-sm btn-danger"
               href="index.php?page=admin&sub=products&action=delete&id=<?php echo $p['id']; ?>"
               onclick="return confirm('Hapus produk ini?')">Hapus</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
