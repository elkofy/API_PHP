CREATE TABLE IF NOT EXISTS `produit` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`nom` varchar(256) NOT NULL,
`description` text NOT NULL,
 `token` varchar(256) NOT NULL,
`prix` int(255) NOT NULL,
  `stock` int(255) NOT NULL,
`category_id` int(11) NOT NULL,
`created_at` datetime,
`modified` timestamp DEFAULT CURRENT_TIMESTAMP,
primary key (id)
) 

CREATE TABLE IF NOT EXISTS `user` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`nom` varchar(256) NOT NULL,
`prenom` varchar(256) NOT NULL,
`token` varchar(256) NOT NULL,
`role` varchar(256) NOT NULL,
`created_at` datetime,
`modified` timestamp DEFAULT CURRENT_TIMESTAMP,
primary key (id)
)

INSERT INTO produit (nom, description, token, prix, stock, category_id, created_at) VALUES ('produit1', 'description1', 'token1', 1, 1, 1, '2019-01-01 00:00:00');
INSERT INTO produit (nom, description, token, prix, stock, category_id, created_at) VALUES ('produit2', 'description2', 'token2', 2, 2, 2, '2019-01-01 00:00:00');
INSERT INTO `user`( `nom`, `prenom`, `token`, `role`, `created_at`, `modified`) VALUES ('admin','admin','admin','admin','2019-01-01 00:00:00','2019-01-01 00:00:00')
INSERT INTO `user`( `nom`, `prenom`, `token`, `role`, `created_at`, `modified`) VALUES ('Daikh','Nassim','admin','admin','2019-01-01 00:00:00','2019-01-01 00:00:00')