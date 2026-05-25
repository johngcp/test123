# Adopt Laravel Framework as Standard Application Foundation: Test Cases Extend

These rules are ALWAYS ACTIVE for all PHP web applications, APIs, microservices, and internal tools adopting Laravel as the standard application foundation.

### Rules

- **R-LARAVEL-001** SHOULD: Test cases SHOULD extend Laravel's base TestCase class and utilize framework testing utilities.

### Verify

```bash
# Verify Laravel framework presence
grep -r "Illuminate\\" app/ bootstrap/ config/ | wc -l

# Verify required Laravel directory structure
test -f artisan && test -f bootstrap/app.php && test -d app/Providers

# Verify Laravel installation
php artisan --version | grep -i laravel

# Verify database migrations follow Laravel conventions
find database/migrations -name '*.php' -type f | head -5
```

**Accept when:**
- Verification commands confirm presence of Laravel framework files (artisan, bootstrap/app.php, app/Providers directory)
- Illuminate namespace imports are detected throughout application code indicating framework usage
- Laravel version command executes successfully showing framework installation
- Database migrations directory contains timestamped migration files following Laravel naming conventions
- Test cases extend Laravel's TestCase class or utilize framework testing utilities

<enforcement>
Claude Code MUST NOT skip or defer verification. All Laravel projects MUST confirm framework presence and test case adherence before proceeding.
</enforcement>