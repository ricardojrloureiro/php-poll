CREATE TABLE IF NOT EXISTS users
(
	user_id INTEGER PRIMARY KEY,
	username TEXT,
	password TEXT
);

CREATE TABLE IF NOT EXISTS polls
(
	poll_id INTEGER PRIMARY KEY,
	user_id INTEGER,
	title TEXT,
	image TEXT,
	public BOOLEAN,
	multiple BOOLEAN,

	FOREIGN KEY (user_id) REFERENCES users(user_id)
);

CREATE TABLE IF NOT EXISTS options
(
	option_id INTEGER PRIMARY KEY,
	poll_id INTEGER,
	value TEXT,

	FOREIGN KEY (poll_id) REFERENCES poll(poll_id)
);

CREATE TABLE IF NOT EXISTS answers
(
	answers_id INTEGER PRIMARY KEY,
	user_id INTEGER,
	option_id INTEGER,

	FOREIGN KEY (user_id) REFERENCES users(user_id),
	FOREIGN KEY (option_id) REFERENCES options(option_id)
);