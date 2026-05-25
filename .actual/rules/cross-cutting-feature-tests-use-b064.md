# Adopt Laravel Eloquent ORM as Standard Data Access Layer: Feature Tests Use

These rules are ALWAYS ACTIVE for all database interactions in Laravel applications, including feature tests, HTTP controllers, database seeders, model definitions, and data access operations.

### Rules

- **R-ELOQUENT-001** SHOULD: Feature tests SHOULD use model factories and database transactions to ensure test isolation.
- **R-ELOQUENT-002** MUST: All new models MUST extend `Illuminate\Database\Eloquent\Model` and define `$fillable` or `$guarded` properties for mass assignment protection.
- **R-ELOQUENT-003** SHOULD: Use model factories (database/factories) for test data generation and seeding rather than manual array construction.
- **R-ELOQUENT-004** SHOULD: Implement model scopes for reusable query logic to keep controllers thin.
- **R-ELOQUENT-005** MUST: Configure eager loading using `with()` method when accessing relationships to prevent N+1 queries.
- **R-ELOQUENT-006** MUST: Use database transactions in feature tests (RefreshDatabase trait) to ensure test isolation and faster execution.
- **R-ELOQUENT-007** SHOULD: Document any raw SQL exceptions in code comments with justification and link to approval ticket.
- **R-ELOQUENT-008** MUST: All controller database operations MUST use Eloquent models with no raw SQL queries except documented exceptions.

### Verify

```bash
# Detect unapproved raw SQL in controllers
grep -r "DB::raw\|DB::select\|DB::statement" app/Http/Controllers/ --include='*.php' | grep -v "// APPROVED" || echo "No unapproved raw SQL in controllers"

# Verify all models extend Eloquent Model
find app/Models -name '*.php' -exec grep -L "extends Model" {} \; | grep -v "Traits" || echo "All models extend Eloquent Model"

# Run feature tests with coverage
php artisan test --filter Feature --coverage --min=80

# Verify mass assignment protection is defined
grep -r "\$fillable\|\$guarded" app/Models/ --include='*.php' | wc -l
```

**Accept when:**
- All controller database operations use Eloquent models with no raw SQL queries except documented exceptions
- All model classes extend `Illuminate\Database\Eloquent\Model` and define mass assignment protection
- Database seeders use model factories or model create methods exclusively
- Feature tests achieve minimum 80% coverage and use database transactions for isolation
- Code review checklist includes verification of eager loading for relationship access
- No N+1 query issues detected in Laravel Debugbar or query logging
- All raw SQL exceptions include code comments with approval ticket references

<enforcement>
Claude Code MUST NOT skip or defer verification. All rules in this file are mandatory for feature test implementations and data access patterns. Violations must be flagged in code review and remediated before merge. Performance exceptions require documented benchmarking data and tech lead approval.
</enforcement>