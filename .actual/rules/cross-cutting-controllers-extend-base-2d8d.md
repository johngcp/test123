# Adopt Laravel Framework as Standard Application Foundation: Controllers Extend Base

These rules are ALWAYS ACTIVE for all new PHP web applications, APIs, existing applications undergoing major refactoring, microservices requiring web framework capabilities, and internal tools and administrative interfaces built with Laravel.

### Rules

- **R-LARAVEL-001** SHOULD: Controllers SHOULD extend the base Controller class and be organized in app/Http/Controllers/ directory.

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
- Controllers are located in app/Http/Controllers/ and extend the base Controller class

<enforcement>
Claude Code MUST NOT skip or defer verification of Laravel framework structure and controller organization. All violations must be flagged during code review and CI pipeline checks must fail if required Laravel structure is missing.
</enforcement>