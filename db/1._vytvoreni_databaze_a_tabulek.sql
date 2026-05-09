-- 1._vytvoreni_databaze_a_tabulek.sql
SET NAMES utf8mb4;
CREATE DATABASE IF NOT EXISTS phone_repair_management_app;
USE phone_repair_management_app;
ALTER DATABASE phone_repair_management_app
CHARACTER SET utf8mb4
COLLATE utf8mb4_czech_ci;
USE phone_repair_management_app;

CREATE TABLE IF NOT EXISTS branches (
id smallint primary key auto_increment,
city varchar(100) not null,
street varchar(100),
house_no integer not null,
zip integer not null
);

CREATE TABLE IF NOT EXISTS employees (
id integer primary key auto_increment,
first_name varchar(50) not null,
last_name varchar(50) not null,
phone varchar(20) not null,
email varchar(100) not null,
role ENUM('receptionist', 'service technician', 'admin') not null,
hash varchar(255) not null,
specialization varchar(100) not null,
branch_id smallint not null,
foreign key (branch_id) references branches(id)
);

CREATE TABLE IF NOT EXISTS pricing (
id smallint primary key auto_increment,
repair_type varchar(200) not null,
min_price integer not null,
max_price integer not null
);

CREATE TABLE IF NOT EXISTS customers (
id bigint primary key auto_increment,
first_name varchar(50) not null,
last_name varchar(50) not null,
phone varchar(20) not null,
email varchar(100) not null,
city varchar(100) not null,
street varchar(100),
house_no integer not null,
zip integer not null
);

CREATE TABLE IF NOT EXISTS invoices (
id bigint primary key auto_increment,
issued date not null,
due date not null,
method varchar(20) not null,
customer_id bigint not null,
foreign key (customer_id) references customers(id)
);

CREATE TABLE IF NOT EXISTS devices (
id bigint primary key auto_increment,
brand varchar(30) not null,
model varchar(50) not null,
serial varchar(100) not null,
state varchar(50) not null,
customer_id bigint not null,
foreign key (customer_id) references customers(id)
);

CREATE TABLE IF NOT EXISTS repairs (
id bigint primary key auto_increment,
started date not null,
expected_end date not null,
description text not null,
notes text,
employee_id integer NULL,
invoice_id bigint NULL,
price_id smallint NULL,
device_id bigint not null,
status varchar(50) not null default 'Založeno',
foreign key (employee_id) references employees(id),
foreign key (invoice_id) references invoices(id),
foreign key (price_id) references pricing(id),
foreign key (device_id) references devices(id)
);