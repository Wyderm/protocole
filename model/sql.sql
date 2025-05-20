DROP TABLE IF EXISTS personne;
DROP TABLE IF EXISTS utilisateur_groupe;
DROP TABLE IF EXISTS utilisateur;
DROP TABLE IF EXISTS groupe;

-- Table groupe
CREATE TABLE groupe
(
    id  INTEGER PRIMARY KEY AUTOINCREMENT,
    nom text
);


-- Table personne
CREATE TABLE personne
(
    id               INTEGER PRIMARY KEY AUTOINCREMENT,
    denomination     TEXT,
    dirigant_contact TEXT,
    categories        TEXT,
    sous_categories    TEXT,
    adresse1         TEXT,
    adresse2         TEXT,
    code_postal      INTEGER,
    ville            TEXT,
    tel              TEXT,
    mail             TEXT,
    id_groupe        INTEGER,
    FOREIGN KEY (id_groupe) REFERENCES groupe (id)
);


-- Table utilisateur
CREATE TABLE utilisateur
(
    id_compte               INTEGER PRIMARY KEY AUTOINCREMENT,
    username                TEXT NOT NULL UNIQUE,
    password                TEXT NOT NULL,
    type                    TEXT NOT NULL DEFAULT 'user' CHECK (type IN ('admin', 'user', 'lecteur')),
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


-- Insertion utilisateurs
INSERT INTO utilisateur (username, password, type, email, valide)
VALUES ('admin', '$2y$12$2UorjzwjRVc/lstMS3cR.ex5wYIUKgWGHSqnU..3VBKNGooSwo/tC', 'admin', 'matheo.deghaye@gmail.com',
        1),
       ('user', '$2y$12$Hj0t8DKygXB.lJli/O8eSeIlcNHuHvJRa13ZVVrfNau8zYwAzc7Hq', 'user', 'matheo.deghaye@uphf.fr', 0);


-- Insertion groupes
INSERT INTO groupe (nom)
VALUES ('ANCIENS_ELUS'),
       ('ASSOCIATIONS'),
       ('COMITE_CONSULTATIF_AFFAIRES_SCOLAIRES'),
       ('COMITE_CONSULTATIF_CIRC_ET_DEPL'),
       ('COMITE_CONSULTATIF_ENV_DURABLE'),
       ('CONSEIL_JEUNES'),
       ('CONSEIL_SENIORS'),
       ('ECOLES'),
       ('ELUS'),
       ('ENGAGEMENT_CITOYEN'),
       ('ENTREPRISES'),
       ('ETAT'),
       ('INV_PROTOCOLAIRE_ET_SOUTIEN'),
       ('PARTENAIRES_INSTITUTIONNELS'),
       ('PRESSE'),
       ('PRESTATAIRES_VILLE'),
       ('PROFESSIONS_LIBERALES'),
       ('TRANQUILITE_PUBLIQUE'),
       ('VIE_POLITIQUE');


-- Insertion personnes
INSERT INTO personne (denomination, dirigant_contact, categorie, adresse1, adresse2, code_postal, ville, tel, mail,
                      id_groupe)
VALUES ('Société A', 'Mathéo DEGHAYE', 'entreprise', '1 rue de la Paix', '', 59233, 'Maing', '0123456789',
        'matheo.deghaye@gmail.com', 11),
       ('', 'Sébastien DEGHAYE', 'ELU', '2 rue de la Liberté', '', 59233, 'Maing', '0987654321',
        'matheo.deghaye@uphf.fr', 9);


-- Insertion utilisateur_groupe
INSERT INTO utilisateur_groupe (id_utilisateur, id_groupe)
VALUES (1, 1),
       (1, 2),
       (1, 3),
       (1, 4),
       (1, 5),
       (1, 6),
       (1, 7),
       (1, 8),
       (1, 9),
       (1, 10),
       (1, 11),
       (1, 12),
       (1, 13),
       (1, 14),
       (1, 15),
       (1, 16),
       (1, 17),
       (1, 18),
       (1, 19),
       (2, 11);
