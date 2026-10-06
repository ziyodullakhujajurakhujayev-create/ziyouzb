CREATE DATABASE IF NOT EXISTS lux_yan_tex_erp CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE lux_yan_tex_erp;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(120) NOT NULL UNIQUE,
    email VARCHAR(180) NOT NULL UNIQUE,
    full_name VARCHAR(180) NOT NULL,
    role ENUM('admin','manager','operator','qc','warehouse','production') NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE raw_materials (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    supplier VARCHAR(180) DEFAULT NULL,
    stock_level DECIMAL(12,2) NOT NULL DEFAULT 0,
    reorder_level DECIMAL(12,2) NOT NULL DEFAULT 0,
    unit VARCHAR(30) NOT NULL DEFAULT 'kg',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE warehouse_inventory (
    id INT AUTO_INCREMENT PRIMARY KEY,
    material_name VARCHAR(150) NOT NULL,
    stock_quantity DECIMAL(12,2) NOT NULL DEFAULT 0,
    unit VARCHAR(30) NOT NULL DEFAULT 'kg',
    location VARCHAR(150) NOT NULL,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE production_orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_number VARCHAR(120) NOT NULL UNIQUE,
    product_name VARCHAR(180) NOT NULL,
    quantity DECIMAL(12,2) NOT NULL DEFAULT 0,
    status ENUM('new','in_progress','completed','delayed') NOT NULL DEFAULT 'new',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE rolls (
    id INT AUTO_INCREMENT PRIMARY KEY,
    roll_number VARCHAR(120) NOT NULL UNIQUE,
    batch_code VARCHAR(120) NOT NULL,
    qr_code VARCHAR(200) NOT NULL UNIQUE,
    material_name VARCHAR(150) NOT NULL,
    length_m DECIMAL(10,2) NOT NULL DEFAULT 0,
    width_cm DECIMAL(10,2) NOT NULL DEFAULT 0,
    weight_kg DECIMAL(10,2) NOT NULL DEFAULT 0,
    status ENUM('active','hold','quality_review','shipped') NOT NULL DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE quality_checks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    roll_number VARCHAR(120) NOT NULL,
    inspector_name VARCHAR(150) NOT NULL,
    result ENUM('pass','fail','pending') NOT NULL DEFAULT 'pending',
    notes TEXT,
    checked_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE defects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    defect_name VARCHAR(180) NOT NULL,
    defect_type VARCHAR(120) NOT NULL,
    severity ENUM('low','medium','high','critical') NOT NULL DEFAULT 'medium',
    affected_roll VARCHAR(120) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE operators (
    id INT AUTO_INCREMENT PRIMARY KEY,
    employee_name VARCHAR(180) NOT NULL,
    shift_name VARCHAR(120) NOT NULL,
    role_name VARCHAR(120) NOT NULL,
    productivity DECIMAL(5,2) NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE alerts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(180) NOT NULL,
    message TEXT NOT NULL,
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE audit_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL DEFAULT 0,
    action VARCHAR(180) NOT NULL,
    details TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE INDEX idx_users_role ON users(role);
CREATE INDEX idx_raw_materials_name ON raw_materials(name);
CREATE INDEX idx_rolls_status ON rolls(status);
CREATE INDEX idx_quality_checks_result ON quality_checks(result);
CREATE INDEX idx_audit_logs_created_at ON audit_logs(created_at);
