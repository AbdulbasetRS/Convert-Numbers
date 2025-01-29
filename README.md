![Thumbnail](docs/thumbnail.png)

# Convert Numbers

A comprehensive PHP package for number conversion, supporting multiple languages and various conversion types.

## Features

### 1. Number to Words Conversion

- Convert integers and decimal numbers to words
- Support for negative numbers
- Decimal point handling
- Language-specific formatting

### 2. Currency Handling

- Convert currency amounts to words
- Format currency with proper separators
- Optional currency symbol display
- Support for multiple currencies:
  - USD (US Dollar)
  - EUR (Euro)
  - EGP (Egyptian Pound)
  - SAR (Saudi Riyal)

### 3. File Size Formatting

- Convert bytes to human-readable formats
- Automatic unit selection (B, KB, MB, GB, TB, PB)
- Language-specific unit names
- Customizable decimal places

### 4. Multi-language Support

- Arabic (ar)
- English (en)
- French (fr)

### 5. Number Formatting

- Language-specific decimal separators
- Thousands separators
- Arabic numeral conversion

## Installation

Install the package via Composer:

```bash
composer require abdulbaset/convert-numbers
```

## Usage

### Basic Number Conversion

```php
use Abdulbaset\ConvertNumbers\ConvertNumbers;

// English (default)
echo ConvertNumbers::toWords(42); // "forty-two"
echo ConvertNumbers::toWords(1234.56); // "one thousand two hundred thirty-four point five six"

// Arabic
echo ConvertNumbers::toWords(42, 'ar'); // "اثنان و أربعون"
echo ConvertNumbers::toWords(1234.56, 'ar'); // "ألف و مائتان و أربعة و ثلاثون فاصلة خمسة ستة"

// French
echo ConvertNumbers::toWords(42, 'fr'); // "quarante-deux"
```

### Currency Conversion

```php
// Basic currency to words
echo ConvertNumbers::currencyToWords(1234.56, 'USD');
// "one thousand two hundred thirty-four dollars and fifty-six cents only"

// Arabic currency
echo ConvertNumbers::currencyToWords(1234.56, 'EGP', 'ar');
// "ألف و مائتان و أربعة و ثلاثون جنيه مصري و ستة و خمسون قرش فقط لا غير"

// Currency formatting
echo ConvertNumbers::currencyFormat(1234567.89, 'USD', 'en', true); // "1,234,567.89 $"
echo ConvertNumbers::currencyFormat(1234567.89, 'EGP', 'ar', true); // "١٬٢٣٤٬٥٦٧٫٨٩ ج.م"
```

### File Size Formatting

```php
// Basic file size formatting
echo ConvertNumbers::toFileSize(1024); // "1.00 KB"
echo ConvertNumbers::toFileSize(1024 * 1024); // "1.00 MB"

// Arabic formatting
echo ConvertNumbers::toFileSize(1024, 'ar'); // "١٫٠٠ كيلوبايت"
echo ConvertNumbers::toFileSize(1024 * 1024, 'ar'); // "١٫٠٠ ميجابايت"

// French formatting
echo ConvertNumbers::toFileSize(1024, 'fr'); // "1,00 Ko"
echo ConvertNumbers::toFileSize(1024 * 1024, 'fr'); // "1,00 Mo"

// Custom decimal places
echo ConvertNumbers::toFileSize(1234567, 'en', 3); // "1.177 MB"
```

## Architecture

The package follows SOLID principles and clean architecture:

1. **Single Responsibility Principle (SRP)**

   - Each class has a single responsibility
   - Language classes handle language-specific conversions
   - Currency classes manage currency-specific logic
   - Utility classes for formatting and conversion

2. **Open/Closed Principle (OCP)**

   - Easy to add new languages by extending `LanguageAbstract`
   - New currencies can be added by extending `CurrencyAbstract`
   - No modification needed to existing code

3. **Interface Segregation Principle (ISP)**

   - Separate interfaces for different functionalities
   - `ConverterInterface` for number conversion
   - `CurrencyInterface` for currency operations
   - `FileSizeInterface` for file size formatting

4. **Dependency Inversion Principle (DIP)**
   - High-level modules depend on abstractions
   - Easy to swap implementations

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

1. Fork the repository
2. Create your feature branch
3. Commit your changes
4. Push to the branch
5. Create a Pull Request

## Change Log

For a detailed list of changes and updates in each version, see the [Change Log](docs/CHANGELOG.md).

## License

This package is open-sourced software licensed under the [LICENSE](LICENSE) license.

## Support

For support:

- Email: AbdulbasetRedaSayedHF@Gmail.com
- Create an issue in the GitHub repository

## Donations 💖

Maintaining this package takes time and effort. If you’d like to support its development and keep it growing, you can:

- 🌟 Star this repository
- 📢 Sharing it with others
- 🛠️ Contribute by reporting issues or suggesting features
- ☕ [Buy me a coffee](https://buymeacoffee.com/abdulbaset)
- ❤️ Become a sponsor on [GitHub Sponsors](https://github.com/sponsors/AbdulbasetRS)
- 💵 Make a one-time donation via [PayPal](https://paypal.me/abdulbasetrs)

Your support means a lot to me! Thank you for making this possible. 🙏
