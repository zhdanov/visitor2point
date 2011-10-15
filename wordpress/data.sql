CREATE TABLE IF NOT EXISTS `v2p_post_visitor` (
  `id` int(11) NOT NULL auto_increment,
  `post` int(11) NOT NULL,
  `visitor` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `v2p_post_transaction` (
  `id` int(11) NOT NULL auto_increment,
  `post` int(11) NOT NULL,
  `transaction` date NOT NULL,
  `cost` decimal(10,2) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `v2p_request_transaction` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL,
  `request` date NOT NULL,
  `transaction` date NOT NULL,
  `cost` decimal(10,2) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
