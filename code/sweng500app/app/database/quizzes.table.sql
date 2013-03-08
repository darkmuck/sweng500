CREATE TABLE IF NOT EXISTS quizzes (
    id  INTEGER(8) NOT NULL AUTO_INCREMENT,
    lesson_id INTEGER(8) NULL,
    course_id INTEGER(8) NULL,
    created DATETIME DEFAULT NULL,
    modified DATETIME DEFAULT NULL,
    PRIMARY KEY(id)
); 

CREATE TABLE IF NOT EXISTS answers (
    id INTEGER(8) NOT NULL AUTO_INCREMENT,
    question_id INTEGER(8) NOT NULL,
    value VARCHAR(50) NOT NULL,
    correct TINYINT(1) NOT NULL DEFAULT 0,
    created DATETIME DEFAULT NULL,
    modified DATETIME DEFAULT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS questions (
    id INTEGER(8) NOT NULL AUTO_INCREMENT,
    quiz_id INTEGER(8) NOT NULL,
    type INTEGER(1) NOT NULL,
    points integer(3) NOT NULL,
    question VARCHAR(150) NOT NULL,
    created DATETIME DEFAULT NULL,
    modified DATETIME DEFAULT NULL,
    PRIMARY KEY(id, quiz_id)
);

--add constraints
ALTER TABLE quizzes ADD CONSTRAINT quiz_lesson_fk FOREIGN KEY (lesson_id) REFERENCES lessons(id) ON DELETE CASCADE;
ALTER TABLE quizzes ADD CONSTRAINT quiz_course_fk FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE;
ALTER TABLE answers ADD CONSTRAINT answers_fk FOREIGN KEY (question_id) REFERENCES questions(id) ON DELETE CASCADE;
ALTER TABLE questions ADD CONSTRAINT question_fk FOREIGN_KEY (quiz_id) REFERENCES quizzes(id) ON DELETE CASCADE;

