
-- Create new, empty database for projekt HOTELRES --


-- delete tables if existing
DROP TABLE IF EXISTS bookings;
DROP TABLE IF EXISTS rooms;

-- provides basic information about rooms
CREATE TABLE rooms(
	id INT NOT NULL AUTO_INCREMENT,
	PRIMARY KEY(id),
	name VARCHAR(30)
	);

-- gathers information about single bookings
CREATE TABLE bookings(
	id INT NOT NULL AUTO_INCREMENT,
	PRIMARY KEY(id),
	room INT NOT NULL,	-- points to rooms.id
	beginn DATE NOT NULL, --start date
	end DATE NOT NULL,    --end date
	comment varchar(500)
	);
