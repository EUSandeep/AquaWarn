# Bolt's Performance Optimization Journal

This journal records critical, codebase-specific performance learnings to avoid mistakes and guide future optimizations.

## 2026-06-16 - [Laravel Query Bulk Insertion & Eloquent Lifecycle Bypassing]
**Learning:** Replacing iterative `Model::create()` calls inside loops with raw `Model::insert($array)` yields massive performance gains (reducing database roundtrips from $O(N)$ to $O(1)$). However, Query Builder's `insert()` method bypasses model-level casting and lifecycle hooks. Thus, standard timestamps (`created_at`, `updated_at`) are not auto-populated, and Carbon date objects must be explicitly serialized to formatted database strings via `toDateTimeString()` beforehand.
**Action:** When migrating iterative database writes to bulk inserts, always manually inject formatted date string timestamps (`created_at` and `updated_at`), copy date references to avoid loop-wide mutations, and format all domain-specific datetime objects explicitly.
