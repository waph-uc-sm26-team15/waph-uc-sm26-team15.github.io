drop table if exists comments;
drop table if exists posts;
drop table if exists users;
drop table if exists superusers;

create table users(
    username varchar(50) PRIMARY KEY, 
    password varchar(100) NOT NULL,
    name varchar(100) NOT NULL,
    email varchar(100) NOT NULL,
    phone_number varchar(20) NOT NULL
);
INSERT INTO users(username, password, name, email, phone_number) VALUES ('team15', md5('Passw0rd!'), 'Team 15', 'team15@example.com', '555-555-5555');

create table superusers(
    username varchar(50) PRIMARY KEY,
    password varchar(100) NOT NULL
);
INSERT INTO superusers(username, password) VALUES ('admin', md5('Passw0rd!'));

create table posts(
    postID INT AUTO_INCREMENT PRIMARY KEY,
    title varchar(50) NOT NULL,
    content TEXT NOT NULL,
    `date` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `owner` varchar(50) NOT NULL,
    FOREIGN KEY (`owner`) REFERENCES `users`(`username`) ON DELETE CASCADE
);

create table comments(
    commentID INT AUTO_INCREMENT PRIMARY KEY,
    postID INT NOT NULL,
    content TEXT NOT NULL,
    `date` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `owner` VARCHAR(50) NOT NULL,
    FOREIGN KEY (`postID`) REFERENCES `posts`(`postID`) ON DELETE CASCADE,
    FOREIGN KEY (`owner`) REFERENCES `users`(`username`) ON DELETE CASCADE
);
