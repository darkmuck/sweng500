CREATE TABLE IF NOT EXISTS quiz_submissions (
    quiz_id INTEGER(8) NOT NULL,
    user_id INTEGER(8) NOT NULL,
    grade FLOAT NULL,
    created DATETIME DEFAULT NULL,
    modified DATETIME DEFAULT NULL,
    FOREIGN KEY (quiz_id) REFERENCES quizzes(id),
    FOREIGN KEY (user_id) REFERENCES users(id);
    PRIMARY KEY (quiz_id, user_id)
);