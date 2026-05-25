# Adopt Laravel Framework as Standard Application Foundation: Applications Use Laravel

These rules are ALWAYS ACTIVE for all new PHP web applications, APIs, microservices, and internal tools requiring web framework capabilities.

### Rules

- **R-LARAVEL-001** MAY: Applications MAY use Laravel's factory pattern for test data generation.

### Verify

```bash
# Check for Illuminate namespace usage throughout the codebase
grep -r "Illuminate\\" app/ bootstrap/ config/ | wc -l

# Verify presence of required Laravel framework files and directories
test -f artisan && test -f bootstrap/app.php && test -d app/Providers

# Confirm Laravel installation and version
php artisan --version | grep -i laravel

# Verify database migrations directory structure
find database/migrations -name '*.php' -type f | head -5
```

**Accept when:**
- Verification commands confirm presence of Laravel framework files (artisan, bootstrap/app.php, app/Providers directory)
- Illuminate namespace imports are detected throughout application code indicating framework usage
- Laravel version command executes successfully showing framework installation
- Database migrations directory contains timestamped migration files following Laravel naming conventions

<enforcement>
Claude Code MUST NOT skip or defer verification. All four verification conditions must pass before accepting Laravel framework adoption.
</enforcement>