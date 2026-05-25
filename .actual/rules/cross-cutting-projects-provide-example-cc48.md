# Adopt Separate Unit and Feature Test Directories for Laravel Testing Strategy: Projects Provide Example

These rules are ALWAYS ACTIVE for all Laravel projects and govern test organization strategy across PHPUnit test files, test directory structure decisions, test base class selection, and CI/CD pipeline test execution configuration.

### Rules

- **R-LARAVEL-TESTING-001** SHOULD: Projects SHOULD provide example tests in both `tests/Unit` and `tests/Feature` directories to demonstrate proper usage patterns for new team members.

### Verify

```bash
# Verify test directories exist
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

<enforcement>
Claude Code MUST NOT skip or defer verification of test directory structure, example test presence, and PHPUnit configuration compliance.
</enforcement>