# DBMS-Project
Working portion:
->a fixed username "abc" and "123" password works as of now
-> donor's portion is pretty much complete
-> dbms works on local host so, a following commands 
create database dbms2023;
use database dbms2023;
CREATE TABLE receipts (
    id INT(11) NOT NULL AUTO_INCREMENT,
    user_id VARCHAR(255) NOT NULL,
    receipt_number VARCHAR(255) NOT NULL,
    receipt_file BLOB NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    PRIMARY KEY (id)
);
