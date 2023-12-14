DROP DATABASE IF EXISTS sipcheer_dksipcheer;
CREATE DATABASE sipcheer_dksipcheer;
USE sipcheer_dksipcheer;

CREATE TABLE Profile (
ProfileID int AUTO_INCREMENT NOT NULL PRIMARY KEY,
Username varchar(100),
Fname varchar(100),
Lname varchar(100),
Email varchar(100),
Pass varchar(255),
Avatar varchar(255),
Birthdate date,
IsAdmin TINYINT(1) DEFAULT 0,
IsBlocked TINYINT(1) DEFAULT 0,
last_login TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
last_modified TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
 
CREATE TABLE Media (
MediaID int AUTO_INCREMENT NOT NULL PRIMARY KEY,
URL varchar(1000),
mediaTitle text,
mediaDesc text,
mediaComment text, 
mediaLike int DEFAULT 0,
MediaProfileFK int NOT NULL,
FOREIGN KEY (MediaProfileFK) REFERENCES Profile (ProfileID)
);

CREATE TABLE Comment (
    CommentID int AUTO_INCREMENT NOT NULL PRIMARY KEY,
    CommentText TEXT NOT NULL,
    dato date NOT NULL,
    MediaCommentFK INT NOT NULL,
    ProfileFK INT NOT NULL,
    FOREIGN KEY (MediaCommentFK) REFERENCES Media (MediaID),
    FOREIGN KEY (ProfileFK) REFERENCES Profile (ProfileID)
);

CREATE TABLE Likes (
    LikeID int AUTO_INCREMENT NOT NULL PRIMARY KEY,
    LikeAmount int,
    MediaLikeFK int NOT NULL,
    ProfileLikeFK int NOT NULL,
    FOREIGN KEY (MediaLikeFK) REFERENCES Media (MediaID),
    FOREIGN KEY (ProfileLikeFK) REFERENCES Profile (ProfileID)
);



INSERT INTO Profile VALUES (NULL, "Smth", "Kasper", "Schmidt", "Kasper.schmidt1@hotmail.com", "123", "213", "1998-05-05", 0, 0, 2023-11-07 23:08:43,2023-11-07 13:58:00);
INSERT INTO Profile VALUES (NULL, "Chell", "Michele", "Andersen", "MA@hotmail.com", "321", "321", "2003-05-05", 0, 0, 2023-11-01 13:08:10,2023-11-07 13:58:00);
INSERT INTO Profile (ProfileID, Username, Fname, Lname, Email, Pass, Avatar, Birthdate, IsAdmin, IsBlocked, last_login, last_modified)
VALUES (NULL, "admin", "admin", "admin", "admin@admin.com", "adminpass", "admin.png", "2000-01-01", 1, 0, '2023-11-07 13:58:00', '2023-11-07 13:58:00');


INSERT INTO Media VALUES (NULL, "title", "text", "textt", "2", "2", NULL);
INSERT INTO Comment VALUES (NULL, "Chell", "11", "2");


DELIMITER //
CREATE TRIGGER before_update_profile
BEFORE UPDATE ON Profile
FOR EACH ROW
BEGIN
    SET NEW.last_modified = CURRENT_TIMESTAMP;
END; //
DELIMITER ;

CREATE TRIGGER update_last_login
BEFORE UPDATE ON Profile
FOR EACH ROW
SET NEW.last_login = CURRENT_TIMESTAMP;



