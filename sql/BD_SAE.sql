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
    nom VARCHAR(35) NULL,
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
    duree INT(11) NOT NULL,
    illustration VARCHAR(50) NOT NULL,
    categorie INT(11),
    tailleSceneRequise INT(11),
    PRIMARY KEY (idSpectacle)
);

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

INSERT INTO CategorieSpectacle (idCategorie,nomCategorie)
VALUES
('1','Musique'),
('2','Sport');

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

CREATE TABLE Jour (
    idJour INT(11) NOT NULL AUTO_INCREMENT,
    heureDebut TIME NULL,
    heureFin TIME NULL,
    tempsEntreSpectacle TIME NULL,
    PRIMARY KEY (idJour)
);

CREATE TABLE Grij (
    idFestival INT(11) NOT NULL,
    idJour INT(11) NOT NULL,
    PRIMARY KEY (idFestival,idJour)
);
ALTER TABLE Grij
ADD FOREIGN KEY (idFestival) REFERENCES Festival(idFestival);
ALTER TABLE Grij
ADD FOREIGN KEY (idJour) REFERENCES Jour(idJour);

CREATE TABLE SpectaclesJour (
    idJour INT(11) NOT NULL,
    idSpectacle INT(11) NOT NULL,
    PRIMARY KEY (idJour, idSpectacle),
    FOREIGN KEY (idJour) REFERENCES Jour(idJour),
    FOREIGN KEY (idSpectacle) REFERENCES Spectacle(idSpectacle)
);