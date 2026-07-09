## 2025-05-19 - Bulk Insert Optimization for Forecast Generation

**Learning:** Database operations in a loop are a major bottleneck. For a 72-hour forecast, switching from 72 individual `create()` calls to a single `insert()` call reduced the execution time by approximately 87% (from ~19ms to ~2.4ms per forecast generation).

**Action:** Always prefer bulk inserts (`Model::insert()`) over individual `create()` calls when dealing with multiple records, especially in batch processes or high-frequency telemetry ingestion. Remember that `insert()` bypasses Eloquent's automatic timestamp handling, so `created_at` and `updated_at` must be manually provided.
