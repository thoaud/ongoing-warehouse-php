# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

### Added
- New `ArticleItemsApi::articleItemsGetArticleItemsModel()` method that returns a single `GetArticleItemsModel` object
- New `GetArticleItemsModel::getArticleItems()` method as an alias for `getItems()`
- New `GetArticleItemInfo::getStatusCode()` method for direct access to status code
- New `GetArticleItemInfoStatus::getStatusCode()` method as an alias for `getCode()`
- Comprehensive PHPDoc for all public methods in `ArticleItemsApi`, `GetArticleItemsModel`, and `GetArticleItemInfo`
- New example in README.md for fetching article items with pagination
- New example in `examples/advanced_usage.php` for article items usage
- New unit tests in `tests/ArticleItemsApiTest.php` covering normal response, empty response, and missing fields

### Changed
- Improved error handling in `ArticleItemsApi` with more detailed exception messages
- Enhanced PHPDoc for all model getters with detailed descriptions and return types
- Updated pagination documentation with clear usage examples

### Deprecated
- `ArticleItemsApi::articleItemsGetArticleItems()` method is now deprecated in favor of `articleItemsGetArticleItemsModel()`
  - The deprecated method still returns an array of models (legacy behavior)
  - The new method returns a single model for better consistency
  - A deprecation warning is triggered when using the old method

### Fixed
- Improved exception messages to include raw response body for better debugging
- Enhanced JSON decoding error messages with raw response content

## [1.0.0] - 2024-01-01

### Added
- Initial release of the Ongoing Warehouse API PHP Client
- Support for all Ongoing WMS REST API endpoints
- Complete type safety with PHP type hints
- PSR-7, PSR-18, and PSR-4 compliance
- Comprehensive documentation and examples 