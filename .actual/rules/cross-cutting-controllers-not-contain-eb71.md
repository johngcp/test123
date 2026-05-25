# Adopt Laravel Eloquent ORM as Standard Data Access Layer: Controllers Not Contain

These rules are ALWAYS ACTIVE for all Laravel HTTP controllers, database seeders, model definitions, and feature tests that perform data access operations.

### Rules

- **R-ELOQUENT-001** MUST NOT: Controllers MUST NOT contain raw SQL queries or direct PDO operations.
- **R-ELOQUENT-002** MUST: All new models MUST extend `Illuminate\Database\Eloquent\Model` and define `$fillable` or `$guarded` properties for mass assignment protection.
- **R-ELOQUENT-003** MUST: Database seeders MUST use model factories or model create methods exclusively, not manual SQL or raw queries.
- **R-ELOQUENT-004** SHOULD: Implement model scopes for reusable query logic (e.g., `scopeActive`, `scopePublished`) to keep controllers thin.
- **R-ELOQUENT-005** SHOULD: Configure eager loading using `with()` method when accessing relationships to prevent N+1 queries.
- **R-ELOQUENT-006** SHOULD: Use model factories (database/factories) for test data generation and seeding rather than manual array construction.
- **R-ELOQUENT-007** SHOULD: Use database transactions in feature tests (RefreshDatabase trait) to ensure test isolation and faster execution.
- **R-ELOQUENT-008** MAY: Raw SQL queries are permitted only when documented exceptions (EXC-001: performance profiling demonstrates ORM overhead exceeds 100ms for critical path queries; EXC-002: complex reporting queries require database-specific features not supported by Eloquent) are approved and code comments include approval ticket reference.

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
- All controller database operations use Eloquent models with no raw SQL queries except documented exceptions with approval ticket references in code comments.
- All model classes in `app/Models/` extend `Illuminate\Database\Eloquent\Model` and define `$fillable` or `$guarded` properties.
- Database seeders use model factories or model create methods exclusively with no raw SQL or direct PDO operations.
- Feature tests achieve minimum 80% code coverage and use database transactions (RefreshDatabase trait) for isolation.
- Code review checklist includes verification of eager loading for relationship access and N+1 query prevention.
- All models with relationships implement eager loading via `with()` method in controllers and queries.

<enforcement>
Claude Code MUST NOT skip or defer verification. All rules in this file are mandatory for Laravel data access operations. Violations must be flagged in code review and CI pipeline must fail if unapproved raw SQL is detected in controllers. Approved exceptions require performance benchmark data or technical justification with ticket reference in code comments.
</enforcement>