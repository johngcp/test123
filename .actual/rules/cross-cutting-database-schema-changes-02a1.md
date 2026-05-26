# Adopt Laravel Framework as Standard Application Foundation: Database Schema Changes

These rules are ALWAYS ACTIVE for all new PHP web applications, APIs, existing applications undergoing major refactoring, microservices requiring web framework capabilities, and internal tools and administrative interfaces built with Laravel.

### Rules

- **R-LARAVEL-DB-001** MUST: Database schema changes MUST be implemented using Laravel migrations stored in `database/migrations/` with timestamp-prefixed filenames.

### Verify

```bash
# Verify Laravel framework presence
grep -r "Illuminate\\" app/ bootstrap/ config/ | wc -l

# Verify required Laravel directory structure
test -f artisan && test -f bootstrap/app.php && test -d app/Providers

# Verify Laravel installation
php artisan --version | grep -i laravel

# Verify database migrations directory and structure
find database/migrations -name '*.php' -type f | head -5
```

**Accept when:**
- Verification commands confirm presence of Laravel framework files (artisan, bootstrap/app.php, app/Providers directory)
- Illuminate namespace imports are detected throughout application code indicating framework usage
- Laravel version command executes successfully showing framework installation
- Database migrations directory contains timestamped migration files following Laravel naming conventions

<enforcement>
Claude Code MUST NOT skip or defer verification. All database schema changes must be validated against the Laravel migrations directory structure and naming conventions before acceptance.
</enforcement>