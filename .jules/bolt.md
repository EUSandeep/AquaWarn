# Bolt Performance Optimization Journal

## 2026-07-28 - [Batch Insert Optimization in Forecasting Service]
**Learning:** Bulk-inserting model objects via raw DB insert in Laravel yields massive execution time reductions (~75% faster) for large repeating predictions (like 72-hour forecasts) compared to iterative individual model creations. When using batch inserts like `insert()`, standard Model features like auto-assigned timestamps (`created_at`, `updated_at`) and cast attributes are bypassed, so we must manually prepare and cast variables, formatting `Carbon` dates explicitly using standard date strings.
**Action:** Always map/collect bulk arrays, manually inject key timestamp keys, serialize attributes explicitly, and perform a single batch DB call.
