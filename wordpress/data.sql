CREATE TABLE IF NOT EXISTS `vp_post2visitor` (
  `id` int(11) NOT NULL auto_increment,
  `post` int(11) NOT NULL,
  `visitor` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `vp_post2transaction` (
  `id` int(11) NOT NULL auto_increment,
  `post` int(11) NOT NULL,
  `transaction` date NOT NULL,
  `cost` decimal(10,2) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
