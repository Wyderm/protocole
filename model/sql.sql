DROP TABLE IF EXISTS personne_souscategories;
DROP TABLE IF EXISTS souscategories;
DROP TABLE IF EXISTS personne;
DROP TABLE IF EXISTS utilisateur_groupe;
DROP TABLE IF EXISTS utilisateur;
DROP TABLE IF EXISTS groupe;

-- Table personne
CREATE TABLE personne
(
    id               INTEGER PRIMARY KEY AUTOINCREMENT,
    denomination     TEXT,
    dirigant_contact TEXT,
    categorie        TEXT,
    adresse1         TEXT,
    adresse2         TEXT,
    code_postal      INTEGER,
    ville            TEXT,
    tel              TEXT,
    mail             TEXT
);

-- Table groupe
CREATE TABLE groupe
(
    id  INTEGER PRIMARY KEY AUTOINCREMENT,
    nom text
);

-- Table utilisateur
CREATE TABLE utilisateur
(
    id_compte               INTEGER PRIMARY KEY AUTOINCREMENT,
    username                TEXT NOT NULL UNIQUE,
    password                TEXT NOT NULL,
    type                    TEXT NOT NULL DEFAULT 'user' CHECK (type IN ('admin', 'user')),
    email                   TEXT NOT NULL,
    valide                  BOOLEAN       DEFAULT false,
    reset_token_hash        TEXT UNIQUE   DEFAULT NULL,
    reset_token_expiration  TEXT          DEFAULT NULL,
    account_activation_hash varchar(64)   DEFAULT NULL,
    supprime                BOOLEAN       DEFAULT false
);

-- Table utilisateur_groupe
CREATE TABLE utilisateur_groupe
(
    id_utilisateur INTEGER NOT NULL,
    id_groupe      INTEGER NOT NULL,
    PRIMARY KEY (id_utilisateur, id_groupe),
    FOREIGN KEY (id_utilisateur) REFERENCES utilisateur (id_compte),
    FOREIGN KEY (id_groupe) REFERENCES groupe (id)
);

-- Table souscategories
CREATE TABLE souscategories
(
    id  INTEGER PRIMARY KEY AUTOINCREMENT,
    nom text
);

-- Table personne_souscategories
CREATE TABLE personne_souscategories
(
    id_personne       INTEGER NOT NULL,
    id_souscategories INTEGER NOT NULL,
    PRIMARY KEY (id_personne, id_souscategories),
    FOREIGN KEY (id_personne) REFERENCES personne (id),
    FOREIGN KEY (id_souscategories) REFERENCES souscategories (id)
);

