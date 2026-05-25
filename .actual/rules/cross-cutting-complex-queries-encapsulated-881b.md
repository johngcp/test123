# Adopt Laravel Eloquent ORM as Standard Data Access Layer: Complex Queries Encapsulated

These rules are ALWAYS ACTIVE for all data access operations in Laravel applications, including CRUD operations in HTTP controllers, database seeding, model relationship definitions, feature and integration tests, API resource controllers, and background job classes that persist or retrieve data.

### Rules

- **R-ELOQUENT-001** SHOULD: Complex queries SHOULD be encapsulated in model scopes or repository methods rather than inline in controllers.

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
- All model classes extend Illuminate\Database\Eloquent\Model and define mass assignment protection ($fillable or $guarded)
- Database seeders use model factories or model create methods exclusively
- Feature tests achieve minimum 80% coverage and use database transactions for isolation
- Code review checklist includes verification of eager loading for relationship access
- Any raw SQL exceptions are documented in code comments with approval ticket reference

<enforcement>
Claude Code MUST NOT skip or defer verification. All rules in this file are ALWAYS ACTIVE and must be checked before accepting pull requests or merging code changes.
</enforcement>