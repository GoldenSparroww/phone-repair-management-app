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
    (100, 'Jarda', 'Sia', 'admin', '123-456-789', 'jarda.sia@sroubovacek.cz', '$2a$12$m9uEeNORJtapCoozMnUT5uAcJ5Na6OoRkJSZFsAMk1rwkLJs2lKUS', 'Software, obnova/záchrana dat, malware', 10),
    (101, 'Eva', 'Miraová','service technician', '987-654-321', 'eva.miraova@sroubovacek.cz', '$2a$12$m9uEeNORJtapCoozMnUT5uAcJ5Na6OoRkJSZFsAMk1rwkLJs2lKUS', 'Hardware', 10),
    (102, 'Karel', 'Vaněček','service technician', '234-567-890', 'karel.vanecek@sroubovacek.cz', '$2a$12$m9uEeNORJtapCoozMnUT5uAcJ5Na6OoRkJSZFsAMk1rwkLJs2lKUS', 'Čištění, lepení sklíček/fólií', 10),
    (103, 'Lucie', 'Malá','admin', '876-543-210', 'lucie.mala@sroubovacek.cz', '$2a$12$m9uEeNORJtapCoozMnUT5uAcJ5Na6OoRkJSZFsAMk1rwkLJs2lKUS', 'Hardware', 20),
    (104, 'Libor', 'Střední','service technician', '345-678-901', 'libor.stredni@sroubovacek.cz', '$2a$12$m9uEeNORJtapCoozMnUT5uAcJ5Na6OoRkJSZFsAMk1rwkLJs2lKUS', 'Čištění, lepení sklíček/fólií', 20),
    (105, 'Martina', 'Velká','receptionist', '765-432-109', 'martina.velka@sroubovacek.cz', '$2a$12$m9uEeNORJtapCoozMnUT5uAcJ5Na6OoRkJSZFsAMk1rwkLJs2lKUS', 'Software, obnova/záchrana dat, malware', 30),
    (106, 'Tomáš', 'Dlouhý','service technician', '456-789-012', 'tomas.dlouhy@sroubovacek.cz', '$2a$12$m9uEeNORJtapCoozMnUT5uAcJ5Na6OoRkJSZFsAMk1rwkLJs2lKUS', 'Hardware', 30),
    (107, 'Vašek', 'Šubrt','receptionist', '654-321-098', 'vasek.subrt@sroubovacek.cz', '$2a$12$m9uEeNORJtapCoozMnUT5uAcJ5Na6OoRkJSZFsAMk1rwkLJs2lKUS', 'Čištění, lepení sklíček/fólií', 30),
    (108, 'Jiří', 'Pes','receptionist', '567-890-123', 'jiri.pes@sroubovacek.cz', '$2a$12$m9uEeNORJtapCoozMnUT5uAcJ5Na6OoRkJSZFsAMk1rwkLJs2lKUS', 'Hardware', 30),
    (109, 'Marek', 'Dong','receptionist', '898-890-111', 'marek.dong@sroubovacek.cz', '$2a$12$m9uEeNORJtapCoozMnUT5uAcJ5Na6OoRkJSZFsAMk1rwkLJs2lKUS', 'Hardware', 30);

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
    (1, 'Jan', 'Novák', '123-456-789', 'jan.novak@gmail.com', 'Plzeň', 'Hlavní', '101', '11000'),
    (2, 'Eva', 'Horáková', '987-654-321', 'eva.horakova@proton.me', 'Plzeň', 'Masarykova', '202', '60200'),
    (3, 'Karel', 'Svoboda', '234-567-890', 'karel.svoboda@seznam.cz', 'Plzeň', 'Nádražní', '303', '70200'),
    (4, 'Lucie', 'Malá', '876-543-210', 'lucie.mala@gmail.com', 'Plzeň', 'Smetanova', '404', '30100'),
    (5, 'Petr', 'Velký', '345-678-901', 'petr.velky@proton.me', 'Chotíkov', null, '505', '46001'),
    (6, 'Martina', 'Kovářová', '765-432-109', 'martina.kovarova@seznam.cz', 'Plzeň', 'Komenského', '606', '77900'),
    (7, 'Veronika', 'Krátká', '654-321-098', 'veronika.kratka@seznam.cz', 'Plzeň', 'Gočárova', '808', '50002'),
    (8, 'Milan', 'Skočdopole', '567-890-123', 'milan.skocdopole@gmail.com', 'České Budějovice', 'Lannova', '909', '37001'),
    (9, 'Anna', 'Zelená', '678-901-234', 'anna.zelena@mail.to', 'Jihlava', 'České Budějovice', '1010', '58601'),
    (10, 'Vladimír', 'Žlutý', '901-234-567', 'vladimir.zluty@gmail.com', 'České Budějovice', 'Krymská', '313', '36001');

insert into devices (id, brand, model, serial, state, customer_id)
values
    (1, 'Apple', 'iPhone 13', 'SN123456', 'Blbne dotyk', 1),
    (2, 'Samsung', 'Galaxy S21', 'SN234567', 'Konektory nefungují', 2),
    (3, 'Huawei', 'P30', 'SN345678', 'Prasklá záda a prasklá zadní kamera', 3),
    (4, 'Sony', 'Xperia 1', 'SN456789', 'Není slyšet přehrávání zvuku', 4),
    (5, 'Nokia', '3310', 'SN567890', 'Prasklá záda', 5),
    (6, 'Sony', 'Xperia 5', 'SN678901', 'Není slyšet přehrávání zvuku', 6),
    (7, 'Google', 'Pixel 6', 'SN789012', 'Funguje, ztracená data', 7),
    (8, 'OnePlus', '8 Pro', 'SN890123', 'Prasklá zadní kamera', 8),
    (9, 'Motorola', 'Moto G8', 'SN901234', 'Funguje, divné barvy', 9),
    (10, 'Motorola', 'Razr', 'SN012345', 'Prasklá zadní kamera', 10),
    (11, 'HTC', 'U12+', 'SN123457', 'Nefunguje displej', 1),
    (12, 'Samsung', 'Galaxy S22', 'SN234568', 'Konektory nefungují', 2),
    (13, 'Oppo', 'Find X3', 'SN345679', 'Konektory nefungují', 2),
    (14, 'OnePlus', '8', 'SN345679', 'Nefunguje displej', 5);

insert into invoices (id, issued, due, method, customer_id)
values
    (500000, '2024-01-01', '2024-01-15', 'Bankovní převod', 1),
    (500001, '2024-01-02', '2024-01-16', 'Hotovost', 2),
    (500002, '2024-01-03', '2024-01-17', 'Kreditní karta', 3),
    (500003, '2024-01-04', '2024-01-18', 'Bankovní převod', 4),
    (500004, '2024-01-05', '2024-01-19', 'Hotovost', 5),
    (500005, '2024-01-06', '2024-01-20', 'Kreditní karta', 6),
    (500006, '2024-01-07', '2024-01-21', 'Bankovní převod', 7),
    (500007, '2024-01-08', '2024-01-22', 'Hotovost', 8),
    (500008, '2024-01-09', '2024-01-23', 'Kreditní karta', 9),
    (500009, '2024-01-10', '2024-01-24', 'Bankovní převod', 10),
    (500010, '2024-02-10', '2024-02-24', 'Bankovní převod', 5);

insert into repairs (started, expected_end, description, notes, employee_id, invoice_id, price_id, device_id)
values
    ('2024-02-01', '2024-02-10', 'Pravděpodbně poškozená flexa', 'Zákazník na opravu spěchá, vyžaduje opravu do konce týdne, je ochoten připlatit', 101, 500000, 1000, 1),
    ('2024-02-02', '2024-02-11', 'Zanesené konektory, nenabíjí se', null, 102, 500001, 3001, 2),
    ('2024-02-03', '2024-02-12', 'Prasklý zadní kryt', null, 101, 500002, 1001, 3),
    ('2024-02-04', '2024-02-13', 'Nefunkční reproduktor', null, 101, 500003, 1006, 4),
    ('2024-02-05', '2024-02-14', 'Prasklý zadní kryt', null, 103, 500004, 1001, 5),
    ('2024-02-06', '2024-02-15', 'Nefunkční reproduktor', null, 101, 500005, 1006, 6),
    ('2024-02-07', '2024-02-16', 'Ztracená data do mylném smazání (interní paměť)', 'Zákazník dává extra důraz na fotografie v interní paměti', 100, 500006, 2000, 7),
    ('2024-02-08', '2024-02-17', 'Rozbitá zadní kamera', null, 108, 500007, 1003, 8),
    ('2024-02-09', '2024-02-18', 'Aktualizace na vyšší verzi androidu způsobila špatné rozložení barev v systému, vyžadován downgrade', 'Zákazník požadoval explicitně downgrade na Android 11', 105, 500008, 2003, 9),
    ('2024-02-10', '2024-02-19', 'Rozbitá zadní kamera', null, 108, 500009, 1003, 10),
    ('2024-02-01', '2024-02-10', 'Pravděpodbně poškozená flexa', 'Zákazník na opravu spěchá, vyžaduje opravu do konce týdne, je ochoten připlatit', 101, 500000, 1000, 11),
    ('2024-02-12', '2024-02-21', 'Zanesené konektory', null, 102, 500001, 3001, 12),
    ('2024-02-13', '2024-02-22', 'Zanesené konektory', 'Špatný signál, není součástí opravy', 102, 500001, 3001, 13),
    ('2024-02-03', '2024-02-12', 'Rozbitá zadní kamera', null, 101, 500002, 1003, 3),
    ('2024-02-10', '2024-02-24', 'Zanesené konektory', null, 104, 500010, 3001, 5);