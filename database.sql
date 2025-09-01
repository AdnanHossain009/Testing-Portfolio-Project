-- Database: portfolio_db

CREATE DATABASE IF NOT EXISTS portfolio_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE portfolio_db;

-- admin users
CREATE TABLE IF NOT EXISTS admins (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Site profile (single row)
CREATE TABLE IF NOT EXISTS profile (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(150) NOT NULL,
    title VARCHAR(150) NOT NULL,
    about TEXT,
    email VARCHAR(150),
    phone VARCHAR(50),
    location VARCHAR(150),
    github VARCHAR(255),
    linkedin VARCHAR(255),
    twitter VARCHAR(255),
    instagram VARCHAR(255)
);

-- Default data insertion for checking 
INSERT INTO profile (full_name, title, about, email, phone, location)
SELECT 'Adnan Hossain Siraz', 'Full Stack Developer',
       'I create innovative digital solutions with clean code and thoughtful UX.',
       'adnan@example.com', '+880 1XXXXXXXXX', 'Dhaka, Bangladesh'
WHERE NOT EXISTS (SELECT 1 FROM profile);

-- Skills table added
CREATE TABLE IF NOT EXISTS skills (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    category ENUM('Frontend', 'Backend', 'Tools & Others') NOT NULL,
    name VARCHAR(100) NOT NULL,
    level TINYINT UNSIGNED DEFAULT 80,
    sort_order INT DEFAULT 0
);

-- Projects table + live url + github link + featured or not --if not featured it wont show in the portfolio
CREATE TABLE IF NOT EXISTS projects (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    description TEXT,
    tech_stack VARCHAR(255),
    live_url VARCHAR(255),
    source_url VARCHAR(255),
    icon VARCHAR(100) DEFAULT 'fas fa-code',
    featured TINYINT(1) DEFAULT 1,
    sort_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- degrees / education 
CREATE TABLE IF NOT EXISTS education (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    degree VARCHAR(200) NOT NULL,
    institution VARCHAR(200) NOT NULL,
    start_year YEAR,
    end_year YEAR,
    details TEXT,
    sort_order INT DEFAULT 0
);

-- certificates
CREATE TABLE IF NOT EXISTS certificates (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(200) NOT NULL,
    issuer VARCHAR(200),
    issue_date DATE,
    credential_url VARCHAR(255),
    sort_order INT DEFAULT 0
);

-- contacts (optional logging)
CREATE TABLE IF NOT EXISTS contacts (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    email VARCHAR(150) NOT NULL,
    subject VARCHAR(200) NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- creating auth token table for cookies section so that it can store auth tokens 
-- FIXED: Changed admin_id to INT UNSIGNED to match admins table
CREATE TABLE IF NOT EXISTS auth_tokens (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    selector VARCHAR(24) NOT NULL,
    validator_hash VARCHAR(255) NOT NULL,
    admin_id INT UNSIGNED NOT NULL,  -- Changed to match admins.id
    expires DATETIME NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (admin_id) REFERENCES admins(id) ON DELETE CASCADE,
    INDEX selector_index (selector),
    INDEX admin_id_index (admin_id)
);

-- Seed admin (email: admin@example.com, password: admin123)
INSERT INTO admins (name, email, password_hash)
SELECT 'Administrator', 'admin@example.com',
       '$2y$10$V3p9oA7YH3yY0Y0xkEoNleq0w2ZyHLxC3s5Qn0Wk8p3FJlr.D2q.K' -- bcrypt for 'admin123'
WHERE NOT EXISTS (SELECT 1 FROM admins);