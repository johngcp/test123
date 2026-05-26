# Establish RESTful Controller-Route Pattern for Service API Boundaries: Route Definitions Centralized

These rules are ALWAYS ACTIVE for all HTTP controllers, route definitions, and service API boundary code within the application.

### Rules

- **R-ROUTE-001** MUST: Route definitions MUST be centralized in routing configuration files (e.g., routes/web.php, routes/api.php) and MUST NOT be scattered throughout the codebase.

### Verify

```bash
# Count controller classes to verify RESTful controller pattern adoption
grep -r 'class.*Controller extends' app/Http/Controllers/ | wc -l

# Verify route definitions are centralized in routes directory
grep -E 'Route::(get|post|put|patch|delete|resource)' routes/*.php | wc -l

# Find controllers that may not follow RESTful conventions
find app/Http/Controllers -name '*Controller.php' -exec grep -L 'function (index|show|store|update|destroy)' {} \;
```

**Accept when:**
- All HTTP endpoints are defined through controller classes located in app/Http/Controllers
- Route definitions are centralized in routes/ directory files with clear controller method references
- Controllers follow RESTful naming conventions for standard resource operations (index, show, store, update, destroy)

<enforcement>
Claude Code MUST NOT skip or defer verification. Route centralization is mandatory and violations must be caught before merge.
</enforcement>