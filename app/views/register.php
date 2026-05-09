<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register - FinanceSmart</title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body style="display: flex; justify-content: center; align-items: center; height: 100vh;">
    <div class="product-card" style="padding: 40px; width: 400px; text-align: center;">
        <h1 style="color: var(--primary-dark); margin-bottom: 20px;">Register</h1>
        <p style="margin-bottom: 20px; font-size: 0.9rem; color: var(--text-muted);">Tip: Register with username "admin" to test the admin dashboard.</p>
        <?php if(isset($error)): ?><p style="color: red;"><?= $error ?></p><?php endif; ?>
        <form action="/register" method="POST" style="display: flex; flex-direction: column; gap: 15px;">
            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
            <input type="text" name="username" placeholder="Username" required style="padding: 10px; border: 1px solid var(--border-color); border-radius: 4px;">
            <input type="password" name="password" placeholder="Password" required style="padding: 10px; border: 1px solid var(--border-color); border-radius: 4px;">
            
            <hr style="border: 0; border-top: 1px solid var(--border-color); margin: 5px 0;">
            <p style="font-size: 0.9rem; color: var(--primary-dark); font-weight: 600; text-align: left; margin: 0;">Personal Details</p>
            
            <input type="text" name="ic_number" placeholder="NRIC / FIN" required style="padding: 10px; border: 1px solid var(--border-color); border-radius: 4px;">
            <input type="date" name="birthdate" required style="padding: 10px; border: 1px solid var(--border-color); border-radius: 4px; font-family: inherit;">
            <textarea name="address" placeholder="Full Home Address" rows="3" required style="padding: 10px; border: 1px solid var(--border-color); border-radius: 4px; font-family: inherit; resize: vertical;"></textarea>

            <button type="submit" class="btn-apply" style="margin-top: 10px;">Register Account</button>
        </form>
        <p style="margin-top: 20px;">Already have an account? <a href="/login" class="more-details">Login</a></p>
    </div>
</body>
</html>
