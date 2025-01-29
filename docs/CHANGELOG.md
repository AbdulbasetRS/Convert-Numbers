# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.0.0] - 2025-01-29

### Added
- Initial release of the package
- Number to words conversion functionality
  - Support for integers and decimal numbers
  - Negative numbers handling
  - Decimal point handling
  - Multi-language support (Arabic, English, French)

- Currency conversion features
  - Convert amounts to words in multiple languages
  - Format currency with proper separators
  - Optional currency symbol display
  - Support for multiple currencies:
    - USD (US Dollar)
    - EUR (Euro)
    - EGP (Egyptian Pound)
    - SAR (Saudi Riyal)

- File size formatting
  - Convert bytes to human-readable formats
  - Automatic unit selection (B, KB, MB, GB, TB, PB)
  - Language-specific unit names
  - Customizable decimal places

- Number formatting utilities
  - Language-specific decimal separators
  - Thousands separators
  - Arabic numeral conversion

### Language Support
- Arabic (ar)
  - Full number to words conversion
  - Currency formatting with Arabic numerals
  - File size units in Arabic
  - Right-to-left (RTL) support

- English (en)
  - Complete number to words implementation
  - Standard currency formatting
  - International file size units

- French (fr)
  - Number to words conversion
  - European currency formatting
  - French file size units

### Architecture
- Implementation following SOLID principles
- Abstract classes and interfaces for extensibility
- Separation of concerns for language and currency handling
- Utility classes for common formatting operations

[1.0.0]: https://github.com/AbdulbasetRS/Convert-Numbers/releases/tag/v1.0.0