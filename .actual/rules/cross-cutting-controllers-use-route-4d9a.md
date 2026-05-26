# Establish RESTful Controller-Route Pattern for Service API Boundaries: Controllers Use Route

These rules are ALWAYS ACTIVE for all HTTP controllers and route definitions that form service API boundaries for external and internal consumers.

### Rules

- **R-CTRL-001** MAY: Controllers MAY use route model binding to automatically resolve resource instances from route parameters.

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

<enforcement>
Claude Code MUST NOT skip or defer verification of controller structure and route centralization.
</enforcement>