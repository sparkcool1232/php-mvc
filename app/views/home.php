<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title) ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <nav class="navbar">
        <div class="nav-container">
            <div class="logo">
                <div class="logo-circle"></div>
                <span class="logo-text">FinanceSmart</span>
            </div>
            <div class="nav-links">
                <a href="#">Credit Cards</a>
                <a href="#">Loans</a>
                <a href="#">Insurance</a>
                <?php if(isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                    <a href="/admin" style="color: red;">Admin Panel</a>
                <?php endif; ?>
            </div>
            <div class="nav-actions">
                <?php if(isset($_SESSION['username'])): ?>
                    <a href="/profile" style="margin-right: 15px; color: var(--primary-dark); font-weight: bold; text-decoration: none;">Hi, <?= htmlspecialchars($_SESSION['username']) ?></a>
                    <a href="/logout" class="btn-login" style="text-decoration: none;">Logout</a>
                <?php else: ?>
                    <a href="/login" class="btn-login" style="text-decoration: none;">Login</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <header class="hero">
        <div class="hero-content">
            <h1>Find the Best Financial Products</h1>
            <p>Compare credit cards, loans, and insurance plans via PHP MVC.</p>
        </div>
    </header>

    <form action="/compare" method="GET">
        <main class="product-grid">
            <div style="display: flex; justify-content: flex-end; margin-bottom: -15px;">
                <button type="submit" class="btn-apply" style="padding: 10px 24px;">Compare Selected</button>
            </div>
            <?php foreach ($products as $product): ?>
            <article class="product-card">
                <div class="card-header">
                    <div class="product-info">
                        <div class="placeholder-logo"><?= htmlspecialchars($product['bankName']) ?></div>
                        <h2 class="product-title"><?= htmlspecialchars($product['title']) ?></h2>
                    </div>
                    <div class="compare-action">
                        <label class="compare-label">
                            <input type="checkbox" name="product_ids[]" value="<?= $product['id'] ?>"> Add to compare
                        </label>
                    </div>
                </div>
            
            <div class="card-body">
                <?php foreach ($product['highlights'] as $label => $value): ?>
                <div class="feature-col">
                    <span class="feature-label"><?= htmlspecialchars($label) ?></span>
                    <strong class="feature-value"><?= htmlspecialchars($value) ?></strong>
                </div>
                <?php endforeach; ?>
            </div>

            <?php if (!empty($product['promoText'])): ?>
            <div class="promo-banner">
                <span class="promo-icon"><?= htmlspecialchars($product['promoIcon']) ?></span>
                <span class="promo-text"><?= htmlspecialchars($product['promoText']) ?></span>
            </div>
            <?php endif; ?>
        </article>
        <?php endforeach; ?>
    </main>
    </form>

    <footer class="site-footer">
        <div class="footer-bottom">
            <p>&copy; 2026 PHP MVC Finance Clone</p>
        </div>
    </footer>

    <!-- Chat Widget Bubble -->
    <div class="chat-bubble-wrapper" style="position: fixed; bottom: 30px; right: 30px; z-index: 1001; display: flex; align-items: center; gap: 15px;">
        <span class="chat-tooltip" style="background: white; padding: 8px 16px; border-radius: 20px; font-weight: 600; font-size: 0.9rem; box-shadow: 0 4px 12px rgba(0,0,0,0.15); color: var(--primary-dark); opacity: 0; transform: translateX(10px); transition: all 0.3s ease; pointer-events: none; white-space: nowrap;">Chat with us</span>
        <div id="chat-bubble" style="width: 65px; height: 65px; background: var(--accent-teal); border-radius: 50%; box-shadow: 0 6px 16px rgba(0,0,0,0.25); cursor: pointer; display: flex; justify-content: center; align-items: center; transition: transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);">
            <svg fill="white" width="30" height="30" viewBox="0 0 24 24"><path d="M20 2H4C2.9 2 2 2.9 2 4V22L6 18H20C21.1 18 22 17.1 22 16V4C22 2.9 21.1 2 20 2Z"></path></svg>
        </div>
    </div>

    <!-- Chat Widget Window -->
    <div id="chat-window" style="display: none; position: fixed; bottom: 110px; right: 30px; width: 350px; background: white; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.2); border: 1px solid var(--border-color); z-index: 1000; overflow: hidden; flex-direction: column; animation: fadeUp 0.3s ease-out;">
        <div style="background: var(--primary-dark); color: white; padding: 15px; font-weight: bold; display: flex; justify-content: space-between; align-items: center;">
            <div style="display: flex; align-items: center; gap: 10px;">
                <div style="width: 10px; height: 10px; background: #22c55e; border-radius: 50%;"></div>
                Customer Service
            </div>
            <button id="chat-close" style="background: none; border: none; color: white; cursor: pointer; font-size: 1.5rem; line-height: 1;">&times;</button>
        </div>
        <div id="chat-messages" style="height: 320px; overflow-y: auto; padding: 15px; font-size: 0.95rem; display: flex; flex-direction: column; gap: 12px; background: #f8fafc;">
            <!-- Messages load here via JS -->
        </div>
        <form id="chat-form" style="display: flex; border-top: 1px solid var(--border-color); padding: 12px; background: white;">
            <input type="text" id="chat-input" placeholder="Write a message..." style="flex: 1; padding: 12px; border: 1px solid var(--border-color); border-radius: 20px; outline: none; font-family: inherit;">
            <button type="submit" style="background: var(--accent-teal); color: white; border: none; padding: 0 18px; margin-left: 10px; border-radius: 20px; cursor: pointer; font-weight: 600; transition: background 0.2s;">Send</button>
        </form>
    </div>
    <style>
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .chat-bubble-wrapper:hover .chat-tooltip {
            opacity: 1;
            transform: translateX(0);
        }
    </style>

    <script src="assets/js/script.js"></script>
</body>
</html>
