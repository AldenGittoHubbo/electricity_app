CREATE DATABASE IF NOT EXISTS listrik;
USE listrik;

CREATE TABLE IF NOT EXISTS user (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

-- User default
INSERT INTO user (username, password) VALUES (
    'admin', SHA2('admin123', 256)
);

CREATE TABLE IF NOT EXISTS tarif (
    id INT PRIMARY KEY,
    per_kwh INT NOT NULL
);

INSERT INTO tarif (id, per_kwh) VALUES (1, 1500)
    ON DUPLICATE KEY UPDATE per_kwh = VALUES(per_kwh);

CREATE TABLE IF NOT EXISTS barang (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_barang VARCHAR(100) NOT NULL,
    jumlah INT NOT NULL,
    watt INT NOT NULL,
    user_id INT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES user(id)
);