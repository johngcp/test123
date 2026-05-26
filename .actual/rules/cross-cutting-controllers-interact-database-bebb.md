# Adopt Laravel Eloquent ORM as Standard Data Access Layer: Controllers Interact Database

These rules are ALWAYS ACTIVE for all database interactions in Laravel applications, including HTTP controllers, models, seeders, migrations, and feature tests.

### Rules

- **R-ELOQUENT-001** MUST: Controllers MUST interact with the database exclusively through Eloquent models, not through direct DB facade calls or raw SQL.

### Verify

```bash
# Detect unapproved raw SQL in controllers
grep -r "DB::raw\|DB::select\|DB::statement" app/Http/Controllers/ --include='*.php' | grep -v "// APPROVED" || echo "No unapproved raw SQL in controllers"

# Verify all models extend Eloquent Model
find app/Models -name '*.php' -exec grep -L "extends Model" {} \; | grep -v "Traits" || echo "All models extend Eloquent Model"

# Run feature tests with coverage threshold
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
- Any approved exceptions are documented in code comments with approval ticket reference

<enforcement>
Claude Code MUST NOT skip or defer verification. All controller database interactions MUST use Eloquent models. Raw SQL in controllers is prohibited unless explicitly approved via exception process with performance benchmarking data. CI pipeline MUST fail if unapproved raw SQL is detected.
</enforcement>