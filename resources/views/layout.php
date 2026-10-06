<?php

$flash = $_SESSION['flash'] ?? [];
$_SESSION['flash'] = [];

$nav = [
    ['label' => 'Dashboard', 'url' => '/dashboard'],
    ['label' => 'Xomashyo', 'url' => '/inventory'],
    ['label' => 'Ishlab chiqarish', 'url' => '/production'],
    ['label' => 'Sifat', 'url' => '/quality'],
    ['label' => 'Ombor', 'url' => '/warehouse'],
    ['label' => 'Rulonlar', 'url' => '/rolls'],
    ['label' => 'Hisobotlar', 'url' => '/reports'],
];
?>
<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($pageTitle ?? 'LUX YAN TEX ERP') ?></title>
    <link rel="stylesheet" href="/assets/css/app.css">
</head>
<body>
<?php if (!empty($this->user ?? null)): ?>
    <header class="navbar">
        <div class="logo">LUX YAN TEX ERP</div>
        <div class="topbar">
            <span><?= e($this->user['full_name'] ?? $this->user['username']) ?> (<?= e($this->user['role']) ?>)</span>
            <a href="/logout">Chiqish</a>
        </div>
    </header>

    <div class="main-layout">
        <aside class="sidebar">
            <div class="menu">
                <?php foreach ($nav as $item): ?>
                    <a class="<?= ($_SERVER['REQUEST_URI'] ?? '/') === $item['url'] ? 'active' : '' ?>" href="<?= e($item['url']) ?>"><?= e($item['label']) ?></a>
                <?php endforeach; ?>
            </div>
        </aside>

        <main class="content">
            <?php foreach ($flash as $message): ?>
                <div class="flash <?= e($message['type']) ?>"><?= e($message['message']) ?></div>
            <?php endforeach; ?>
            <?php require __DIR__ . '/../../' . str_replace('.', '/', $view) . '.php'; ?>
        </main>
    </div>
<?php else: ?>
    <?php require __DIR__ . '/../../' . str_replace('.', '/', $view) . '.php'; ?>
<?php endif; ?>

<script src="/assets/js/app.js"></script>
</body>
</html>
