# Backend foundation

This project remains classic PHP. The backend foundation provides secure sessions, CSRF protection, request validation, contact-form handling, rate limiting, security headers, safe exception handling and a lazy PDO/MySQL connection factory.

## Database boundary

The application does not create a database, tables, migrations, SQL queries, models, repositories or database data. Those are intentionally outside this implementation. The PDO connection factory only opens a MySQL connection when a future feature explicitly calls it.

phpMyAdmin is an administration interface; the application connects to the MySQL/MariaDB server itself.

Configure these environment variables in Apache/PHP before enabling database-backed features:

- APP_ENV=production
- APP_BASE_URL=/my-project
- DB_HOST=127.0.0.1
- DB_PORT=3306
- DB_NAME=your_database_name
- DB_USER=your_database_user
- DB_PASSWORD=your_database_password

Do not commit credentials or place them in public PHP files.

## Contact form

The contact form uses PHP mail(). Configure CONTACT_TO_EMAIL and CONTACT_FROM_EMAIL. The hosting/server must have a working mail transport. A successful PHP mail() return value means the message was accepted by the local mail transport, not that delivery to the recipient was confirmed.

## PHP requirements

- PHP 8.1+
- pdo_mysql for future MySQL connection use
- Apache with .htaccess / mod_headers support for the included directory and response protections

## Security notes

- Session cookies are HttpOnly, SameSite=Lax and Secure on HTTPS.
- Session strict mode and cookie-only sessions are enabled.
- CSRF tokens protect the contact POST.
- Contact submissions are validated server-side and rate-limited by client IP.
- Rate-limit metadata is kept in the operating system temporary directory, not in a database or project data folder.
- Content Security Policy, clickjacking protection, MIME sniffing protection, referrer policy and a restrictive permissions policy are sent.
- Uploads are not currently accepted by any endpoint. The uploads directory blocks executable file extensions.
- Database-backed login, roles, admin CRUD and persistent content management are not implemented because no schema or database queries were requested.
