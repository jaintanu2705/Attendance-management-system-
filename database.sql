CREATE DATABASE smart_attendance;
USE smart_attendance;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50),
    password VARCHAR(255)
);

INSERT INTO users (username,password)
VALUES ('admin', '$2y$10$QmZqv5xPZ9kZyKkFZPZ6ruyP7P1YF2Y9Pq8M3vC9m4K');

CREATE TABLE students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    roll VARCHAR(20),
    name VARCHAR(100),
    course VARCHAR(50)
);

CREATE TABLE attendance (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT,
    date DATE,
    status VARCHAR(10)
);
