# Establish RESTful Controller-Route Pattern for Service API Boundaries: Http Endpoints Defined

These rules are ALWAYS ACTIVE for all HTTP API endpoints, controller classes, and route definitions within the application's service boundaries.

### Rules

- **R-HTTP-001** MUST: All HTTP API endpoints MUST be defined through dedicated controller classes that handle request/response transformation.

### Verify

```bash
# Count controller classes in the application
grep -r 'class.*Controller extends' app/Http/Controllers/ | wc -l

# Count route definitions using framework helpers
grep -E 'Route::(get|post|put|patch|delete|resource)' routes/*.php | wc -l

# Find controllers that do not implement standard RESTful methods
find app/Http/Controllers -name '*Controller.php' -exec grep -L 'function (index|show|store|update|destroy)' {} \;
```

**Accept when:**
- All HTTP endpoints are defined through controller classes located in `app/Http/Controllers`
- Route definitions are centralized in `routes/` directory files with clear controller method references
- Controllers follow RESTful naming conventions for standard resource operations (index, show, store, update, destroy)
- Non-standard endpoints are documented with clear comments explaining deviation from RESTful conventions

<enforcement>
Claude Code MUST NOT skip or defer verification. All HTTP endpoints must be validated against these rules during code review and CI pipeline execution. Violations block pull requests unless approved exceptions are documented in ADR amendments.
</enforcement>