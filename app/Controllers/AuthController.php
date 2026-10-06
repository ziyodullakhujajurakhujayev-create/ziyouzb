<?php

class AuthController extends Controller
{
    public function loginPage(): void
    {
        if ($this->user) {
            redirect('/dashboard');
        }

        $this->render('auth.login', [
            'pageTitle' => 'Kirish',
        ]);
    }

    public function login(): void
    {
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        if ($username === '' || $password === '') {
            $this->setFlash('error', 'Username va parolni to‘liq kiriting.');
            redirect('/login');
        }

        $userModel = new UserModel();
        $user = $userModel->authenticate($username, $password);

        if (!$user) {
            $this->setFlash('error', 'Noto‘g‘ri login yoki parol.');
            redirect('/login');
        }

        $_SESSION['user'] = [
            'id' => $user['id'],
            'username' => $user['username'],
            'full_name' => $user['full_name'],
            'role' => $user['role'],
            'email' => $user['email'],
        ];

        $erp = new ErpModel();
        $erp->addAuditLog('login', 'User logged in: ' . $user['username'], (int) $user['id']);

        redirect('/dashboard');
    }

    public function logout(): void
    {
        session_unset();
        session_destroy();
        redirect('/login');
    }
}
