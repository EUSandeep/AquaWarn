# Bolt's Journal - Critical Learnings Only

## 2026-06-16 - Eloquent Bulk Insert Datetime Serialization & Timestamp Lifecycle
**Learning:** In Laravel Eloquent, using raw bulk operations like `Eloquent::insert()` is highly efficient and avoids the N+1 iterative save overhead (reducing database roundtrips by 98% for 72-hour forecasts). However, `insert()` directly accesses the query builder, completely bypassing Eloquent's model lifecycle. This means:
1. `created_at` and `updated_at` timestamps are not automatically populated and must be manually included.
2. Casting/serialization rules defined on the model (e.g. converting Carbon objects to database-specific date/time formats) are completely ignored. Carbon objects must be explicitly formatted as strings using `toDateTimeString()` before passing them to the insert payload.

**Action:** When migrating iterative Eloquent model saves to `insert()` batch insertions, always manually define `created_at` and `updated_at` timestamps and call `toDateTimeString()` on any Carbon/DateTime instances.
