CREATE DATABASE IF NOT EXISTS gfspa_db
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE gfspa_db;

DROP TABLE IF EXISTS messages;
DROP TABLE IF EXISTS bookings;
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
('Confirmed'),
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