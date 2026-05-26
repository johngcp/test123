# Establish RESTful Controller-Route Pattern for Service API Boundaries: Each Controller Responsible

These rules are ALWAYS ACTIVE for all HTTP controllers, route definitions, and service API boundary code within the application.

### Rules

- **R-CTRL-001** SHOULD: Each controller SHOULD be responsible for a single resource or closely related set of operations to maintain single responsibility principle.

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
- Controllers remain thin and do not accumulate business logic beyond request handling and response formatting
- Route definitions are not fragmented across multiple files outside the centralized routes/ directory

<enforcement>
Claude Code MUST NOT skip or defer verification of controller structure and RESTful route patterns. Violations must be flagged during code review and architectural fitness checks.
</enforcement>