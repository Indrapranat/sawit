CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Seed user (optional default admin)
-- Password: password123 (hashed)
INSERT INTO users (username, password) VALUES 
('admin', '$2y$10$jxJxJYp1j5IKOqa7BP204O7ZDR7zPd2Pj5rj95em896vPi2zAx4XK');
