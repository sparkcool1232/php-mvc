<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Product - Admin Dashboard</title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body style="padding: 40px; max-width: 800px; margin: 0 auto;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 40px;">
        <h1 style="color: var(--primary-dark);">Edit Product</h1>
        <a href="/admin" class="btn-login" style="background: var(--text-muted);">Cancel</a>
    </div>

    <div class="product-card">
        <form action="/admin/update/<?= $product['id'] ?>" method="POST" style="display: flex; flex-direction: column; gap: 15px; padding: 30px;">
            <label>Bank Name</label>
            <input type="text" name="bank_name" value="<?= htmlspecialchars($product['bankName']) ?>" required style="padding: 10px; border: 1px solid var(--border-color); border-radius: 4px;">
            
            <label>Card Title</label>
            <input type="text" name="title" value="<?= htmlspecialchars($product['title']) ?>" required style="padding: 10px; border: 1px solid var(--border-color); border-radius: 4px;">
            
            <label>Key Highlight</label>
            <input type="text" name="highlight_main" value="<?= htmlspecialchars($product['highlights']['Key Highlight']) ?>" style="padding: 10px; border: 1px solid var(--border-color); border-radius: 4px;">
            
            <label>Annual Fee</label>
            <input type="text" name="annual_fee" value="<?= htmlspecialchars($product['highlights']['Annual Fee']) ?>" style="padding: 10px; border: 1px solid var(--border-color); border-radius: 4px;">
            
            <label>Minimum Income</label>
            <input type="text" name="min_income" value="<?= htmlspecialchars($product['highlights']['Minimum Income']) ?>" style="padding: 10px; border: 1px solid var(--border-color); border-radius: 4px;">
            
            <label>Promo Icon (Emoji)</label>
            <input type="text" name="promo_icon" value="<?= htmlspecialchars($product['promoIcon']) ?>" style="padding: 10px; border: 1px solid var(--border-color); border-radius: 4px;">
            
            <label>Promo Text</label>
            <input type="text" name="promo_text" value="<?= htmlspecialchars($product['promoText']) ?>" style="padding: 10px; border: 1px solid var(--border-color); border-radius: 4px;">
            
            <button type="submit" class="btn-apply" style="margin-top: 15px;">Save Changes</button>
        </form>
    </div>
</body>
</html>
