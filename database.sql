CREATE DATABASE IF NOT EXISTS chickmon;
USE chickmon;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    nama_lengkap VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO users (username, password, nama_lengkap) VALUES 
('admin', '$2y$10$xLmCRwH8Yq5Z3vK9nW0.aOqJ8mN6pR4tU2wX0yB1cD3eF4gH5iJ6kL', 'Administrator');

CREATE TABLE IF NOT EXISTS sensor_data (
    id INT AUTO_INCREMENT PRIMARY KEY,
    suhu FLOAT NOT NULL,
    kelembapan FLOAT NOT NULL,
    gas INT NOT NULL,
    cahaya INT NOT NULL,
    status_suhu VARCHAR(20),
    status_gas VARCHAR(20),
    status_cahaya VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_created_at (created_at)
);

CREATE TABLE IF NOT EXISTS component_status (
    id INT AUTO_INCREMENT PRIMARY KEY,
    kipas_masuk TINYINT(1) DEFAULT 0,
    kipas_keluar TINYINT(1) DEFAULT 0,
    lampu_hangat TINYINT(1) DEFAULT 0,
    lampu_terang TINYINT(1) DEFAULT 0,
    conveyor TINYINT(1) DEFAULT 0,
    buzzer TINYINT(1) DEFAULT 0,
    manual_kipas_masuk TINYINT(1) DEFAULT 0,
    manual_kipas_keluar TINYINT(1) DEFAULT 0,
    manual_lampu_hangat TINYINT(1) DEFAULT 0,
    manual_lampu_terang TINYINT(1) DEFAULT 0,
    manual_conveyor TINYINT(1) DEFAULT 0,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

INSERT INTO component_status (id) VALUES (1);

CREATE TABLE IF NOT EXISTS manual_control (
    id INT AUTO_INCREMENT PRIMARY KEY,
    component_name VARCHAR(50) NOT NULL UNIQUE,
    is_manual TINYINT(1) DEFAULT 0,
    manual_value TINYINT(1) DEFAULT 0,
    manual_start_time TIMESTAMP NULL,
    timeout_minutes INT DEFAULT 5,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

INSERT INTO manual_control (component_name, is_manual, manual_value) VALUES 
('kipas_masuk', 0, 0),
('kipas_keluar', 0, 0),
('lampu_hangat', 0, 0),
('lampu_terang', 0, 0),
('conveyor', 0, 0);

-- DELETE FROM sensor_data WHERE created_at < DATE_SUB(NOW(), INTERVAL 24 HOUR);

