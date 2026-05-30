CREATE DATABASE IF NOT EXISTS monoshop;
USE monoshop;

-- Table: produits
CREATE TABLE IF NOT EXISTS produits (
    id INT AUTO_INCREMENT PRIMARY KEY,
    image TEXT,
    nom VARCHAR(255) NOT NULL,
    prix INT NOT NULL,
    description TEXT
);

-- Table: admin
CREATE TABLE IF NOT EXISTS admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pseudo VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    motdepasse VARCHAR(255) NOT NULL
);

-- Table: client
CREATE TABLE IF NOT EXISTS client (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pseudo VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    motdepasse VARCHAR(255) NOT NULL
);

-- Default admin account (pseudo: admin / password: 1234)
INSERT INTO admin (pseudo, email, motdepasse) VALUES ('admin', 'admin@test.com', '1234');