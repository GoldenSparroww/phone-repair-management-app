CREATE TABLE IF NOT EXISTS repairs (
id SERIAL PRIMARY KEY,
device_name VARCHAR(255) NOT NULL,
status VARCHAR(50) NOT NULL,
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO repairs (device_name, status) VALUES
('iPhone 13 - prasklý displej', 'Nová'),
('Samsung Galaxy S22 - výměna baterie', 'V opravě'),
('Xiaomi Redmi Note 11 - nejde zapnout', 'Dokončeno');