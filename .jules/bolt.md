## 2026-06-16 - Batch Insertion with Eloquent Models
**Learning:** Using Eloquent `insert()` for bulk insertions significantly optimizes database write performance (reducing roundtrips by up to 98% in this codebase). However, raw `insert()` bypasses standard model lifecycle features, meaning `created_at` and `updated_at` must be manually provided, and datetime fields (like `forecasted_for`) must be formatted to strings via `toDateTimeString()` before insertion, since automatic casting is skipped.
**Action:** When refactoring iterative database saves to bulk operations, always construct complete records including manual timestamps and pre-cast datetime string representations.

## 2026-06-16 - Lock File and Environment Restorations
**Learning:** Installing or updating packages during testing in a sandbox can lead to dependency lock file (`composer.lock`, `package-lock.json`) contamination or framework version updates, which introduces out-of-scope changes and potential regressions.
**Action:** Always restore lock files and dependency definitions (`package.json`, `composer.lock`, `package-lock.json`) before committing/pushing changes, keeping only the code improvements.
