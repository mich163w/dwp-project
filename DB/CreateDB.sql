DROP DATABASE IF EXISTS SipCheer;
CREATE DATABASE SipCheer;
USE SipCheer;

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
CommentText text, 
LikeCount int,
MediaCommentFK int NOT NULL,
FOREIGN KEY (MediaCommentFK) REFERENCES Media (MediaID)
);

CREATE TABLE Likes (
LikeID int AUTO_INCREMENT NOT NULL PRIMARY KEY,
LikeAmount int,
MediaLikeFK int NOT NULL,
FOREIGN KEY (MediaLikeFK) REFERENCES Media (MediaID)
);



INSERT INTO Profile VALUES (NULL, "SxySmth", "Kasper", "Schmidt", "Kasper.schmidt1@hotmail.com", "123", "213", "1998-05-05", 0, 0);
INSERT INTO Profile VALUES (NULL, "Chell", "Michele", "Andersen", "MA@hotmail.com", "321", "321", "2003-05-05", 0, 0);
INSERT INTO Profile VALUES (NULL, "admin", "admin", "admin", "admin@admin.com", "adminpass", "admin.png", "2000-01-01", 1, 0);

INSERT INTO Media VALUES (NULL, "title", "text", "textt", "2", "2");
INSERT INTO Comment VALUES (NULL, "Chell", "11", "2");


DELIMITER //

CREATE TRIGGER before_update_profile
BEFORE UPDATE ON Profile
FOR EACH ROW
BEGIN
    SET NEW.last_modified = CURRENT_TIMESTAMP();
END;

//

DELIMITER ;
