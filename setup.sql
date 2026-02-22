CREATE DATABASE IF NOT EXISTS gfspa_db
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE gfspa_db;

DROP TABLE IF EXISTS messages;
DROP TABLE IF EXISTS bookings;
DROP TABLE IF EXISTS subservices;
DROP TABLE IF EXISTS services;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS status;

CREATE TABLE users (
    user_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    lastname VARCHAR(100) NOT NULL,
    firstname VARCHAR(100) NOT NULL,
    middlename VARCHAR(100),
    email VARCHAR(255) NOT NULL UNIQUE,
    contact_number VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('client', 'staff', 'admin') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

INSERT INTO users (lastname, firstname, middlename, email, contact_number, password, role)
VALUES
('Loslos', 'Gabriel', 'M', 'gabriel.loslos@email.com', '00000000001', '$2a$12$aBddAWylfI21Ia4WxtJ/ZeiT03hC4cOcymZ3j0IpRP40vFtdsqHcO', 'admin'),
('Loslos', 'James', 'M', 'james.loslos@email.com', '00000000002', '$2a$12$aBddAWylfI21Ia4WxtJ/ZeiT03hC4cOcymZ3j0IpRP40vFtdsqHcO', 'client');

CREATE TABLE status (
    status_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE
) ENGINE=InnoDB;

INSERT INTO status (name) VALUES 
('Pending'),
('Approved'),
('Completed'),
('Cancelled')
ON DUPLICATE KEY UPDATE name = name;

CREATE TABLE bookings (
    booking_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL,
    service VARCHAR(150) NOT NULL,
    subservice VARCHAR(150),
    date DATE NOT NULL,
    start_time TIME NOT NULL,
    end_time TIME NOT NULL,
    status_id INT UNSIGNED NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_bookings_user FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_bookings_status FOREIGN KEY (status_id) REFERENCES status(status_id) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE messages (
    message_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL,
    messageBody TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_messages_user FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS services (
    service_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE,
    description TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS subservices (
    subservice_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    service_id INT UNSIGNED NOT NULL,
    name VARCHAR(100) NOT NULL,
    description TEXT NULL,
    price DECIMAL(10,2) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_subservices_service
        FOREIGN KEY (service_id)
        REFERENCES services(service_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    UNIQUE KEY unique_service_subservice (service_id, name)
) ENGINE=InnoDB;

INSERT INTO services (name, description) VALUES
('Massage', 'Relaxing and therapeutic massage services'),
('Facial', 'Skin care and facial treatments'),
('Hair Care', 'Haircuts, styling, and treatments'),
('Manicure & Pedicure', 'Hand and foot grooming services'),
('Body Treatment', 'Full body scrubs and wraps');

INSERT INTO subservices (service_id, name, description, price, created_at) VALUES
(1, 'Swedish Massage', 'Gentle relaxing massage', 500.00, NOW()),
(1, 'Deep Tissue Massage', 'Intense muscle relief massage', 700.00, NOW()),
(2, 'Anti-Aging Facial', 'Reduces fine lines and wrinkles', 600.00, NOW()),
(2, 'Acne Treatment Facial', 'Cleanses and treats acne-prone skin', 550.00, NOW()),
(3, 'Haircut', 'Basic haircut and styling', 300.00, NOW()),
(3, 'Hair Coloring', 'Professional hair coloring service', 800.00, NOW()),
(4, 'Manicure', 'Nail shaping and polish', 250.00, NOW()),
(4, 'Pedicure', 'Foot care and nail polish', 300.00, NOW()),
(5, 'Body Scrub', 'Full body exfoliation', 650.00, NOW()),
(5, 'Body Wrap', 'Detoxifying and hydrating wrap', 700.00, NOW());