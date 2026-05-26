# Adopt Laravel Migration Pattern for Database Schema Management: Database Schema Changes

These rules are ALWAYS ACTIVE for all database schema changes and migration files in the `database/migrations/` directory.

### Rules

- **R-MIGRATION-001** MUST: All database schema changes MUST be implemented as Laravel migration files in the `database/migrations/` directory.
- **R-MIGRATION-002** MUST: Each migration file MUST follow the timestamp naming convention `YYYY_MM_DD_HHMMSS_description.php`.
- **R-MIGRATION-003** MUST: Each migration class MUST extend `Migration` and implement both `up()` and `down()` methods.
- **R-MIGRATION-004** MUST: Schema changes MUST use Laravel's Schema Builder (Schema::create, Schema::table, Schema::drop) rather than raw `DB::statement()` calls.
- **R-MIGRATION-005** SHOULD: Test both `up()` and `down()` methods locally before committing by running `php artisan migrate` followed by `php artisan migrate:rollback`.
- **R-MIGRATION-006** SHOULD: Document any data transformations or manual steps required alongside schema changes in migration comments.
- **R-MIGRATION-007** SHOULD: Use foreign key constraints with `onDelete()` and `onUpdate()` cascades appropriately to maintain referential integrity.

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

# Verify migration status in deployment pipeline
php artisan migrate:status
```

**Accept when:**
- All migration files in `database/migrations/` follow the timestamp naming convention `YYYY_MM_DD_HHMMSS_description.php`
- Each migration class extends `Migration` and implements both `up()` and `down()` methods
- Schema changes use Laravel's Schema Builder (Schema::create, Schema::table, Schema::drop) rather than raw `DB::statement()` calls
- The count of `up()` methods matches the count of `down()` methods across all migrations
- `php artisan migrate:status` executes successfully in the deployment pipeline

<enforcement>
Claude Code MUST NOT skip or defer verification of migration file structure, naming conventions, and method implementation. All schema changes MUST be validated against these rules before acceptance.
</enforcement>