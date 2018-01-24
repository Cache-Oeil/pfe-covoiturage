CREATE DATABASE `covoiturage`;

CREATE TABLE `compte` (
  `id_compte` int(11) NOT NULL AUTO_INCREMENT,
  `nom` VARCHAR(32) CHARACTER SET utf8 NOT NULL,
  `prenom` VARCHAR(32) CHARACTER SET utf8 NOT NULL,
  `username` VARCHAR(32) CHARACTER SET utf8 NOT NULL,
  `password` VARCHAR(32) CHARACTER SET utf8 NOT NULL,
  `age` int (11) NOT NULL,
  `sexe` char(5) NOT NULL,
  `telephone` int(11) NOT NULL,
  `email` VARCHAR(100) CHARACTER SET utf8 NOT NULL,
  `url_avatar` text CHARACTER SET utf8 NOT NULL,
  `date_inscription` datetime NOT NULL,
  `statut` int(11) NOT NULL,
  CONSTRAINT `pk_compte` PRIMARY KEY (`id_compte`)
) ENGINE=MYISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `compte`
    ADD CONSTRAINT `username` UNIQUE (`username`),
    ADD CONSTRAINT `email` UNIQUE (`email`);


INSERT INTO `compte` (`id_compte`, `nom`, `prenom`, `username`, `password`, `age`, `sexe`, `telephone`, `email`,
`url_avatar`, `date_inscription`, `statut`) VALUES
(1, 'CHAU', 'Khac Quoc Bao', 'falcon', md5('falcon'), '22', 'homme', '0751148330', 'baochow95@gmail.com', '', '2017-12-04', '0'),
(2, 'CHOU', 'Remz', 'remz', md5('bloodymonday'), '22', 'homme', '01214602706', 'yagamikokuho@gmail.com', '', '2017-12-04', '0'),
(3, 'Kaneki', 'Ken', 'OEK', md5('khaihoan'), '22', 'homme', '123456789', 'OEK@tokyo.ghoul', 'https://pbs.twimg.com/profile_images/820533094813794305/9GCHJLjK_400x400.jpg', '', '0'),
(4, 'Hikigaya', 'Hachiman', '8man', md5('khaihoan'), '18', 'homme', '147258369', 'SNTFU@oregairu.seishun', 'https://pbs.twimg.com/profile_images/592698985837649922/VPqDa1pf.png', '', '0');


CREATE TABLE `point` (
  `id_point` int(11) NOT NULL AUTO_INCREMENT,
  `nom` VARCHAR(60) CHARACTER SET utf8 NOT NULL,
  `adresse` VARCHAR (100) CHARACTER SET utf8 NOT NULL,
  `lat` FLOAT(10,6) NOT NULL ,
  `lng` FLOAT(10,6) NOT NULL ,
  CONSTRAINT `pk_point` PRIMARY KEY (`id_point`)
) ENGINE=MYISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


INSERT INTO `point` (`id_point`, `nom`, `adresse`, `lat`, `lng`) VALUES
(1, 'Ecole Primaire Cassandre Salviati', '2 Rue Agrippa d''Aubigné, Mer, France', '47.700603', '1.502828'),
(2, 'Ecole Maternelle Les Mérolles', 'Rue Basse d''Aulnay, Mer, France', '47.706878', '1.499612'),
(3, 'Ecole Maternelle De La Brêche', '7 Rue de la Brèche, Mer, France', '47.702896', '1.508067'),
(4, 'Ecole De Musique', '28 route d''Orléans, Mer, France', '47.705300', '1.518452'),
(5, 'Complexe Sportif Bernard Guimont', 'Rue De Berthelottes, Mer, France', '47.698513', '1.498582');


CREATE TABLE `trajet` (
  `id_trajet` int(11) NOT NULL AUTO_INCREMENT,
  `id_conducteur` int(11) NOT NULL,
  `pt_depart` int(11) NOT NULL,
  `pt_arrive` int(11) NOT NULL,
  `places` int(11) NOT NULL,
  `date_depart` datetime NOT NULL,
  CONSTRAINT `pk_trajet` PRIMARY KEY (`id_trajet`)
) ENGINE=MYISAM DEFAULT CHARSET=utf8;

ALTER TABLE `trajet`
    ADD CONSTRAINT `conducteur` FOREIGN KEY (`id_conducteur`) REFERENCES `compte` (`id_compte`),
    ADD CONSTRAINT `depart` FOREIGN KEY(`pt_depart`) REFERENCES `point` (`id_point`),
    ADD CONSTRAINT `arrive` FOREIGN KEY(`pt_arrive`) REFERENCES `point` (`id_point`);


CREATE TABLE `reservation` (
  `id_reservation` int(11) NOT NULL AUTO_INCREMENT,
  `id_passager` int(11) NOT NULL,
  `id_trajet` int(11) NOT NULL,
  `statut` int(11) NOT NULL,
  CONSTRAINT `pk_reservation` PRIMARY KEY (`id_reservation`)
) ENGINE=MYISAM DEFAULT CHARSET=utf8;

ALTER TABLE `reservation`
    ADD CONSTRAINT `passager` FOREIGN KEY (`id_passager`) REFERENCES `compte` (`id_compte`),
    ADD CONSTRAINT `trajet` FOREIGN KEY (`id_trajet`) REFERENCES `trajet` (`id_trajet`);

CREATE TABLE `message` (
  `id_message` int(11) NOT NULL AUTO_INCREMENT,
  `emetteur` int(11) NOT NULL,
  `recepteur` int(11) NOT NULL,
  `texte` text CHARACTER SET utf8 NOT NULL,
  `date_envoye` datetime NOT NULL,
  `statut` int(11) NOT NULL,
  CONSTRAINT `pk_message` PRIMARY KEY (`id_message`),
  FOREIGN KEY (`emetteur`) REFERENCES `compte` (`id_compte`),
  FOREIGN KEY (`recepteur`) REFERENCES `compte` (`id_compte`)
) ENGINE = MYISAM DEFAULT CHARSET=utf8;
