<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body style="padding: 40px; max-width: 1200px; margin: 0 auto;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 40px;">
        <h1 style="color: var(--primary-dark);">Admin Dashboard</h1>
        <div>
            <a href="/" class="more-details" style="margin-right: 20px;">View Site</a>
            <a href="/logout" class="btn-login">Logout</a>
        </div>
    </div>

    <div style="display: flex; gap: 40px;">
        <div style="flex: 1;" class="product-card">
            <div style="padding: 20px; border-bottom: 1px solid var(--border-color);">
                <h2>Add New Product</h2>
            </div>
            <form action="/admin/add" method="POST" style="display: flex; flex-direction: column; gap: 15px; padding: 20px;">
                <input type="text" name="bank_name" placeholder="Bank Name (e.g. Bank C)" required style="padding: 10px;">
                <input type="text" name="title" placeholder="Card Title" required style="padding: 10px;">
                <input type="text" name="highlight_main" placeholder="Key Highlight" style="padding: 10px;">
                <input type="text" name="annual_fee" placeholder="Annual Fee" style="padding: 10px;">
                <input type="text" name="min_income" placeholder="Minimum Income" style="padding: 10px;">
                <input type="text" name="promo_icon" placeholder="Promo Icon (Emoji)" style="padding: 10px;">
                <input type="text" name="promo_text" placeholder="Promo Text" style="padding: 10px;">
                <button type="submit" class="btn-apply">Add Product</button>
            </form>
        </div>

        <div style="flex: 2;">
            <h2>Manage Existing Products</h2>
            <div style="display: flex; flex-direction: column; gap: 10px; margin-top: 20px;">
                <?php foreach ($products as $product): ?>
                <div class="product-card" style="display: flex; justify-content: space-between; align-items: center; padding: 15px;">
                    <div>
                        <strong><?= htmlspecialchars($product['bankName']) ?></strong> - <?= htmlspecialchars($product['title']) ?>
                    </div>
                    <div style="display: flex; gap: 10px;">
                        <a href="/admin/edit/<?= $product['id'] ?>" style="background: var(--accent-teal); color: white; text-decoration: none; padding: 8px 15px; border-radius: 4px; font-size: 0.9rem;">Edit</a>
                        <form action="/admin/delete/<?= $product['id'] ?>" method="POST" style="margin: 0;" onsubmit="return confirm('Delete this product?');">
                            <button type="submit" style="background: red; color: white; border: none; padding: 8px 15px; border-radius: 4px; cursor: pointer; font-size: 0.9rem;">Delete</button>
                        </form>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Chat Moderation Section -->
    <div style="margin-top: 60px;">
        <h2>Chat Moderation</h2>
        <div style="display: flex; flex-direction: column; gap: 10px; margin-top: 20px; max-height: 400px; overflow-y: auto; background: white; padding: 20px; border-radius: 8px; border: 1px solid var(--border-color);">
            <?php foreach ($messages as $msg): ?>
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 10px; border-bottom: 1px solid #f1f5f9;">
                <div>
                    <strong style="color: var(--primary-dark);"><?= htmlspecialchars($msg['user_name']) ?>:</strong> 
                    <span style="color: var(--text-muted);"><?= htmlspecialchars($msg['message']) ?></span>
                    <div style="font-size: 0.8rem; color: #94a3b8; margin-top: 4px;"><?= htmlspecialchars($msg['created_at']) ?></div>
                </div>
                <form action="/admin/chat/delete/<?= $msg['id'] ?>" method="POST" onsubmit="return confirm('Delete this message?');">
                    <button type="submit" style="background: red; color: white; border: none; padding: 6px 12px; border-radius: 4px; cursor: pointer; font-size: 0.85rem;">Delete</button>
                </form>
            </div>
            <?php endforeach; ?>
            <?php if(empty($messages)): ?>
                <p style="color: var(--text-muted);">No chat messages found.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
