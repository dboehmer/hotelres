/*
 *      res/create_db.sql
 *      
 *      Copyright 2010 Daniel Böhmer <daniel.boehmer@it2007.ba-leipzig.de> and
 *                     Patrick Nicolaus <patrick.nicolaus@it2007.ba-leipzig.de>
 *      
 *      This file is part of Hotelres.
 * 
 *      Hotelres is free software; you can redistribute it and/or modify
 *      it under the terms of the GNU General Public License as published by
 *      the Free Software Foundation; either version 2 of the License, or
 *      (at your option) any later version.
 *      
 *      Hotelres is distributed in the hope that it will be useful,
 *      but WITHOUT ANY WARRANTY; without even the implied warranty of
 *      MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *      GNU General Public License for more details.
 *      
 *      You should have received a copy of the GNU General Public License
 *      along with this program; if not, write to the Free Software
 *      Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 *      MA 02110-1301, USA.
 */
 
 
-- Create new, empty database for project HOTELRES --


-- delete tables if existing
DROP TABLE IF EXISTS bookings;
DROP TABLE IF EXISTS guests;
DROP TABLE IF EXISTS rooms;
DROP TABLE IF EXISTS users;


-- gathers information about single bookings
CREATE TABLE bookings(
	id INT NOT NULL AUTO_INCREMENT,
	PRIMARY KEY(id),
	room INT NOT NULL,	-- points to rooms.id
    persons INT NOT NULL,  -- number of persons who will come
    guest INT NOT NULL,   -- points to guests.id
	begin DATE NOT NULL, -- start date
	end DATE NOT NULL,   -- end date
	comment varchar(500)   -- free field for entering useful information, e.g. special wishes
	);

-- holds information about a guest
CREATE TABLE guests(
    id INT NOT NULL AUTO_INCREMENT,
    PRIMARY KEY(id),
    firstname VARCHAR(50),   -- several types of contact information
    lastname VARCHAR(50),
    street VARCHAR(50),
    number VARCHAR(10),
    zip VARCHAR(10),
    city VARCHAR(50),
    country VARCHAR(50),
    phone VARCHAR(50),
    email VARCHAR(50)
    );

-- provides basic information about rooms
CREATE TABLE rooms(
	id INT NOT NULL AUTO_INCREMENT,
	PRIMARY KEY(id),
	name VARCHAR(30),   -- name of the room, e.g. "Room 23" / "Appartment 42"
    capacity INT   -- maximum number of guests in this room
	);

-- lists all users with password and their rights
CREATE TABLE users(
    id INT NOT NULL AUTO_INCREMENT,
	PRIMARY KEY(id),
    username VARCHAR(50) NOT NULL,   -- credentials
    password VARCHAR(50) NOT NULL,
    salt VARCHAR(50) NOT NULL,   -- so called salt value for improving password security
    rights SET("guest","manager","admin") NOT NULL   -- different type of accounts
    );

-- create default user with admin rights
INSERT INTO users (username, salt, password, rights) VALUES("admin", "admin", SHA1("adminadmin"), "admin");

