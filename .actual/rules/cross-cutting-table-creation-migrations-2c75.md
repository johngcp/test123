# Adopt Laravel Migration Pattern for Database Schema Management: Table Creation Migrations

These rules are ALWAYS ACTIVE for all database migration files in the `database/migrations/` directory following Laravel's migration pattern.

### Rules

- **R-MIGRATION-001** SHOULD: Table creation migrations SHOULD include appropriate indexes, foreign key constraints, and default values at creation time.

### Verify

```bash
# Verify migration file naming convention (YYYY_MM_DD_HHMMSS_description.php)
find database/migrations -name '*.php' | grep -E '[0-9]{4}_[0-9]{2}_[0-9]{2}_[0-9]{6}_.*\.php'

# Verify all migration classes extend Migration
grep -r 'class.*extends Migration' database/migrations/

# Count up() methods
grep -r 'public function up()' database/migrations/ | wc -l

# Count down() methods
grep -r 'public function down()' database/migrations/ | wc -l
```

**Accept when:**
- All migration files in `database/migrations/` follow the timestamp naming convention `YYYY_MM_DD_HHMMSS_description.php`
- Each migration class extends `Migration` and implements both `up()` and `down()` methods
- Schema changes use Laravel's Schema Builder (`Schema::create`, `Schema::table`, `Schema::drop`) rather than raw `DB::statement()` calls
- The count of `up()` methods matches the count of `down()` methods across all migrations

<enforcement>
Claude Code MUST NOT skip or defer verification of migration file structure, naming conventions, and method presence before accepting changes to database schema files.
</enforcement>