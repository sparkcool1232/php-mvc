<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Dashboard - Profile</title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { background: #f8fafc; }
        .profile-header {
            display: flex; align-items: center; gap: 30px; margin-bottom: 40px; padding-bottom: 30px; border-bottom: 1px solid var(--border-color);
        }
        .avatar-container {
            position: relative; width: 120px; height: 120px; border-radius: 50%; overflow: hidden; border: 4px solid white; box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .avatar-container img {
            width: 100%; height: 100%; object-fit: cover;
        }
        .upload-overlay {
            position: absolute; bottom: 0; left: 0; right: 0; background: rgba(0,0,0,0.6); color: white; text-align: center; font-size: 0.8rem; padding: 6px 0; cursor: pointer; transition: background 0.2s; font-weight: 500; text-transform: uppercase;
        }
        .upload-overlay:hover { background: var(--accent-teal); }
        .data-card {
            background: white; border: 1px solid var(--border-color); border-radius: 12px; padding: 25px; box-shadow: 0 4px 6px rgba(0,0,0,0.02);
        }
    </style>
</head>
<body style="padding: 40px; max-width: 1000px; margin: 0 auto;">
    
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <h1 style="color: var(--primary-dark); font-size: 2rem; margin: 0;">User Dashboard</h1>
        <div>
            <a href="/" class="more-details" style="margin-right: 20px;">Back to Home</a>
            <a href="/logout" class="btn-login">Logout</a>
        </div>
    </div>

    <div class="product-card" style="padding: 40px; margin-bottom: 30px; box-shadow: 0 10px 25px rgba(0,0,0,0.05);">
        
        <!-- Header & Avatar Upload -->
        <div class="profile-header">
            <form action="/profile/avatar" method="POST" enctype="multipart/form-data" id="avatar-form">
                <div class="avatar-container" onclick="document.getElementById('avatar-input').click()">
                    <!-- If upload fails or is default, ui-avatars generates a nice letter icon -->
                    <img src="/assets/uploads/<?= htmlspecialchars($user['avatar'] ?? 'default.png') ?>" alt="Avatar" onerror="this.src='https://ui-avatars.com/api/?name=<?= urlencode($user['username']) ?>&background=00A388&color=fff&size=120'">
                    <div class="upload-overlay">Change</div>
                </div>
                <input type="file" id="avatar-input" name="avatar" style="display: none;" accept="image/*" onchange="document.getElementById('avatar-form').submit()">
            </form>
            <div>
                <h2 style="font-size: 2.2rem; margin: 0; color: var(--primary-dark);"><?= htmlspecialchars($user['username']) ?></h2>
                <div style="margin-top: 10px; display: flex; gap: 10px;">
                    <span style="background: var(--accent-teal); color: white; padding: 4px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: bold; text-transform: uppercase;">
                        <?= htmlspecialchars($user['role']) ?> Role
                    </span>
                    <span style="background: #e2e8f0; color: #475569; padding: 4px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 500;">
                        Member since <?= date('M Y', strtotime($user['created_at'])) ?>
                    </span>
                </div>
            </div>
        </div>

        <div style="display: flex; gap: 40px;">
            <!-- Left Column: Secure Details -->
            <div style="flex: 1;">
                <h3 style="color: var(--primary-dark); margin-bottom: 20px; display: flex; align-items: center; gap: 10px; font-size: 1.2rem;">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="var(--accent-teal)" stroke-width="2.5"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                    Encrypted Private Data
                </h3>
                
                <div class="data-card">
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-size: 0.75rem; font-weight: bold; color: var(--text-muted); text-transform: uppercase; margin-bottom: 6px; letter-spacing: 0.5px;">Decrypted NRIC/FIN</label>
                        <div style="font-size: 1.1rem; color: #1e293b;"><?= htmlspecialchars($user['ic_number']) ?: '<em style="color: #94a3b8;">Not provided</em>' ?></div>
                    </div>
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-size: 0.75rem; font-weight: bold; color: var(--text-muted); text-transform: uppercase; margin-bottom: 6px; letter-spacing: 0.5px;">Birthdate</label>
                        <div style="font-size: 1.1rem; color: #1e293b;"><?= htmlspecialchars($user['birthdate']) ?: '<em style="color: #94a3b8;">Not provided</em>' ?></div>
                    </div>
                    <div>
                        <label style="display: block; font-size: 0.75rem; font-weight: bold; color: var(--text-muted); text-transform: uppercase; margin-bottom: 6px; letter-spacing: 0.5px;">Decrypted Home Address</label>
                        <div style="font-size: 1.1rem; color: #1e293b; line-height: 1.5;"><?= htmlspecialchars($user['address']) ?: '<em style="color: #94a3b8;">Not provided</em>' ?></div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Chat History -->
            <div style="flex: 1.5;">
                <h3 style="color: var(--primary-dark); margin-bottom: 20px; display: flex; align-items: center; gap: 10px; font-size: 1.2rem;">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="var(--accent-teal)" stroke-width="2.5"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
                    My Chat History
                </h3>
                
                <div style="display: flex; flex-direction: column; gap: 15px; max-height: 400px; overflow-y: auto; padding-right: 10px;">
                    <?php foreach ($chats as $chat): ?>
                        <div class="data-card" style="padding: 15px;">
                            <div style="font-size: 0.8rem; color: #94a3b8; margin-bottom: 8px; font-weight: 500;"><?= date('M j, Y, g:i a', strtotime($chat['created_at'])) ?></div>
                            <div style="color: #334155; line-height: 1.6;"><?= htmlspecialchars($chat['message']) ?></div>
                        </div>
                    <?php endforeach; ?>
                    
                    <?php if(empty($chats)): ?>
                        <div style="text-align: center; padding: 40px; color: var(--text-muted); background: white; border-radius: 12px; border: 2px dashed #e2e8f0;">
                            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#cbd5e1" stroke-width="2" style="margin-bottom: 10px;"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg><br>
                            You haven't participated in the community chat yet.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
