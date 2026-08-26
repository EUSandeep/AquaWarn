## 2026-06-16 - Explicit Timestamp Ordering for Index Utilization

**Learning:** Eloquent's `latest()` defaults to ordering by `created_at`. When time-series tables use domain-specific timestamp columns (`recorded_at`, `triggered_at`, `forecasted_for`) and have database indexes on those columns, calling `latest()` without arguments forces SQLite/MySQL to order by `created_at`, bypassing index optimization and triggering full table scans and filesort operations.

**Action:** Always specify the target timestamp column explicitly when using `latest()` on time-series models (e.g., `latest('recorded_at')` or `latest('triggered_at')`).
