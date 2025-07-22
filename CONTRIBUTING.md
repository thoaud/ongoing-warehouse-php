# Contributing to Ongoing Warehouse API PHP Client

Thank you for your interest in contributing to the Ongoing Warehouse API PHP Client! This document provides guidelines and information for contributors.

## Table of Contents

- [Code of Conduct](#code-of-conduct)
- [How Can I Contribute?](#how-can-i-contribute)
- [Development Setup](#development-setup)
- [Testing](#testing)
- [Code Style](#code-style)
- [Pull Request Process](#pull-request-process)
- [Release Process](#release-process)

## Code of Conduct

This project and everyone participating in it is governed by our Code of Conduct. By participating, you are expected to uphold this code.

## How Can I Contribute?

### Reporting Bugs

- Use the GitHub issue tracker
- Include a clear and descriptive title
- Provide steps to reproduce the issue
- Include error messages and stack traces
- Specify your PHP version and environment

### Suggesting Enhancements

- Use the GitHub issue tracker
- Describe the enhancement clearly
- Explain why this enhancement would be useful
- Include any relevant documentation or examples

### Pull Requests

- Fork the repository
- Create a feature branch (`git checkout -b feature/amazing-feature`)
- Make your changes
- Add tests for new functionality
- Ensure all tests pass
- Update documentation if needed
- Submit a pull request

## Development Setup

### Prerequisites

- PHP 7.4 or higher
- Composer
- Git

### Installation

1. Fork and clone the repository:
```bash
git clone https://github.com/thoaud/ongoing-warehouse-php.git
cd ongoing-warehouse-php
```

2. Install dependencies:
```bash
composer install
```

3. Install development dependencies:
```bash
composer install --dev
```

### Environment Setup

Create a `.env` file for your development environment:

```bash
cp .env.example .env
```

Edit the `.env` file with your test credentials:

```env
ONGOING_API_HOST=https://api.ongoingsystems.se/test-warehouse
ONGOING_API_USERNAME=your-test-username
ONGOING_API_PASSWORD=your-test-password
ONGOING_API_GOODS_OWNER_ID=123
```

## Testing

### Running Tests

```bash
# Run all tests
composer test

# Run tests with coverage
composer test-coverage

# Run specific test file
./vendor/bin/phpunit tests/ArticlesApiTest.php

# Run tests with verbose output
./vendor/bin/phpunit --verbose
```

### Writing Tests

- Tests should be placed in the `tests/` directory
- Follow the naming convention: `ClassNameTest.php`
- Extend `PHPUnit\Framework\TestCase`
- Use descriptive test method names
- Mock external dependencies when appropriate

Example test structure:

```php
<?php

namespace OngoingAPI\Tests;

use PHPUnit\Framework\TestCase;
use OngoingAPI\Api\ArticlesApi;
use OngoingAPI\Configuration;

class ArticlesApiTest extends TestCase
{
    private ArticlesApi $articlesApi;
    private Configuration $config;

    protected function setUp(): void
    {
        $this->config = new Configuration();
        $this->config->setHost('https://api.ongoingsystems.se/test');
        $this->config->setUsername('test');
        $this->config->setPassword('test');
        
        $this->articlesApi = new ArticlesApi(null, $this->config);
    }

    public function testGetAllArticles(): void
    {
        // Test implementation
    }
}
```

## Code Style

### PHP Standards

This project follows PSR-12 coding standards. Use PHP CodeSniffer to check your code:

```bash
# Check code style
composer phpcs

# Auto-fix code style issues
composer phpcbf
```

### Code Quality

Use PHPStan for static analysis:

```bash
composer phpstan
```

### Pre-commit Hooks

Consider setting up pre-commit hooks to automatically run tests and code style checks:

```bash
# Install pre-commit hooks
cp .git/hooks/pre-commit.sample .git/hooks/pre-commit
chmod +x .git/hooks/pre-commit
```

## Pull Request Process

1. **Create a feature branch** from the main branch
2. **Write tests** for new functionality
3. **Follow coding standards** (PSR-12)
4. **Update documentation** if needed
5. **Run all tests** and ensure they pass
6. **Update CHANGELOG.md** with your changes
7. **Submit the pull request** with a clear description

### Pull Request Guidelines

- Use a clear and descriptive title
- Provide a detailed description of changes
- Include any relevant issue numbers
- Add screenshots or examples if applicable
- Ensure all CI checks pass

### Commit Message Guidelines

Follow conventional commit format:

```
type(scope): description

[optional body]

[optional footer]
```

Types:
- `feat`: New feature
- `fix`: Bug fix
- `docs`: Documentation changes
- `style`: Code style changes
- `refactor`: Code refactoring
- `test`: Test changes
- `chore`: Maintenance tasks

Examples:
```
feat(articles): add support for article categories
fix(auth): resolve authentication timeout issue
docs(readme): update installation instructions
```

## Release Process

### Versioning

This project follows [Semantic Versioning](https://semver.org/):

- **MAJOR**: Incompatible API changes
- **MINOR**: New functionality in a backwards-compatible manner
- **PATCH**: Backwards-compatible bug fixes

### Release Steps

1. **Update version** in `composer.json`
2. **Update CHANGELOG.md** with release notes
3. **Create a release tag**:
   ```bash
   git tag -a v1.0.0 -m "Release version 1.0.0"
   git push origin v1.0.0
   ```
4. **Create GitHub release** with release notes
5. **Publish to Packagist** (if applicable)

### Pre-release Checklist

- [ ] All tests pass
- [ ] Code style is compliant
- [ ] Documentation is updated
- [ ] CHANGELOG.md is updated
- [ ] Version numbers are updated
- [ ] Release notes are prepared

## Getting Help

If you need help with contributing:

- **Issues**: Use the GitHub issue tracker
- **Discussions**: Use GitHub Discussions
- **Email**: phpdevsec@proton.me

## License

By contributing to this project, you agree that your contributions will be licensed under the MIT License.

## Acknowledgments

Thank you to all contributors who have helped make this project better! 