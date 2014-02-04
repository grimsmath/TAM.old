/*
 * Begin: System Tables (for use internally by TAM)
 */
DROP TABLE IF EXISTS User;
CREATE TABLE IF NOT EXISTS User (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
								 username VARCHAR(50) NOT NULL,
								 password VARCHAR(50) NOT NULL,
								 first_name VARCHAR(50) NOT NULL,
								 last_name VARCHAR(50) NOT NULL,
								 user_role_id INTEGER NOT NULL,
 								 user_is_active BOOL NOT NULL,
								 FOREIGN KEY(user_role_id) REFERENCES UserRole(id));

DROP TABLE IF EXISTS UserRole;
CREATE TABLE IF NOT EXISTS UserRole (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
									 role_name VARCHAR(255));
									 
DROP TABLE IF EXISTS Session;
CREATE TABLE IF NOT EXISTS Session (session_id VARCHAR(40) PRIMARY KEY DEFAULT '0' NOT NULL, 
									ip_address VARCHAR(16) DEFAULT '0' NOT NULL, 
									user_agent VARCHAR(50) NOT NULL,
									last_activity INTEGER UNSIGNED DEFAULT 0 NOT NULL,
									user_data TEXT DEFAULT '' NOT NULL);
									
/*
 * Application data tables
 */
DROP TABLE IF EXISTS History;
CREATE TABLE IF NOT EXISTS History (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
									date TEXT NOT NULL,
									time TEXT NOT NULL,
									table_name TEXT NOT NULL,
									row_id INTEGER NOT NULL,
									action TEXT NOT NULL,
									username VARCHAR(50) NOT NULL,
									sql_statement TEXT NOT NULL);
 
DROP TABLE IF EXISTS Assignment;
CREATE TABLE IF NOT EXISTS Assignment (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
									   assignment_decal_id INTEGER NOT NULL,
									   assignment_user_id INTEGER NOT NULL,
									   assignment_position_id INTEGER NOT NULL,
									   assignment_lab_id INTEGER NOT NULL,
									   assignment_status INTEGER NOT NULL,
									   assignment_notes TEXT,
									   FOREIGN KEY(assignment_decal_id) REFERENCES Asset(id),
									   FOREIGN KEY(assignment_user_id) REFERENCES User(id),
									   FOREIGN KEY(assignment_position_id) REFERENCES Position(id),
									   FOREIGN KEY(assignment_lab_id) REFERENCES User(id));
													 
DROP TABLE IF EXISTS Asset;
CREATE TABLE IF NOT EXISTS Asset(id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, 
								 asset_decal VARCHAR(255) NOT NULL, 
								 asset_serial VARCHAR(255),
								 asset_model_id INTEGER,
								 asset_cpu_id INTEGER,
								 asset_ram INTEGER,
								 asset_os_id INTEGER,
								 asset_loc_id INTEGER,
								 asset_status_id INTEGER,
								 asset_mac_addr VARCHAR(50),
								 asset_wifi_mac_addr VARCHAR(50),
								 asset_purchase_date VARCHAR(50),
								 asset_warranty_begin VARCHAR(50),
								 asset_warranty_end VARCHAR(50),
								 asset_survey_number VARCHAR(255),
								 asset_survey_date VARCHAR(50),
								 asset_notes TEXT,
								 FOREIGN KEY(asset_model_id) REFERENCES Model(id),
								 FOREIGN KEY(asset_cpu_id) REFERENCES CPU(id),
								 FOREIGN KEY(asset_os_id) REFERENCES OS(id),
								 FOREIGN KEY(asset_loc_id) REFERENCES Location(id),
								 FOREIGN KEY(asset_status_id) REFERENCES Status(id));
								 
DROP TABLE IF EXISTS Position;
CREATE TABLE IF NOT EXISTS Position (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
									 position_name VARCHAR(255),
									 position_number VARCHAR(50),
									 position_person_id INTEGER,
									 position_currency BOOL NOT NULL DEFAULT '0',
									 FOREIGN KEY(position_person_id) REFERENCES User(id));
									 								
DROP TABLE IF EXISTS Person;
CREATE TABLE IF NOT EXISTS Person (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
								   person_username VARCHAR(50) NOT NULL,
								   person_f_name VARCHAR(50) NOT NULL, 
								   person_l_name VARCHAR(50),
								   person_email VARCHAR(255),
								   person_extension VARCHAR(50),
								   person_loc_id INTEGER,
								   FOREIGN KEY(person_loc_id) REFERENCES Location(id));

DROP TABLE IF EXISTS Model;
CREATE TABLE IF NOT EXISTS Model (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
								  model_name VARCHAR(255) NOT NULL,
								  model_mfg_id INTEGER NOT NULL,
								  model_notes TEXT,
								  FOREIGN KEY(model_mfg_id) REFERENCES Model(id));

DROP TABLE IF EXISTS Manufacturer;
CREATE TABLE IF NOT EXISTS Manufacturer (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
										 mfg_name VARCHAR(255) NOT NULL,
										 mfg_website VARCHAR(255),
										 mfg_notes TEXT);

INSERT INTO "Manufacturer" VALUES ("1","Intel","http://www.intel.com","Processors");
INSERT INTO "Manufacturer" VALUES ("2","Dell","http://www.dell.com","Servers, desktops, laptops, peripherals");
INSERT INTO "Manufacturer" VALUES ("3","Microsoft","http://www.microsoft.com","Operating systems and computer peripherals");
INSERT INTO "Manufacturer" VALUES ("4","Apple","http://www.apple.com","Desktops, laptops, tablets, phones, music devices, servers, accessories, other");
INSERT INTO "Manufacturer" VALUES ("5","Lenovo","http://www.lenovo.com","Servers, desktops, laptops, accessories");

DROP TABLE IF EXISTS OS;
CREATE TABLE IF NOT EXISTS OS (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, 
							   os_name VARCHAR(255) NOT NULL, 
							   os_mfg_id INTEGER, 
							   os_notes TEXT,
							   FOREIGN KEY(os_mfg_id) REFERENCES Manufacturer(id));

DROP TABLE IF EXISTS CPU;
CREATE TABLE IF NOT EXISTS CPU (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, 
								cpu_name VARCHAR(255) NOT NULL, 
								cpu_mfg_id INTEGER NOT NULL, 
								cpu_notes TEXT);

INSERT INTO "CPU" VALUES ("1","Pentium 4","1","");
INSERT INTO "CPU" VALUES ("2","Core Duo (Conroe)","1","");
INSERT INTO "CPU" VALUES ("3","Core 2 Duo","1","");
INSERT INTO "CPU" VALUES ("4","Core i3","1","");
INSERT INTO "CPU" VALUES ("5","Core i5","1","");
INSERT INTO "CPU" VALUES ("6","Core i7","1","");

DROP TABLE IF EXISTS Location;
CREATE TABLE IF NOT EXISTS Location (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, 
									 loc_name VARCHAR(255) NOT NULL,
									 loc_building VARCHAR(255),									 
									 loc_floor INTEGER, 
									 loc_room VARCHAR(255),
									 loc_type_id INTEGER,
									 loc_notes TEXT,
									 FOREIGN KEY(loc_type_id) REFERENCES LocationType(id));

DROP TABLE IF EXISTS LocationType;
CREATE TABLE IF NOT EXISTS LocationType (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
										 loc_type_name VARCHAR(255) NOT NULL);
									 
INSERT INTO "LocationType" VALUES ("1","Computer Lab");
INSERT INTO "LocationType" VALUES ("2","Classroom");
INSERT INTO "LocationType" VALUES ("3","Faculty Office");
INSERT INTO "LocationType" VALUES ("4","Conference Room");
INSERT INTO "LocationType" VALUES ("5","NOC");
INSERT INTO "LocationType" VALUES ("6","Research Lab");
INSERT INTO "LocationType" VALUES ("7","Classroom Lab");
INSERT INTO "LocationType" VALUES ("8","Workroom");
INSERT INTO "LocationType" VALUES ("9","Storage");
INSERT INTO "LocationType" VALUES ("10","Closet");
INSERT INTO "LocationType" VALUES ("11","Mounted Location");
INSERT INTO "LocationType" VALUES ("12","Other");
									 
DROP TABLE IF EXISTS Comment;
CREATE TABLE IF NOT EXISTS Comment (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
									comment_title VARCHAR(255),
									comment_text TEXT,
									comment_date VARCHAR(50),
									comment_time VARCHAR(50),
									/* Here are the local keys that match up with the foreign keys */
									comment_decal_id INTEGER,
									comment_assignment_id INTEGER,
									comment_mfg_id INTEGER,
									comment_model_id INTEGER,
									comment_cpu_id INTEGER,
									comment_os_id INTEGER,
									comment_person_id INTEGER,
									comment_position_id INTEGER,
									comment_loc_id INTEGER,
									FOREIGN KEY(comment_decal_id) REFERENCES Asset(asset_decal),
									FOREIGN KEY(comment_assignment_id) REFERENCES Assignment(id),
									FOREIGN KEY(comment_mfg_id) REFERENCES Manufacturer(id)
									FOREIGN KEY(comment_model_id) REFERENCES Model(id),
									FOREIGN KEY(comment_cpu_id) REFERENCES CPU(id),
									FOREIGN KEY(comment_os_id) REFERENCES OS(id),
									FOREIGN KEY(comment_person_id) REFERENCES Person(id),
									FOREIGN KEY(comment_position_id) REFERENCES Position(id),
									FOREIGN KEY(comment_loc_id) REFERENCES Location(id));
									
DROP TABLE IF EXISTS Attachment;
CREATE TABLE IF NOT EXISTS Attachment (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
									   attachment_path VARCHAR(255) NOT NULL,
									   attachment_decal_id INTEGER,
									   attachment_model_id INTEGER,
									   attachment_assignment_id INTEGER,
									   attachment_user_id INTEGER,
									   attachment_os_id INTEGER,
									   attachment_cpu_id INTEGER,
									   attachment_loc_id INTEGER,
									   attachment_mfg_id INTEGER,
									   FOREIGN KEY(attachment_decal_id) REFERENCES Asset(id),
									   FOREIGN KEY(attachment_model_id) REFERENCES Model(id),
									   FOREIGN KEY(attachment_assignment_id) REFERENCES Assignment(id),
									   FOREIGN KEY(attachment_user_id) REFERENCES User(id),
									   FOREIGN KEY(attachment_os_id) REFERENCES OS(id),
									   FOREIGN KEY(attachment_cpu_id) REFERENCES CPU(id),
									   FOREIGN KEY(attachment_loc_id) REFERENCES Location(id),
									   FOREIGN KEY(attachment_mfg_id) REFERENCES Manufacturer(id));
									   
DROP TABLE IF EXISTS Status;
CREATE TABLE IF NOT EXISTS Status (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
								   status_name VARCHAR(255) NOT NULL,
								   status_notes TEXT);									 

INSERT INTO "Status" VALUES ("1","In Use","Unit is currently in use");
INSERT INTO "Status" VALUES ("2","Inactive","Unit is not currently in use but is otherwise in good condition");
INSERT INTO "Status" VALUES ("3","Out of Order","Unit is not in working order");
INSERT INTO "Status" VALUES ("4","Out for Service","Unit is currently being serviced");
INSERT INTO "Status" VALUES ("5","Surveyed","Unit has been surveyed after being decomissioned");

DROP VIEW IF EXISTS VIEW_CPU;
CREATE VIEW "VIEW_CPU" AS SELECT * FROM CPU JOIN Manufacturer ON Manufacturer.id = CPU.cpu_mfg_id;

DROP VIEW IF EXISTS VIEW_LOCATION;
CREATE VIEW "VIEW_LOCATION" AS SELECT * FROM Location JOIN LocationType ON LocationType.id = Location.loc_type_id;

DROP VIEW IF EXISTS VIEW_PEOPLE;
CREATE VIEW "VIEW_PEOPLE" AS SELECT * FROM Person JOIN Location ON Location.id = Person.person_loc_id;

DROP VIEW IF EXISTS VIEW_OS;
CREATE VIEW "VIEW_OS" AS SELECT * FROM OS JOIN Manufacturer ON Manufacturer.id = OS.os_mfg_id;	

DROP VIEW IF EXISTS VIEW_POSITIONS;
CREATE VIEW "VIEW_POSITIONS" AS SELECT * FROM Position LEFT OUTER JOIN Person ON Person.id = Position.position_person_id;

DROP VIEW IF EXISTS VIEW_USERS;
CREATE VIEW "VIEW_USERS" AS
	SELECT
		u.username,
		u.first_name,
		u.last_name,
		u.user_is_active,
		u.user_role_id,
		r.role_name
	FROM 
		User u
	JOIN 
		UserRole r
	ON 
		r.id = u.user_role_id