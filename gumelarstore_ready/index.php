<?php
require 'config.php';
require 'includes/functions.php';
require 'includes/auth.php';
$page = $_GET['page'] ?? 'home';
if (!isset($_SESSION)) session_start();
$WHATSAPP_NUMBER = '6285647058923';
switch($page){
    case 'home':
        $products = $pdo->query("SELECT p.*, c.name as category FROM products p LEFT JOIN categories c ON p.category_id=c.id ORDER BY p.created_at DESC LIMIT 12")->fetchAll(PDO::FETCH_ASSOC);
        include 'views/header.php'; include 'views/home.php'; include 'views/footer.php';
        break;
    case 'catalog':
        $q = $_GET['q'] ?? '';
        $stmt = $pdo->prepare("SELECT p.*, c.name as category FROM products p LEFT JOIN categories c ON p.category_id=c.id WHERE p.name LIKE ? OR p.description LIKE ? ORDER BY p.created_at DESC");
        $stmt->execute(["%$q%","%$q%"]);
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        include 'views/header.php'; include 'views/catalog.php'; include 'views/footer.php';
        break;
    case 'product':
        $id = (int)($_GET['id'] ?? 0);
        $product = $pdo->prepare("SELECT p.*, c.name as category FROM products p LEFT JOIN categories c ON p.category_id=c.id WHERE p.id = ?");
        $product->execute([$id]); $product = $product->fetch(PDO::FETCH_ASSOC);
        include 'views/header.php'; include 'views/product.php'; include 'views/footer.php';
        break;
    case 'add_to_cart':
        if ($_SERVER['REQUEST_METHOD']==='POST'){
            $id = (int)($_POST['id']); $qty = max(1,(int)($_POST['qty'] ?? 1));
            if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];
            if (!isset($_SESSION['cart'][$id])) $_SESSION['cart'][$id]=0;
            $_SESSION['cart'][$id] += $qty;
            echo json_encode(['ok'=>true,'cart_count'=>array_sum($_SESSION['cart'])]); exit;
        }
        break;
    case 'cart':
        include 'views/header.php'; include 'views/cart.php'; include 'views/footer.php'; break;
    case 'cart_empty_all':
        unset($_SESSION['cart']);
        header('Location: index.php?page=cart'); exit;
        break;
    case 'checkout':
        require_login();
        if ($_SERVER['REQUEST_METHOD']==='POST'){
            $name = $_POST['name']; $phone = $_POST['phone']; $address = $_POST['address'];
            $pdo->beginTransaction();
            $total = 0; $items = [];
            if (!empty($_SESSION['cart'])){
                $ids = implode(',', array_map('intval', array_keys($_SESSION['cart'])));
                $pd = $pdo->query("SELECT * FROM products WHERE id IN ($ids)")->fetchAll(PDO::FETCH_ASSOC);
                foreach($pd as $p){ $q = $_SESSION['cart'][$p['id']]; $items[] = ['product_id'=>$p['id'],'qty'=>$q,'price'=>$p['price']]; $total += $p['price']*$q; }
            }
            $stmt = $pdo->prepare("INSERT INTO orders (user_id,customer_name,phone,address,total,status,created_at) VALUES (?,?,?,?,?,? ,NOW())");
            $stmt->execute([$_SESSION['user_id'],$name,$phone,$address,$total,'pending']);
            $order_id = $pdo->lastInsertId();
            $ip = $pdo->prepare("INSERT INTO order_items (order_id,product_id,quantity,price) VALUES (?,?,?,?)");
            foreach($items as $it) $ip->execute([$order_id,$it['product_id'],$it['qty'],$it['price']]);
            $pdo->commit();
            $_SESSION['cart'] = [];
            header('Location: index.php?page=payment&order_id='.$order_id); exit;
        }
        include 'views/header.php'; include 'views/checkout.php'; include 'views/footer.php'; break;
    case 'payment':
        $order_id = (int)($_GET['order_id'] ?? 0);
        $order = $pdo->prepare("SELECT * FROM orders WHERE id = ?"); $order->execute([$order_id]); $order = $order->fetch(PDO::FETCH_ASSOC);
        include 'views/header.php'; include 'views/payment.php'; include 'views/footer.php'; break;
    case 'pay_process':
        if ($_SERVER['REQUEST_METHOD']==='POST'){
            $order_id = (int)($_POST['order_id']); $pdo->prepare("UPDATE orders SET status='paid' WHERE id = ?")->execute([$order_id]);
            echo json_encode(['ok'=>true]); exit;
        }
        break;
    case 'register':
        if ($_SERVER['REQUEST_METHOD']==='POST'){
            $u = trim($_POST['username']); $e = trim($_POST['email']); $p = $_POST['password']; $h = password_hash($p,PASSWORD_DEFAULT);
            $pdo->prepare("INSERT INTO users (username,email,password,created_at) VALUES (?,?,?,NOW())")->execute([$u,$e,$h]);
            header('Location: index.php?page=login&registered=1'); exit;
        }
        include 'views/header.php'; include 'views/register.php'; include 'views/footer.php'; break;
    case 'login':
        if ($_SERVER['REQUEST_METHOD']==='POST'){
            $username = $_POST['username']; $password = $_POST['password'];
            $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? LIMIT 1"); $stmt->execute([$username]); $u = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($u && password_verify($password,$u['password'])){ $_SESSION['user_id']=$u['id']; $_SESSION['username']=$u['username']; header('Location: index.php'); exit; } else { $err="Login gagal"; }
        }
        include 'views/header.php'; include 'views/login.php'; include 'views/footer.php'; break;
    case 'logout':
        session_destroy(); header('Location: index.php'); exit;
    case 'user_orders':
        require_login();
        $stmt = $pdo->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC"); $stmt->execute([$_SESSION['user_id']]); $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
        include 'views/header.php'; include 'views/user_orders.php'; include 'views/footer.php'; break;
    case 'admin':
        $admin_err = "";
        if (!is_admin_logged()){
            if ($_SERVER['REQUEST_METHOD']==='POST'){
                $user = $_POST['username']; $pass = $_POST['password'];
                $stmt = $pdo->prepare("SELECT * FROM admins WHERE username = ? LIMIT 1");
                $stmt->execute([$user]);
                $adm = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($adm && password_verify($pass, $adm['password'])){
                    $_SESSION['admin_id']=$adm['id'];
                    $_SESSION['admin_username']=$adm['username'];
                    header('Location: index.php?page=admin&sub=dashboard'); exit;
                } else {
                    $admin_err = 'Invalid username or password';
                }
            }
            include 'admin/login.php';
        } else {
            $sub = $_GET['sub'] ?? 'dashboard';
            include 'admin/header.php';
            if ($sub==='dashboard'){
                $totalP = $pdo->query("SELECT COUNT(*) FROM products")->fetchColumn();
                $totalO = $pdo->query("SELECT COUNT(*) FROM orders")->fetchColumn();
                include 'admin/dashboard.php';
            } elseif ($sub==='products'){
                include 'admin/products.php';
            } elseif ($sub==='orders'){
                include 'admin/orders.php';
            } elseif ($sub==='users'){
                include 'admin/users.php';
            } elseif ($sub==='reports'){
                include 'admin/reports.php';
            } elseif ($sub==='export_sales'){
                header('Content-Type: text/csv; charset=utf-8');
                header('Content-Disposition: attachment; filename=sales_report_'.date('Ymd_His').'.csv');
                $out = fopen('php://output','w');
                fputcsv($out, ['order_id','customer_name','phone','address','total','status','created_at']);
                $rows = $pdo->query("SELECT * FROM orders ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);
                foreach($rows as $r) fputcsv($out, [$r['id'],$r['customer_name'],$r['phone'],$r['address'],$r['total'],$r['status'],$r['created_at']]);
                exit;
            }
            include 'admin/footer.php';
        }
        break;
    default:
        http_response_code(404); include 'views/header.php'; echo '<div class="container"><h2>404 Not Found</h2></div>'; include 'views/footer.php';
}