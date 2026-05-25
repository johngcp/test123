# Establish RESTful Controller-Route Pattern for Service API Boundaries: Route Controller Mappings

These rules are ALWAYS ACTIVE for all HTTP controllers, route definitions, and service API boundary code within the application.

### Rules

- **R-RESTFUL-001** SHOULD: Route-to-controller mappings SHOULD use explicit method references rather than string-based routing to enable static analysis and refactoring tools.

### Verify

```bash
# Count controller classes in the application
grep -r 'class.*Controller extends' app/Http/Controllers/ | wc -l

# Count RESTful route definitions
grep -E 'Route::(get|post|put|patch|delete|resource)' routes/*.php | wc -l

# Find controllers that don't implement standard RESTful methods
find app/Http/Controllers -name '*Controller.php' -exec grep -L 'function (index|show|store|update|destroy)' {} \;
```

**Accept when:**
- All HTTP endpoints are defined through controller classes located in app/Http/Controllers
- Route definitions are centralized in routes/ directory files with clear controller method references
- Controllers follow RESTful naming conventions for standard resource operations (index, show, store, update, destroy)
- Route-to-controller mappings use explicit method references (e.g., `TaskController@index`) rather than string-based routing

<enforcement>
Claude Code MUST NOT skip or defer verification of route-to-controller mappings. All HTTP endpoints must be audited for compliance with explicit method reference patterns and centralized route definition requirements.
</enforcement>