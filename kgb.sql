DROP DATABASE IF EXISTS kgb;
CREATE DATABASE kgb;

USE kgb;

DELIMITER //
CREATE PROCEDURE get_agent (
IN n_agent_id INT(11)
) 
BEGIN
	SELECT * FROM kgb.person 
    INNER JOIN (
		SELECT agent_id FROM kgb.agent
		) AS a ON row_id = a.agent_id
	INNER JOIN (
		SELECT adjective AS nationality, row_id AS cid FROM kgb.country
		) AS b ON country_id = cid
	WHERE agent_id = n_agent_id;
END //

DELIMITER ;

DELIMITER //
CREATE PROCEDURE new_agent (
IN n_lastname VARCHAR(50),
IN n_firstname VARCHAR(50),
IN n_birthdate DATE,
IN n_country_id INT(11),
IN n_name_code VARCHAR(50)
) 
BEGIN
	DECLARE out_param INT(11);
	INSERT INTO kgb.person (lastname, firstname, birthdate, country_id, name_code) VALUES (n_lastname, n_firstname, n_birthdate, n_country_id, n_name_code);
    INSERT INTO kgb.agent (agent_id) VALUES (last_insert_id());
    SET out_param = LAST_INSERT_ID();
    
    SELECT out_param;
END //

DELIMITER ;

DELIMITER //
CREATE PROCEDURE update_agent (
IN n_person_id INT(11),
IN n_lastname VARCHAR(50),
IN n_firstname VARCHAR(50),
IN n_birthdate DATE,
IN n_country_id INT(11),
IN n_name_code VARCHAR(50),
IN n_spe_id INT(11)
) 
BEGIN
	UPDATE kgb.person SET lastname = n_lastname, firstname = n_firstname, birthdate = n_birthdate, country_id = n_country_id WHERE row_id = n_person_id;
    UPDATE kgb.agent SET name_code = n_name_code WHERE agent_id = n_person_id;
    UPDATE kgb.assoc_agent_spe SET agent_id = n_person_id, spe_id = n_spe_id;

END //

DELIMITER ;

DELIMITER //
CREATE PROCEDURE get_spe_of_agent (
IN n_agent_id INT(11)

) 
BEGIN
    SELECT * FROM kgb.assoc_agent_spe INNER JOIN (SELECT * FROM speciality) AS a ON spe_id = a.row_id WHERE agent_id = n_agent_id;
END //

DELIMITER ;

DELIMITER //
CREATE PROCEDURE assign_spe_to_agent (
IN n_agent_id INT(11),
IN n_spe_id INT(11)
) 
BEGIN
    INSERT INTO kgb.assoc_agent_spe (agent_id, spe_id) VALUES (n_agent_id, n_spe_id);
END //

DELIMITER ;

DELIMITER //
CREATE PROCEDURE get_contact (
IN n_contact_id INT(11)
) 
BEGIN
	SELECT * FROM kgb.person 
    INNER JOIN (
		SELECT contact_id FROM kgb.contact
		) AS a ON row_id = a.contact_id
	INNER JOIN (
		SELECT adjective AS nationality, row_id AS cid FROM kgb.country
		) AS b ON country_id = cid
	WHERE contact_id = n_contact_id;
END //

DELIMITER ;

DELIMITER //
CREATE PROCEDURE new_contact (
IN n_lastname VARCHAR(50),
IN n_firstname VARCHAR(50),
IN n_birthdate DATE,
IN n_country_id INT(11),
IN n_name_code VARCHAR(50)
) 
BEGIN
	DECLARE out_param INT(11);
	INSERT INTO kgb.person (lastname, firstname, birthdate, country_id, name_code) VALUES (n_lastname, n_firstname, n_birthdate, n_country_id, n_name_code);
    INSERT INTO kgb.contact (contact_id) VALUES (last_insert_id());
	SET out_param = LAST_INSERT_ID();
    
    SELECT out_param;
END //

DELIMITER ;

DELIMITER //
CREATE PROCEDURE get_target (
IN n_target_id INT(11)
) 
BEGIN
	SELECT * FROM kgb.person 
    INNER JOIN (
		SELECT target_id FROM kgb.target
		) AS a ON row_id = a.target_id
	INNER JOIN (
		SELECT adjective AS nationality, row_id AS cid FROM kgb.country
		) AS b ON country_id = cid
	WHERE target_id = n_target_id;
END //

DELIMITER ;

DELIMITER //
CREATE PROCEDURE new_target (
IN n_lastname VARCHAR(50),
IN n_firstname VARCHAR(50),
IN n_birthdate DATE,
IN n_country_id INT(11),
IN n_name_code VARCHAR(50)
) 
BEGIN
	DECLARE out_param INT(11);
	INSERT INTO kgb.person (lastname, firstname, birthdate, country_id, name_code) VALUES (n_lastname, n_firstname, n_birthdate, n_country_id, n_name_code);
    INSERT INTO kgb.target (target_id) VALUES (last_insert_id());
	SET out_param = LAST_INSERT_ID();
    
    SELECT out_param;
END //

DELIMITER ;

DELIMITER //
CREATE PROCEDURE get_hideout (
IN n_hideout_id INT(11)
) 
BEGIN
	SELECT * FROM kgb.hideout
    INNER JOIN (
		SELECT row_id AS hid, label FROM kgb.hideout_type
		) AS a ON type_id = hid
	INNER JOIN (
		SELECT noun AS country, row_id AS cid FROM kgb.country
    ) AS b ON country_id = cid
	WHERE row_id = n_hideout_id;
END //

DELIMITER ;

DELIMITER //
CREATE PROCEDURE new_hideout (
IN n_name_code VARCHAR(50),
IN n_address VARCHAR(256),
IN n_type_id INT(11),
IN n_country_id INt(11)
) 
BEGIN
	DECLARE out_param INT(11);
	INSERT INTO kgb.hideout (name_code, address, type_id, country_id) VALUES
		(n_name_code, n_address, n_type_id, n_country_id);
	SET out_param = LAST_INSERT_ID();
    
    SELECT out_param;
END //

DELIMITER ;

DELIMITER //
CREATE PROCEDURE get_mission (
IN n_mission_id INT(11)
) 
BEGIN
	SELECT * FROM kgb.mission
    INNER JOIN (
		SELECT row_id AS hid, spe_name FROM kgb.speciality
		) AS a ON mission_type_id = hid
	INNER JOIN (
		SELECT noun AS country, row_id AS cid FROM kgb.country
    ) AS b ON country_id = cid
    INNER JOIN (
		SELECT label AS m_status, row_id AS sid FROM kgb.mission_status
	) AS c ON mission_status_id = sid
	WHERE row_id = n_mission_id;
END //

DELIMITER ;


DELIMITER //
CREATE PROCEDURE new_mission (
IN n_title VARCHAR(50),
IN n_desc LONGTEXT,
IN n_name_code VARCHAR(50),
IN n_country INT(11),
IN n_type INT(11),
IN n_start DATE,
IN n_end DATE,
IN n_status INT(11)
) 
BEGIN
	INSERT INTO kgb.mission (title, descript, name_code, mission_status_id, start_date, end_date, mission_type_id, country_id) VALUES (n_title, n_desc, n_name_code, n_status, n_start, n_end, n_type, n_country);
    SELECT last_insert_id() AS 'id';
END //

DELIMITER ;

DELIMITER //
CREATE PROCEDURE assign_to_mission (
IN n_person_id INT(11),
IN n_mission_id INT(11)
) 
BEGIN
	INSERT INTO kgb.assoc_mission_person (person_id, mission_id) VALUES (n_person_id, n_mission_id);
END //

DELIMITER ;

DELIMITER //
CREATE PROCEDURE hideout_to_mission (
IN n_hideout_id INT(11),
IN n_mission_id INT(11)
) 
BEGIN
	INSERT INTO kgb.assoc_mission_hideout (hideout_id, mission_id) VALUES (n_hideout_id, n_mission_id);
END //

DELIMITER ;


CREATE TABLE kgb.mission_status (
	row_id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    label VARCHAR(50) NOT NULL
	);
    
CREATE TABLE kgb.speciality (
	row_id INT(11) AUTO_INCREMENT NOT NULL PRIMARY KEY,
    spe_name VARCHAR(50) NOT NULL
	);
    
CREATE TABLE kgb.country (
	row_id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    noun VARCHAR(50) NOT NULL,
    adjective VARCHAR(50) NOT NULL
	);

CREATE TABLE kgb.mission (
	row_id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(50) NOT NULL,
    descript LONGTEXT NOT NULL,
    name_code VARCHAR(50) NOT NULL,
    mission_status_id INT(11) NOT NULL,
    FOREIGN KEY (mission_status_id) REFERENCES kgb.mission_status(row_id),
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    mission_type_id INT(11) NOT NULL,
    FOREIGN KEY (mission_type_id) REFERENCES kgb.speciality(row_id),
    country_id INT(11) NOT NULL,
    FOREIGN KEY (country_id) REFERENCES kgb.country(row_id)
	);

CREATE TABLE kgb.person (
	row_id INT(11) AUTO_INCREMENT NOT NULL PRIMARY KEY,
    lastname VARCHAR(50) NOT NULL,
    firstname VARCHAR(50) NOT NULL,
    birthdate DATE NOT NULL,
    name_code VARCHAR(50) NOT NULL,
    country_id INT(11) NOT NULL,
    FOREIGN KEY (country_id) REFERENCES kgb.country(row_id)
	);
    
CREATE TABLE kgb.agent (
	agent_id INT(11) NOT NULL PRIMARY KEY,
    FOREIGN KEY (agent_id) REFERENCES kgb.person(row_id)
	);
    
CREATE TABLE kgb.assoc_agent_spe (
	agent_id INT(11) NOT NULL,
    spe_id INT(11) NOT NULL,
    PRIMARY KEY (agent_id, spe_id),
    FOREIGN KEY (agent_id) REFERENCES kgb.agent(agent_id),
    FOREIGN KEY (spe_id) REFERENCES kgb.speciality(row_id)
	);

CREATE TABLE kgb.target (
	target_id INT(11) NOT NULL PRIMARY KEY,
    FOREIGN KEY (target_id) REFERENCES kgb.person(row_id)
	);
    
CREATE TABLE kgb.contact (
	contact_id INT(11) NOT NULL PRIMARY KEY,
    FOREIGN KEY (contact_id) REFERENCES kgb.person(row_id)
    );
    
    
CREATE TABLE kgb.hideout_type (
	row_id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	label VARCHAR(50) NOT NULL
	);
    
CREATE TABLE kgb.hideout (
	row_id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name_code VARCHAR(50) NOT NULL,
    address VARCHAR(256) NOT NULL,
    type_id INT(11) NOT NULL,
    FOREIGN KEY (type_id) REFERENCES kgb.hideout_type(row_id),
    country_id INT(11) NOT NULL,
    FOREIGN KEY (country_id) REFERENCES kgb.country(row_id)
	);
   
CREATE TABLE kgb.user_role (
	row_id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    label VARCHAR(50) NOT NULL
	);

CREATE TABLE kgb.users (
	row_id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    lastname VARCHAR(50) NOT NULL,
    firstname VARCHAR(50) NOT NULL,
    mail VARCHAR(256) NOT NULL UNIQUE,
    pass_word TEXT NOT NULL,
    creation_date DATETIME NOT NULL,
    role_id INT(11) NOT NULL, 
    FOREIGN KEY (role_id) REFERENCES kgb.user_role(row_id)
	);
    
CREATE TABLE kgb.assoc_mission_person (
	person_id INT(11) NOT NULL,
	mission_id INT(11) NOT NULL,
    PRIMARY KEY(person_id, mission_id),
    FOREIGN KEY (person_id) REFERENCES kgb.person(row_id),
    FOREIGN KEY (mission_id) REFERENCES kgb.mission(row_id)
	);
    
CREATE TABLE kgb.assoc_mission_hideout (
	hideout_id INT(11) NOT NULL,
    mission_id INT(11) NOT NULL,
    PRIMARY KEY (hideout_id, mission_id),
    FOREIGN KEY (hideout_id) REFERENCES kgb.hideout(row_id),
    FOREIGN KEY (mission_id) REFERENCES kgb.mission(row_id)
	);

INSERT INTO kgb.country (noun, adjective)
VALUES
('Afghanistan', 'Afghan(e)'),
('Afrique du Sud', 'Sud-Africain(e)'),
('Albanie', 'Albanais(e)'),
('Algérie', 'Algérien(ne)'),
('Allemagne', 'Allemand(e)'),
('Andorre', 'Andorran(e)'),
('Angola', 'Angolais(e)'),
('Antigua-et-Barbuda', 'Antiguais(e)'),
('Arabie saoudite', 'Saoudien(ne)'),
('Argentine', 'Argentin(e)'),
('Arménie', 'Arménien(ne)'),
('Australie', 'Australien(ne)'),
('Autriche', 'Autrichien(ne)'),
('Azerbaïdjan', 'Azerbaïdjanais(e)'),
('Bahamas', 'Bahaméen(ne)'),
('Bahreïn', 'Bahreïnien(ne)'),
('Bangladesh', 'Bangladais(e)'),
('Barbade', 'Barbadien(ne)'),
('Belgique', 'Belge'),
('Belize', 'Bélizien(ne)'),
('Bénin', 'Béninois(e)'),
('Bhoutan', 'Bhoutanais(e)'),
('Biélorussie', 'Biélorusse'),
('Birmanie', 'Birman(e)'),
('Bolivie', 'Bolivien(ne)'),
('Bosnie-Herzégovine', 'Bosnien(ne)'),
('Botswana', 'Botswanais(e)'),
('Brésil', 'Brésilien(ne)'),
('Brunei', 'Bruneien(ne)'),
('Bulgarie', 'Bulgare'),
('Burkina Faso', 'Burkinabé(e)'),
('Burundi', 'Burundais(e)'),
('Cambodge', 'Cambodgien(ne)'),
('Cameroun', 'Camerounais(e)'),
('Canada', 'Canadien(ne)'),
('Cap-Vert', 'Cap-verdien(ne)'),
('Chili', 'Chilien(ne)'),
('Chine', 'Chinois(e)'),
('Chypre', 'Chypriote'),
('Colombie', 'Colombien(ne)'),
('Comores', 'Comorien(ne)'),
('Congo', 'Congolais(e)'),
('Corée du Nord', 'Nord-coréen(ne)'),
('Corée du Sud', 'Sud-coréen(ne)'),
('Costa Rica', 'Costaricain(e)'),
('Côte d\'Ivoire', 'Ivoirien(ne)'),
('Croatie', 'Croate'),
('Cuba', 'Cubain(e)'),
('Danemark', 'Danois(e)'),
('Djibouti', 'Djiboutien(ne)'),
('Dominique', 'Dominiquais(e)'),
('Égypte', 'Égyptien(ne)'),
('Émirats arabes unis', 'Émirien(ne)'),
('Équateur', 'Équatorien(ne)'),
('Érythrée', 'Érythréen(ne)'),
('Espagne', 'Espagnol(e)'),
('Estonie', 'Estonien(ne)'),
('États-Unis', 'Américain(e)'),
('Éthiopie', 'Éthiopien(ne)'),
('Fidji', 'Fidjien(ne)'),
('Finlande', 'Finlandais(e)'),
('France', 'Français(e)'),
('Gabon', 'Gabonais(e)'),
('Gambie', 'Gambien(ne)'),
('Géorgie', 'Géorgien(ne)'),
('Ghana', 'Ghanéen(ne)'),
('Grèce', 'Grec(que)'),
('Grenade', 'Grenadien(ne)'),
('Guatemala', 'Guatémaltèque'),
('Guinée', 'Guinéen(ne)'),
('Guinée équatoriale', 'Équatoguinéen(ne)'),
('Guinée-Bissau', 'Bissau-guinéen(ne)'),
('Guyana', 'Guyanais(e)'),
('Haïti', 'Haïtien(ne)'),
('Honduras', 'Hondurien(ne)'),
('Hongrie', 'Hongrois(e)'),
('Inde', 'Indien(ne)'),
('Indonésie', 'Indonésien(ne)'),
('Irak', 'Irakien(ne)'),
('Iran', 'Iranien(ne)'),
('Irlande', 'Irlandais(e)'),
('Islande', 'Islandais(e)'),
('Israël', 'Israélien(ne)'),
('Italie', 'Italien(ne)'),
('Jamaïque', 'Jamaïcain(e)'),
('Japon', 'Japonais(e)'),
('Jordanie', 'Jordanien(ne)'),
('Kazakhstan', 'Kazakh(e)'),
('Kenya', 'Kényan(ne)'),
('Kirghizistan', 'Kirghize'),
('Kiribati', 'Kiribatien(ne)'),
('Koweït', 'Koweïtien(ne)'),
('Laos', 'Laotien(ne)'),
('Lesotho', 'Lesothien(ne)'),
('Lettonie', 'Letton(ne)'),
('Liban', 'Libanais(e)'),
('Libéria', 'Libérien(ne)'),
('Libye', 'Libyen(ne)'),
('Liechtenstein', 'Liechtensteinois(e)'),
('Lituanie', 'Lituanien(ne)'),
('Luxembourg', 'Luxembourgeois(e)'),
('Macédoine du Nord', 'Macédonien(ne)'),
('Madagascar', 'Malgache'),
('Malaisie', 'Malaisien(ne)'),
('Malawi', 'Malawien(ne)'),
('Maldives', 'Maldivien(ne)'),
('Mali', 'Malien(ne)'),
('Malte', 'Maltais(e)'),
('Maroc', 'Marocain(e)'),
('Marshall', 'Marshallais(e)'),
('Maurice', 'Mauricien(ne)'),
('Mauritanie', 'Mauritanien(ne)'),
('Mexique', 'Mexicain(e)'),
('Micronésie', 'Micronésien(ne)'),
('Moldavie', 'Moldave'),
('Monaco', 'Monégasque'),
('Mongolie', 'Mongol(e)'),
('Monténégro', 'Monténégrin(e)'),
('Mozambique', 'Mozambicain(e)'),
('Namibie', 'Namibien(ne)'),
('Nauru', 'Nauruan(ne)'),
('Népal', 'Népalais(e)'),
('Nicaragua', 'Nicaraguayen(ne)'),
('Niger', 'Nigérien(ne)'),
('Nigeria', 'Nigérian(e)'),
('Niue', 'Niouéen(ne)'),
('Norvège', 'Norvégien(ne)'),
('Nouvelle-Zélande', 'Néo-zélandais(e)'),
('Oman', 'Omanais(e)'),
('Ouganda', 'Ougandais(e)'),
('Ouzbékistan', 'Ouzbek(e)'),
('Pakistan', 'Pakistanais(e)'),
('Palaos', 'Paluan(ne)'),
('Panama', 'Panaméen(ne)'),
('Papouasie-Nouvelle-Guinée', 'Papouasien(ne)-néo-guinéen(ne)'),
('Paraguay', 'Paraguayen(ne)'),
('Pays-Bas', 'Néerlandais(e)'),
('Pérou', 'Péruvien(ne)'),
('Philippines', 'Philippin(e)'),
('Pologne', 'Polonais(e)'),
('Portugal', 'Portugais(e)'),
('Qatar', 'Qatarien(ne)'),
('République centrafricaine', 'Centrafricain(e)'),
('République démocratique du Congo', 'Congolais(e)'),
('République dominicaine', 'Dominicain(e)'),
('République du Congo', 'Congolais(e)'),
('République tchèque', 'Tchèque'),
('Roumanie', 'Roumain(e)'),
('Royaume-Uni', 'Britannique'),
('Russie', 'Russe'),
('Rwanda', 'Rwandais(e)'),
('Saint-Christophe-et-Niévès', 'Sain -christophien(ne) et Névicien(ne)'),
('Saint-Marin', 'Saint-marinais(e)'),
('Saint-Vincent-et-les Grenadines', 'Saint-vincentais(e)-grenadin(e)'),
('Sainte-Lucie', 'Saint-lucien(ne)'),
('Salomon', 'Salomonais(e)'),
('Salvador', 'Salvadorien(ne)'),
('Samoa', 'Samoan(e)'),
('Sao Tomé-et-Principe', 'Santoméen(ne)-principien(ne)'),
('Sénégal', 'Sénégalais(e)'),
('Seychelles', 'Seychellois(e)'),
('Sierra Leone', 'Sierra-leonais(e)'),
('Singapour', 'Singapourien(ne)'),
('Slovaquie', 'Slovaque'),
('Slovénie', 'Slovène'),
('Somalie', 'Somalien(ne)'),
('Soudan', 'Soudanais(e)'),
('Soudan du Sud', 'Sud-soudanais(e)'),
('Sri Lanka', 'Sri-lankais(e)'),
('Suède', 'Suédois(e)'),
('Suisse', 'Suisse'),
('Suriname', 'Surinamien(ne)'),
('Syrie', 'Syrien(ne)'),
('Tadjikistan', 'Tadjik(e)'),
('Tanzanie', 'Tanzanien(ne)'),
('Tchad', 'Tchadien(ne)'),
('Thaïlande', 'Thaïlandais(e)'),
('Timor oriental', 'Timorais(e)'),
('Togo', 'Togolais(e)'),
('Tonga', 'Tongan(ne)'),
('Trinité-et-Tobago', 'Trinidadien(ne)-tobagonien(ne)'),
('Tunisie', 'Tunisien(ne)'),
('Turkménistan', 'Turkmène'),
('Turquie', 'Turc(que)'),
('Tuvalu', 'Tuvaluan(ne)'),
('Ukraine', 'Ukrainien(ne)'),
('Uruguay', 'Uruguayen(ne)'),
('Vanuatu', 'Vanuatuan(ne)'),
('Vatican', 'Vaticanais(e)'),
('Venezuela', 'Vénézuélien(ne)'),
('Vietnam', 'Vietnamien(ne)'),
('Yémen', 'Yéménite'),
('Zambie', 'Zambien(ne)'),
('Zimbabwe', 'Zimbabwéen(ne)');
    
INSERT INTO person (lastname, firstname, birthdate, country_id, name_code) VALUES ('González', 'Maria', '1993-05-25', 10, 'M');
INSERT INTO person (lastname, firstname, birthdate, country_id, name_code) VALUES ('Suzuki', 'Takashi', '1987-11-17', 86, 'Tokyo Revenger');
INSERT INTO person (lastname, firstname, birthdate, country_id, name_code) VALUES ('Nguyen', 'Minh', '1989-04-03', 191, '');
INSERT INTO person (lastname, firstname, birthdate, country_id, name_code) VALUES ('Kim', 'Ji-woo', '1997-02-18', 44, '');
INSERT INTO person (lastname, firstname, birthdate, country_id, name_code) VALUES ('Singh', 'Raj', '1990-08-08', 77, 'Baahubali');
INSERT INTO person (lastname, firstname, birthdate, country_id, name_code) VALUES ('Garcia', 'Juan', '1985-06-14', 56, 'Zorro');
INSERT INTO person (lastname, firstname, birthdate, country_id, name_code) VALUES ('Cruz', 'Maria', '1998-12-01', 190, '');
INSERT INTO person (lastname, firstname, birthdate, country_id, name_code) VALUES ('Ali', 'Fatima', '1994-07-22', 80, 'Jasmine');
INSERT INTO person (lastname, firstname, birthdate, country_id, name_code) VALUES ('Müller', 'Hans', '1982-03-11', 5, 'Moriarty');
INSERT INTO person (lastname, firstname, birthdate, country_id, name_code) VALUES ('Smith', 'John', '2000-09-30', 58, 'Mr Smith');

INSERT INTO person (lastname, firstname, birthdate, country_id, name_code) VALUES ('Rossi', 'Sofia', '1994-12-31', 84, '');
INSERT INTO person (lastname, firstname, birthdate, country_id, name_code) VALUES ('Cooper', 'Jessica', '1992-06-15', 149, '');
INSERT INTO person (lastname, firstname, birthdate, country_id, name_code) VALUES ('Hernandez', 'Alejandro', '1991-09-23', 113, '');
INSERT INTO person (lastname, firstname, birthdate, country_id, name_code) VALUES ('Kowalski', 'Piotr', '1989-03-07', 140, '');
INSERT INTO person (lastname, firstname, birthdate, country_id, name_code) VALUES ('Santos', 'Mariana', '1996-11-18', 141, '');

INSERT INTO person (lastname, firstname, birthdate, country_id, name_code) VALUES ('Kowalski', 'Karol', '1992-07-01', 150, 'La Veuve Noire');
INSERT INTO person (lastname, firstname, birthdate, country_id, name_code) VALUES ('Wang', 'Yan', '1988-09-13', 38, 'Shi-Fu');
INSERT INTO person (lastname, firstname, birthdate, country_id, name_code) VALUES ('López', 'Sofía', '1996-04-28', 40, 'La Dealeuse');
INSERT INTO person (lastname, firstname, birthdate, country_id, name_code) VALUES ('Abdullah', 'Ahmed', '1991-02-07', 9, 'Imam');
INSERT INTO person (lastname, firstname, birthdate, country_id, name_code) VALUES ('Dubois', 'Anne', '1987-12-15', 62, 'Capitaine Dubois');

INSERT INTO kgb.agent (agent_id) VALUES
	(1), (2), (3), (4), (5), (6), (7), (8), (9), (10);
	
INSERT INTO kgb.contact (contact_id) VALUES
	(11), (12), (13), (14), (15);
	
INSERT INTO kgb.target (target_id) VALUES
	(16), (17), (18), (19), (20);
	
INSERT INTO kgb.speciality (spe_name) VALUES
	('infiltration'),
	('surveillance'),
	('piratage'),
	('opérations spéciales'),
	('persuasion'),
	('assassinat'),
	('subversion');
    
INSERT INTO kgb.assoc_agent_spe (agent_id, spe_id) VALUES
	(1, 1), (1, 7),
    (2, 2), (2, 3),
    (3, 4),
    (4, 6),
    (5, 6), (5, 5),
    (6, 3),
    (7, 7),
    (8, 5), (8, 7),
    (9, 2), (9, 1),
    (10, 4);
	
INSERT INTO kgb.hideout_type (label) VALUES
	('Usine désafecté'),
	('Garage'),
	('Chambre d\'Hotel'),
	('Arrière-boutique'),
	('Appartement');
	
INSERT INTO kgb.hideout (name_code, address, type_id, country_id) VALUES ('Copy Shop', '45 High Street, London', 4, 149);
INSERT INTO kgb.hideout (name_code, address, type_id, country_id) VALUES ('Car Washer', '12 Via Roma, Rome', 2, 84);
INSERT INTO kgb.hideout (name_code, address, type_id, country_id) VALUES ('Delta', '653 Av. Insurgentes, Mexico City', 1, 113);
    
INSERT INTO kgb.mission_status (label) VALUES
	('En préparation'),
    ('En cours'),
    ('Terminée'),
    ('Echec');
	
INSERT INTO kgb.user_role (label) VALUES
	('ADMIN'),
	('MODERATOR'),
	('USERS');
	
INSERT INTO kgb.users (lastname, firstname, mail, pass_word, creation_date, role_id) VALUES
	('Martignon', 'Lucas', 'lucas.martignon@wanadoo.fr', '$2y$10$rVrjWU5fawCl4JQXy.1wRekMz9gX/eyvw1W8h6cCD74OkY2BxQrWe', now(), 1),
	('ADM', 'adm', 'adm@example.fr', '$2y$10$rVrjWU5fawCl4JQXy.1wRekMz9gX/eyvw1W8h6cCD74OkY2BxQrWe', now(), 1);

CALL kgb.new_mission(
	'Infiltration d\'entreprise', 
    '<b>Objectif de la mission</b> : Infiltrer les installations secrètes de la société concurrente Solaris pour récupérer des informations confidentielles sur leur dernière technologie de panneaux solaires.<br><br>
<b>Plan d\'action</b> : Vous serez envoyé en tant qu\'employé sous couverture chez Solaris, après avoir réussi à passer une série d\'entretiens et de tests de sécurité. Vous serez chargé de travailler dans le département de recherche et développement pour obtenir un accès complet aux informations sur leur technologie de pointe.<br><br>
Votre mission sera de recueillir autant d\'informations que possible sur leur technologie, notamment leurs plans de conception, leurs prototypes et leur calendrier de production. Vous devrez également identifier les membres clés de leur équipe de recherche et de développement et trouver un moyen de vous lier d\'amitié avec eux pour obtenir des informations supplémentaires.<br><br>
Vous aurez également accès à leur système informatique, et vous devrez télécharger les données les plus importantes et les plus confidentielles sur leur technologie de panneaux solaires, en vous assurant que vous ne laissez aucune trace.<br><br>
Vous devrez rester en contact avec votre équipe de soutien qui sera en dehors de l\'entreprise Solaris, en utilisant un téléphone portable crypté pour transmettre les informations que vous avez recueillies. Vous serez également équipé d\'un dispositif d\'écoute pour être en mesure de communiquer avec votre équipe de soutien en cas d\'urgence.<br><br>
Soyez conscient que si vous êtes découvert, votre couverture sera grillée, ce qui risque de compromettre non seulement votre mission, mais également la sécurité de votre équipe de soutien. Assurez-vous donc de ne jamais attirer l\'attention sur vous et de suivre toutes les procédures de sécurité.<br><br>
La mission se terminera lorsque vous aurez récupéré toutes les informations nécessaires et que vous aurez quitté les installations de Solaris sans éveiller les soupçons.', 
	'Eclipse', 
	149, 
    1, 
	'2023-03-13', 
	'2023-03-31', 
	1);
    
CALL assign_to_mission(16 ,1);
CALL assign_to_mission(9, 1);
CALL assign_to_mission(12, 1);
CALL hideout_to_mission(1, 1);

CALL kgb.new_mission(
	'Piratage de données confidentielles',
    '<b>Objectif de la mission</b> : Infiltrer les serveurs de la société "TechCorp" pour récupérer des informations confidentielles sur leur dernier projet de recherche en intelligence artificielle.<br><br>
<b>Plan d\'action</b> : Vous serez chargé d\'infiltrer les systèmes informatiques de TechCorp en utilisant des techniques avancées de piratage. Vous devrez accéder aux serveurs de la société pour récupérer des données sur leur projet de recherche en intelligence artificielle, y compris les plans de conception, les prototypes et les codes sources.<br><br>
Votre mission nécessitera une analyse préalable approfondie de la sécurité de TechCorp, y compris l\'identification des vulnérabilités dans leur système et la création de plans pour les exploiter. Vous devrez également préparer des logiciels de piratage personnalisés pour éviter de déclencher des alarmes de sécurité ou des mesures de détection.<br><br>
Une fois que vous aurez infiltré les systèmes informatiques de TechCorp, vous devrez naviguer dans leurs serveurs pour trouver les informations qui vous intéressent. Vous devrez également effacer toutes les traces de votre présence pour éviter d\'être détecté.<br><br>
Vous devrez également être en contact avec votre équipe de soutien qui sera en dehors de l\'entreprise TechCorp, en utilisant un système de communication crypté pour transmettre les informations que vous avez recueillies. Vous devrez être prêt à agir rapidement si votre présence est détectée, et à vous retirer en toute sécurité avec toutes les données que vous avez réussi à récupérer.<br><br>
Soyez conscient que si vous êtes découvert, les conséquences pourraient être graves, y compris des poursuites pénales et des dommages financiers importants pour votre employeur. Vous devrez donc prendre toutes les précautions nécessaires pour éviter d\'être détecté.<br><br>
La mission se terminera lorsque vous aurez récupéré toutes les informations nécessaires et que vous aurez effacé toutes les traces de votre présence sur les serveurs de TechCorp.',
	'Cyber-Archer',
	84,
    3,
    '2023-04-20',
    '2024-04-15',
   1
);

CALL assign_to_mission(18 ,2);
CALL assign_to_mission(6, 2);
CALL assign_to_mission(11, 2);
CALL hideout_to_mission(2, 2);

CALL kgb.new_mission(
	'Subversion au sein d\'un parti',
    '<b>Objectif de la mission</b> : Infiltrer un groupe extrémiste et compromettre leur plan de campagne.<br><br>
<b>Plan d\'action</b> : Vous serez envoyé sous couverture pour infiltrer un groupe extrémiste qui a planifié une campagne électoral contenant un programme allant à l\'encontre du gouvernement démocratiquement élu. Votre mission sera de collecter des informations sur leur plan d\'action, leurs membres clés, leurs sources de financement et leurs ressources.<br><br>
Une fois que vous aurez intégré le groupe, vous devrez gagner leur confiance et obtenir un accès à des informations sensibles. Vous devrez être capable de détecter les signes d\'une activité illégale ou dangereuse et d\'en informer votre équipe de soutien à l\'extérieur.<br><br>
Si vous découvrez que le groupe prépare une action violente ou illégale, vous devrez agir rapidement pour empêcher leur plan en avertissant les autorités compétentes. Vous devrez être prêt à risquer votre couverture pour empêcher tout préjudice ou dommage aux individus ou aux institutions.<br><br>
Votre mission se terminera lorsque vous aurez collecté suffisamment d\'informations pour permettre aux autorités de démanteler le groupe ou de prévenir leur action de subversion. Vous devrez également vous assurer de quitter le groupe sans éveiller les soupçons et de protéger votre couverture pour des missions futures.<br><br>',
	'Phoenix',
    113,
    7,
    '2023-07-01',
    '2025-08-01',
    1
);

CALL assign_to_mission(17 ,3);
CALL assign_to_mission(7, 3);
CALL assign_to_mission(1, 3);
CALL assign_to_mission(13, 3);
CALL hideout_to_mission(3, 3);