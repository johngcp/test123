# Establish RESTful Controller-Route Pattern for Service API Boundaries: Controllers Not Contain

These rules are ALWAYS ACTIVE for all HTTP controllers and route definitions within the application's service API boundaries.

### Rules

- **R-CTRL-001** MUST_NOT: Controllers MUST NOT contain business logic; they MUST delegate to service layer or domain objects.

### Verify

```bash
# Count controller classes in the application
grep -r 'class.*Controller extends' app/Http/Controllers/ | wc -l

# Count RESTful route definitions
grep -E 'Route::(get|post|put|patch|delete|resource)' routes/*.php | wc -l

# Find controllers that do not implement standard RESTful methods
find app/Http/Controllers -name '*Controller.php' -exec grep -L 'function (index|show|store|update|destroy)' {} \;
```

**Accept when:**
- All HTTP endpoints are defined through controller classes located in app/Http/Controllers
- Route definitions are centralized in routes/ directory files with clear controller method references
- Controllers follow RESTful naming conventions for standard resource operations (index, show, store, update, destroy)
- Controllers delegate business logic to service layer or domain objects rather than implementing it directly

<enforcement>
Clause Code MUST NOT skip or defer verification of controller structure and business logic delegation patterns.
</enforcement>