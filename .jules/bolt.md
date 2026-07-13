## 2025-05-15 - [Batch Insertion for Forecasts]
**Learning:** Using `Eloquent::create()` in a loop causes one database roundtrip per record. For bulk data (like 72-hour forecasts), this is a major bottleneck. `Eloquent::insert()` reduces this to a single query.
**Action:** Always prefer `insert()` for bulk operations. Remember that `insert()` bypasses Eloquent's automatic timestamping and casting, so `created_at`/`updated_at` must be manually provided and Carbon objects must be formatted as strings.
