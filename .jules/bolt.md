# Bolt's Performance Journal

## 2026-06-16 - Batch Insert Optimization for Time-Series Forecast Generation
**Learning:** `Eloquent::create()` inside sequential loops introduces significant overhead due to individual query compilation, model lifecycle events, and network/DB roundtrips. When inserting large sequential datasets (such as a 72-hour forecast), `Eloquent::insert()` reduces queries from N+1 to 1 and improves execution speed by ~90%. However, `insert()` bypasses Eloquent model events and timestamp mutators, requiring explicit conversion of `Carbon` objects to formatted strings (e.g., `$carbon->toDateTimeString()`) and manual setting of `created_at`/`updated_at`.
**Action:** Always prefer `Model::insert()` for batch data generation or background jobs, ensuring timestamps and string formatting are explicitly handled.
