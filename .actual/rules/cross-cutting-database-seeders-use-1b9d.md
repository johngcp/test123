# Adopt Laravel Eloquent ORM as Standard Data Access Layer: Database Seeders Use

These rules are ALWAYS ACTIVE for all database interactions in Laravel applications, including HTTP controllers, database seeders, model definitions, feature tests, API resource controllers, and background job classes that persist or retrieve data.

### Rules

- **R-ELOQUENT-001** MUST: Database seeders MUST use Eloquent model factories or model create methods for data population.
- **R-ELOQUENT-002** MUST: All new models MUST extend `Illuminate\Database\Eloquent\Model` and define `$fillable` or `$guarded` properties for mass assignment protection.
- **R-ELOQUENT-003** MUST: All controller database operations MUST use Eloquent models with no raw SQL queries except documented exceptions (EXC-001, EXC-002).
- **R-ELOQUENT-004** SHOULD: Implement model scopes for reusable query logic (e.g., `scopeActive`, `scopePublished`) to keep controllers thin.
- **R-ELOQUENT-005** SHOULD: Configure eager loading using `with()` method when accessing relationships to prevent N+1 queries.
- **R-ELOQUENT-006** SHOULD: Use database transactions in feature tests (RefreshDatabase trait) to ensure test isolation and faster execution.
- **R-ELOQUENT-007** MUST: Any raw SQL exceptions MUST be documented in code comments with justification and link to approval ticket.

### Verify

```bash
# Detect unapproved raw SQL in controllers
grep -r "DB::raw\|DB::select\|DB::statement" app/Http/Controllers/ --include='*.php' | grep -v "// APPROVED" || echo "No unapproved raw SQL in controllers"

# Verify all models extend Eloquent Model
find app/Models -name '*.php' -exec grep -L "extends Model" {} \; | grep -v "Traits" || echo "All models extend Eloquent Model"

# Run feature tests with coverage
php artisan test --filter Feature --coverage --min=80

# Count fillable/guarded property definitions
grep -r "\$fillable\|\$guarded" app/Models/ --include='*.php' | wc -l
```

**Accept when:**
- All controller database operations use Eloquent models with no raw SQL queries except documented exceptions
- All model classes extend `Illuminate\Database\Eloquent\Model` and define mass assignment protection
- Database seeders use model factories or model create methods exclusively
- Feature tests achieve minimum 80% coverage and use database transactions for isolation
- Code review checklist includes verification of eager loading for relationship access
- All raw SQL exceptions include code comments with approval ticket reference

<enforcement>
Claude Code MUST NOT skip or defer verification. CI pipeline MUST fail if unapproved raw SQL is detected in controllers. Pull requests MUST be blocked until Eloquent patterns are followed or exceptions are properly documented. Violations MUST be flagged in code review with required refactoring before merge.
</enforcement>