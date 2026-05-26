# Standardize Laravel Framework for Public API Development: Implementations Extend Laravel

These rules are ALWAYS ACTIVE for all public/external API development including API controllers, models, service providers, and test suites within the application boundary.

### Rules

- **R-LARAVEL-API-001** MAY: API implementations MAY extend Laravel's base TestCase class with custom assertion helpers for domain-specific testing needs.

### Verify

```bash
# Verify Laravel controller inheritance
grep -r "extends Controller" app/Http/Controllers/ | wc -l

# Verify Eloquent model usage
grep -r "extends Model" app/Models/ | grep -v "^Binary" | wc -l

# Run test suite
php artisan test --testsuite=Feature --testsuite=Unit

# Verify service provider registration
grep -r "class.*ServiceProvider extends ServiceProvider" app/Providers/ | wc -l
```

**Accept when:**
- All API controllers extend Laravel's base Controller class and use framework HTTP abstractions (verified by grep showing >0 matches)
- All data models extend Eloquent Model class with proper relationships and attributes (verified by grep showing >0 matches)
- Test suite passes with Feature tests for API endpoints and Unit tests for business logic (verified by php artisan test exit code 0)
- Service providers are registered for API-related services following Laravel conventions (verified by grep showing AppServiceProvider and similar patterns)

<enforcement>
Claude Code MUST NOT skip or defer verification. All API implementations MUST be verified against these Laravel framework patterns before acceptance.
</enforcement>