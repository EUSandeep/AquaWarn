# Bolt's Optimization Journal

## 2026-07-29 - [Fixing Vite Build and PHP Database Config Blockers]
**Learning:** In this environment, Vite build fails because of a missing `"./fonts"` specifier in the `laravel-vite-plugin` package when trying to import `bunny` from `laravel-vite-plugin/fonts`. Furthermore, the `config/database.php` config had a syntax/class loading error with `Pdo\Mysql` instead of using the global `PDO` namespace.
**Action:** Remove the unused font imports/options from `vite.config.js` and use `PDO` constants (like `PDO::MYSQL_ATTR_SSL_CA`) instead of `Pdo\Mysql` to make the workspace functional and ready for running tests and profiling.

## 2026-07-29 - [Iterative create() to Batch insert() in MockForecastingService]
**Learning:** Generating a 72-hour forecast using iterative `Forecast::create()` calls resulted in 72 separate database inserts. By utilizing `Forecast::insert()` for batch operations, we can reduce database roundtrips by 98.6% (from 72 queries to just 1) and dramatically improve mock forecast generation performance. When doing so, `created_at`/`updated_at` timestamps must be manually specified as strings because bulk `insert()` bypasses standard model casting.
**Action:** Use batch insertion (`insert()`) for bulk mock generation patterns while explicitly formatting Carbon objects as strings (using `toDateTimeString()`) and adding explicit timestamps.
