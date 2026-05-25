# Adopt Separate Unit and Feature Test Directories for Laravel Testing Strategy: Laravel Projects Maintain

These rules are ALWAYS ACTIVE for all Laravel projects and govern test organization strategy across all PHPUnit test files and test directory structure decisions.

### Rules

- **R-LARAVEL-001** MUST: All Laravel projects MUST maintain separate `tests/Unit` and `tests/Feature` directories for organizing tests by scope.
- **R-LARAVEL-002** MUST: Unit tests MUST extend `PHPUnit\Framework\TestCase` and test individual classes and methods in isolation without framework dependencies.
- **R-LARAVEL-003** MUST: Feature tests MUST extend `Tests\TestCase` (or project-specific TestCase) and validate end-to-end behavior including HTTP routing, middleware, and database interactions.
- **R-LARAVEL-004** MUST: PHPUnit configuration file (`phpunit.xml`) MUST define separate test suites for Unit and Feature tests to enable independent execution.
- **R-LARAVEL-005** SHOULD: CI/CD pipeline SHOULD run unit tests first for fast feedback, followed by feature tests.
- **R-LARAVEL-006** SHOULD: Projects SHOULD include comprehensive example tests in both `tests/Unit` and `tests/Feature` directories demonstrating proper usage patterns, assertions, and base class selection.
- **R-LARAVEL-007** SHOULD: Projects SHOULD document the distinction between unit and feature tests in project README or CONTRIBUTING.md with clear examples.
- **R-LARAVEL-008** MAY: Projects MAY use domain/module organization (e.g., `tests/Unit/User`, `tests/Feature/Order`) as subdirectory organization within Unit/ and Feature/ directories.

### Verify

```bash
# Verify both test directories exist
test -d tests/Unit && test -d tests/Feature && echo 'Test directories exist' || echo 'Missing test directories'

# Verify Unit tests use PHPUnit TestCase
find tests/Unit -name '*Test.php' -type f | head -n 1 | xargs grep -l 'PHPUnit\\Framework\\TestCase' && echo 'Unit tests use PHPUnit TestCase'

# Verify Feature tests use Laravel TestCase
find tests/Feature -name '*Test.php' -type f | head -n 1 | xargs grep -l 'Tests\\TestCase' && echo 'Feature tests use Laravel TestCase'

# Verify PHPUnit config includes separate test suites
grep -A 10 '<testsuites>' phpunit.xml | grep -E '(Unit|Feature)' && echo 'PHPUnit config includes separate test suites'
```

**Accept when:**
- Both `tests/Unit` and `tests/Feature` directories exist in the project root
- At least one example test exists in each directory demonstrating proper base class usage
- PHPUnit configuration file defines separate test suites for Unit and Feature tests
- Unit tests extend `PHPUnit\Framework\TestCase` and Feature tests extend `Tests\TestCase` (or project-specific TestCase)
- CI/CD pipeline is configured to run unit tests independently from feature tests

<enforcement>
Claude Code MUST NOT skip or defer verification of test directory structure, base class usage, and PHPUnit configuration. Violations MUST be flagged during code review and CI pipeline execution.
</enforcement>