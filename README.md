# Beaming Light Academy Website

A PHP and MySQL secondary-school website project featuring public information pages, student registration and login, a student dashboard, results, contact messages, and an administrator area. The interface uses a **Burgundy & Ivory** colour palette.
/screenshot/fullpage_snapshot_beaminglightacademy_freedev_app_2026-10-13-07-18-34.png

## Features

- Home, About, Student Corner, and Contact pages
- Student registration and login
- Student dashboard and results pages
- Contact form and message-management pages
- Administrator dashboard and student-management pages
- Responsive styling with Bootstrap, custom CSS, and Font Awesome

## Tech stack

- PHP 8+
- MySQL or MariaDB
- HTML, CSS, and JavaScript
- Bootstrap 5

## Run locally with XAMPP

1. Install and start **Apache** and **MySQL** in XAMPP.
2. Copy this project folder into `htdocs`. For example: `C:\xampp\htdocs\beaming-light-academy`.
3. Open phpMyAdmin and create a database named `schoolwebsite_database`.
4. Import [`database/schoolwebsite_database_sample.sql`](database/schoolwebsite_database_sample.sql). This file contains the schema and fictional demo records only; it is not the production database.
5. Copy `includes/db-config.example.php` to `includes/db-config.local.php`. Update the local database settings if your XAMPP setup differs. The local config file is excluded by `.gitignore`.
6. Open `http://localhost/beaming-light-academy/` (adjust the URL to match your folder name).

### Demo student account

The sample database includes one fictional student for local testing:

- **Email:** `student.demo@example.com`
- **Password:** `DemoStudent123!`

This is a local demonstration account only. Do not reuse it on a public deployment. No administrator account is seeded.

## Database and privacy

The SQL file in this repository is a sample database. It uses fictional names, `example.com` email addresses, and dummy contact details. It does not include the original database records. Never commit a production database dump, real student details, password hashes from a live system, or hosting credentials.

## Before deploying publicly

This is a portfolio/learning project, not a security-audited production system. Review and strengthen the legacy administrator authentication and SQL query handling before using it with real student data. Use prepared statements, secure password hashing, role checks on every protected page, HTTPS, and proper session protections. Replace the demo contact details with approved school contact information before publication.
