CREATE TABLE IF NOT EXISTS quiz_submissions (
    id INTEGER(8) NOT NULL AUTO_INCREMENT,
    quiz_id INTEGER(8) NOT NULL,
    user_id INTEGER(8) NOT NULL,
    grade FLOAT NULL,
    created DATETIME DEFAULT NULL,
    modified DATETIME DEFAULT NULL,
    PRIMARY KEY (id, quiz_id, user_id)
);

CREATE TABLE IF NOT EXISTS submitted_answers (
    quiz_submission_id INTEGER(8) NOT NULL,
    question_id INTEGER(8) NOT NULL,
    answer VARCHAR(50) NOT NULL,
    points FLOAT NULL,
    created DATETIME DEFAULT NULL,
    modified DATETIME DEFAULT NULL,
    PRIMARY KEY (quiz_submission_id, question_id)
);

ALTER TABLE quiz_submissions ADD CONSTRAINT quiz_sub_user_fk FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE;
ALTER TABLE quiz_submissions ADD CONSTRAINT quiz_sub_quiz_fk FOREIGN KEY (quiz_id) REFERENCES quizzes(id) ON DELETE CASCADE;
ALTER TABLE submitted_answers ADD CONSTRAINT sa_question_fk FOREIGN KEY (question_id) REFERENCES questions(id);
ALTER TABLE submitted_answers ADD CONSTRAINT sa_quiz_sub_fk FOREIGN KEY (quiz_submission_id) REFERENCES quiz_submissions(id) ON DELETE CASCADE;

 