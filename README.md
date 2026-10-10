# PHP Signup Form

A simple signup form built with PHP and MySQL. It validates user 
input, saves users to the database with prepared statements, and 
displays all registered users below the form.

Built while following the [Laracasts PHP for Beginners (2023)](https://laracasts.com/series/php-for-beginners-2023-edition) course.

---

## Features

- **Form validation** — shows "Name is required" and "City is required" 
  when fields are left empty
- **SQL injection protection** — uses PDO prepared statements for inserts
- **XSS protection** — escapes all user output with `htmlspecialchars()`
- **Welcome message** — shows "Welcome [name] from [city]!" after signup
- **User list** — displays all registered users below the form, newest first

---

## Tech Stack

- PHP 8+
- MySQL
- PDO (PHP Data Objects)

---

## Setup

### 1. Clone the repository

```bash
git clone https://github.com/your-username/php-signup-form.git
cd php-signup-form
```

### 2. Create the database

Open phpMyAdmin or the MySQL CLI and run:

```sql
CREATE DATABASE IF NOT EXISTS myapp;
USE myapp;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    age INT,
    city VARCHAR(255)
);
```

### 3. Place the file in your web root

Move `signup.php` into your server's web root:

- **XAMPP (Windows):** `C:\xampp\htdocs\signup.php`
- **XAMPP (Mac):** `/Applications/XAMPP/htdocs/signup.php`
- **MAMP:** `/Applications/MAMP/htdocs/signup.php`

### 4. Run it

Start Apache and MySQL, then open:

```
http://localhost/signup.php
```

---

## How It Works

1. **On page load** — connects to MySQL and fetches all users for 
   the list below the form.
2. **On form submit (POST)** — trims and validates `name` and `city`. 
   If either is empty, adds a message to `$errors`.
3. **If validation passes** — inserts the user with a prepared 
   statement and sets `$saved = true`.
4. **On render** — displays errors (if any), the welcome message 
   (if saved), the form, and the user list.

---

## What This Project Demonstrates

| Concept | Where in the code |
|---------|-------------------|
| PDO connection | Top of `signup.php` |
| Form handling (`$_POST`) | `if ($_SERVER['REQUEST_METHOD'] === 'POST')` |
| Input sanitization | `trim()`, `??` null coalescing operator |
| Validation | `if ($name === '')` checks |
| Prepared statements | `$pdo->prepare()` + `$stmt->execute()` |
| Output escaping | Every `<?= ?>` uses `htmlspecialchars()` |
| Fetching data | `$pdo->query(...)->fetchAll(PDO::FETCH_ASSOC)` |

---

## Project Structure

```
php-signup-form/
└── signup.php    # Everything: DB connection, validation, form, list
```

---

## License

MIT — free to use, learn from, and modify.
