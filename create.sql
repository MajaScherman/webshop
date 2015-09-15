CREATE TABLE IF NOT EXISTS users(
	username varchar(100) PRIMARY KEY,
	password varchar(100) NOT NULL,
	email varchar(100) NOT NULL,
	givenname varchar(100) NOT NULL,
	surname varchar(100) NOT NULL,
	homeaddress varchar(100) NOT NULL
);

CREATE TABLE IF NOT EXISTS orders(
	username varchar(100) NOT NULL,
	ordernbr serial NOT NULL,
	CONSTRAINT order_pk PRIMARY KEY (username, ordernbr),
	CONSTRAINT username_fk FOREIGN KEY (username) REFERENCES users(username) ON DELETE CASCADE,
);

CREATE TABLE IF NOT EXISTS items(
	itemname varchar(100) NOT NULL,
	index serial PRIMARY KEY,
	price int NOT NULL
);

CREATE TABLE IF NOT EXISTS ordereditems(
	itemnbr serial NOT NULL,
	ordernbr serial NOT NULL,
	nbr int NOT NULL,
	CONSTRAINT itemnbr_fk FOREIGN KEY (itemnbr) REFERENCES items(index) ON DELETE CASCADE,
	CONSTRAINT ordernbr_fk FOREIGN KEY (ordernbr) REFERENCES orders(ordernbr) ON DELETE CASCADE,
);