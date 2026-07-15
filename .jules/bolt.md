## 2026-07-15 - [Batch Insertion & Indexing]
**Learning:** Using `Eloquent::insert()` for batch operations (72 records) is ~2x faster than individual `create()` calls even on SQLite. However, `insert()` bypasses standard model casting and automatic timestamping, requiring manual handling of `created_at` and `updated_at`.
**Action:** Always manually include `created_at` and `updated_at` timestamps when using `insert()` for bulk operations to maintain data integrity.

## 2026-07-15 - [Explicit Timestamp Indexing]
**Learning:** Default Laravel `latest()` uses `created_at`. In telemetry systems, sorting by domain-specific timestamps like `recorded_at` or `triggered_at` is more common and requires explicit indexing and query modification to be performant.
**Action:** When sorting by non-standard timestamps, explicitly pass the column name to `latest($column)` and ensure a corresponding database index exists.
