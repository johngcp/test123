# Adopt Laravel Framework as Standard Application Foundation: Service Providers Used

These rules are ALWAYS ACTIVE for all new PHP web applications, APIs, microservices, and internal tools built with Laravel framework.

### Rules

- **R-LARAVEL-SP-001** SHOULD: Service providers SHOULD be used to register application services and dependencies in the service container.

### Verify

```bash
# Check for Illuminate namespace usage throughout the codebase
grep -r "Illuminate\\" app/ bootstrap/ config/ | wc -l

# Verify presence of required Laravel structure
test -f artisan && test -f bootstrap/app.php && test -d app/Providers

# Confirm Laravel installation and version
php artisan --version | grep -i laravel

# Verify database migrations follow Laravel conventions
find database/migrations -name '*.php' -type f | head -5
```

**Accept when:**
- Verification commands confirm presence of Laravel framework files (artisan, bootstrap/app.php, app/Providers directory)
- Illuminate namespace imports are detected throughout application code indicating framework usage
- Laravel version command executes successfully showing framework installation
- Database migrations directory contains timestamped migration files following Laravel naming conventions

<enforcement>
Claude Code MUST NOT skip or defer verification. All Laravel projects MUST pass these checks before acceptance.
</enforcement>
