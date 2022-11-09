CREATE DATABASE doingsdone
    DEFAULT CHARACTER SET utf8
    DEFAULT COLLATE utf8_general-ci;

CREATE TABLE project (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(128),
    user_id INT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES user (id)
);

CREATE TABLE user (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(128) NOT NULL UNIQUE,
    email VARCHAR(128) NOT NULL UNIQUE,
    password VARCHAR(255),
    date_reg TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE task (
    id INT AUTO_INCREMENT PRIMARY KEY,
    date_add TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status INT DEFAULT 0,
    name VARCHAR(128) NOT NULL,
    file VARCHAR(128),
    date_make TIMESTAMP,
    user_id INT,
    project_id INT,
    FOREIGN KEY (user_id) REFERENCES user(id),
    FOREIGN KEY (project_id) REFERENCES project(id)
);

CREATE INDEX c_task_name ON task(name);
