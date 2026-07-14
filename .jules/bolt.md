## 2026-07-14 - [Batch Insertion in Eloquent]
**Learning:** Using `Eloquent::insert()` for bulk operations significantly improves performance by reducing database roundtrips. However, unlike `create()`, `insert()` bypasses standard model features like automatic `created_at`/`updated_at` timestamps and attribute casting. Carbon date objects must be explicitly formatted as strings (e.g., via `toDateTimeString()`).
**Action:** Always manually include timestamps and format dates when using `Eloquent::insert()` for batch operations.
