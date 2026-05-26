# Establish RESTful Controller-Route Pattern for Service API Boundaries: Controllers Follow Restful

These rules are ALWAYS ACTIVE for all HTTP controllers and route definitions that form service API boundaries for external and internal consumers.

### Rules

- **R-RESTFUL-001** MUST: Controllers MUST follow RESTful naming conventions (index, show, store, update, destroy) for resource-based operations.

### Verify

```bash
# Count controller classes in the application
grep -r 'class.*Controller extends' app/Http/Controllers/ | wc -l

# Count route definitions using standard HTTP verbs and resource helpers
grep -E 'Route::(get|post|put|patch|delete|resource)' routes/*.php | wc -l

# Find controllers that do not implement standard RESTful methods
find app/Http/Controllers -name '*Controller.php' -exec grep -L 'function (index|show|store|update|destroy)' {} \;
```

**Accept when:**
- All HTTP endpoints are defined through controller classes located in app/Http/Controllers
- Route definitions are centralized in routes/ directory files with clear controller method references
- Controllers follow RESTful naming conventions for standard resource operations (index, show, store, update, destroy)

<enforcement>
Claude Code MUST NOT skip or defer verification. All HTTP controllers and routes must be audited against these rules during code review and CI pipeline execution.
</enforcement>