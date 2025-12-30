CREATE DATABASE IF NOT EXISTS payments_db;
USE payments_db;

CREATE TABLE IF NOT EXISTS level1_payments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    plan VARCHAR(50),
    amount DECIMAL(10, 2),
    wish_number VARCHAR(20),
    reference_code VARCHAR(50),
    proof_file VARCHAR(255),
    timestamp DATETIME
);

CREATE TABLE IF NOT EXISTS level2_payments LIKE level1_payments;
RENAME TABLE level2_payments TO level2_payments;

CREATE TABLE IF NOT EXISTS level3_payments LIKE level1_payments;
RENAME TABLE level3_payments TO level3_payments;
