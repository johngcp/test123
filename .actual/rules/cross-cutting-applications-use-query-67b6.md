# Adopt Laravel Eloquent ORM as Standard Data Access Layer: Applications Use Query

These rules are ALWAYS ACTIVE for all database interactions in Laravel applications, including CRUD operations in HTTP controllers, database seeding, model relationship definitions, feature and integration tests, API resource controllers, and background job classes that persist or retrieve data.

### Rules

- **R-ELOQUENT-001** MUST: Use Eloquent ORM models (extending `Illuminate\Database\Eloquent\Model`) for all standard CRUD operations in HTTP controllers, database seeders, and feature tests.
- **R-ELOQUENT-002** MUST: Define `$fillable` or `$guarded` properties on all Eloquent models to prevent mass assignment vulnerabilities.
- **R-ELOQUENT-003** MUST: Use eager loading with the `with()` method when accessing model relationships to prevent N+1 query problems.
- **R-ELOQUENT-004** SHOULD: Implement model scopes (e.g., `scopeActive()`, `scopePublished()`) for reusable query logic to keep controllers thin.
- **R-ELOQUENT-005** SHOULD: Use model factories (in `database/factories/`) for test data generation and seeding rather than manual array construction.
- **R-ELOQUENT-006** SHOULD: Use database transactions in feature tests via the `RefreshDatabase` trait to ensure test isolation and faster execution.
- **R-ELOQUENT-007** MAY: Use the Query Builder directly for complex reporting queries that do not map to single model operations, provided performance profiling justifies the exception.
- **R-ELOQUENT-008** MUST NOT: Use raw SQL (`DB::raw()`, `DB::select()`, `DB::statement()`) in HTTP controllers without documented exception approval and code comments referencing the approval ticket.

### Verify

```bash
# Detect unapproved raw SQL in controllers
grep -r "DB::raw\|DB::select\|DB::statement" app/Http/Controllers/ --include='*.php' | grep -v "// APPROVED" || echo "No unapproved raw SQL in controllers"

# Verify all models extend Eloquent Model
find app/Models -name '*.php' -exec grep -L "extends Model" {} \; | grep -v "Traits" || echo "All models extend Eloquent Model"

# Run feature tests with coverage threshold
php artisan test --filter Feature --coverage --min=80

# Count fillable/guarded property definitions
grep -r "\$fillable\|\$guarded" app/Models/ --include='*.php' | wc -l
```

**Accept when:**
- All controller database operations use Eloquent models with no raw SQL queries except documented exceptions with approval ticket references in code comments.
- All model classes in `app/Models/` extend `Illuminate\Database\Eloquent\Model` and define `$fillable` or `$guarded` properties.
- Database seeders use model factories or model `create()` methods exclusively, with no manual SQL inserts.
- Feature tests achieve minimum 80% code coverage and use database transactions (RefreshDatabase trait) for isolation.
- Code review checklist verification confirms eager loading is used for all relationship access and no N+1 queries are present.
- All exceptions to raw SQL usage are documented in code comments with justification and approval ticket reference.

<enforcement>
Claude Code MUST NOT skip or defer verification. All rules in this file are mandatory for Laravel applications within scope. Violations must be flagged in code review and remediated before merge. Performance exceptions require benchmark data and tech lead approval before implementation.
</enforcement>