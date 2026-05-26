# Adopt Laravel Framework as Standard Application Foundation: New Web Applications

These rules are ALWAYS ACTIVE for all new PHP web applications and APIs, existing applications undergoing major refactoring, microservices requiring web framework capabilities, and internal tools and administrative interfaces.

### Rules

- **R-LARAVEL-001** MUST: All new web applications MUST use Laravel framework as the foundational application structure.
- **R-LARAVEL-002** MUST: Use Laravel's latest LTS (Long Term Support) version for new projects to balance feature availability with stability.
- **R-LARAVEL-003** MUST: Configure environment-specific settings via .env files and never commit sensitive configuration to version control.
- **R-LARAVEL-004** SHOULD: Leverage Laravel's service providers for application bootstrapping and dependency registration rather than manual instantiation.
- **R-LARAVEL-005** SHOULD: Utilize Eloquent ORM for database interactions unless specific performance requirements necessitate raw queries.
- **R-LARAVEL-006** SHOULD: Implement feature tests using Laravel's HTTP testing utilities to verify end-to-end application behavior.

### Verify

```bash
# Verify Laravel framework files and structure
grep -r "Illuminate\\" app/ bootstrap/ config/ | wc -l
test -f artisan && test -f bootstrap/app.php && test -d app/Providers
php artisan --version | grep -i laravel
find database/migrations -name '*.php' -type f | head -5
```

**Accept when:**
- Verification commands confirm presence of Laravel framework files (artisan, bootstrap/app.php, app/Providers directory)
- Illuminate namespace imports are detected throughout application code indicating framework usage
- Laravel version command executes successfully showing framework installation
- Database migrations directory contains timestamped migration files following Laravel naming conventions

<enforcement>
Claude Code MUST NOT skip or defer verification. All new web applications MUST pass Laravel framework structure verification before acceptance.
</enforcement>