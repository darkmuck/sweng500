CREATE TABLE lessons (
    id  INTEGER(8) NOT NULL AUTO_INCREMENT,
    course_id INTEGER(8) NOT NULL,
    name VARCHAR(100) NOT NULL,
    created DATETIME DEFAULT NULL,
    modified DATETIME DEFAULT NULL,
    main_content TEXT NOT NULL,
    lesson_order INTEGER(2) NOT NULL,
    PRIMARY KEY(id)
); 