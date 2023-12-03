CREATE DATABASE todo_db;
USE todo_db;
CREATE TABLE tasks(
    id MEDIUMINT NOT NULL AUTO_INCREMENT, 
    task VARCHAR(255) NOT NULL, 
    date_added DATETIME NOT NULL,
    done BOOLEAN NOT NULL DEFAULT false,
    PRIMARY KEY (id)
    );
INSERT INTO tasks(task, date_added) VALUES ('Workout', NOW());
INSERT INTO tasks(task, date_added) VALUES ('Water the plants', NOW());
INSERT INTO tasks(task, date_added) VALUES ('Call Mom', NOW());