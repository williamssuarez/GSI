ALTER TABLE clubes
ADD FOREIGN KEY (user_id)
REFERENCES usuarios (id)
