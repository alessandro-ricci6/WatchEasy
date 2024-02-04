CREATE TABLE users (
	userId INT NOT NULL AUTO_INCREMENT,
	username VARCHAR(30) NOT NULL,
	pass VARCHAR(255) NOT NULL,
	img VARCHAR(255) DEFAULT 'deafult.png',
	email VARCHAR(50) NOT NULL,
	PRIMARY KEY (userId)
);
CREATE TABLE log_attempts (
  `user_id` INT(11) NOT NULL,
  `time` VARCHAR(30) NOT NULL,
  FOREIGN KEY (user_id) REFEREnCES users(userId)
) ENGINE=InnoDB
CREATE TABLE showSaved(
	savedId INT NOT NULL AUTO_INCREMENT,
	showId INT NOT NULL,
	userId INT NOT NULL,
	PRIMARY KEY (savedId),
	FOREIGN KEY (userId) REFERENCES users(userId)
);
CREATE TABLE post (
	postId INT NOT NULL AUTO_INCREMENT,
	userId INT NOT NULL,
	showId INT NOT NULL,
	seasonId INT,
	episodeId INT,
	img VARCHAR(255),
	paragraph VARCHAR(255) NOT NULL,
	pubTime DATETIME,
	PRIMARY KEY (postId),
	FOREIGN KEY (userId) REFEREnCES users(userId)
);
CREATE TABLE notification(
	notificationId INT NOT NULL AUTO_INCREMENT,
	fromUserId INT NOT NULL,
	toUserId INT NOT NULL,
	postId INT,
	notificationType INT NOT NULL,
	notificationRead tinyint NOT NULL,
	PRIMARY KEY (notificationId),
	FOREIGN KEY (fromUserId) REFERENCES users(userId),
	FOREIGN KEY (toUserId) REFERENCES users(userId),
	FOREIGN KEY (postId) REFERENCES post(postId)
);
CREATE TABLE likes(
	likeId INT NOT NULL AUTO_INCREMENT,
	userId INT NOT NULL,
	PRIMARY KEY (likeId),
	FOREIGN KEY (userId) REFERENCES users(userId)
);
CREATE TABLE follow(
	followId INT NOT NULL AUTO_INCREMENT,
	fromUserId INT NOT NULL,
	toUserId INT NOT NULL,
	PRIMARY KEY (followId),
	FOREIGN KEY (fromUserId) REFERENCES users(userId),
	FOREIGN KEY (toUserId) REFERENCES users(userId)
);
CREATE TABLE comments(
	commentId INT NOT NULL AUTO_INCREMENT,
	comm VARCHAR(255) NOT NULL,
	postId INT NOT NULL,
	userId INT NOT NULL,
	PRIMARY KEY (commentId),
	FOREIGN KEY (postId) REFERENCES post(postId),
	FOREIGN KEY (userId) REFERENCES users(userId)
);
CREATE TABLE episodeSaved(
	userId INT NOT NULL,
	epsodeId INT NOT NULL,
	FOREIGN KEY (userId) REFERENCES users(userId)
);
