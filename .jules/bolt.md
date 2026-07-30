# Bolt's Optimization Journal

## 2026-07-30 - Bulk Insert for MockForecastingService
**Learning:** Iteratively calling `Forecast::create()` inside a loop (72 times) causes 72 individual `INSERT` queries to the database. By utilizing Eloquent bulk insertion via `Forecast::insert()`, we can perform a single multi-row `INSERT` query. For bulk inserts, we must manually specify `created_at` and `updated_at` timestamps as Eloquent doesn't populate them automatically on bulk operations. Also, Carbon objects must be explicitly formatted as string datetimes for database insertion compatibility.
**Action:** Replace the iterative `Forecast::create()` loop with a single `Forecast::insert()` call, generating all 72 data points in memory beforehand.
