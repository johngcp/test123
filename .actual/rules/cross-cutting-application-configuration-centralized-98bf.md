# Adopt Laravel Framework as Standard Application Foundation: Application Configuration Centralized

These rules are ALWAYS ACTIVE for all new PHP web applications, APIs, microservices, and internal tools built with Laravel framework.

### Rules

- **R-LARAVEL-CONFIG-001** MUST: Application configuration MUST be centralized in `config/` directory using Laravel's configuration system with environment-based overrides via `.env` files.
- **R-LARAVEL-CONFIG-002** MUST: Sensitive configuration values MUST never be committed to version control; use `.env` files for environment-specific secrets.
- **R-LARAVEL-CONFIG-003** SHOULD: Use Laravel's latest LTS (Long Term Support) version for new projects to balance feature availability with stability.
- **R-LARAVEL-CONFIG-004** SHOULD: Leverage Laravel's service providers for application bootstrapping and dependency registration rather than manual instantiation.
- **R-LARAVEL-CONFIG-005** SHOULD: Utilize Eloquent ORM for database interactions unless specific performance requirements necessitate raw queries.
- **R-LARAVEL-CONFIG-006** SHOULD: Implement feature tests using Laravel's HTTP testing utilities to verify end-to-end application behavior.

### Verify

```bash
# Verify Laravel framework presence
grep -r "Illuminate\\" app/ bootstrap/ config/ | wc -l

# Verify required Laravel structure
test -f artisan && test -f bootstrap/app.php && test -d app/Providers

# Verify Laravel installation
php artisan --version | grep -i laravel

# Verify database migrations follow Laravel conventions
find database/migrations -name '*.php' -type f | head -5
```

**Accept when:**
- Verification commands confirm presence of Laravel framework files (`artisan`, `bootstrap/app.php`, `app/Providers` directory)
- Illuminate namespace imports are detected throughout application code indicating framework usage
- Laravel version command executes successfully showing framework installation
- Database migrations directory contains timestamped migration files following Laravel naming conventions
- Configuration files exist in `config/` directory with environment-based overrides via `.env`

<enforcement>
Claude Code MUST NOT skip or defer verification. All Laravel projects MUST pass the verification commands before acceptance. CI pipeline MUST fail if required Laravel structure is missing or framework is not properly installed.
</enforcement>