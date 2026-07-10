## 2026-06-16 - [Batch Insertion for Forecasts]
**Learning:** Replacing 72 individual `Model::create()` calls with a single `Model::insert()` reduced execution time for a 72-hour forecast by ~75% (from ~25.5ms to ~6.5ms).
**Action:** Use `Model::insert()` for batch operations, but remember to manually include `created_at` and `updated_at` timestamps as Eloquent does not handle them automatically for bulk inserts.
