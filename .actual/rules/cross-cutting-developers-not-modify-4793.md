# Adopt Laravel Migration Pattern for Database Schema Management: Developers Not Modify

These rules are ALWAYS ACTIVE for all database migration files in the `database/migrations/` directory and any schema change operations affecting the application database.

### Rules

- **R-MIGRATE-001** MUST_NOT: Developers MUST NOT modify existing migration files that have been committed and deployed to shared environments.
- **R-MIGRATE-002** MUST: All migration files in `database/migrations/` MUST follow the timestamp naming convention `YYYY_MM_DD_HHMMSS_description.php`.
- **R-MIGRATE-003** MUST: Each migration class MUST extend `Migration` and implement both `up()` and `down()` methods.
- **R-MIGRATE-004** MUST: Schema changes MUST use Laravel's Schema Builder (Schema::create, Schema::table, Schema::drop) rather than raw `DB::statement()` calls.
- **R-MIGRATE-005** SHOULD: Developers SHOULD test both `up()` and `down()` methods locally before committing migrations.
- **R-MIGRATE-006** SHOULD: Complex schema changes SHOULD be documented with comments explaining data transformations or manual steps required.
- **R-MIGRATE-007** MAY: Developers MAY use foreign key constraints with `onDelete()` and `onUpdate()` cascades to maintain referential integrity.

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
- No existing committed migrations have been modified after deployment to shared environments

<enforcement>
Claude Code MUST NOT skip or defer verification of migration file structure, naming conventions, and method presence. All R-MIGRATE rules marked MUST are non-negotiable and MUST be enforced during code review and CI pipeline checks.
</enforcement>