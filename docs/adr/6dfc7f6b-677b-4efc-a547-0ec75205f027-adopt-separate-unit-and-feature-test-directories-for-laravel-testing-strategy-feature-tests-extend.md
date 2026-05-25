# Adopt Separate Unit and Feature Test Directories for Laravel Testing Strategy: Feature Tests Extend

Status: proposed
Date: 2024-01-20
Deciders: Detection Pipeline (automated)

## Activation

This ADR is ALWAYS ACTIVE for all Laravel projects and governs test organization strategy.

## Context

- Laravel projects require a clear testing strategy that separates concerns between isolated unit tests and integrated feature tests
- The framework provides default test directories (tests/Unit and tests/Feature) that encourage separation of test types based on scope and dependencies
- Unit tests focus on testing individual classes and methods in isolation without framework dependencies, while feature tests validate end-to-end behavior including HTTP routing, middleware, and database interactions
- The pattern was detected across 3 files including web routes and example test files, indicating this is a foundational architectural decision made early in project setup
- Proper test organization improves test execution speed, maintainability, and helps developers understand what level of testing is appropriate for different components

## Problem Statement

Without a clear testing strategy and organizational structure, test suites become difficult to maintain, slow to execute, and provide unclear feedback when failures occur. Mixing unit and integration tests in a single directory makes it impossible to run fast unit tests independently and obscures the appropriate testing approach for different components.

## Decision

1. SHOULD: Feature tests SHOULD extend Tests\TestCase to leverage Laravel testing utilities and application bootstrapping

## Policy Block

- SHOULD Feature tests SHOULD extend Tests\TestCase to leverage Laravel testing utilities and application bootstrapping

In scope:
- All PHPUnit test files in Laravel projects
- Test organization and directory structure decisions
- Test base class selection (TestCase vs PHPUnit TestCase)
- CI/CD pipeline test execution configuration

Out of scope:
- Browser testing with Laravel Dusk (separate dusk/ directory)
- JavaScript/frontend unit tests
- Third-party package tests
- Performance or load testing tools

Exceptions:
- EXC-001: Legacy projects migrating from a different test organization structure may temporarily violate this structure during transition
- EXC-002: Microservices or API-only applications with no traditional feature tests may use alternative organization

## Rationale

- The pattern was detected with 81.60% confidence across 3 files including both test directories and web routes, indicating this is an established architectural pattern in the codebase
- Separating unit and feature tests enables faster feedback loops by running isolated unit tests independently without framework overhead
- Laravel's default project structure explicitly provides these directories, suggesting this is a framework-endorsed best practice
- Clear separation helps developers understand testing scope and choose appropriate testing strategies for different components

## Consequences

Positive:
- Faster test execution when running unit tests independently without framework bootstrapping overhead
- Clearer test organization makes it easier for developers to locate and understand existing tests
- Better test isolation reduces flaky tests and improves reliability of the test suite
- Enables parallel test execution strategies by separating fast unit tests from slower feature tests

Negative:
- Requires developers to understand the distinction between unit and feature tests, adding cognitive overhead
- May lead to debates about where certain tests belong, especially for tests that fall in a gray area
- Maintaining example tests in both directories requires additional documentation effort
- Some tests may need to be refactored or moved as understanding of their scope evolves

## Alternatives

- Single tests/ directory with no separation between unit and feature tests (rejected)
  Rejected because: Makes it impossible to run fast unit tests independently and provides no guidance on appropriate testing scope for different components
  When valid: Only appropriate for very small projects with fewer than 10 tests total
- Organize tests by domain/module rather than by test type (e.g., tests/User, tests/Order) (rejected)
  Rejected because: Prevents running all unit tests or all feature tests independently, which is critical for CI/CD optimization and developer workflow
  When valid: Could be used as subdirectory organization within Unit/ and Feature/ directories
- Three-tier structure with tests/Unit, tests/Integration, and tests/Feature (rejected)
  Rejected because: Adds complexity without clear benefit for most Laravel applications; the Unit/Feature distinction is sufficient for typical use cases
  When valid: May be appropriate for very large enterprise applications with complex integration requirements

## Risks

- Developers may incorrectly classify tests, placing feature tests in Unit/ or vice versa, reducing the effectiveness of the separation
  Mitigation: Provide clear documentation and example tests; implement CI checks to verify unit tests don't extend Laravel TestCase
  Owner: Engineering team lead
- Over-reliance on feature tests may lead to slow test suites if developers default to feature tests for everything
  Mitigation: Establish code review guidelines emphasizing unit test coverage; track and report test execution times in CI
  Owner: Engineering team
- Example tests may become outdated or removed, eliminating guidance for new developers
  Mitigation: Include example test maintenance in onboarding documentation review process; protect example files in CI
  Owner: Technical documentation owner

## Implementation Notes

- Ensure phpunit.xml configuration includes separate test suites for Unit and Feature tests to enable independent execution
- Create comprehensive example tests in both directories demonstrating proper usage patterns, assertions, and base class selection
- Document the distinction between unit and feature tests in project README or CONTRIBUTING.md with clear examples
- Configure CI pipeline to run unit tests first for fast feedback, followed by feature tests
- Consider adding PHPStan or Psalm rules to enforce that tests in Unit/ directory don't extend Laravel's TestCase

## Continuation Context


Verify commands:
- test -d tests/Unit && test -d tests/Feature && echo 'Test directories exist' || echo 'Missing test directories'
- find tests/Unit -name '*Test.php' -type f | head -n 1 | xargs grep -l 'PHPUnit\\Framework\\TestCase' && echo 'Unit tests use PHPUnit TestCase'
- find tests/Feature -name '*Test.php' -type f | head -n 1 | xargs grep -l 'Tests\\TestCase' && echo 'Feature tests use Laravel TestCase'
- grep -A 10 '<testsuites>' phpunit.xml | grep -E '(Unit|Feature)' && echo 'PHPUnit config includes separate test suites'

Accept when:
- Both tests/Unit and tests/Feature directories exist in the project root
- At least one example test exists in each directory demonstrating proper base class usage
- PHPUnit configuration file defines separate test suites for Unit and Feature tests
- Unit tests extend PHPUnit\Framework\TestCase and Feature tests extend Tests\TestCase (or project-specific TestCase)

## Enforcement

- Verified by: Automated CI pipeline checks verify test directory structure exists
- Verified by: Code review process validates new tests are placed in appropriate directories
- Verified by: Static analysis tools check that Unit tests don't extend Laravel TestCase
- Verified by: PHPUnit test suite execution confirms separate suites are configured
- Violation handling: CI pipeline fails if test directories are missing or improperly structured
- Violation handling: Pull requests with incorrectly placed tests receive review comments requesting relocation
- Violation handling: Quarterly test suite audits identify and remediate misclassified tests
- Violation handling: Team retrospectives address patterns of confusion about test classification
- Exception process: Developer identifies need for exception and documents rationale in test file comments
- Exception process: Technical lead reviews exception request during code review
- Exception process: Approved exceptions are documented in project testing guidelines
- Exception process: Exceptions are reviewed quarterly to determine if they should become permanent patterns or be refactored