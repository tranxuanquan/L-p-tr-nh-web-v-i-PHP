<?php
require_once __DIR__ . '/config.php';
if (isset($_POST['logout'])) {
    session_destroy();
    header('Location: index.php'); // Quay lại menu chính
    exit();
}

// Xử lý tìm kiếm sản phẩm theo tên
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
if ($search !== '') {
    $stmt = $conn->prepare('SELECT * FROM products WHERE name LIKE ? ORDER BY id DESC');
    $search_param = '%' . $search . '%';
    $stmt->bind_param('s', $search_param);
    $stmt->execute();
    $products = $stmt->get_result();
    $stmt->close();
} else {
    $products = $conn->query('SELECT * FROM products ORDER BY id DESC');
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Mizuki’s Cakes  – Bánh ngọt</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
</head>
<body>

  <nav class="nav">
    <div class="container nav-inner">
      <div class="brand">
        <a href="index.php" style="color:inherit;text-decoration:none;">Mizuki’s Cakes</a>
      </div>
      <div class="menu">
        <a href="#uu-dai">Ưu đãi</a>
        <a href="#menu">Menu</a>
        <a href="#ve-chung-toi">Về chúng tôi</a>
        <a class="cta" href="#lien-he">Đặt bánh</a>
        <button class="cart-btn" aria-label="Giỏ hàng" onclick="window.location='cart.php'">
          <svg width="26" height="26" viewBox="0 0 24 24" fill="none">
            <circle cx="9" cy="21" r="1.5" fill="#b48d61"/>
            <circle cx="18" cy="21" r="1.5" fill="#b48d61"/>
            <path d="M3 5h2l1.68 10.39A2 2 0 0 0 8.65 17h7.7a2 2 0 0 0 1.97-1.61L21 7H6" stroke="#b48d61" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
          <span class="cart-badge"><?php echo cartQty(); ?></span>
        </button>
        <form class="search-box" method="get" action="#menu">
          <input type="text" name="search" placeholder="Tìm kiếm sản phẩm..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>" />
          <button class="search-btn" aria-label="Tìm kiếm">
            <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
              <circle cx="9" cy="9" r="7" stroke="#5b4632" stroke-width="2"/>
              <line x1="14.4142" y1="14" x2="18" y2="17.5858" stroke="#5b4632" stroke-width="2" stroke-linecap="round"/>
            </svg>
          </button>
        </form>
        <?php if (isset($_SESSION['user'])): ?>
          <form method="post" style="display:inline;">
            <button class="login-btn" type="submit" name="logout">Đăng xuất</button>
          </form>
        <?php else: ?>
          <button class="login-btn" onclick="window.location='auth.php'">Đăng nhập</button>
          <button class="register-btn" onclick="window.location='auth.php'">Đăng ký</button>
        <?php endif; ?>
      </div>
    </div>
  </nav>

  <header class="hero" id="top">
      <div class="hero-track">
        <div class="slide active"><img alt="Hero 1" src="images/slideshow_1.png" loading="lazy"></div>
        <div class="slide"><img alt="Hero 2" src="images/slideshow_2.png" loading="lazy"></div>
        <button class="hero-arrow left" id="heroPrev" aria-label="Prev">‹</button>
        <button class="hero-arrow right" id="heroNext" aria-label="Next">›</button>
      </div>
      <div class="hero-copy">
        <h1>Cake & Matcha – Mùa Hè Ngon Lành</h1>
        <p>Bánh Entremet cảm hứng Pháp, kết hợp hương vị trái cây nhiệt đới Việt Nam.</p>
      </div>
      <div class="dots"><span class="dot active"></span></div>
  </header>

  <section class="cats" id="uu-dai">
    <div class="container">
      <div class="cat-grid">
        <article class="card">
          <img src="images/banner_img1.jpg" alt="Bánh sinh nhật">
          <h3>BÁNH SINH NHẬT</h3>
        </article>
        <article class="card">
          <img src="images/banner_img2.jpg" alt="Bánh lẻ">
          <h3>BÁNH LẺ</h3>
        </article>
        <article class="card">
          <img src="images/banner_img3.jpg" alt="Bánh theo set">
          <h3>GIFTSET</h3>
        </article>
      </div>
    </div>
</section>

  <section class="section" id="menu">
    <div class="container">
      <h2 class="title">MENU</h2>
      <div class="menu-grid">
        <!-- Chỉ giữ sản phẩm từ database -->
        <?php while ($row = $products->fetch_assoc()): ?>
          <article class="item">
            <div class="thumb">
              <a href="product.php?id=<?php echo $row['id']; ?>">
                <img src="<?php echo htmlspecialchars($row['img']); ?>" alt="<?php echo htmlspecialchars($row['name']); ?>">
              </a>
            </div>
            <div class="info">
              <div class="name"><?php echo htmlspecialchars($row['name']); ?></div>
              <p><?php echo htmlspecialchars($row['description']); ?></p>
              <div class="price"><?php echo number_format($row['price'], 0, ',', '.') . '₫'; ?></div>
              <div style="display:flex;gap:10px;flex-wrap:wrap;">
                <!-- Đặt ngay -->
                <form method="post" action="order.php" style="flex:1;min-width:180px;max-width:220px;display:flex;flex-direction:column;gap:8px;">
                  <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                  <input type="hidden" name="name" value="<?php echo htmlspecialchars($row['name']); ?>">
                  <input type="hidden" name="img" value="<?php echo htmlspecialchars($row['img']); ?>">
                  <input type="hidden" name="price" value="<?php echo $row['price']; ?>">
                  <input type="hidden" name="qty" value="1">
                  <input type="text" name="note" placeholder="Ghi chú (tuỳ chọn)" style="padding:6px;border-radius:8px;border:1px solid #e0d3c2;">
                  <button type="submit" class="btn" style="width:100%;">Đặt ngay</button>
                </form>
                <!-- Giỏ hàng -->
                <form method="post" action="cart.php" style="flex:1;min-width:180px;max-width:220px;display:flex;flex-direction:column;gap:8px;">
                  <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                  <input type="hidden" name="name" value="<?php echo htmlspecialchars($row['name']); ?>">
                  <input type="hidden" name="img" value="<?php echo htmlspecialchars($row['img']); ?>">
                  <input type="hidden" name="price" value="<?php echo $row['price']; ?>">
                  <input type="hidden" name="qty" value="1">
                  <input type="text" name="note" placeholder="Ghi chú (tuỳ chọn)" style="padding:6px;border-radius:8px;border:1px solid #e0d3c2;">
                  <button type="submit" name="add_to_cart" class="btn" style="width:100%;">Giỏ hàng</button>
                </form>
              </div>
            </div>
          </article>
        <?php endwhile; ?>
      </div>
    </div>
  </section>
  <!-- Large banners removed to keep a single hero banner -->

  <section class="section" id="ve-chung-toi" style="background:#fff7ee">
    <div class="container about">
      <img src="images/18deeb16-2376-4364-8ab6-a6dda02aeeca.png" alt="About Us">
      <div>
        <h3>A PIECE OF CAKE, A PART OF WHOLE LIFE</h3>
        <p>Artemis Pastry ra đời với niềm đam mê mang đến những chiếc bánh Entremet cấu kỳ
        của ẩm thực Pháp, kết hợp tinh tế hương vị nhiệt đới Việt Nam. Chúng tôi trân trọng trải nghiệm vị giác tinh tế và độc đáo.</p>
        <p>Như một biểu tượng của sự gắn kết, mỗi miếng bánh là một phần của ký ức.
        Cùng sẻ chia và lưu giữ khoảnh khắc đáng nhớ trong cuộc sống.</p>
        <a class="btn" href="#lien-he">Đặt bánh ngay</a>
      </div>
    </div>
  </section>

  <footer id="lien-he">
    <div class="container foot">
      <div>
        <h4 style="margin:0 0 8px">Mizuki’s Cakes</h4>
        <p>20 Ngô Quyền, Hoàn Kiếm, Hà Nội<br/>
           67 Văn Cao, Ba Đình, Hà Nội<br/>
           </p>
        <p>PRE-ORDER: <a href="tel:0325325946">0325325946</a><br/>
           Email: <a href="mail:20221046@eaut.edu.vn">20221046@eaut.edu.vn</a></p>
      </div>
      <div>
        <h4 style="margin:0 0 8px">MẠNG XÃ HỘI</h4>
        <p><a target="_blank">Facebook</a> • <a target="_blank">Instagram</a> • <a target="_blank">TikTok</a></p>
        <p>Giờ mở cửa: 09:00 – 21:00</p>
        <a class="btn" href="#menu">Xem menu</a>
      </div>
    </div>
    <div class="copy">A PIECE OF CAKE, A PART OF WHOLE LIFE – Bánh Sẻ Chia, Trọn Cuộc Sống</div>
  </footer>

  <a class="phone" href="tel:2022104620221062" aria-label="Gọi đặt bánh">☎</a>

</body>
</html>
<script>
  (function(){
    const slides = document.querySelectorAll('.hero .slide');
    const prev = document.getElementById('heroPrev');
    const next = document.getElementById('heroNext');
    let idx = 0;
    function show(i){
      slides.forEach(s => s.classList.remove('active'));
      slides[i].classList.add('active');
    }
    function nextSlide(){ idx = (idx+1) % slides.length; show(idx); }
    function prevSlide(){ idx = (idx-1 + slides.length) % slides.length; show(idx); }
    let t = setInterval(nextSlide,3000);
    function resetTimer(){ clearInterval(t); t = setInterval(nextSlide,3000); }
    next.addEventListener('click', ()=>{ nextSlide(); resetTimer(); });
    prev.addEventListener('click', ()=>{ prevSlide(); resetTimer(); });
    window.addEventListener('load', ()=> show(0));
  })();
</script>
