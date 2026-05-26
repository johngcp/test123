# Standardize Laravel Framework for Public API Development: Public Controllers Extend

These rules are ALWAYS ACTIVE for all public API controllers, models, service providers, and test suites within the application boundary.

### Rules

- **R-LARAVEL-001** MUST: All public API controllers MUST extend the base Laravel Controller class and utilize framework-provided HTTP abstractions for request/response handling.

### Verify

```bash
# Verify all API controllers extend Laravel Controller
grep -r "extends Controller" app/Http/Controllers/ | wc -l

# Verify all data models extend Eloquent Model
grep -r "extends Model" app/Models/ | grep -v "^Binary" | wc -l

# Run test suite
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
Claude Code MUST NOT skip or defer verification. All public API controllers must be verified to extend the base Laravel Controller class before accepting changes.
</enforcement>