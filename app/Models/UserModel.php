<?php

class UserModel
{
    private Database $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function findByUsername(string $username): ?array
    {
        return $this->db->fetch(
            'SELECT * FROM users WHERE username = :username LIMIT 1',
            ['username' => $username]
        );
    }

    public function allUsers(): array
    {
        return $this->db->fetchAll('SELECT * FROM users ORDER BY created_at DESC');
    }

    public function authenticate(string $username, string $password): ?array
    {
        $user = $this->findByUsername($username);

        if (!$user || !password_verify($password, $user['password_hash'])) {
            return null;
        }

        return $user;
    }
}
