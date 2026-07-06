## 2026-07-06 - [Database Indexing and Eloquent Ordering]
**Learning:** Adding indexes to timestamp columns like `recorded_at` and `triggered_at` is essential for performance as datasets grow. However, Eloquent's `latest()` defaults to `created_at`. To leverage these indexes, queries must be explicitly updated to use the indexed columns (e.g., `latest('recorded_at')`).
**Action:** Always check if the column used for ordering is indexed, and if not, add an index and update the Eloquent query to use that column.

## 2026-07-06 - [Laravel Config and PDO Constants]
**Learning:** Using `Pdo\Mysql` in Laravel config files can lead to 'Class not found' errors if not properly aliased or if the environment doesn't support that specific namespacing. Using global `PDO` constants (like `PDO::MYSQL_ATTR_SSL_CA`) is safer and more standard.
**Action:** Use global `PDO` constants in database configuration to ensure compatibility.
