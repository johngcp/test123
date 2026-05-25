# Adopt Separate Unit and Feature Test Directories for Laravel Testing Strategy: Unit Tests Extend

These rules are ALWAYS ACTIVE for all PHPUnit test files in Laravel projects, governing test organization strategy and base class selection.

### Rules

- **R-UNIT-001** SHOULD: Unit tests SHOULD extend PHPUnit\Framework\TestCase rather than Tests\TestCase to avoid loading the full Laravel framework

### Verify

```bash
# Verify test directories exist
test -d tests/Unit && test -d tests/Feature && echo 'Test directories exist' || echo 'Missing test directories'

# Verify unit tests use PHPUnit TestCase
find tests/Unit -name '*Test.php' -type f | head -n 1 | xargs grep -l 'PHPUnit\\Framework\\TestCase' && echo 'Unit tests use PHPUnit TestCase'

# Verify feature tests use Laravel TestCase
find tests/Feature -name '*Test.php' -type f | head -n 1 | xargs grep -l 'Tests\\TestCase' && echo 'Feature tests use Laravel TestCase'

# Verify PHPUnit config includes separate test suites
grep -A 10 '<testsuites>' phpunit.xml | grep -E '(Unit|Feature)' && echo 'PHPUnit config includes separate test suites'
```

**Accept when:**
- Both tests/Unit and tests/Feature directories exist in the project root
- At least one example test exists in each directory demonstrating proper base class usage
- PHPUnit configuration file defines separate test suites for Unit and Feature tests
- Unit tests extend PHPUnit\Framework\TestCase and Feature tests extend Tests\TestCase (or project-specific TestCase)

<enforcement>
Claude Code MUST NOT skip or defer verification of test directory structure, base class usage, and PHPUnit configuration.
</enforcement>