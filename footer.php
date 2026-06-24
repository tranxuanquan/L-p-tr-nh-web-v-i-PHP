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
        <a class="btn" href="index.php#menu">Xem menu</a>
      </div>
    </div>
    <div class="copy">A PIECE OF CAKE, A PART OF WHOLE LIFE – Bánh Sẻ Chia, Trọn Cuộc Sống</div>
  </footer>
  <a class="phone" href="tel:2022104620221062" aria-label="Gọi đặt bánh">☎</a>
  <?php if (!empty($pageScripts) && is_array($pageScripts)): ?>
    <?php foreach ($pageScripts as $script): ?>
      <script src="<?php echo htmlspecialchars($script); ?>"></script>
    <?php endforeach; ?>
  <?php endif; ?>
</body>
</html>
