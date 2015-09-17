CREATE TABLE IF NOT EXISTS users(
	username varchar(100) PRIMARY KEY,
	password varchar(255) NOT NULL,
	email varchar(100) NOT NULL,
	givenname varchar(100) NOT NULL,
	surname varchar(100) NOT NULL,
	homeaddress varchar(100) NOT NULL
);

CREATE TABLE IF NOT EXISTS orders(
	username varchar(100) NOT NULL,
	ordernbr int NOT NULL UNIQUE,
	CONSTRAINT order_pk PRIMARY KEY (ordernbr),
	FOREIGN KEY (username) REFERENCES users(username) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS items(
	indexnbr int PRIMARY KEY,
	itemname varchar(100) NOT NULL,
	price int NOT NULL
);

CREATE TABLE IF NOT EXISTS ordered_items(
	itemnbr int NOT NULL,
	ordernbr int NOT NULL,
	nbr int NOT NULL,
	CONSTRAINT ordered_item_pk PRIMARY KEY (itemnbr, ordernbr),
	CONSTRAINT itemnbr_fk FOREIGN KEY (itemnbr) REFERENCES items(indexnbr) ON DELETE CASCADE,
	CONSTRAINT ordernbr_fk FOREIGN KEY (ordernbr) REFERENCES orders(ordernbr) ON DELETE CASCADE
	
);