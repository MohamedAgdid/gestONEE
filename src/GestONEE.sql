create table if not exists service (
    id int(11) auto_increment primary key,
    name varchar(50) not null  
);

create table if not exists employee (
    id int(11) auto_increment primary key,
    name varchar(50) not null,
    email varchar(100) unique not null,
    gender enum('male', 'female', 'other') not null,
    picture varchar(100),
    address text,
    typeservice varchar(20),  
    password varchar(255) not null,  
    idb int(11),  
    idservice int(11),
    foreign key (idservice) references service(id)
);

create table if not exists responsable (
    id int(11) auto_increment primary key,
    name varchar(50) not null,
    picture varchar(100),
    email varchar(100) unique not null,
    gender enum('male', 'female', 'other') not null,
    address text,
    typeservice varchar(20),  
    password varchar(255) not null,  
    idb int(11),  
    idservice int(11),
    foreign key (idservice) references service(id)
);



create table if not exists vehicule (
    id int(11) auto_increment primary key,
    matricule varchar(15) not null,
    nbrtotal int(11),  
    nbrlibre int(11),
    nbrutilise int(11),
    idservice int(11),
    foreign key (idservice) references service(id)
);

create table if not exists congees (
     id int auto_increment primary key,
    datedebut date not null,
    datefin DATE NOT NULL,
    idr int(11),
    ide int(11),
    demande enum('oui','non'),
    statut ENUM('En Attente', 'Approuvé', 'Rejeté') DEFAULT 'En Attente',
    foreign key (idr) references responsable(id),
    foreign key (ide) references employee(id)
);

CREATE TABLE IF NOT EXISTS missions (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,  
    date DATE NOT NULL,
    address VARCHAR(100) NOT NULL,  
    description TEXT,
    idr INT(11),
    ide INT(11),
    raport TEXT,
    status ENUM ('Terminée', 'En attente', 'Active', 'Arrêtée'),
    nbr_vehicule INT(11),
    FOREIGN KEY (idr) REFERENCES responsable(id),
    FOREIGN KEY (ide) REFERENCES employee(id)
);


create table if not exists admin (
    id int(11) auto_increment primary key,
    name varchar(50) not null,
    password varchar(255) not null,  
    picture varchar(100)
);


ALTER TABLE responsable
ADD COLUMN type VARCHAR(1) DEFAULT 'R';

ALTER TABLE  employee 
ADD COLUMN type VARCHAR(1) DEFAULT 'E';


CREATE TABLE IF NOT EXISTS emails (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        email VARCHAR(100) NOT NULL,
        idSender int(11) not null,
        subject VARCHAR(255) NOT NULL,
        message TEXT NOT NULL,
        sent_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );

