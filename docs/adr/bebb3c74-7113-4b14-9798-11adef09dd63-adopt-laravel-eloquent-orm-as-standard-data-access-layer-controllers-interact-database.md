# Adopt Laravel Eloquent ORM as Standard Data Access Layer: Controllers Interact Database

Status: proposed
Date: 2025-01-17
Deciders: Detection Pipeline (automated)

## Activation

This ADR is ACTIVE for all data access operations in Laravel applications. All database interactions MUST follow the Eloquent ORM patterns defined herein unless explicitly exempted.

## Context

- The application uses Laravel framework which provides Eloquent ORM as its primary database abstraction layer
- Pattern detected across multiple layers: bootstrap configuration, HTTP controllers, database seeders, model definitions, and feature tests
- Consistent usage pattern observed in 5 files with 81.30% confidence, indicating established architectural convention
- The codebase demonstrates standard Laravel MVC architecture with clear separation between models, controllers, and data seeding
- Eloquent provides Active Record pattern implementation with built-in query builder, relationship management, and model lifecycle hooks

## Problem Statement

The application requires a consistent, maintainable approach to database interactions that balances developer productivity with code quality. Without a standardized data access pattern, teams may implement inconsistent query patterns, direct SQL usage, or mixed abstraction levels, leading to maintenance challenges, security vulnerabilities (SQL injection), and difficulty in testing and refactoring database logic.

## Decision

1. MUST: Controllers MUST interact with the database exclusively through Eloquent models, not through direct DB facade calls or raw SQL

## Policy Block

- MUST Controllers MUST interact with the database exclusively through Eloquent models, not through direct DB facade calls or raw SQL

In scope:
- All CRUD operations in HTTP controllers
- Database seeding and migration data population
- Model relationship definitions and eager loading
- Feature and integration tests requiring database interaction
- API resource controllers and RESTful endpoints
- Background job classes that persist or retrieve data

Out of scope:
- Complex analytical queries requiring raw SQL optimization
- Database administration scripts and maintenance tasks
- Data migration scripts from legacy systems
- Performance-critical queries where ORM overhead is measured and unacceptable
- Third-party package internals that manage their own data access

Exceptions:
- EXC-001: Performance profiling demonstrates ORM overhead exceeds 100ms for critical path queries
- EXC-002: Complex reporting queries require database-specific features not supported by Eloquent

## Rationale

- Pattern signature b2c7e34030e14ff60ea3ab94b7579acc detected with 81.30% confidence across 5 files indicates consistent architectural approach
- Eloquent ORM provides built-in protection against SQL injection through parameter binding and query builder abstraction
- Active Record pattern reduces boilerplate code and improves developer productivity by eliminating manual SQL for common operations
- Framework-integrated approach ensures compatibility with Laravel ecosystem tools (migrations, factories, seeders, testing utilities)
- Consistent data access pattern improves code maintainability and reduces onboarding time for new developers familiar with Laravel conventions

## Consequences

Positive:
- Reduced SQL injection vulnerability surface through automatic parameter binding and query sanitization
- Improved developer productivity with expressive, chainable query syntax and automatic relationship loading
- Enhanced testability through model factories, database transactions, and in-memory SQLite support
- Better code organization with clear separation between data access logic (models) and business logic (controllers/services)
- Simplified database migrations and schema changes through framework-integrated tooling

Negative:
- Performance overhead for complex queries compared to hand-optimized SQL (typically 5-15% overhead)
- Learning curve for developers unfamiliar with Active Record pattern or Laravel conventions
- Potential N+1 query problems if eager loading is not properly implemented for relationships
- Limited support for advanced database features (CTEs, window functions) requiring workarounds or raw queries
- Tight coupling to Laravel framework makes migration to other frameworks more difficult

## Alternatives

- Use Laravel Query Builder directly without Eloquent models (rejected)
  Rejected because: Query Builder lacks model lifecycle hooks, relationship management, and type safety benefits. Detected pattern shows consistent model usage across controllers and tests, indicating team preference for Active Record pattern.
  When valid: Valid for one-off reporting queries or data export scripts where model overhead is unnecessary
- Implement Repository Pattern with interface-based data access (deferred)
  Rejected because: Not rejected but deferred. Current pattern shows direct model usage in controllers. Repository pattern adds abstraction layer that may be valuable for larger teams but adds complexity for current codebase size.
  When valid: Consider when application grows beyond 20 models or when multiple data sources require abstraction
- Use raw PDO or database-specific drivers directly (rejected)
  Rejected because: Eliminates framework benefits, increases SQL injection risk, requires manual parameter binding, and breaks compatibility with Laravel testing and migration tools. No evidence of raw PDO usage in detected pattern.
  When valid: Only for extreme performance optimization after profiling proves ORM is bottleneck

## Risks

- N+1 query problems causing performance degradation when loading model relationships without eager loading
  Mitigation: Enable query logging in development, use Laravel Debugbar to detect N+1 issues, implement automated tests that count queries, and enforce eager loading in code reviews
  Owner: Engineering team with backend tech lead oversight
- Developers may bypass Eloquent for perceived performance gains without proper benchmarking, creating inconsistent codebase
  Mitigation: Establish clear exception process requiring performance profiling data, document approved patterns in team wiki, and implement automated linting to detect raw SQL in controllers
  Owner: Tech lead and architecture review board
- Mass assignment vulnerabilities if model fillable/guarded properties are not properly configured
  Mitigation: Enforce fillable or guarded property definition in all models through static analysis, include mass assignment tests in security test suite, and conduct regular security audits
  Owner: Security team with engineering implementation

## Implementation Notes

- All new models should extend Illuminate\Database\Eloquent\Model and define $fillable or $guarded properties for mass assignment protection
- Use model factories (database/factories) for test data generation and seeding rather than manual array construction
- Implement model scopes for reusable query logic (e.g., scopeActive, scopePublished) to keep controllers thin
- Configure eager loading using with() method when accessing relationships to prevent N+1 queries
- Use database transactions in feature tests (RefreshDatabase trait) to ensure test isolation and faster execution
- Document any raw SQL exceptions in code comments with justification and link to approval ticket

## Continuation Context


Verify commands:
- grep -r "DB::raw\|DB::select\|DB::statement" app/Http/Controllers/ --include='*.php' | grep -v "// APPROVED" || echo "No unapproved raw SQL in controllers"
- find app/Models -name '*.php' -exec grep -L "extends Model" {} \; | grep -v "Traits" || echo "All models extend Eloquent Model"
- php artisan test --filter Feature --coverage --min=80
- grep -r "\$fillable\|\$guarded" app/Models/ --include='*.php' | wc -l

Accept when:
- All controller database operations use Eloquent models with no raw SQL queries except documented exceptions
- All model classes extend Illuminate\Database\Eloquent\Model and define mass assignment protection
- Database seeders use model factories or model create methods exclusively
- Feature tests achieve minimum 80% coverage and use database transactions for isolation
- Code review checklist includes verification of eager loading for relationship access

## Enforcement

- Verified by: Automated CI pipeline runs grep commands to detect raw SQL in controllers
- Verified by: PHPStan or Psalm static analysis configured to enforce model type hints
- Verified by: Code review checklist includes Eloquent pattern compliance verification
- Verified by: Laravel Debugbar enabled in development to monitor query counts and N+1 issues
- Verified by: Monthly architecture review of new models and data access patterns
- Violation handling: CI pipeline fails if unapproved raw SQL detected in controllers
- Violation handling: Pull requests blocked until Eloquent patterns are followed or exception is documented
- Violation handling: Violations flagged in code review with required refactoring before merge
- Violation handling: Performance issues from N+1 queries trigger immediate remediation tickets
- Violation handling: Quarterly audit report tracks violations and trends for architecture review
- Exception process: Developer creates exception request ticket with performance benchmark data or technical justification
- Exception process: Tech lead reviews and approves/rejects based on documented criteria (100ms threshold, database-specific features)
- Exception process: Approved exceptions must include code comments with approval ticket reference
- Exception process: Exception registry maintained in architecture documentation with annual review
- Exception process: All exceptions require equivalent test coverage and security review for SQL injection risks