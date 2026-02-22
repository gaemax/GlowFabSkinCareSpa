INSERT INTO users (lastname, firstname, middlename, email, contact_number, password, role)
VALUES
('Loslos', 'Gabriel', 'M', 'gabriel.loslos@email.com', '00000000001', '$2a$12$aBddAWylfI21Ia4WxtJ/ZeiT03hC4cOcymZ3j0IpRP40vFtdsqHcO', 'admin'),
('Garcia', 'Juan', 'Santos', 'juan.garcia@example.com', '09171234567', '$2y$10$examplehash', 'client'),
('Reyes', 'Maria', 'Lopez', 'maria.reyes@example.com', '09171234568', '$2y$10$examplehash', 'client'),
('Santos', 'Pedro', 'Cruz', 'pedro.santos@example.com', '09171234569', '$2y$10$examplehash', 'client'),
('Dela Cruz', 'Ana', 'Torres', 'ana.delacruz@example.com', '09171234570', '$2y$10$examplehash', 'client'),
('Lopez', 'Jose', 'Ramos', 'jose.lopez@example.com', '09171234571', '$2y$10$examplehash', 'client'),
('Martinez', 'Carmen', 'Velasco', 'carmen.martinez@example.com', '09171234572', '$2y$10$examplehash', 'client'),
('Villanueva', 'Luis', 'Garcia', 'luis.villanueva@example.com', '09171234573', '$2y$10$examplehash', 'client'),
('Torres', 'Isabel', 'Reyes', 'isabel.torres@example.com', '09171234574', '$2y$10$examplehash', 'client'),
('Fernandez', 'Ramon', 'Santos', 'ramon.fernandez@example.com', '09171234575', '$2y$10$examplehash', 'client'),
('Alvarez', 'Lucia', 'Mendoza', 'lucia.alvarez@example.com', '09171234576', '$2y$10$examplehash', 'client');

INSERT INTO services (name, description, created_at)
VALUES
('Massage', 'Relaxing and therapeutic massage services', NOW()),
('Facial', 'Skin care and facial treatments', NOW()),
('Hair Care', 'Haircuts, styling, and treatments', NOW()),
('Manicure & Pedicure', 'Hand and foot grooming services', NOW()),
('Body Treatment', 'Full body scrubs and wraps', NOW());



INSERT INTO subservices (service_id, name, description, price, created_at)
VALUES
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



INSERT INTO bookings (user_id, service_id, subservice_id, date, start_time, end_time, status_id)
VALUES
(1, 1, 1, '2026-01-15', '10:00', '11:00', 1),
(2, 2, 3, '2026-01-16', '13:00', '14:00', 2),
(3, 3, 5, '2026-01-17', '09:00', '10:00', 3),
(4, 4, 7, '2026-01-18', '11:00', '12:00', 1),
(5, 5, 9, '2026-01-19', '15:00', '16:00', 2),
(6, 1, 2, '2025-12-20', '10:00', '11:00', 3),
(7, 2, 4, '2025-12-21', '14:00', '15:00', 1),
(8, 3, 6, '2025-12-22', '09:30', '10:30', 2),
(9, 4, 8, '2025-12-23', '11:30', '12:30', 3),
(10, 5, 10, '2025-12-24', '13:30', '14:30', 4),
(1, 1, 1, '2025-11-05', '10:00', '11:00', 1),
(2, 2, 3, '2025-11-06', '12:00', '13:00', 2),
(3, 3, 5, '2025-11-07', '09:00', '10:00', 3),
(4, 4, 7, '2025-11-08', '11:00', '12:00', 1),
(5, 5, 9, '2025-11-09', '15:00', '16:00', 2),
(6, 1, 2, '2025-10-10', '10:00', '11:00', 3),
(7, 2, 4, '2025-10-11', '14:00', '15:00', 1),
(8, 3, 6, '2025-10-12', '09:30', '10:30', 2),
(9, 4, 8, '2025-10-13', '11:30', '12:30', 3),
(10, 5, 10, '2025-10-14', '13:30', '14:30', 4),
(1, 1, 1, '2025-09-01', '10:00', '11:00', 1),
(2, 2, 3, '2025-09-02', '12:00', '13:00', 2),
(3, 3, 5, '2025-09-03', '09:00', '10:00', 3),
(4, 4, 7, '2025-09-04', '11:00', '12:00', 1),
(5, 5, 9, '2025-09-05', '15:00', '16:00', 2),
(6, 1, 2, '2025-08-06', '10:00', '11:00', 3),
(7, 2, 4, '2025-08-07', '14:00', '15:00', 1),
(8, 3, 6, '2025-08-08', '09:30', '10:30', 2),
(9, 4, 8, '2025-08-09', '11:30', '12:30', 3),
(10, 5, 10, '2025-08-10', '13:30', '14:30', 4),
(1, 1, 1, '2025-07-15', '10:00', '11:00', 1),
(2, 2, 3, '2025-07-16', '12:00', '13:00', 2),
(3, 3, 5, '2025-07-17', '09:00', '10:00', 3),
(4, 4, 7, '2025-07-18', '11:00', '12:00', 1),
(5, 5, 9, '2025-07-19', '15:00', '16:00', 2),
(6, 1, 2, '2025-06-20', '10:00', '11:00', 3),
(7, 2, 4, '2025-06-21', '14:00', '15:00', 1),
(8, 3, 6, '2025-06-22', '09:30', '10:30', 2),
(9, 4, 8, '2025-06-23', '11:30', '12:30', 3),
(10, 5, 10, '2025-06-24', '13:30', '14:30', 4),
(1, 1, 1, '2024-12-01', '10:00', '11:00', 1),
(2, 2, 3, '2024-12-02', '12:00', '13:00', 2),
(3, 3, 5, '2024-12-03', '09:00', '10:00', 3),
(4, 4, 7, '2024-12-04', '11:00', '12:00', 1),
(5, 5, 9, '2024-12-05', '15:00', '16:00', 2),
(6, 1, 2, '2024-11-06', '10:00', '11:00', 3),
(7, 2, 4, '2024-11-07', '14:00', '15:00', 1),
(8, 3, 6, '2024-11-08', '09:30', '10:30', 2),
(9, 4, 8, '2024-11-09', '11:30', '12:30', 3),
(10, 5, 10, '2024-11-10', '13:30', '14:30', 4);