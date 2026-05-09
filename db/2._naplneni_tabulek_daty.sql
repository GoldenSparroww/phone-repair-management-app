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

INSERT INTO `invoices` (`id`, `issued`, `due`, `method`, `customer_id`) VALUES
    (1, '2026-05-09', '2026-05-23', 'Kartou', 3),
    (2, '2026-05-09', '2026-05-23', 'Hotově', 1);

insert into repairs (started, expected_end, description, notes, employee_id, invoice_id, price_id, device_id, status)
values
    ('2026-04-10', '2026-04-19', 'Pravděpodbně poškozená flexa', null, null, null, null, 1, 'Nepřiřazená'),
    ('2026-04-11', '2026-04-20', 'Zanesené konektory, nenabíjí se', 'Provedl jsem kompletní revizi konektorů, a vyčistil jack 3.5. Ostatní bylo v pořádku. Navíc jsem vyčistil i rohy a okraje. Nabíjení už funguje také, tam nebylo třeba hlubší čištění.', 101, 1, 3001, 2, 'Vyfakturována'),
    ('2026-04-12', '2026-04-21', 'Prasklý zadní kryt', 'Telefon měl více problémů, než jen zadní kryt. Celá spodní část základní desky byla poškozená, takže kromě výměny zadního krytu byla přidána i celá nový základní deska.', 101, 2, 1006, 3, 'Vyfakturována'),
    ('2026-04-13', '2026-04-22', 'Nefunkční reproduktor', 'Stačilo jen vyčistit', 101, null, 3001, 4, 'Opravena'),
    ('2026-04-14', '2026-04-23', 'Prasklý zadní kryt', null, 101, null, null, 5, 'Přiřazená'),
    ('2026-04-15', '2026-04-24', 'Nefunkční reproduktor', null, 101, null, null, 6, 'Přiřazená'),
    ('2026-04-16', '2026-04-25', 'Ztracená data do mylném smazání (interní paměť)', null, null, null, null, 7, 'Nepřiřazená'),
    ('2026-04-17', '2026-04-26', 'Rozbitá zadní kamera', null, null, null, null, 8, 'Nepřiřazená'),
    ('2026-04-18', '2026-04-27', 'Špatné rozložení barev v systému, vyžadován downgrade', null, null, null, null, 9, 'Nepřiřazená'),
    ('2026-04-19', '2026-04-28', 'Rozbitá zadní kamera', null, null, null, null, 10, 'Nepřiřazená'),
    ('2026-04-20', '2026-04-29', 'Pravděpodbně poškozená flexa', null, null, null, null, 11, 'Nepřiřazená'),
    ('2026-04-21', '2026-04-30', 'Zanesené konektory', null, 106, null, null, 12, 'Přiřazená'),
    ('2026-04-22', '2026-05-01', 'Zanesené konektory', null, 106, null, null, 13, 'Přiřazená'),
    ('2026-04-23', '2026-05-02', 'Rozbitá zadní kamera', null, null, null, null, 3, 'Nepřiřazená'),
    ('2026-04-24', '2026-05-08', 'Zanesené konektory', null, null, null, null, 5, 'Nepřiřazená');