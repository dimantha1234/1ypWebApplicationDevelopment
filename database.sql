CREATE USER 'id18643062_healthline'@'localhost' IDENTIFIED BY '+o]ITN522Opap<|k';
GRANT ALL PRIVILEGES ON id18643062_healthlineclinic.* TO 'id18643062_healthline'@'localhost';

CREATE DATABASE IF NOT EXISTS id18643062_healthlineclinic;

USE id18643062_healthlineclinic;

CREATE TABLE doctors( -- admins updates the doctor table
		doc_id INTEGER AUTO_INCREMENT,
		doc_name VARCHAR(50),
		doc_tp VARCHAR(10),
		doc_specialization VARCHAR(50),
		doc_hospital VARCHAR(50),
		PRIMARY KEY (doc_id)
		);
		
CREATE TABLE users( -- users sign up by themselves
		usr_id VARCHAR(15),
		usr_email VARCHAR(100), -- login by using this
		usr_pwd VARCHAR(100), -- encrypted users password
		usr_name VARCHAR(255),
		usr_tp VARCHAR(10),
		usr_address VARCHAR(255),
		usr_gender VARCHAR(10),
		allergies VARCHAR(1000),
		usr_age VARCHAR(10),
		usr_country VARCHAR(20),
		usr_role VARCHAR(5) DEFAULT 'user', -- indicate if the user is an admin or a patient
		member_since DATETIME DEFAULT CURRENT_TIMESTAMP,
		PRIMARY KEY (usr_id)
		);
		
CREATE TABLE appointments(
		apn_id INTEGER AUTO_INCREMENT,
		apn_time DATETIME,
		usr_id VARCHAR(15),
		doc_id INTEGER,
		PRIMARY KEY (apn_id),
		FOREIGN KEY (usr_id) REFERENCES users(usr_id),
		FOREIGN KEY (doc_id) REFERENCES doctors(doc_id)
		);
		
CREATE TABLE health_records( -- doctor/nurse enters diagnosis data here
		rec_id INTEGER AUTO_INCREMENT,
		rec_time DATETIME DEFAULT CURRENT_TIMESTAMP,
		record_data VARCHAR(1000),
		usr_id VARCHAR(10),
		PRIMARY KEY (rec_id),
		FOREIGN KEY (usr_id) REFERENCES users(usr_id)
		);
		
INSERT INTO `doctors` ( `doc_name`, `doc_tp`, `doc_specialization`, `doc_hospital`) VALUES
	('Mr.W.G.Perera', '077123456789', 'Eye', 'Durdans'),
	('Ms.V.Karunathna', '077123456789', 'Brain', 'Apollo'),
	('Ms.Y.A.Pokunegoda', '077123456789', 'Dental', 'Durdans'),
	('Mr.A.Wikckramagamage', '077123456789', 'Brain', 'Durdans'),
	('Mr.D.Thilakasiri', '077123456789', 'Dental', 'Apollo'),
	('Ms.R.Fernando', '077123456789', 'Eye', 'Apollo');
	
INSERT INTO `users` (`usr_id`, `usr_email`, `usr_pwd`, `usr_name`, `usr_tp`, `usr_address`, `usr_gender`, `allergies`, `usr_age`, `usr_country`, `usr_role`, `member_since`) VALUES
	('admin', 'admin_mail', '$2y$10$kOs91jgv4HmjJua0ASh3SeC/151TKMVCklHMz7Y85q0toku5fIpSO', 'admin', '0772659856', 'admin_city', 'M', NULL, '32', 'Sri-Lanka', 'admin', '2022-03-20 02:01:13');
	
		