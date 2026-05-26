# Adopt Laravel Migration Pattern for Database Schema Management: Migrations Include Data

These rules are ALWAYS ACTIVE for all database migration files in the `database/migrations/` directory following Laravel's migration pattern.

### Rules

- **R-MIGRATE-001** MUST: All migration files follow the timestamp naming convention `YYYY_MM_DD_HHMMSS_description.php`.
- **R-MIGRATE-002** MUST: Each migration class extends `Migration` and implements both `up()` and `down()` methods.
- **R-MIGRATE-003** MUST: Schema changes use Laravel's Schema Builder (`Schema::create`, `Schema::table`, `Schema::drop`) rather than raw `DB::statement()` calls.
- **R-MIGRATE-004** SHOULD: Test both `up()` and `down()` methods locally before committing using `php artisan migrate` followed by `php artisan migrate:rollback`.
- **R-MIGRATE-005** MAY: Migrations MAY include data seeding operations when the data is essential for schema functionality, though separate seeders are preferred for test data.
- **R-MIGRATE-006** SHOULD: Document any data transformations or manual steps required alongside schema changes in migration comments.
- **R-MIGRATE-007** SHOULD: Use foreign key constraints with `onDelete()` and `onUpdate()` cascades appropriately to maintain referential integrity.

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
- Schema changes use Laravel's Schema Builder (`Schema::create`, `Schema::table`, `Schema::drop`) rather than raw `DB::statement()` calls
- The count of `up()` methods matches the count of `down()` methods across all migrations
- `php artisan migrate:status` executes successfully without errors

<enforcement>
Claude Code MUST NOT skip or defer verification. All migration files MUST be validated against naming conventions, class structure, and method presence before acceptance. CI pipeline checks and code review processes are mandatory enforcement gates.
</enforcement>