INSERT INTO users (lastname, firstname, middlename, email, contact_number, password, role)
VALUES
('Loslos', 'Gabriel', 'M', 'gabriel.loslos@email.com', '00000000001', '$2a$12$aBddAWylfI21Ia4WxtJ/ZeiT03hC4cOcymZ3j0IpRP40vFtdsqHcO', 'admin'),
('Loslos', 'James', 'M', 'james.loslos@email.com', '00000000001', '$2a$12$aBddAWylfI21Ia4WxtJ/ZeiT03hC4cOcymZ3j0IpRP40vFtdsqHcO', 'client');

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