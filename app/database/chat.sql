CREATE TABLE users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    username TEXT NOT NULL UNIQUE,
    updated_at DATETIME NOT NULL,
    created_at DATETIME NOT NULL
);

CREATE TABLE messages (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    sender_user_id INTEGER NOT NULL,
    chat_id INTEGER NOT NULL,
    message TEXT NOT NULL,
    updated_at DATETIME NOT NULL,
    created_at DATETIME NOT NULL,
    FOREIGN KEY (sender_user_id) REFERENCES users (id)
    FOREIGN KEY (chat_id) REFERENCES chats (id)

);

CREATE TABLE chats (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    sender_user_id INTEGER NOT NULL,
    receiver_user_id INTEGER NOT NULL,
    updated_at DATETIME NOT NULL,
    created_at DATETIME NOT NULL,
    FOREIGN KEY (sender_user_id) REFERENCES users (id),
    FOREIGN KEY (receiver_user_id) REFERENCES users (id),
    UNIQUE (sender_user_id, receiver_user_id)
);