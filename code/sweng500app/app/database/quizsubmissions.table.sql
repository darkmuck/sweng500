CREATE TABLE IF NOT EXISTS quiz_submissions (
    id INTEGER(8) NOT NULL AUTO_INCREMENT,
    quiz_id INTEGER(8) NOT NULL,
    user_id INTEGER(8) NOT NULL,
    question_id INTEGER(8) NOT NULL,
    points FLOAT DEFAULT NULL,
    answer VARCHAR(255) DEFAULT NULL,
    created DATETIME DEFAULT NULL,
    modified DATETIME DEFAULT NULL,
    PRIMARY KEY (id)
);

ALTER TABLE quiz_submissions ADD CONSTRAINT quiz_sub_user_fk FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE;
ALTER TABLE quiz_submissions ADD CONSTRAINT quiz_sub_quiz_fk FOREIGN KEY (quiz_id) REFERENCES quizzes(id) ON DELETE CASCADE;
ALTER TABLE quiz_submissions ADD CONSTRAINT quiz_sub_question_fk FOREIGN KEY (question_id) REFERENCES questions(id) ON DELETE CASCADE;
