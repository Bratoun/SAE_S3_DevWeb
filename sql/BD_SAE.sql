DROP DATABASE IF EXISTS Festiplan;
CREATE DATABASE IF NOT EXISTS Festiplan DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE Festiplan;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE TABLE Utilisateur (
    idUtilisateur INT PRIMARY KEY AUTO_INCREMENT,
    prenom VARCHAR(30) NOT NULL,
    nom VARCHAR(35) NOT NULL,
    mail VARCHAR(50) NOT NULL UNIQUE,
    login VARCHAR(35) NOT NULL UNIQUE,
    mdp VARCHAR(30) NOT NULL
);

-- Création de la table CategorieFestival
CREATE TABLE CategorieFestival (
    idCategorie INT(11) NOT NULL AUTO_INCREMENT,
    nom VARCHAR(35) NULL,
    PRIMARY KEY (idCategorie)
);

CREATE TABLE Festival (
    idFestival INT(11) NOT NULL AUTO_INCREMENT,
    categorie INT(11) NOT NULL,
    titre VARCHAR(35) NULL,
    description VARCHAR(1000) NULL,
    dateDebut DATE NOT NULL,
    dateFin DATE NOT NULL,
    illustration VARCHAR(50) NULL,
    PRIMARY KEY (idFestival)
);
ALTER TABLE Festival
ADD FOREIGN KEY (categorie) REFERENCES CategorieFestival(idCategorie);

CREATE TABLE EquipeOrganisatrice (
    idUtilisateur INT(11) NOT NULL,
    idFestival INT(11) NOT NULL,
    responsable BOOLEAN DEFAULT FALSE,
    PRIMARY KEY (idUtilisateur, idFestival)
);
ALTER TABLE EquipeOrganisatrice
ADD FOREIGN KEY (idUtilisateur) REFERENCES Utilisateur(idUtilisateur);
ALTER TABLE EquipeOrganisatrice
ADD FOREIGN KEY (idFestival) REFERENCES Festival(idFestival);

CREATE TABLE Spectacle (
    idSpectacle INT(11) NOT NULL AUTO_INCREMENT,
    titre VARCHAR(50) NOT NULL,
    description VARCHAR(1000) NULL,
    duree TIME NOT NULL,
    illustration VARCHAR(50) NULL,
    categorie INT(11),
    tailleSceneRequise INT(11),
    PRIMARY KEY (idSpectacle)
);

CREATE TABLE SpectacleOrganisateur (
    idUtilisateur INT(11) NOT NULL,
    idSpectacle INT(11) NOT NULL,
    PRIMARY KEY (idUtilisateur, idSpectacle)
);
ALTER TABLE SpectacleOrganisateur
ADD FOREIGN KEY (idUtilisateur) REFERENCES Utilisateur(idUtilisateur);
ALTER TABLE SpectacleOrganisateur
ADD FOREIGN KEY (idSpectacle) REFERENCES Spectacle(idSpectacle);

CREATE TABLE SpectacleDeFestival (
    idSpectacle INT(11) NOT NULL,
    idFestival INT(11) NOT NULL,
    PRIMARY KEY (idSpectacle, idFestival)
);
ALTER TABLE SpectacleDeFestival
ADD FOREIGN KEY (idSpectacle) REFERENCES Spectacle(idSpectacle);
ALTER TABLE SpectacleDeFestival
ADD FOREIGN KEY (idFestival) REFERENCES Festival(idFestival);

CREATE TABLE CategorieSpectacle (
    idCategorie INT(11) NOT NULL AUTO_INCREMENT,
    nomCategorie VARCHAR(35) NOT NULL,
    PRIMARY KEY (idCategorie)
);

ALTER TABLE Spectacle
ADD FOREIGN KEY (categorie) REFERENCES CategorieSpectacle(idCategorie);



-- Création de la table Intervenant
CREATE TABLE Intervenant (
  idIntervenant INT(11) NOT NULL AUTO_INCREMENT,
  nom VARCHAR(35) NOT NULL,
  prenom VARCHAR(35) NOT NULL,
  mail VARCHAR(50) NOT NULL,
  surScene BOOLEAN NOT NULL,
  typeIntervenant INT(11) NOT NULL,
  PRIMARY KEY (idIntervenant)
);

CREATE TABLE MetierIntervenant (
    idMetierIntervenant INT(11) NOT NULL,
    metier VARCHAR(50) NOT NULL,
    PRIMARY KEY (idMetierIntervenant)
);

ALTER TABLE Intervenant
ADD FOREIGN KEY (typeIntervenant) REFERENCES MetierIntervenant(idMetierIntervenant);

CREATE TABLE IntervenantSpectacle (
    idSpectacle INT(11) NOT NULL,
    idIntervenant INT(11) NOT NULL,
    PRIMARY KEY (idSpectacle, idIntervenant)
);
ALTER TABLE IntervenantSpectacle
ADD FOREIGN KEY (idSpectacle) REFERENCES Spectacle(idSpectacle);
ALTER TABLE IntervenantSpectacle
ADD FOREIGN KEY (idIntervenant) REFERENCES Intervenant(idIntervenant);


CREATE TABLE Scene (
    idScene INT(11) NOT NULL AUTO_INCREMENT,
    taille INT(11) NOT NULL,
    nombreSpectateurs INT(6) NULL,
    longitude NUMERIC(8,5) NULL,
    latitude NUMERIC(8,5) NULL,
    nom VARCHAR(35) NULL,
    PRIMARY KEY (idScene)
);

CREATE TABLE Taille (
    idTaille INT(11) NOT NULL AUTO_INCREMENT,
    nom VARCHAR(35) NULL,
    PRIMARY KEY (idTaille)
);


ALTER TABLE Scene
ADD FOREIGN KEY (taille) REFERENCES Taille(idTaille);
ALTER TABLE Spectacle
ADD FOREIGN KEY (tailleSceneRequise) REFERENCES Taille(idTaille);

CREATE TABLE SceneFestival (
    idFestival INT(11) NOT NULL,
    idScene INT(11) NOT NULL,
    PRIMARY KEY (idFestival,idScene)
);

ALTER TABLE SceneFestival
ADD FOREIGN KEY (idScene) REFERENCES Scene(idScene);
ALTER TABLE SceneFestival
ADD FOREIGN KEY (idFestival) REFERENCES Festival(idFestival);


CREATE TABLE Grij (
    idGrij INT(11) NOT NULL AUTO_INCREMENT,
    heureDebut TIME NULL,
    heureFin TIME NULL,
    tempsEntreSpectacle TIME NULL,
    PRIMARY KEY (idGrij),
    FOREIGN KEY (idGrij) REFERENCES Festival(idFestival)
);

CREATE TABLE Jour (
    idJour INT(11) NOT NULL AUTO_INCREMENT,
    idGrij INT(11) NOT NULL,
    dateDuJour DATE NOT NULL,
    PRIMARY KEY (idJour),
    FOREIGN KEY (idGrij) REFERENCES Grij(idGrij)
);

CREATE TABLE SpectaclesJour (
    idFestival INT(11) NOT NULL,
    idJour INT(11) NULL,
    idSpectacle INT(11) NOT NULL,
    idScene INT(11) NULL,
    ordre INT(3) NOT NULL DEFAULT 0,
    place TINYINT NOT NULL DEFAULT 0,
    PRIMARY KEY (idFestival, idSpectacle),
    FOREIGN KEY (idJour) REFERENCES Jour(idJour),
    FOREIGN KEY (idSpectacle) REFERENCES Spectacle(idSpectacle),
    FOREIGN KEY (idScene) REFERENCES Scene(idScene),
    FOREIGN KEY (idFestival) REFERENCES Festival(idFestival)
);

-- Données insérées
INSERT INTO CategorieFestival (nom)
VALUES
('Musique'),
('Théatre'),
('Cirque'),
('Danse'),
('Projection de film');

INSERT INTO CategorieSpectacle (nomCategorie)
VALUES
('Concert'),
('Piece de theatre'),
('Cirque'),
('Danse'),
('Projection de film');


INSERT INTO Taille (nom)
VALUES
('Petite'),
('Moyenne'),
('Grande');


-- TESTS ////////////////////////////////////////
INSERT INTO Utilisateur (prenom,nom,mail,login,mdp)
VALUES
('Nathan','Girardin','n@sfr.fr','nathan','123'),
('Mateo','Faussurier','M@sfr.fr','mateo','123'),
('Rayan','IBRAHIME','r@sfr.fr','rayan','123'),
('Alix','BRUGIER','a@sfr.fr','alix','123');


INSERT INTO Festival (categorie, titre, description, dateDebut, dateFin, illustration)
VALUES 
(1, 'Festival d été', 'Un grand festival estival', '2023-07-01', '2023-07-10', NULL),
(2, 'Festival de cinéma', 'Projection de films internationaux', '2023-08-15', '2023-08-25', null),
(3, 'Festival de musique', 'Concerts de divers genres musicaux', '2023-09-05', '2023-09-15', null);

INSERT INTO Spectacle (titre, description, duree, categorie, tailleSceneRequise)
VALUES ('spec1', 'une description des familles', '01:00:00', 1, 1),
('spec2', 'une description des familles', '00:10:00', 2, 1),
('spec3', 'une description des familles', '01:20:00', 4, 2),
('spec14', 'une description des familles', '00:36:00', 3, 3);

INSERT INTO EquipeOrganisatrice (idUtilisateur, idFestival)
VALUES (2, 1);

INSERT INTO SpectacleDeFestival (idFestival, idSpectacle)
VALUES (1,1),(1,2),(1,3),(1,4);

INSERT INTO Scene (taille, nom, nombreSpectateurs, longitude, latitude)
VALUES (1, 'scene1', 30, 12.12121, 12.12121),
(1, 'scene2', 33, 12.12121, 12.12121),
(2, 'scene3', 120, 12.12121, 12.12121),
(3, 'scene4', 500, 12.12121, 12.12121),
(3, 'scene5', 503, 12.12121, 12.12121);


INSERT INTO SceneFestival (idFestival,idScene)
VALUES (1,1),(1,2),(1,3),(1,4),(1,5);