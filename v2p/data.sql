CREATE TABLE IF NOT EXISTS `v2p_post_visitor` (
  `post_visitor_id` int(11) NOT NULL auto_increment,
  `post_id` int(11) NOT NULL,
  `visitors` int(11) NOT NULL,
  PRIMARY KEY  (`post_visitor_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `v2p_post_transaction` (
  `post_transaction_id` int(11) NOT NULL auto_increment,
  `post` int(11) NOT NULL,
  `transaction` date NOT NULL,
  `cost` decimal(10,2) NOT NULL,
  `request_transaction_id` int(11) NOT NULL,
  PRIMARY KEY  (`post_transaction_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `v2p_request_transaction` (
  `request_transaction_id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL,
  `request` date NOT NULL,
  `transaction` date NOT NULL,
  `cost` decimal(10,2) NOT NULL,
  `description` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY  (`request_transaction_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
