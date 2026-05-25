# Standardize Laravel Framework for Public API Development: Service Providers Used

These rules are ALWAYS ACTIVE for all HTTP controllers serving public/external API endpoints, Eloquent models representing API resource data, service providers registering API-related services and middleware, feature and unit tests validating API behavior, database factories and seeders supporting API data requirements, and API request validation logic and form requests.

### Rules

- **R-LARAVEL-SP-001** MUST: Service providers MUST be used to register API-related services, bindings, and configuration in the Laravel service container (AppServiceProvider pattern).

### Verify

```bash
# Verify API controllers extend Laravel base Controller
grep -r "extends Controller" app/Http/Controllers/ | wc -l

# Verify data models extend Eloquent Model
grep -r "extends Model" app/Models/ | grep -v "^Binary" | wc -l

# Run Laravel test suite
php artisan test --testsuite=Feature --testsuite=Unit

# Verify service providers are registered
grep -r "class.*ServiceProvider extends ServiceProvider" app/Providers/ | wc -l
```

**Accept when:**
- All API controllers extend Laravel's base Controller class and use framework HTTP abstractions (verified by grep showing >0 matches)
- All data models extend Eloquent Model class with proper relationships and attributes (verified by grep showing >0 matches)
- Test suite passes with Feature tests for API endpoints and Unit tests for business logic (verified by php artisan test exit code 0)
- Service providers are registered for API-related services following Laravel conventions (verified by grep showing AppServiceProvider and similar patterns)

<enforcement>
Claude Code MUST NOT skip or defer verification. All four verification conditions must pass before accepting code changes.
</enforcement>