
--
-- Structure de la table `ecrit`
--

CREATE TABLE `ecrit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) NOT NULL,
  `contenu` text,
  `dateEcrit` datetime NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `idAuteur` int(11) NOT NULL,
  `idAmi` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Structure de la table `lien`
--

CREATE TABLE `lien` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idUtilisateur1` int(11) NOT NULL,
  `idUtilisateur2` int(11) NOT NULL,
  `etat` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


-- une donnée dans la table ecrit

INSERT INTO `ecrit` (`id`, `titre`, `contenu`, `dateEcrit`, `image`, `idAuteur`, `idAmi`) VALUES
(1, 'test', 'alors comment ca va', '2017-10-10 16:57:14', '', 1, 1);

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(100) NOT NULL,
  `mdp` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `remember` varchar(255) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `login` (`login`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `login`, `mdp`, `email`, `remember`, `avatar`) VALUES
(1, 'gilles', '*A4B6157319038724E3560894F7F932C8886EBFCF', 'gilles@toto.fr', '', '');
COMMIT;
INSERT INTO `user` (`id`, `login`, `mdp`, `email`, `remember`, `avatar`) VALUES
(2, 'theo', '*A4B6157319038724E3560894F7F932C8886EBFCF', 'theo@toto.fr', '', '');
COMMIT;
INSERT INTO `user` (`id`, `login`, `mdp`, `email`, `remember`, `avatar`) VALUES
(1, 'zelia', '*A4B6157319038724E3560894F7F932C8886EBFCF', 'zelia@toto.fr', '', '');
COMMIT;