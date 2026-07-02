<?php
session_start();
$cart_count = isset($_SESSION['cart']) ? array_sum(array_column($_SESSION['cart'], 'qty')) : 0;
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Midnight Blue Melhfa — Nomad Spirit Store</title>
  <meta name="description"
    content="Discover our elegant Midnight Blue Melhfa. Adapts to all body types, celebrating Sahrawi cultural heritage.">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300&family=Jost:wght@300;400;500&display=swap"
    rel="stylesheet">
  <link rel="stylesheet" href="assets/css/style.css?v=<?php echo time(); ?>">
</head>

<body>

  <!-- ═══════════════════════════════════════════════════════ NAVIGATION -->
  <header class="site-header">
    <nav class="navbar">
      <a href="index.php" class="nav-logo">Nomad<em>Spirit</em> Store</a>

      <ul class="nav-links">
        <li><a href="index.php">Home</a></li>
        <li><a href="category.php?slug=women">Women</a></li>
        <li><a href="category.php?slug=men">Men</a></li>
        <li><a href="category.php?slug=heritage">Heritage</a></li>
      </ul>

      <div class="nav-actions">
        <a href="cart.php" class="cart-btn">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
            <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z" />
            <line x1="3" y1="6" x2="21" y2="6" />
            <path d="M16 10a4 4 0 0 1-8 0" />
          </svg>
          Cart
          <?php if ($cart_count > 0): ?>
            <span class="cart-badge"><?= $cart_count ?></span>
          <?php endif; ?>
        </a>
      </div>
    </nav>
  </header>

  <!-- ═══════════════════════════════════════════════════════ PRODUCT DETAILS -->
  <section class="section product-details">
    <div class="product-grid">
      <!-- Gallery -->
      <div class="product-gallery">
        <div class="main-image">
          <div class="placeholder-img"
            style="background:#F7F7F7; border: 1px solid rgba(0,0,0,0.08); width:100%; height:550px; border-radius:4px; display:flex; align-items:center; justify-content:center; color:var(--deep); font-family:var(--font-display); font-style:italic;">
            Embroidery Detail</div>
        </div>
        <div class="thumb-list" style="display:flex; gap:10px; margin-top:10px;">
          <div class="thumb"
            style="background:#F9F9F9; border: 1px solid rgba(0,0,0,0.06); width:33%; height:120px; border-radius:4px; display:flex; align-items:center; justify-content:center; color:var(--deep); font-size:0.8rem; cursor:pointer;">
            Detail</div>
          <div class="thumb"
            style="background:#F4F4F4; border: 1px solid rgba(0,0,0,0.06); width:33%; height:120px; border-radius:4px; display:flex; align-items:center; justify-content:center; color:var(--deep); font-size:0.8rem; cursor:pointer;">
            Back View</div>
          <div class="thumb"
            style="background:#F0F0F0; border: 1px solid rgba(0,0,0,0.06); width:33%; height:120px; border-radius:4px; display:flex; align-items:center; justify-content:center; color:var(--deep); font-size:0.8rem; cursor:pointer;">
            Fabric Folds</div>
        </div>
      </div>

      <div class="product-info">
        <div class="product-breadcrumb"
          style="font-size:0.7rem; color:var(--muted); letter-spacing:0.1em; text-transform:uppercase; margin-bottom:1rem;">
          Home / Women / Melhfas
        </div>
        <h1 class="product-title"
          style="font-family:var(--font-display); font-size:2.8rem; color:var(--deep); line-height:1.1; margin-bottom:0.5rem;">
          Midnight Blue Melhfa</h1>
        <div class="product-price"
          style="font-family:var(--font-display); font-size:1.8rem; color:var(--terracotta); margin-bottom:2rem;">$220
        </div>

       
        <div class="product-colors" style="margin-bottom:1.5rem;">
          <span
            style="display:block; font-size:0.75rem; letter-spacing:0.1em; text-transform:uppercase; color:var(--deep); margin-bottom:0.5rem; font-weight:500;">Select
            Color: <span style="color:var(--muted); font-weight:normal;" id="colorLabel">Midnight Blue</span></span>
          <div style="display:flex; gap:0.5rem;">
            <div class="color-swatch"
              style="width:28px; height:28px; border-radius:50%; background:#1E2A3E; cursor:pointer; border:2px solid var(--gold); outline:1px solid #fff; outline-offset:-3px;">
            </div>
            <div class="color-swatch"
              style="width:28px; height:28px; border-radius:50%; background:#2A2A2A; cursor:pointer; border:1px solid var(--border);">
            </div>
            <div class="color-swatch"
              style="width:28px; height:28px; border-radius:50%; background:#DDC499; cursor:pointer; border:1px solid var(--border);">
            </div>
          </div>
        </div>

        
        <div class="product-size" style="margin-bottom:2.5rem;">
          <span
            style="display:block; font-size:0.75rem; letter-spacing:0.1em; text-transform:uppercase; color:var(--deep); margin-bottom:0.5rem; font-weight:500;">Size:</span>
          <div
            style="display:inline-block; border:1px solid var(--gold); color:var(--gold-dark); padding:0.6rem 1.2rem; font-size:0.8rem; letter-spacing:0.1em; text-transform:uppercase; border-radius:4px; font-weight:500;">
            One Size</div>
          <div style="font-size:0.8rem; color:var(--muted); margin-top:0.6rem; font-style:italic;">* Melhfa adapts to
            all body types</div>
        </div>

        <button class="add-to-cart-btn btn-primary"
          style="width:100%; border-radius:4px; padding:1.2rem; display:flex; align-items:center; justify-content:center; gap:0.75rem; position:relative; overflow:hidden; z-index:1;">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z" />
            <line x1="3" y1="6" x2="21" y2="6" />
            <path d="M16 10a4 4 0 0 1-8 0" />
          </svg>
          Add to Cart
        </button>

        <div class="product-description"
          style="margin-top:3rem; font-family:var(--font-accent); color:var(--muted); line-height:1.8; font-size:1.15rem;">
          <p>A flowing four-meter masterpiece of Sahrawi heritage. Woven with delicate breathability for the desert sun,
            and dyed in the rich indigo reminiscent of deep nomadic nights.</p>
        </div>

        <div class="product-review"
          style="margin-top:2.5rem; background:var(--card-bg); border:1px solid var(--border); padding:1.5rem; border-radius:4px;">
          <div class="stars" style="color:var(--gold); margin-bottom:0.8rem;">★★★★★</div>
          <p
            style="font-style:italic; font-family:var(--font-display); color:var(--deep); font-size:1.1rem; line-height:1.5; margin-bottom:0.8rem;">
            "I feel connected to my roots. The fabric feels incredible and drapes perfectly."</p>
          <div style="font-size:0.75rem; letter-spacing:0.1em; text-transform:uppercase; color:var(--muted);">— Fatima,
            Laayoune</div>
        </div>

      </div>
    </div>
  </section>

  <!-- ═══════════════════════════════════════════════════════ FOOTER -->
  <footer class="site-footer">
    <div class="footer-top">
      <div class="footer-brand">
        <a href="index.php" class="footer-logo">Nomad<em>Spirit</em> Store</a>
        <p>Bridging the ancient art of Sahrawi craftsmanship with the modern world. Every thread tells a story.</p>
      </div>
    </div>
  </footer>

  <style>
    .product-grid {
      display: grid;
      grid-template-columns: 1.1fr 0.9fr;
      gap: 4rem;
    }

    @media (max-width: 900px) {
      .product-grid {
        grid-template-columns: 1fr;
        gap: 2rem;
      }
    }

    .add-to-cart-btn::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.25), transparent);
      transition: all 0.5s ease;
      z-index: -1;
    }

    .add-to-cart-btn:hover::before {
      left: 100%;
      transition: all 0.6s ease;
    }
  </style>

  <script>
    const thumbs = document.querySelectorAll('.thumb');
    thumbs.forEach(el => {
      el.addEventListener('click', () => {
        alert('Swapping to: ' + el.innerText);
      });
    });
    
    const swatches = document.querySelectorAll('.color-swatch');
    const label = document.getElementById('colorLabel');
    const colorNames = ['Midnight Blue', 'Deep Black', 'Desert Sand'];

    swatches.forEach((swatch, idx) => {
      swatch.addEventListener('click', () => {
        swatches.forEach(s => { s.style.border = '1px solid var(--border)'; s.style.outline = 'none'; });
        swatch.style.border = '2px solid var(--gold)';
        swatch.style.outline = '1px solid #fff';
        label.innerText = colorNames[idx];
      });
    });
  </script>
</body>

</html>