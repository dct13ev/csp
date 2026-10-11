
CREATE DATABASE IF NOT EXISTS QL_SP CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE QL_SP;

CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    price DECIMAL(15,2) NOT NULL,
    quantity INT NOT NULL,
    description TEXT
);

-- Thêm dữ liệu demo
INSERT INTO products (name, price, quantity, description) VALUES
('Laptop Dell XPS 15', 25000000, 10, 'Laptop văn phòng cao cấp'),
('Chuột Logitech G502', 1200000, 50, 'Chuột gaming không dây'),
('Bàn phím cơ Keychron K8', 1800000, 30, 'Bàn phím cơ Bluetooth');