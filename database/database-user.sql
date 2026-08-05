drop table if exists users;
create table users(username varchar(50) PRIMARY KEY, password varchar(100) NOT NULL);
INSERT INTO users(username,password) VALUES ('team15',md5('password'));
