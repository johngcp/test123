# Standardize Laravel Framework for Public API Development: Endpoints Implement Validation

These rules are ALWAYS ACTIVE for all HTTP controllers serving public/external API endpoints, Eloquent models representing API resource data, service providers registering API-related services and middleware, feature and unit tests validating API behavior, and database factories and seeders supporting API data requirements.

### Rules

- **R-LARAVEL-API-001** MUST: All API endpoints MUST implement validation using Laravel's validation framework (FormRequest or controller validation) before processing requests.

### Verify

```bash
# Verify all API controllers extend Laravel's base Controller class
grep -r "extends Controller" app/Http/Controllers/ | wc -l

# Verify all data models extend Eloquent Model class
grep -r "extends Model" app/Models/ | grep -v "^Binary" | wc -l

# Run Laravel test suite (Feature and Unit tests)
php artisan test --testsuite=Feature --testsuite=Unit

# Verify service providers follow Laravel conventions
grep -r "class.*ServiceProvider extends ServiceProvider" app/Providers/ | wc -l
```

**Accept when:**
- All API controllers extend Laravel's base Controller class and use framework HTTP abstractions (verified by grep showing >0 matches)
- All data models extend Eloquent Model class with proper relationships and attributes (verified by grep showing >0 matches)
- Test suite passes with Feature tests for API endpoints and Unit tests for business logic (verified by php artisan test exit code 0)
- Service providers are registered for API-related services following Laravel conventions (verified by grep showing AppServiceProvider and similar patterns)

<enforcement>
Claude Code MUST NOT skip or defer verification. All API endpoints must implement validation using Laravel's validation framework before processing requests. Violations block merge in CI pipeline and require code review approval to align with Laravel conventions.
</enforcement>