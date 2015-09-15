CREATE TABLE IF NOT EXISTS users(
	username varchar(100) PRIMARY KEY,
	password varchar(100) NOT NULL,
	email varchar(100) NOT NULL,
	givenname varchar(100) NOT NULL,
	surname varchar(100) NOT NULL,
	homeaddress varchar(100) NOT NULL
);

CREATE TABLE IF NOT EXISTS orders(
	username varchar(100) FOREIGN KEY REFERENCES users,
	ordernbr serial NOT NULL,
	CONSTRAINT order_pk PRIMARY KEY (username, ordernbr)
);

CREATE TABLE IF NOT EXISTS items(
	itemname varchar(100) NOT NULL,
	index serial PRIMARY KEY,
	price int NOT NULL
);

CREATE TABLE IF NOT EXISTS ordereditems(
	itemnbr serial FOREIGN KEY REFERENCES items,
	ordernbr serial FOREIGN KEY REFERENCES orders,
	nbr int NOT NULL
);