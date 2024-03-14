DROP DATABASE IF EXISTS `Students verification`;
CREATE DATABASE `Students verification`;
USE `Students verification`;

CREATE TABLE student_inf (
    student_id int not null auto_increment,
    First_name varchar(50) NOT NULL,
    Last_name varchar(50) NOT NULL,
    Class varchar(10) not null,
    Class_number int not null,
    Chip_ID varchar(50) not null,
    primary key (student_id)
    );
    
INSERT INTO student_inf ( First_name, Last_name, Class, Class_number, Chip_ID)
VALUES
('Petar', 'Antonov', '8g', '24','77 BE 18 C6'),
('Iren', 'Serbezova', '8g', '16','F6 43 8D D4'),
( 'Ilia', 'Iliev', '8g','15','86 17 D6 48'),
( 'Antoan', 'Tzonkov', '8g','8','45 18 41 C5'),
('Matei', 'Simeonov', '8g', '21', '01 02 03 04');

create table delays (
	delay_id int not null auto_increment,
	primary key(delay_id),
    first_name int not null,
    last_name int not null,
    class int not null,
    class_number int not null
);

create table absence (
	absence_id int not null auto_increment,
    primary key(absence_id),
    first_name int not null,
    last_name int not null,
    class int not null,
    class_number int not null
);



