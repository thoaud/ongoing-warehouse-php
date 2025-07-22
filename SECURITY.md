# Security Policy

## Supported Versions

Use this section to tell people about which versions of your project are currently being supported with security updates.

| Version | Supported          |
| ------- | ------------------ |
| 1.0.x   | :white_check_mark: |
| < 1.0   | :x:                |

## Reporting a Vulnerability

We take security vulnerabilities seriously. If you discover a security vulnerability in the Ongoing Warehouse API PHP Client, please follow these steps:

### 1. **DO NOT** create a public GitHub issue

Security vulnerabilities should be reported privately to avoid potential exploitation.

### 2. Email us directly

Send an email to **phpdevsec@proton.me** with the following information:

- **Subject**: `[SECURITY] Ongoing API PHP Client Vulnerability Report`
- **Description**: Detailed description of the vulnerability
- **Steps to reproduce**: Clear steps to reproduce the issue
- **Impact**: Potential impact of the vulnerability
- **Suggested fix**: If you have a suggested fix (optional)

### 3. What to include in your report

Please include as much detail as possible:

- **Version affected**: Which version(s) of the library are affected
- **Environment**: PHP version, operating system, etc.
- **Code example**: Minimal code example that demonstrates the vulnerability
- **Proof of concept**: If possible, include a proof of concept
- **Timeline**: When you discovered the vulnerability

### 4. Response timeline

- **Initial response**: Within 48 hours
- **Status update**: Within 1 week
- **Fix timeline**: Depends on severity and complexity

### 5. Disclosure policy

- We will acknowledge receipt of your report within 48 hours
- We will provide regular updates on the status of the fix
- Once a fix is ready, we will:
  - Release a security patch
  - Update the CHANGELOG.md with security information
  - Credit you in the security advisory (unless you prefer to remain anonymous)

## Security Best Practices

When using this library, please follow these security best practices:

### 1. **Keep dependencies updated**

Regularly update the library and its dependencies:

```bash
composer update ongoingwarehouse/ongoing-api-php
```

### 2. **Use HTTPS only**

Always use HTTPS for API communications:

```php
$config->setHost('https://api.ongoingsystems.se/your-warehouse');
```

### 3. **Secure credential storage**

Never hardcode credentials in your source code:

```php
// Good: Use environment variables
$config->setUsername($_ENV['ONGOING_API_USERNAME']);
$config->setPassword($_ENV['ONGOING_API_PASSWORD']);

// Bad: Hardcoded credentials
$config->setUsername('myuser');
$config->setPassword('mypassword');
```

### 4. **Validate input data**

Always validate and sanitize data before sending to the API:

```php
// Validate article numbers
if (!preg_match('/^[A-Z0-9-]+$/', $articleNumber)) {
    throw new InvalidArgumentException('Invalid article number format');
}
```

### 5. **Handle errors securely**

Don't expose sensitive information in error messages:

```php
try {
    $articles = $articlesApi->articlesGetAll($goodsOwnerId);
} catch (ApiException $e) {
    // Log the full error for debugging
    error_log("API Error: " . $e->getMessage());
    
    // Show user-friendly message
    echo "An error occurred while fetching articles.";
}
```

### 6. **Use proper authentication**

Ensure your API credentials have the minimum required permissions:

- Use dedicated API users, not admin accounts
- Regularly rotate API credentials
- Monitor API usage for suspicious activity

## Security Features

This library includes several security features:

### 1. **Input validation**

All API parameters are validated before being sent to the server.

### 2. **HTTPS enforcement**

The library enforces HTTPS connections by default.

### 3. **Secure defaults**

The library uses secure defaults for all configurations.

### 4. **Error handling**

Comprehensive error handling prevents information leakage.

## Security Updates

Security updates will be released as patch versions (e.g., 1.0.1, 1.0.2) and will be clearly marked in the CHANGELOG.md file.

## Contact

For security-related questions or concerns:

- **Email**: phpdevsec@proton.me
- **PGP Key**: Available upon request
- **Response time**: Within 48 hours

## Acknowledgments

We thank all security researchers and users who responsibly report vulnerabilities to help keep our library secure. 