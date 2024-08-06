CREATE DATABASE gest;

USE gest;

-- Service Table
CREATE TABLE service (
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL
);

INSERT INTO service (name)
VALUES ("Gestion 1"), 
       ("Gestion 2"), 
       ("Gestion 3");

-- Admin Table
CREATE TABLE admin (
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    picture VARCHAR(100) NULL,
    email VARCHAR(50) NOT NULL,
    type VARCHAR(1) NOT NULL DEFAULT "A",
    idservice INT(11) NOT NULL,
    address VARCHAR(100) NULL,
    acces ENUM('Oui', 'Non') DEFAULT 'Non',
    FOREIGN KEY (idservice) REFERENCES service(id)
);

INSERT INTO admin (name, password, picture, email, type, idservice, address, acces)
VALUES ("Admin", "Admin", NULL, "admin@gmail.ma", "A", 1, NULL, "Oui");

-- Responsable Table
CREATE TABLE responsable (
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    picture VARCHAR(100) NULL,
    email VARCHAR(100) NOT NULL,
    gender ENUM('male', 'female') NOT NULL,
    address TEXT NULL,
    typeservice VARCHAR(20) NULL,
    password VARCHAR(255) NOT NULL DEFAULT "R-1234",
    idb INT(11) NULL,
    idservice INT(11) NULL,
    type VARCHAR(1) DEFAULT "R",
    note TEXT NULL,
    acces ENUM('Oui', 'Non') DEFAULT 'Non',
    FOREIGN KEY (idservice) REFERENCES service(id)
);

INSERT INTO responsable (name, picture, email, gender, address, typeservice, idb, idservice, type, note, acces)
VALUES 
    ("Mohamed Agdid", NULL, "mohamed.agdid@onee.ma", "male", "errachidia", "Service 1", NULL, 1, "R", NULL, "Oui"),
    ("Fatima Zahra", NULL, "fatima.zahra@onee.ma", "female", "Fes", "Service 2", NULL, 2, "R", NULL, "Non"),
    ("Yassine El Moussaoui", NULL, "yassine.moussaoui@onee.ma", "male", "Marrakech", "Service 3", NULL, 3, "R", NULL, "Oui");

CREATE TABLE employee (
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL,
    gender ENUM('male', 'female') NOT NULL,
    picture VARCHAR(100) NULL,
    address TEXT NULL,
    typeservice VARCHAR(20) NULL,
    password VARCHAR(255) NOT NULL DEFAULT "E-1234",
    idb INT(11) NULL,
    idservice INT(11) NULL,
    type VARCHAR(1) DEFAULT "E",
    idM INT(11) NULL,
    note TEXT NULL,
    acces ENUM('Oui', 'Non') DEFAULT 'Non',
    FOREIGN KEY (idservice) REFERENCES service(id)
) AUTO_INCREMENT=100;

INSERT INTO employee (name, email, gender, picture, address, typeservice, password, idb, idservice, type, idM, note, acces)
VALUES 
    ("Youssef Boussaid", "youssef.boussaid@onee.ma", "male", NULL, "12 Rue de Rabat, Rabat", "Gestion 1", "1234", NULL, 1, "E", 1, NULL, "Oui"),
    ("Khadija El Idrissi", "khadija.elidrissi@onee.ma", "female", NULL, "34 Avenue de Agadir, Agadir", "Gestion 1", "1234", NULL, 1, "E", 1, NULL, "Non"),
    ("Said Amrani", "said.amrani@onee.ma", "male", NULL, "56 Boulevard de Tanger, Tanger", "Gestion 1", "1234", NULL, 1, "E", 1, NULL, "Oui"),
    ("Nadia El Gharbi", "nadia.elgharbi@onee.ma", "female", NULL, "78 Route de Marrakech, Marrakech", "Gestion 2", "1234", NULL, 2, "E", 2, NULL, "Non"),
    ("Ahmed El Mansouri", "ahmed.mansouri@onee.ma", "male", NULL, "90 Rue de Casablanca, Casablanca", "Gestion 2", "1234", NULL, 2, "E", 2, NULL, "Oui"),
    ("Hajar Zahra", "hajar.zahra@onee.ma", "female", NULL, "12 Avenue de Fes, Fes", "Gestion 2", "1234", NULL, 2, "E", 2, NULL, "Non"),
    ("Rachid El Amrani", "rachid.amrani@onee.ma", "male", NULL, "34 Boulevard de Rabat, Rabat", "Gestion 3", "1234", NULL, 3, "E", 3, NULL, "Oui"),
    ("Aicha El Ghazali", "aicha.elghazali@onee.ma", "female", NULL, "56 Avenue de Marrakech, Marrakech", "Gestion 3", "1234", NULL, 3, "E", 3, NULL, "Non"),
    ("Mounir El Idrissi", "mounir.elidrissi@onee.ma", "male", NULL, "78 Route de Tangier, Tangier", "Gestion 3", "1234", NULL, 3, "E", 3, NULL, "Oui");

-- Missions Table
CREATE TABLE missions (
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    date DATE NOT NULL,
    address VARCHAR(100) NOT NULL,
    description TEXT NULL,
    idr INT(11) NULL,
    ide INT(11) NULL,
    raport TEXT NULL,
    status ENUM('Terminée', 'Acceptée', 'En attente', 'Active', 'Annulée') NOT NULL,
    nbr_vehicule INT(11) NULL,
    matricules varchar(15) NULL,
    `show` ENUM('oui', 'non') DEFAULT 'oui', 
    FOREIGN KEY (idr) REFERENCES responsable(id),
    FOREIGN KEY (ide) REFERENCES employee(id)
    
);

INSERT INTO missions (name, date, address, description, idr, ide, raport, status, nbr_vehicule, `show`)
VALUES 
    ("Inspection Réseau Eau", "2024-07-21", "123 Rue de Errachidia, Errachidia", "Inspection des réseaux d'eau potable.", 1, 100, NULL, "En attente", 2, "oui"),
    ("Audit Financier", "2024-07-22", "456 Avenue de Errachidia, Errachidia", "Audit des finances annuelles.", 2, 101, NULL, "Acceptée", 1, "oui"),
    ("Réparation Canalisation", "2024-07-23", "789 Boulevard de Errachidia, Errachidia", "Réparation urgente des canalisations.", 3, 102, NULL, "Active", 3, "oui"),
    ("Évaluation Sécurité Réseau", "2024-07-24", "321 Route de Errachidia, Errachidia", "Évaluation des mesures de sécurité du réseau.", 1, NULL, NULL, "Annulée", 1, "non"),
    ("Formation Sécurité", "2024-07-25", "654 Rue de Errachidia, Errachidia", "Formation sur les procédures de sécurité.", 2, NULL, NULL, "Terminée", 1, "oui"),
    ("Maintenance Réseau", "2024-07-26", "987 Avenue de Errachidia, Errachidia", "Maintenance préventive du réseau.", 3, NULL, NULL, "Active", 2, "oui"),
    ("Supervision Projet Réseau", "2024-07-27", "123 Boulevard de Errachidia, Errachidia", "Supervision du projet de rénovation du réseau.", 1, NULL, NULL, "En attente", 2, "oui"),
    ("Contrôle Qualité Eau", "2024-07-28", "456 Route de Errachidia, Errachidia", "Contrôle de la qualité de l'eau.", 2, NULL, NULL, "Acceptée", 1, "oui"),
    ("Rapport Annuel Réseau", "2024-07-29", "789 Rue de Errachidia, Errachidia", "Préparation du rapport annuel du réseau.", 3, NULL, NULL, "Terminée", 1, "oui");

-- Congés Table
CREATE TABLE congees (
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    datedebut DATE NOT NULL,
    datefin DATE NOT NULL,
    idr INT(11) NULL,
    ide INT(11) NULL,
    demande ENUM('oui', 'non') NULL,
    statut ENUM('En Attente', 'Approuvé', 'Rejeté') DEFAULT 'En Attente',
    motif TEXT NULL,
    effectue ENUM('oui', 'non') DEFAULT 'non',
    nbr_rest INT(11) DEFAULT 22,
    days_select INT(11) NULL,
    FOREIGN KEY (idr) REFERENCES responsable(id),
    FOREIGN KEY (ide) REFERENCES employee(id)
);

-- Courier Table
CREATE TABLE courier (
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    idsender INT(11) NOT NULL,
    idDistinateur INT(11) NOT NULL,
    message TEXT NOT NULL,
    date DATETIME NOT NULL,
    seen TINYINT(1) DEFAULT 0,
    reply TEXT NULL

);

-- Vehicule Table
CREATE TABLE vehicule (
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    matricule VARCHAR(50) NOT NULL,
    idService INT(11) NOT NULL,
    Disponibilite ENUM('oui', 'non') NOT NULL DEFAULT 'oui',
    FOREIGN KEY (idService) REFERENCES service(id)
);

INSERT INTO vehicule (matricule, idService)
VALUES 
    ("1234-001", 1),
    ("1423-002", 1),
    ("1342-003", 1),
    ("1243-004", 1),
    ("1234-005", 2),
    ("1243-006", 2),
    ("1432-007", 2),
    ("1423-008", 2),
    ("1123-009", 3),
    ("2234-010", 3),
    ("3241-011", 3),
    ("4321-012", 3);
















