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
                <a href="/">Back to Home</a>
            </div>
        </div>
    </nav>

    <div class="product-grid" style="margin-top: 40px;">
        <h1 style="color: var(--primary-dark); margin-bottom: 20px;">Comparing Selected Cards</h1>
        
        <div style="display: flex; gap: 20px; overflow-x: auto; padding-bottom: 20px;">
            <?php foreach ($products as $product): ?>
            <article class="product-card" style="flex: 1; min-width: 300px;">
                <div class="card-header">
                    <div class="product-info" style="flex-direction: column; align-items: flex-start; gap: 10px;">
                        <div class="placeholder-logo"><?= htmlspecialchars($product['bankName']) ?></div>
                        <h2 class="product-title"><?= htmlspecialchars($product['title']) ?></h2>
                    </div>
                </div>
                
                <div class="card-body" style="flex-direction: column; gap: 20px;">
                    <?php foreach ($product['highlights'] as $label => $value): ?>
                    <div class="feature-col">
                        <span class="feature-label"><?= htmlspecialchars($label) ?></span>
                        <strong class="feature-value"><?= htmlspecialchars($value) ?></strong>
                    </div>
                    <?php endforeach; ?>
                </div>

                <div class="card-actions">
                    <button class="btn-apply" style="width: 100%;">Apply Now</button>
                </div>
                
                <?php if (!empty($product['promoText'])): ?>
                <div class="promo-banner" style="font-size: 0.9rem;">
                    <span class="promo-icon"><?= htmlspecialchars($product['promoIcon']) ?></span>
                    <span class="promo-text"><?= htmlspecialchars($product['promoText']) ?></span>
                </div>
                <?php endif; ?>
            </article>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>
