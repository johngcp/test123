# Adopt Laravel Framework as Standard Application Foundation: Applications Follow Laravel

These rules are ALWAYS ACTIVE for all new PHP web applications and APIs, existing applications undergoing major refactoring, microservices requiring web framework capabilities, and internal tools and administrative interfaces.

### Rules

- **R-LARAVEL-001** MUST: Applications MUST follow Laravel's standard directory structure with bootstrap/, config/, app/, database/, public/, and tests/ directories.
- **R-LARAVEL-002** MUST: Use Laravel's latest LTS (Long Term Support) version for new projects to balance feature availability with stability.
- **R-LARAVEL-003** MUST: Configure environment-specific settings via .env files and never commit sensitive configuration to version control.
- **R-LARAVEL-004** SHOULD: Leverage Laravel's service providers for application bootstrapping and dependency registration rather than manual instantiation.
- **R-LARAVEL-005** SHOULD: Utilize Eloquent ORM for database interactions unless specific performance requirements necessitate raw queries.
- **R-LARAVEL-006** SHOULD: Implement feature tests using Laravel's HTTP testing utilities to verify end-to-end application behavior.

### Verify

```bash
# Check for Laravel framework imports
grep -r "Illuminate\\" app/ bootstrap/ config/ | wc -l

# Verify required Laravel files and directories exist
test -f artisan && test -f bootstrap/app.php && test -d app/Providers

# Confirm Laravel installation
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
Claude Code MUST NOT skip or defer verification. All Laravel framework adoption must be confirmed via the verify commands before accepting the application structure.
</enforcement>