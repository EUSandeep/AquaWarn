# Bolt's Journal: Critical Learnings Only

## 2026-07-24 - Bulk insertion for forecasts vs iterative creation in Eloquent
**Learning:** In Laravel/Eloquent, inserting a batch of records (e.g., 72 hours of forecast data) iteratively using `Model::create()` within a loop results in heavy database round-trip overhead (72 separate queries, taking ~209ms in SQLite). Switching to `Model::insert()` combines everything into a single bulk insert query, reducing execution time to ~12ms (a ~94% reduction). However, `insert()` bypasses standard model casting and lifecycle events, requiring manual inclusion of `created_at` and `updated_at` timestamps, as well as explicit string formatting (`toDateTimeString()`) for Carbon date objects.
**Action:** Always favor batch insert `Model::insert()` over iterative `Model::create()` inside a loop for high-frequency time-series data or batch-generation scenarios, while ensuring manual timestamping and explicit datetime string serialization are applied.
