<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - FinanceSmart</title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body style="display: flex; justify-content: center; align-items: center; height: 100vh;">
    <div class="product-card" style="padding: 40px; width: 400px; text-align: center;">
        <h1 style="color: var(--primary-dark); margin-bottom: 20px;">Login</h1>
        <?php if(isset($error)): ?><p style="color: red;"><?= $error ?></p><?php endif; ?>
        <form action="/login" method="POST" style="display: flex; flex-direction: column; gap: 15px;">
            <input type="text" name="username" placeholder="Username" required style="padding: 10px; border: 1px solid var(--border-color); border-radius: 4px;">
            <input type="password" name="password" placeholder="Password" required style="padding: 10px; border: 1px solid var(--border-color); border-radius: 4px;">
            <button type="submit" class="btn-apply">Login</button>
        </form>
        <p style="margin-top: 20px;">Don't have an account? <a href="/register" class="more-details">Register</a></p>
    </div>
</body>
</html>
