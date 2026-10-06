<?php
$sections = [
    'inventory' => 'Xomashyo & Ombor',
    'production' => 'Ishlab chiqarish',
    'quality' => 'Sifat nazorati',
    'warehouse' => 'Ombor boshqaruvi',
    'rolls' => 'Rulonlar',
    'audit' => 'Audit log',
];
?>
<div class="form-card">
    <h2>Kirish</h2>
    <form method="POST" action="/login">
        <label>
            Username
            <input type="text" name="username" placeholder="admin@luxyantex.local" required>
        </label>
        <label>
            Parol
            <input type="password" name="password" placeholder="admin123" required>
        </label>
        <button type="submit" class="btn">Kirish</button>
    </form>

    <div class="card" style="margin-top: 18px;">
        <h4>Demo hisob</h4>
        <p><strong>admin@luxyantex.local</strong> / <strong>admin123</strong></p>
    </div>
</div>
