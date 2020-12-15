DROP TABLE IF EXISTS `commentaire`;
CREATE TABLE IF NOT EXISTS `commentaire` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idUser` int(11) NOT NULL,
  `contenu` text COLLATE utf8_unicode_ci NOT NULL,
  `idPost` int(11) NOT NULL,
  `dateCommentaire` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `comments`
--

INSERT INTO `comments` (`id`, `idUser`, `content`, `idPost`, `dateComment`, `image`) VALUES
(1, 6, 'Ceci un test de commentaire... Bonjour.', 2, '02/12/20 à 20h05', ''),
(2, 6, 'Encore un test de commentaire où j\'écris n\'importe quoi. Je sais pas pourquoi j\'écrit ça.', 2, '02/12/20 à 20h12', '');
