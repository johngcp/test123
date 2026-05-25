# Adopt Laravel Framework as Standard Application Foundation: Models Extend Illuminate

These rules are ALWAYS ACTIVE for all new PHP web applications, APIs, microservices, and internal tools built with Laravel framework.

### Rules

- **R-LARAVEL-001** SHOULD: Models SHOULD extend `Illuminate\Database\Eloquent\Model` and be placed in `app/Models/` directory.

### Verify

```bash
# Check for Illuminate namespace usage throughout application
grep -r "Illuminate\\" app/ bootstrap/ config/ | wc -l

# Verify Laravel framework files exist
test -f artisan && test -f bootstrap/app.php && test -d app/Providers

# Confirm Laravel installation
php artisan --version | grep -i laravel

# Check for database migrations following Laravel conventions
find database/migrations -name '*.php' -type f | head -5
```

**Accept when:**
- Verification commands confirm presence of Laravel framework files (artisan, bootstrap/app.php, app/Providers directory)
- Illuminate namespace imports are detected throughout application code indicating framework usage
- Laravel version command executes successfully showing framework installation
- Database migrations directory contains timestamped migration files following Laravel naming conventions
- Models in app/Models/ extend Illuminate\Database\Eloquent\Model

<enforcement>
Claude Code MUST NOT skip or defer verification. All Laravel applications MUST pass framework structure checks before proceeding with model implementation.
</enforcement>