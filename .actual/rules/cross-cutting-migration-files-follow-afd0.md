# Adopt Laravel Migration Pattern for Database Schema Management: Migration Files Follow

These rules are ALWAYS ACTIVE for all database migration files in the `database/migrations/` directory.

### Rules

- **R-MIGRATION-001** MUST: Migration files MUST follow the naming convention `YYYY_MM_DD_HHMMSS_descriptive_name.php` where the timestamp ensures execution order.
- **R-MIGRATION-002** MUST: Each migration class MUST extend `Migration` and implement both `up()` and `down()` methods.
- **R-MIGRATION-003** MUST: Schema changes MUST use Laravel's Schema Builder (Schema::create, Schema::table, Schema::drop) rather than raw `DB::statement()` calls.
- **R-MIGRATION-004** SHOULD: Both `up()` and `down()` methods SHOULD be tested locally before committing: run `php artisan migrate` followed by `php artisan migrate:rollback`.
- **R-MIGRATION-005** SHOULD: Complex schema changes SHOULD use `Schema::table()` with multiple column operations rather than separate migrations where feasible.
- **R-MIGRATION-006** SHOULD: Foreign key constraints SHOULD use `onDelete()` and `onUpdate()` cascades appropriately to maintain referential integrity.
- **R-MIGRATION-007** SHOULD: Data transformations or manual steps required alongside schema changes SHOULD be documented in migration comments.

### Verify

```bash
# Verify migration file naming convention
find database/migrations -name '*.php' | grep -E '[0-9]{4}_[0-9]{2}_[0-9]{2}_[0-9]{6}_.*\.php'

# Verify all migrations extend Migration class
grep -r 'class.*extends Migration' database/migrations/

# Count up() methods
grep -r 'public function up()' database/migrations/ | wc -l

# Count down() methods
grep -r 'public function down()' database/migrations/ | wc -l

# Verify Schema Builder usage (not raw DB::statement)
grep -r 'Schema::' database/migrations/ | wc -l
```

**Accept when:**
- All migration files in `database/migrations/` follow the timestamp naming convention `YYYY_MM_DD_HHMMSS_description.php`
- Each migration class extends `Migration` and implements both `up()` and `down()` methods
- Schema changes use Laravel's Schema Builder (Schema::create, Schema::table, Schema::drop) rather than raw `DB::statement()` calls
- The count of `up()` methods matches the count of `down()` methods across all migrations
- Migration files are version-controlled and tracked in the codebase

<enforcement>
Claude Code MUST NOT skip or defer verification of migration file compliance. All migration files MUST be checked against the naming convention and structural requirements before acceptance.
</enforcement>