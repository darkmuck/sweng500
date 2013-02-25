ALTER TABLE courses DROP COLUMN prerequisite;
ALTER TABLE courses ADD COLUMN course_id INTEGER DEFAULT NULL; --course_id of prerequisite
ALTER TABLE courses ADD CONSTRAINT fk_course_id FOREIGN KEY (course_id) REFERENCES courses(id);
ALTER TABLE courses ADD COLUMN user_id INTEGER DEFAULT NULL; --the instructor
ALTER TABLE courses ADD CONSTRAINT fk_user_id FOREIGN KEY (user_id) REFERENCES users(id);
