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
-- Massage (1)
(1, 'Swedish Massage', 'Gentle relaxing massage', 500.00, NOW()),
(1, 'Deep Tissue Massage', 'Intense muscle relief massage', 700.00, NOW()),
(1, 'Hot Stone Massage', 'Heated stones for muscle relaxation', 750.00, NOW()),
(1, 'Aromatherapy Massage', 'Massage with essential oils', 650.00, NOW()),
(1, 'Shiatsu Massage', 'Japanese pressure point massage', 800.00, NOW()),

-- Facial (2)
(2, 'Anti-Aging Facial', 'Reduces fine lines and wrinkles', 600.00, NOW()),
(2, 'Acne Treatment Facial', 'Cleanses and treats acne-prone skin', 550.00, NOW()),
(2, 'Hydrating Facial', 'Deep skin hydration treatment', 580.00, NOW()),
(2, 'Brightening Facial', 'Improves skin radiance', 620.00, NOW()),
(2, 'Gold Facial', 'Luxury facial with gold mask', 900.00, NOW()),

-- Hair Care (3)
(3, 'Haircut', 'Basic haircut and styling', 300.00, NOW()),
(3, 'Hair Coloring', 'Professional hair coloring service', 800.00, NOW()),
(3, 'Hair Rebond', 'Hair straightening treatment', 1500.00, NOW()),
(3, 'Hair Treatment', 'Deep conditioning treatment', 600.00, NOW()),
(3, 'Keratin Treatment', 'Smoothening and anti-frizz treatment', 1800.00, NOW()),

-- Manicure & Pedicure (4)
(4, 'Classic Manicure', 'Nail shaping and polish', 250.00, NOW()),
(4, 'Classic Pedicure', 'Foot care and nail polish', 300.00, NOW()),
(4, 'Gel Manicure', 'Long-lasting gel polish', 450.00, NOW()),
(4, 'Spa Pedicure', 'Pedicure with foot spa', 500.00, NOW()),
(4, 'Nail Art', 'Decorative nail design', 350.00, NOW()),

-- Body Treatment (5)
(5, 'Body Scrub', 'Full body exfoliation', 650.00, NOW()),
(5, 'Body Wrap', 'Detoxifying and hydrating wrap', 700.00, NOW()),
(5, 'Slimming Treatment', 'Body contouring session', 1200.00, NOW()),
(5, 'Back Treatment', 'Cleansing and exfoliating back care', 750.00, NOW()),
(5, 'Mud Therapy', 'Mineral-rich body mask treatment', 850.00, NOW());