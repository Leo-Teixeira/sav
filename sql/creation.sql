SET storage_engine = INNODB;

CREATE TABLE UTILISATEUR(
  UTILISATEURID INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
  IDENTIFIANT VARCHAR(64) NOT NULL,
  MDP VARCHAR(255) NOT NULL
);

CREATE TABLE CLIENT(
  CLIENTID INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
  UTILISATEURID INT,
  CODE VARCHAR(6) NOT NULL UNIQUE,
  DATECREA INT
);

CREATE TABLE FOURNISSEUR(
  FOURNISSEURID INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
  UTILISATEURID INT,
  CODE VARCHAR(6) NOT NULL UNIQUE,
  DATECREA INT
);

CREATE TABLE DEMANDE(
  DEMANDEID INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
  CLIENTID INT NOT NULL,
  FOURNISSEURID INT,
  DATECREA DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE SECTION(
  SECTIONID INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
  DEMANDEID INT NOT NULL,
  SECTYPE NUMERIC(1) NOT NULL,
  CONTENT VARCHAR(1024),
  DATECREA DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE DOCUMENT(
  DOCUMENTID INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
  SECTIONID INT NOT NULL,
  BYTES MEDIUMBLOB NOT NULL,
  NOM VARCHAR(128)
);

ALTER TABLE CLIENT
  ADD FOREIGN KEY (UTILISATEURID) REFERENCES UTILISATEUR(UTILISATEURID)
  ON DELETE SET NULL
  ON UPDATE CASCADE;

ALTER TABLE FOURNISSEUR
  ADD FOREIGN KEY (UTILISATEURID) REFERENCES UTILISATEUR(UTILISATEURID)
  ON DELETE SET NULL
  ON UPDATE CASCADE;

ALTER TABLE DEMANDE
  ADD FOREIGN KEY (CLIENTID) REFERENCES CLIENT(CLIENTID)
  ON UPDATE CASCADE;

ALTER TABLE DEMANDE
  ADD FOREIGN KEY (FOURNISSEURID) REFERENCES FOURNISSEUR(FOURNISSEURID)
    ON DELETE SET NULL
    ON UPDATE CASCADE;

ALTER TABLE SECTION
  ADD FOREIGN KEY (DEMANDEID) REFERENCES DEMANDE(DEMANDEID)
  ON DELETE CASCADE
  ON UPDATE CASCADE;

ALTER TABLE DOCUMENT
  ADD FOREIGN KEY (SECTIONID) REFERENCES SECTION(SECTIONID)
  ON DELETE CASCADE;