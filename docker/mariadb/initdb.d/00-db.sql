CREATE DATABASE adhocmusic;
CREATE USER 'adhocmusic'@'localhost' IDENTIFIED BY 'changeme';
GRANT ALL PRIVILEGES ON adhocmusic . * TO 'adhocmusic'@'localhost';
FLUSH PRIVILEGES;
