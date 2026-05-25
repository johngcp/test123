# Standardize Laravel Framework for Public API Development: Data Models Use

These rules are ALWAYS ACTIVE for all public/external API development including API controllers, models, service providers, and test suites within the application boundary.

### Rules

- **R-API-001** MUST: API data models MUST use Laravel Eloquent ORM with explicit relationship definitions, fillable/guarded properties, and type casting for consistent data access patterns.

### Verify

```bash
# Verify API controllers extend Laravel base Controller
grep -r "extends Controller" app/Http/Controllers/ | wc -l

# Verify data models extend Eloquent Model
grep -r "extends Model" app/Models/ | grep -v "^Binary" | wc -l

# Run test suite
php artisan test --testsuite=Feature --testsuite=Unit

# Verify service providers follow Laravel conventions
grep -r "class.*ServiceProvider extends ServiceProvider" app/Providers/ | wc -l
```

**Accept when:**
- All API controllers extend Laravel's base Controller class and use framework HTTP abstractions (grep shows >0 matches)
- All data models extend Eloquent Model class with proper relationships and attributes (grep shows >0 matches)
- Test suite passes with Feature tests for API endpoints and Unit tests for business logic (php artisan test exit code 0)
- Service providers are registered for API-related services following Laravel conventions (grep shows AppServiceProvider and similar patterns)

<enforcement>
Claude Code MUST NOT skip or defer verification. CI pipeline blocks merge if test suite fails or static analysis detects framework pattern violations. Code review process requires changes to align with Laravel conventions before approval.
</enforcement>