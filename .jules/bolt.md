## 2025-05-15 - [Database Indexing for Time-Series Queries]
**Learning:** In applications handling time-series data, default Eloquent `latest()` calls sort by `created_at`. If the application logically orders data by domain-specific timestamps (e.g., `recorded_at`, `triggered_at`), these columns must be indexed and explicitly passed to `latest()`. Sorting on unindexed columns causes full table scans, which degrade performance linearly with dataset growth.
**Action:** Always check if `latest()` or `orderBy()` is using an indexed column. If sorting by domain timestamps, ensure an index exists and update the query to `latest('timestamp_column')`.

## 2025-05-15 - [Batch Insertion Optimization for Forecasts]
**Learning:** Using `Eloquent::create()` in a loop triggers a database roundtrip for every single record, which is extremely inefficient for predictable datasets like 72-hour forecasts. Switching to `Eloquent::insert()` reduces roundtrips by 98% (from 72 to 1). However, `insert()` bypasses standard model casting and automatic timestamp management.
**Action:** Use batch insertion for fixed-size time-series generation. Manually include `created_at` and `updated_at` as strings (formatted via `toDateTimeString()`) to ensure data integrity.
