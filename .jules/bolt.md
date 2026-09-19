# Bolt Journal - Performance Learnings

## 2026-06-18 - Explicit timestamp ordering for indexed telemetry queries
**Learning:** Default Eloquent `latest()` sorts by `created_at` DESC. In time-series tables where business time queries use domain timestamps (`recorded_at`, `triggered_at`, `forecasted_for`), queries fail to utilize indexes on domain timestamp columns unless `latest('recorded_at')` or `latest('triggered_at')` is explicitly specified.
**Action:** Always verify migration indexes against Eloquent `latest()` calls and explicitly pass the indexed timestamp column name.
