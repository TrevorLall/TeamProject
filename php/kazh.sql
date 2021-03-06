DROP TABLE cart;
DROP TABLE users;
DROP TABLE product;

CREATE TABLE users
(
u_id INT AUTO_INCREMENT PRIMARY KEY,
u_name VARCHAR(30) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL UNIQUE,
pass CHAR(60) NOT NULL
);

CREATE TABLE product
(
p_id INT AUTO_INCREMENT PRIMARY KEY,
p_name VARCHAR(50) NOT NULL,
p_desc TEXT(500),
genre VARCHAR(20),
price FLOAT(6,2) NOT NULL,
qoh INT NOT NULL,
image LONGBLOB NOT NULL
);

CREATE TABLE cart
(
c_id INT AUTO_INCREMENT PRIMARY KEY,
u_id INT NOT NULL,
p_id INT NOT NULL,
FOREIGN KEY (u_id) REFERENCES users (u_id),
FOREIGN KEY (p_id) REFERENCES product (p_id)
);