CREATE TABLE users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    username TEXT NOT NULL UNIQUE,
    updated_at DATETIME NOT NULL,
    created_at DATETIME NOT NULL
);

CREATE TABLE messages (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    user_id INTEGER NOT NULL,
    chat_id INTEGER NOT NULL,
    message TEXT NOT NULL,
    timestamp DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    created_at DATETIME NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users (id)
);

CREATE TABLE chats (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    updated_at DATETIME NOT NULL,
    created_at DATETIME NOT NULL
);

CREATE TABLE chat_users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    user_id INTEGER NOT NULL,
    chat_id INTEGER NOT NULL,
    updated_at DATETIME NOT NULL,
    created_at DATETIME NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users (id)
);
