START TRANSACTION;

CREATE DATABASE obis;
USE obis;

CREATE TABLE bmi (
    id INT PRIMARY KEY AUTO_INCREMENT,
    year_value INT(4) NOT NULL,
    locationabbr CHAR(2) NOT NULL,
    sample_size INT NOT NULL,
    data_value_percentage FLOAT NOT NULL,
    confidence_limit_low FLOAT NOT NULL,
    confidence_limit_high FLOAT NOT NULL,
    response_id VARCHAR(10) NOT NULL,
    break_out_id VARCHAR(10) NOT NULL,
    break_out_category_id VARCHAR(10) NOT NULL
);

ALTER TABLE `bmi` ADD INDEX(`locationabbr`);
ALTER TABLE `bmi` ADD INDEX(`response_id`);
ALTER TABLE `bmi` ADD INDEX(`break_out_id`);
ALTER TABLE `bmi` ADD INDEX(`break_out_category_id`);

CREATE TABLE locations (
    locationabbr CHAR(2) PRIMARY KEY,
    location_name VARCHAR(75) NOT NULL,
    CONSTRAINT fk_locationabbr FOREIGN KEY (locationabbr) REFERENCES bmi(locationabbr)
);

CREATE TABLE responses (
    response_id VARCHAR(10) PRIMARY KEY,
    response VARCHAR(100) NOT NULL,
    CONSTRAINT fk_response_id FOREIGN KEY (response_id) REFERENCES bmi(response_id)
);

CREATE TABLE break_outs (
    break_out_id VARCHAR(10) PRIMARY KEY,
    break_out VARCHAR(100) NOT NULL,
    CONSTRAINT fk_break_out_id FOREIGN KEY (break_out_id) REFERENCES bmi(break_out_id)
);

CREATE TABLE break_outs_category (
    break_out_category_id VARCHAR(10) PRIMARY KEY,
    break_out_category VARCHAR(100) NOT NULL,
    CONSTRAINT fk_break_out_category_id FOREIGN KEY (break_out_category_id) REFERENCES bmi(break_out_category_id)
);

CREATE TABLE users ( 
    id INT PRIMARY KEY AUTO_INCREMENT,
    firstname VARCHAR(128) NOT NULL, 
    lastname VARCHAR(128) NOT NULL, 
    email VARCHAR(128) NOT NULL, 
    password VARCHAR(1024) NOT NULL, 
    created DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP, 
    modified TIMESTAMP ON update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE contactmessages (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(128) NOT NULL,
    email VARCHAR(128) NOT NULL,
    message TEXT NOT NULL
);

COMMIT;