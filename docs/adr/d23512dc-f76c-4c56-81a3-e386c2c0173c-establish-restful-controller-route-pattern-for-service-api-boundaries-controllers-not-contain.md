# Establish RESTful Controller-Route Pattern for Service API Boundaries: Controllers Not Contain

Status: proposed
Date: 2024-01-09
Deciders: Detection Pipeline (automated)

## Context

- The application requires a consistent approach to defining service boundaries and API endpoints for external and internal consumers
- HTTP controllers and route definitions form the primary interface contract between clients and the application's business logic
- Pattern detected across TaskController.php and web.php routing configuration, indicating a standardized approach to API boundary definition
- RESTful conventions provide predictable, maintainable service interfaces that align with industry standards and developer expectations

## Problem Statement

Without a standardized pattern for defining service API boundaries through controllers and routes, the application risks inconsistent interface contracts, unpredictable endpoint behavior, and difficulty in maintaining clear separation between presentation and business logic layers. This leads to coupling issues, testing challenges, and poor API discoverability.

## Decision

1. MUST_NOT: Controllers MUST NOT contain business logic; they MUST delegate to service layer or domain objects

## Policy Block

- MUST_NOT Controllers MUST NOT contain business logic; they MUST delegate to service layer or domain objects

In scope:
- All HTTP endpoints exposed to external clients
- Internal API endpoints consumed by frontend applications
- RESTful resource controllers (TaskController, UserController, etc.)
- Web and API route definition files

Out of scope:
- Console commands and CLI interfaces
- Background job handlers and queue workers
- Event listeners and subscribers
- Internal service-to-service method calls that do not cross HTTP boundaries

Exceptions:
- EX-001: Legacy endpoints require non-RESTful naming for backward compatibility with existing clients
- EX-002: Webhook or third-party integration endpoints require specific non-standard patterns dictated by external specifications

## Rationale

- Pattern detected with 81.20% confidence across TaskController.php and web.php, indicating established architectural practice
- RESTful controller-route pattern provides clear separation of concerns between HTTP layer and business logic, improving testability and maintainability
- Centralized route definitions enable comprehensive API documentation generation and security auditing
- Consistent naming conventions reduce cognitive load for developers and improve code discoverability across the codebase

## Consequences

Positive:
- Clear, predictable API surface area that follows industry-standard RESTful conventions
- Improved testability through isolated controller testing without requiring full application bootstrap
- Enhanced maintainability with explicit route-to-controller mappings visible in centralized configuration
- Better IDE support and static analysis capabilities through type-safe controller references

Negative:
- Additional abstraction layer may feel like overhead for simple CRUD operations
- Requires discipline to avoid business logic creep into controllers over time
- May require refactoring existing inline route handlers or closure-based routes
- Learning curve for developers unfamiliar with MVC or controller-based architectures

## Alternatives

- Closure-based routing with inline request handlers defined directly in route files (rejected)
  Rejected because: Inline closures mix routing configuration with business logic, making testing difficult and violating separation of concerns. Does not scale well for complex applications.
  When valid: May be acceptable for extremely simple applications with fewer than 10 endpoints and no anticipated growth
- Action-based single-purpose controller classes (one controller per endpoint) (deferred)
  Rejected because: Not rejected; this is a valid alternative pattern that may be adopted for specific use cases
  When valid: Appropriate for complex operations that don't fit RESTful resource patterns, or when following CQRS/command handler patterns
- API Gateway pattern with centralized routing proxy (rejected)
  Rejected because: Adds significant infrastructure complexity and latency for monolithic applications. Better suited for microservices architectures.
  When valid: Should be reconsidered when transitioning to distributed microservices architecture

## Risks

- Controllers may accumulate business logic over time, violating separation of concerns and reducing testability
  Mitigation: Enforce code review guidelines requiring controllers to remain thin. Implement automated complexity metrics in CI pipeline to flag controllers exceeding cyclomatic complexity thresholds.
  Owner: Engineering team leads
- Route definitions may become fragmented across multiple files as application grows, reducing discoverability
  Mitigation: Establish clear conventions for route file organization (e.g., api.php for API routes, web.php for web routes). Generate automated route documentation as part of build process.
  Owner: Platform architecture team
- Inconsistent application of RESTful conventions may lead to confusing API design
  Mitigation: Provide controller templates and code generation tools that enforce conventions. Include API design review as part of pull request checklist.
  Owner: Engineering team

## Implementation Notes

- Use framework-provided controller generation commands (e.g., 'php artisan make:controller') to ensure consistent structure
- Organize controllers by resource domain in app/Http/Controllers directory with subdirectories for logical grouping
- Leverage route resource helpers (e.g., Route::resource()) to automatically generate standard RESTful routes
- Implement base controller classes for shared concerns like authentication, validation, and response formatting
- Document non-standard endpoints with clear comments explaining deviation from RESTful conventions

## Continuation Context


Verify commands:
- grep -r 'class.*Controller extends' app/Http/Controllers/ | wc -l
- grep -E 'Route::(get|post|put|patch|delete|resource)' routes/*.php | wc -l
- find app/Http/Controllers -name '*Controller.php' -exec grep -L 'function (index|show|store|update|destroy)' {} \;

Accept when:
- All HTTP endpoints are defined through controller classes located in app/Http/Controllers
- Route definitions are centralized in routes/ directory files with clear controller method references
- Controllers follow RESTful naming conventions for standard resource operations (index, show, store, update, destroy)

## Enforcement

- Verified by: Automated static analysis in CI pipeline checking for route definitions outside approved files
- Verified by: Code review checklist requiring verification of controller structure and RESTful conventions
- Verified by: Architectural fitness functions testing controller complexity and method naming patterns
- Violation handling: CI pipeline fails if routes are defined outside centralized route files
- Violation handling: Pull requests blocked if controllers exceed complexity thresholds or contain business logic
- Violation handling: Architecture review required for any non-RESTful endpoint patterns
- Exception process: Submit exception request to architecture review board with justification and impact analysis
- Exception process: Document approved exceptions in ADR amendments with expiration dates where applicable
- Exception process: Review all active exceptions quarterly to assess whether they can be resolved