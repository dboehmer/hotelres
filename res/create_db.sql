
-- Create new, empty database for project HOTELRES --


-- delete tables if existing
DROP TABLE IF EXISTS bookings;
DROP TABLE IF EXISTS guests;
DROP TABLE IF EXISTS rooms;

-- provides basic information about rooms
CREATE TABLE rooms(
	id INT NOT NULL AUTO_INCREMENT,
	PRIMARY KEY(id),
	name VARCHAR(30)
	);

CREATE TABLE guests(
    id INT NOT NULL AUTO_INCREMENT,
    PRIMARY KEY(id),
    firstname VARCHAR(50),
    lastname VARCHAR(50),
    street VARCHAR(50),
    number VARCHAR(10),
    zip VARCHAR(10),
    city VARCHAR(50),
    country VARCHAR(50),
    phone VARCHAR(50),
    email VARCHAR(50)
    );

-- gathers information about single bookings
CREATE TABLE bookings(
	id INT NOT NULL AUTO_INCREMENT,
	PRIMARY KEY(id),
	room INT NOT NULL,	-- points to rooms.id
    guest INT NOT NULL,   -- points to guests.id
	beginn DATE NOT NULL, -- start date
	end DATE NOT NULL,   -- end date
	comment varchar(500)   -- free field for entering useful information, e.g. special wishes
	);



