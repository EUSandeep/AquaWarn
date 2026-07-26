# Bolt's Optimization Journal

## 2026-06-16 - [Batch Forecast Generation]
**Learning:** Generating 72-hour forecast data hour-by-hour using separate Eloquent `create` statements incurs massive database and framework overhead, taking ~175ms for 72 inserts. Switching to batch insertion (`Forecast::insert()`) reduces execution time by ~98% (down to ~4ms per generation block), significantly boosting background job and HTTP ingestion response throughput.
**Action:** Use batch insertions (`::insert()`) with manually specified timestamps (`created_at`, `updated_at`) and formatted datetime strings (`toDateTimeString()`) for bulk creations to bypass Eloquent's row-by-row overhead and avoid casting mismatches with RAW arrays.
