# Bolt's Performance Optimization Journal

This journal records critical performance learnings, architecture bottlenecks, and lessons learned from optimizing the Automated Visual Network (AVN) system.

## 2026-07-27 - [Laravel Eloquent Bulk Insertion Optimization]
**Learning:** When performing batch operations in Laravel Eloquent (such as 72-hour forecast generations), executing iterative `create()` calls inside loops leads to N+1 write operations, causing severe database transaction and I/O bottlenecks. Switching to `insert()` reduces database roundtrips by ~98%. However, `insert()` bypasses standard Eloquent model events and model casting/serialization. Thus, `created_at` and `updated_at` must be manually generated and specified as formatted strings, and carbon datetimes must be serialized to string format beforehand.
**Action:** Always batch write operations using `insert()` instead of `create()` in loops, and manually append correctly formatted `created_at` and `updated_at` timestamps to prevent silent schema constraints or default value failures.
