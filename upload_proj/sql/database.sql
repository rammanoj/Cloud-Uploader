
CREATE TABLE user (

	id int NOT NULL AUTO_INCREMENT,
	username varchar(200) NOT NULL,
  password varchar(200) NOT NULL,
	length varchar(200) NOT NULL,
	user_id varchar(200) NOT NULL,
	email varchar(200) NOT NULL,
	country varchar(200) NOT NULL,
	state varchar(200) NOT NULL,
	mobile varchar(200) NOT NULL,
	status varchar(200) NOT NULL,
	directory varchar(200),
	session_id varchar(200),
	PRIMARY KEY (id)
);


INSERT INTO user (username, password, user_id,
	 email, country, state, mobile, length,
	  status, directory ) VALUES ('admin', '3ff0b6f3d2f9985a90c5ff7f14e62709',
			 'admin_user_id', 'rammanojpotla1608@gmail.com', 'India', 'kerala', '', '10', 'admin', 'all' )
