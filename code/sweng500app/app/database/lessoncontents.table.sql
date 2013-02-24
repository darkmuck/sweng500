CREATE TABLE lesson_contents (
    id  INTEGER(8) NOT NULL AUTO_INCREMENT,
    lesson_id INTEGER(8) NOT NULL,
    filename VARCHAR(100) NOT NULL,
    filesize INTEGER(8) NOT NULL,
    file LONGBLOB NOT NULL,
    filetype VARCHAR(100) NOT NULL,
    created DATETIME DEFAULT NULL,
    modified DATETIME DEFAULT NULL,
    PRIMARY KEY(id)
); 