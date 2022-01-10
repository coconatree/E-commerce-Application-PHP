CREATE DATABASE IF NOT EXISTS DatabasePA01;
SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS customer;
CREATE TABLE customer(
    cid     VARCHAR(12),
    cname   VARCHAR(50),
    bdate   DATE,
    address VARCHAR(50),
    city    VARCHAR(20),
    wallet  FLOAT,
    PRIMARY KEY (cid)
) ENGINE = InnoDB;

INSERT INTO customer(cid, cname, bdate, address, city, wallet) VALUES
    ('C101', 'Ali',   '1997-03-03', 'Besiktas',  'Istanbul',      114.50),
    ('C102', 'Veli',  '2001-05-19', 'Bilkent',   'Ankara',        200.00),
    ('C103', 'Ayse',  '1972-04-23', 'Tunali',    'Ankara',        15.00),
    ('C104', 'Alice', '1990-10-29', 'Meltem',    'Antalya',       1024.00),
    ('C105', 'Bob',   '1987-08-30', 'Stretford', 'Manchester',    15.00);

DROP TABLE IF EXISTS product;
CREATE TABLE product(
    pid     VARCHAR(8),
    pname   VARCHAR(50),
    price   FLOAT,
    stock   INT,
    PRIMARY KEY (pid)
) ENGINE = InnoDB;

INSERT INTO product(pid, pname, price, stock) VALUES
    ('P101', 'powerbank',  300.00,  2),
    ('P102', 'battery',    5.50,    5),
    ('P103', 'laptop',     3500.00, 10),
    ('P104', 'mirror',     10.75,   50),
    ('P105', 'notebook',   3.85,    100),
    ('P106', 'carpet',     50.99,   1),
    ('P107', 'lawn mower', 1025.00, 3);

DROP TABLE IF EXISTS buy;
CREATE TABLE buy(
    cid      VARCHAR(12),
    pid      VARCHAR(8),
    quantity INT,
    PRIMARY KEY (cid, pid, quantity),
    FOREIGN KEY (pid)    REFERENCES product(pid)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    FOREIGN KEY (cid)    REFERENCES customer(cid)
        ON DELETE CASCADE
        ON UPDATE CASCADE
) ENGINE = InnoDB;

INSERT INTO buy(cid, pid, quantity) VALUES
    ('C101', 'P105', 2),
    ('C102', 'P105', 2),
    ('C103', 'P105', 5),
    ('C101', 'P101', 1),
    ('C102', 'P102', 4),
    ('C105', 'P104', 1);
