<nav class="nav">
  <div class="container nav-inner">
    <div class="brand">
      <a href="index.php" class="brand-link">Mizuki’s Cakes</a>
    </div>
    <div class="menu">
      <a href="index.php#uu-dai">Ưu đãi</a>
      <a href="index.php#menu">Menu</a>
      <a href="index.php#ve-chung-toi">Về chúng tôi</a>
      <a class="cta" href="index.php#lien-he">Đặt bánh</a>
      <button class="cart-btn" aria-label="Giỏ hàng" onclick="window.location='cart.php'">
        <svg width="26" height="26" viewBox="0 0 24 24" fill="none">
          <circle cx="9" cy="21" r="1.5" fill="#b48d61"/>
          <circle cx="18" cy="21" r="1.5" fill="#b48d61"/>
          <path d="M3 5h2l1.68 10.39A2 2 0 0 0 8.65 17h7.7a2 2 0 0 0 1.97-1.61L21 7H6" stroke="#b48d61" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        <span class="cart-badge"><?php echo cartQty(); ?></span>
      </button>
      <form class="search-box" method="get" action="index.php#menu">
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
