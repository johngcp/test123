# Standardize Laravel Framework for Public API Development: Public Controllers Extend

Status: proposed
Date: 2024-01-09
Deciders: Detection Pipeline (automated)

## Activation

This ADR is ACTIVE for all public/external API development and applies to all API controllers, models, service providers, and test suites within the application boundary.

## Context

- The codebase demonstrates consistent use of Laravel framework patterns across 10 files including controllers, models, service providers, factories, and test cases with 80.22% confidence
- Public API endpoints require standardized request handling, validation, response formatting, and error management to ensure consistent external integration experiences
- Laravel's built-in features (Eloquent ORM, service container, middleware, resource controllers) provide battle-tested patterns for API development that reduce implementation variance
- The detected pattern shows systematic adoption across the application stack from HTTP layer (TaskController, Controller base) through data layer (User, Task models) to testing infrastructure (TestCase, Feature/Unit tests)
- External API consumers benefit from predictable behavior patterns that Laravel conventions naturally enforce through framework structure

## Problem Statement

Public-facing APIs require consistent architectural patterns for request handling, data validation, response formatting, authentication, and error management. Without standardized framework conventions, API implementations diverge in structure and behavior, creating integration challenges for external consumers and maintenance burden for internal teams. The codebase needs a unified approach to API development that ensures predictable contracts while maintaining developer productivity.

## Decision

1. MUST: All public API controllers MUST extend the base Laravel Controller class and utilize framework-provided HTTP abstractions for request/response handling

## Policy Block

- MUST All public API controllers MUST extend the base Laravel Controller class and utilize framework-provided HTTP abstractions for request/response handling

In scope:
- All HTTP controllers serving public/external API endpoints
- Eloquent models representing API resource data
- Service providers registering API-related services and middleware
- Feature and unit tests validating API behavior
- Database factories and seeders supporting API data requirements
- API request validation logic and form requests

Out of scope:
- Internal service-to-service communication not exposed via public APIs
- Administrative or internal-only endpoints not part of the public API contract
- Third-party package integrations that provide their own framework abstractions
- Legacy endpoints scheduled for deprecation with documented migration paths

Exceptions:
- EXC-001: Performance-critical endpoints require direct database access bypassing Eloquent ORM
- EXC-002: Legacy API endpoints must maintain backward compatibility with non-Laravel response formats

## Rationale

- Pattern detection across 10 files (TaskController, User/Task models, AppServiceProvider, test infrastructure) with 80.22% confidence indicates systematic Laravel adoption rather than isolated usage
- Laravel's opinionated structure reduces architectural decisions developers must make, leading to more consistent API implementations and faster onboarding
- Framework conventions provide built-in security features (CSRF protection, SQL injection prevention via query builder, mass assignment protection) critical for public API safety
- The evidence shows integration across the full stack (HTTP layer, business logic, data access, testing) demonstrating that Laravel patterns successfully span all API development concerns

## Consequences

Positive:
- Consistent API structure across all endpoints improves external developer experience and reduces integration errors
- Laravel's extensive ecosystem and documentation accelerates development velocity for new API features
- Built-in testing tools (HTTP testing, database factories, mocking) enable comprehensive test coverage with minimal boilerplate
- Framework upgrades provide automatic security patches and performance improvements across all API endpoints simultaneously

Negative:
- Framework coupling creates migration complexity if future requirements necessitate moving away from Laravel
- Laravel's magic methods and facades can obscure actual dependencies, making static analysis and refactoring more challenging
- Framework upgrade cycles may require coordinated updates across all API components when breaking changes occur
- Performance overhead of framework abstractions may impact high-throughput API endpoints requiring optimization

## Alternatives

- Adopt framework-agnostic API architecture using PSR standards (PSR-7 HTTP messages, PSR-15 middleware) with minimal framework coupling (rejected)
  Rejected because: Increases implementation complexity and development time without clear benefits given the existing Laravel investment evidenced across 10 files. PSR standards lack the integrated ecosystem (ORM, validation, testing) that Laravel provides.
  When valid: Valid for greenfield projects with explicit multi-framework requirements or when building reusable API packages intended for distribution
- Use microframework (Lumen, Slim) for lightweight API-only architecture without full Laravel stack (rejected)
  Rejected because: Evidence shows full Laravel usage including service providers, Eloquent models, and comprehensive testing infrastructure. Microframework would require rewriting existing patterns and lose access to Laravel's full feature set.
  When valid: Valid for new isolated microservices with strict performance requirements and minimal feature needs
- Implement custom MVC framework tailored specifically to application domain requirements (rejected)
  Rejected because: Custom framework development diverts resources from business value delivery and creates maintenance burden. Laravel's maturity (10+ years, large community) provides stability and security that custom solutions cannot match.
  When valid: Valid only for highly specialized domains where no existing framework can meet unique architectural constraints

## Risks

- Laravel version upgrades introduce breaking changes requiring coordinated updates across all API components
  Mitigation: Maintain comprehensive test suite (Feature/Unit tests as evidenced), follow Laravel upgrade guides, test in staging environment, and schedule upgrades during low-traffic periods
  Owner: Engineering team with platform architecture oversight
- Over-reliance on Laravel magic methods and facades reduces code transparency and complicates debugging for complex API issues
  Mitigation: Enforce explicit dependency injection in controllers and services, use IDE helper packages for autocomplete, and document framework-specific patterns in team knowledge base
  Owner: Development team leads
- Framework abstractions introduce performance overhead that may not scale for high-throughput API endpoints
  Mitigation: Establish performance benchmarks for critical endpoints, implement caching strategies using Laravel's cache abstraction, and document exception process for performance-critical optimizations
  Owner: Performance engineering team

## Implementation Notes

- Use Laravel's API resource controllers (php artisan make:controller --api) to scaffold consistent endpoint structures with standard REST methods
- Leverage FormRequest classes for complex validation logic to keep controllers thin and validation rules reusable across endpoints
- Implement API versioning strategy using route prefixes (api/v1, api/v2) to maintain backward compatibility as APIs evolve
- Utilize Laravel's database factories (as evidenced in UserFactory.php) for consistent test data generation across feature tests
- Configure API-specific exception handling in app/Exceptions/Handler.php to return consistent JSON error responses for all failure scenarios

## Continuation Context


Verify commands:
- grep -r "extends Controller" app/Http/Controllers/ | wc -l
- grep -r "extends Model" app/Models/ | grep -v "^Binary" | wc -l
- php artisan test --testsuite=Feature --testsuite=Unit
- grep -r "class.*ServiceProvider extends ServiceProvider" app/Providers/ | wc -l

Accept when:
- All API controllers extend Laravel's base Controller class and use framework HTTP abstractions (verified by grep showing >0 matches)
- All data models extend Eloquent Model class with proper relationships and attributes (verified by grep showing >0 matches)
- Test suite passes with Feature tests for API endpoints and Unit tests for business logic (verified by php artisan test exit code 0)
- Service providers are registered for API-related services following Laravel conventions (verified by grep showing AppServiceProvider and similar patterns)

## Enforcement

- Verified by: Automated CI pipeline runs Laravel test suite (Feature/Unit tests) on every pull request
- Verified by: Code review checklist includes verification of Laravel framework pattern adherence (controller inheritance, Eloquent usage, validation implementation)
- Verified by: Static analysis tools (PHPStan/Psalm with Laravel extensions) detect deviations from framework conventions
- Verified by: Architecture decision log review during sprint planning ensures new API endpoints follow established patterns
- Violation handling: CI pipeline blocks merge if test suite fails or static analysis detects framework pattern violations
- Violation handling: Code review process requires changes to align with Laravel conventions before approval
- Violation handling: Architecture review board evaluates violations requiring exceptions and documents approved deviations
- Violation handling: Quarterly technical debt review identifies and prioritizes remediation of non-compliant legacy code
- Exception process: Developer submits exception request to architecture review board with justification (performance data, technical constraints, business requirements)
- Exception process: Review board evaluates request within 3 business days, considering impact on API consistency and maintenance burden
- Exception process: Approved exceptions are documented in ADR amendments with sunset timeline and migration path
- Exception process: Exception usage is tracked and reviewed quarterly to identify patterns requiring policy updates