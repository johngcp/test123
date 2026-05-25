# Adopt Laravel Migration Pattern for Database Schema Management: Schema Modifications Use

These rules are ALWAYS ACTIVE for all database migration files and schema modification code in the Laravel application.

### Rules

- **R-SCHEMA-001** MUST: Schema modifications MUST use Laravel's Schema Builder facade (Schema::create, Schema::table, Schema::drop) rather than raw SQL DDL statements.

### Verify

```bash
# Verify migration files follow timestamp naming convention
find database/migrations -name '*.php' | grep -E '[0-9]{4}_[0-9]{2}_[0-9]{2}_[0-9]{6}_.*\.php'

# Verify all migration classes extend Migration
grep -r 'class.*extends Migration' database/migrations/

# Count up() methods
grep -r 'public function up()' database/migrations/ | wc -l

# Count down() methods
grep -r 'public function down()' database/migrations/ | wc -l
```

**Accept when:**
- All migration files in database/migrations/ follow the timestamp naming convention YYYY_MM_DD_HHMMSS_description.php
- Each migration class extends Migration and implements both up() and down() methods
- Schema changes use Laravel's Schema Builder (Schema::create, Schema::table, Schema::drop) rather than raw DB::statement() calls
- The count of up() methods matches the count of down() methods across all migrations

<enforcement>
Claude Code MUST NOT skip or defer verification. All schema modifications must be validated against these rules before acceptance.
</enforcement>