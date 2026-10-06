<?php

class Controller
{
    protected Database $db;
    protected ?array $user;

    public function __construct()
    {
        $this->db = Database::getInstance();
        $this->user = $_SESSION['user'] ?? null;
    }

    protected function render(string $view, array $params = []): void
    {
        $pageTitle = $params['pageTitle'] ?? 'LUX YAN TEX ERP';
        $viewFile = __DIR__ . '/../resources/views/' . str_replace('.', '/', $view) . '.php';
        extract($params, EXTR_SKIP);
        require __DIR__ . '/../resources/views/layout.php';
    }

    protected function setFlash(string $type, string $message): void
    {
        $_SESSION['flash'][] = ['type' => $type, 'message' => $message];
    }

    protected function authorize(array $allowedRoles): void
    {
        if (!$this->user) {
            redirect('/login');
        }

        if (!in_array($this->user['role'], $allowedRoles, true)) {
            $this->setFlash('error', 'Sizga ushbu bo‘limga kirish uchun ruxsat yo‘q.');
            redirect('/dashboard');
        }
    }
}
