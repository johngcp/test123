# Adopt Laravel Eloquent ORM as Standard Data Access Layer: Database Entities Represented

These rules are ALWAYS ACTIVE for all database interactions, model definitions, controllers, seeders, and feature tests in Laravel applications.

### Rules

- **R-ELOQUENT-001** MUST: All database entities MUST be represented as Eloquent Model classes extending `Illuminate\Database\Eloquent\Model`.
- **R-ELOQUENT-002** MUST: All CRUD operations in HTTP controllers MUST use Eloquent models, not raw SQL or Query Builder without models.
- **R-ELOQUENT-003** MUST: All model classes MUST define `$fillable` or `$guarded` properties for mass assignment protection.
- **R-ELOQUENT-004** MUST: Database seeders MUST use model factories or model `create()` methods exclusively, not manual SQL inserts.
- **R-ELOQUENT-005** SHOULD: Model relationship access SHOULD use eager loading with `with()` method to prevent N+1 query problems.
- **R-ELOQUENT-006** SHOULD: Reusable query logic SHOULD be implemented as model scopes (e.g., `scopeActive`, `scopePublished`) to keep controllers thin.
- **R-ELOQUENT-007** MAY: Raw SQL queries MAY be used only when documented exceptions (EXC-001, EXC-002) are approved and marked with `// APPROVED` comments.

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
- All model classes extend `Illuminate\Database\Eloquent\Model` and define mass assignment protection (`$fillable` or `$guarded`)
- Database seeders use model factories or model `create()` methods exclusively
- Feature tests achieve minimum 80% coverage and use database transactions for isolation
- Code review checklist includes verification of eager loading for relationship access
- Any raw SQL exceptions include code comments with approval ticket reference

<enforcement>
Claude Code MUST NOT skip or defer verification. All rules in this file are mandatory for database access patterns. Violations must be flagged in code review and CI pipeline checks must pass before merge.
</enforcement>