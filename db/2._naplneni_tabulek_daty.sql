-- 2._naplneni_tabulek_daty.sql
SET NAMES utf8mb4;
USE phone_repair_management_app;

insert into branches (id, city, street, house_no, zip)
values
    (10, 'Plzeň', 'Na kovárně', 122, 31200),
    (20, 'Chotíkov', NULL, 88, 33017),
    (30, 'České Budějovice', 'U Rybárny', 9, 87880);

insert into employees (id, first_name, last_name, role, phone, email, hash, specialization, branch_id)
values
    (100, 'Jarda', 'Sia', 'admin', '123456789', 'jarda.sia@sroubovacek.cz', '$2a$12$m9uEeNORJtapCoozMnUT5uAcJ5Na6OoRkJSZFsAMk1rwkLJs2lKUS', 'Software, obnova/záchrana dat, malware', 10),
    (101, 'Eva', 'Miraová','service technician', '987654321', 'eva.miraova@sroubovacek.cz', '$2a$12$m9uEeNORJtapCoozMnUT5uAcJ5Na6OoRkJSZFsAMk1rwkLJs2lKUS', 'Hardware', 10),
    (102, 'Karel', 'Vaněček','service technician', '234567890', 'karel.vanecek@sroubovacek.cz', '$2a$12$m9uEeNORJtapCoozMnUT5uAcJ5Na6OoRkJSZFsAMk1rwkLJs2lKUS', 'Čištění, lepení sklíček/fólií', 10),
    (103, 'Lucie', 'Malá','admin', '876543210', 'lucie.mala@sroubovacek.cz', '$2a$12$m9uEeNORJtapCoozMnUT5uAcJ5Na6OoRkJSZFsAMk1rwkLJs2lKUS', 'Hardware', 20),
    (104, 'Libor', 'Střední','service technician', '345678901', 'libor.stredni@sroubovacek.cz', '$2a$12$m9uEeNORJtapCoozMnUT5uAcJ5Na6OoRkJSZFsAMk1rwkLJs2lKUS', 'Čištění, lepení sklíček/fólií', 20),
    (105, 'Martina', 'Velká','receptionist', '765432109', 'martina.velka@sroubovacek.cz', '$2a$12$m9uEeNORJtapCoozMnUT5uAcJ5Na6OoRkJSZFsAMk1rwkLJs2lKUS', 'Software, obnova/záchrana dat, malware', 30),
    (106, 'Tomáš', 'Dlouhý','service technician', '456789012', 'tomas.dlouhy@sroubovacek.cz', '$2a$12$m9uEeNORJtapCoozMnUT5uAcJ5Na6OoRkJSZFsAMk1rwkLJs2lKUS', 'Hardware', 30),
    (107, 'Vašek', 'Šubrt','receptionist', '654321098', 'vasek.subrt@sroubovacek.cz', '$2a$12$m9uEeNORJtapCoozMnUT5uAcJ5Na6OoRkJSZFsAMk1rwkLJs2lKUS', 'Čištění, lepení sklíček/fólií', 30),
    (108, 'Jiří', 'Pes','receptionist', '567890123', 'jiri.pes@sroubovacek.cz', '$2a$12$m9uEeNORJtapCoozMnUT5uAcJ5Na6OoRkJSZFsAMk1rwkLJs2lKUS', 'Hardware', 30),
    (109, 'Marek', 'Dong','receptionist', '898890111', 'marek.dong@sroubovacek.cz', '$2a$12$m9uEeNORJtapCoozMnUT5uAcJ5Na6OoRkJSZFsAMk1rwkLJs2lKUS', 'Hardware', 30);

insert into pricing (id, repair_type, min_price, max_price)
values
    (1000, "Výměna displeje", 1000, 3500),
    (1001, "Výměna rámu/krytu", 300, 1000),
    (1002, "Oprava/oprava nefunkčních hardwarových tlačítek", 200, 1500),
    (1003, "Výměna/oprava kamer(y) (zadní)", 1000, 6000),
    (1004, "Výměna/oprava kamer(y) (přední)", 500, 5500),
    (1005, "Slepení nedoléhajících částí", 100, 800),
    (1006, "Jiná hardwarová výměna", 100, 5000),
    (2000, "Obnova ztracených dat (interní paměť)", 500, 2000),
    (2001, "Obnova ztracených dat (přídavné paměťové karty)", 200, 1500),
    (2002, "Ostraňování malware (závažné)", 500, 1500),
    (2003, "Downgrade", 100, 500),
    (2004, "Obecné softwarové potíže", 100, 1500),
    (3000, "Lepení sklíčka/fólie", 100, 500),
    (3001, "Obecné čištění", 100, 1000);

insert into customers (id, first_name, last_name, phone, email, city, street, house_no, zip)
values
    (1, 'Jan', 'Novák', '123456789', 'jan.novak@gmail.com', 'Plzeň', 'Hlavní', '101', '11000'),
    (2, 'Eva', 'Horáková', '987654321', 'eva.horakova@proton.me', 'Plzeň', 'Masarykova', '202', '60200'),
    (3, 'Karel', 'Svoboda', '234567890', 'karel.svoboda@seznam.cz', 'Plzeň', 'Nádražní', '303', '70200'),
    (4, 'Lucie', 'Malá', '876543210', 'lucie.mala@gmail.com', 'Plzeň', 'Smetanova', '404', '30100'),
    (5, 'Petr', 'Velký', '345678901', 'petr.velky@proton.me', 'Chotíkov', null, '505', '46001'),
    (6, 'Martina', 'Kovářová', '765432109', 'martina.kovarova@seznam.cz', 'Plzeň', 'Komenského', '606', '77900'),
    (7, 'Veronika', 'Krátká', '654321098', 'veronika.kratka@seznam.cz', 'Plzeň', 'Gočárova', '808', '50002'),
    (8, 'Milan', 'Skočdopole', '567890123', 'milan.skocdopole@gmail.com', 'České Budějovice', 'Lannova', '909', '37001'),
    (9, 'Anna', 'Zelená', '678901234', 'anna.zelena@mail.to', 'Jihlava', 'České Budějovice', '1010', '58601'),
    (10, 'Vladimír', 'Žlutý', '901234567', 'vladimir.zluty@gmail.com', 'České Budějovice', 'Krymská', '313', '36001');

insert into devices (id, brand, model, serial, customer_id)
values
    (1, 'Apple', 'iPhone 13', 'SN123456', 1),
    (2, 'Samsung', 'Galaxy S21', 'SN234567', 2),
    (3, 'Huawei', 'P30', 'SN345678', 3),
    (4, 'Sony', 'Xperia 1', 'SN456789', 4),
    (5, 'Nokia', '3310', 'SN567890', 5),
    (6, 'Sony', 'Xperia 5', 'SN678901', 6),
    (7, 'Google', 'Pixel 6', 'SN789012', 7),
    (8, 'OnePlus', '8 Pro', 'SN890123', 8),
    (9, 'Motorola', 'Moto G8', 'SN901234', 9),
    (10, 'Motorola', 'Razr', 'SN012345', 10),
    (11, 'HTC', 'U12+', 'SN123457', 1),
    (12, 'Samsung', 'Galaxy S22', 'SN234568', 2),
    (13, 'Oppo', 'Find X3', 'SN345679', 2),
    (14, 'OnePlus', '8', 'SN345679', 5);


insert into repairs (started, expected_end, description, notes, employee_id, invoice_id, price_id, device_id)
values
    ('2024-02-01', '2024-02-10', 'Pravděpodbně poškozená flexa', null, null, null, null, 1),
    ('2024-02-02', '2024-02-11', 'Zanesené konektory, nenabíjí se', null, null, null, null, 2),
    ('2024-02-03', '2024-02-12', 'Prasklý zadní kryt', null, null, null, null, 3),
    ('2024-02-04', '2024-02-13', 'Nefunkční reproduktor', null, null, null, null, 4),
    ('2024-02-05', '2024-02-14', 'Prasklý zadní kryt', null, null, null, null, 5),
    ('2024-02-06', '2024-02-15', 'Nefunkční reproduktor', null, null, null, null, 6),
    ('2024-02-07', '2024-02-16', 'Ztracená data do mylném smazání (interní paměť)', null, null, null, null, 7),
    ('2024-02-08', '2024-02-17', 'Rozbitá zadní kamera', null, null, null, null, 8),
    ('2024-02-09', '2024-02-18', 'Špatné rozložení barev v systému, vyžadován downgrade', null, null, null, null, 9),
    ('2024-02-10', '2024-02-19', 'Rozbitá zadní kamera', null, null, null, null, 10),
    ('2024-02-01', '2024-02-10', 'Pravděpodbně poškozená flexa', null, null, null, null, 11),
    ('2024-02-12', '2024-02-21', 'Zanesené konektory', null, null, null, null, 12),
    ('2024-02-13', '2024-02-22', 'Zanesené konektory', null, null, null, null, 13),
    ('2024-02-03', '2024-02-12', 'Rozbitá zadní kamera', null, null, null, null, 3),
    ('2024-02-10', '2024-02-24', 'Zanesené konektory', null, null, null, null, 5);