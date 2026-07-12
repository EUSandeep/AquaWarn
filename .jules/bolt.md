# Bolt's Performance Journal ⚡

## 2026-06-16 - [Database Bottleneck: Iterative Inserts and Missing Indexes]
**Learning:** In the AVN project, the `MockForecastingService` generates 72-hour forecasts by calling `Forecast::create()` 72 times in a loop. This results in 72 separate database roundtrips. Additionally, frequently queried timestamp columns like `recorded_at`, `forecasted_for`, and `triggered_at` lack database indexes, leading to potential full table scans as telemetry data accumulates.

**Action:**
1. Use `Eloquent::insert()` for batch operations to reduce database roundtrips.
2. Add database indexes to frequently ordered/filtered timestamp columns.
3. Ensure bulk inserts manually include `created_at` and `updated_at` and format Carbon objects to strings.

## 2026-06-16 - [Environment Limitation: Composer Mismatch]
**Learning:** The project's `composer.lock` references Laravel v13.16.1 while `composer.json` specifies ^11.9. Security advisories for Laravel 11.x also block standard updates. This makes the `vendor/` directory difficult to populate without a forced update that might deviate from the project's intended state.
**Action:** Use `php -l` for syntax verification and avoid committing `composer.lock` changes unless specifically tasked.
