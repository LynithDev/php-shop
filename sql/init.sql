CREATE DATABASE IF NOT EXISTS `shop` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `shop`;

CREATE TABLE categories (
    `id` INT AUTO_INCREMENT NOT NULL,
    `name` VARCHAR(127) NOT NULL,

    PRIMARY KEY (id)
);

CREATE TABLE users (
    `id` INT AUTO_INCREMENT NOT NULL,
    `login` VARCHAR(64) NOT NULL,
    `password` VARCHAR(64) NOT NULL,
    `permissions` INT NOT NULL DEFAULT 0,

    PRIMARY KEY (id),
    UNIQUE (`login`)
);

CREATE TABLE products (
    `id` INT AUTO_INCREMENT NOT NULL,
    `name` VARCHAR(255) NOT NULL,
    `description` VARCHAR(1024) NOT NULL,
    `price` INT NOT NULL,
    `category_id` INT NOT NULL,
    `author_id` INT NOT NULL, 
     
    PRIMARY KEY (id),
    FOREIGN KEY (category_id) REFERENCES categories(id),
    FOREIGN KEY (author_id) REFERENCES users(id)
);

CREATE TABLE featured_products (
    `id` INT AUTO_INCREMENT NOT NULL,
    `product_id` INT NOT NULL,

    PRIMARY KEY (id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);