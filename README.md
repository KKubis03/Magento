# Magento 2 Practice Modules

A collection of custom Magento 2 modules demonstrating various framework features, patterns, and best practices.

## Modules

### CartCategorySuggestion
Observes the add-to-cart event and displays a promotional success message when a product with a special price is added to the cart, encouraging customers to browse other deals.

### CategoryNameFormatter
Uses a Magento preference to override the Category model and prepend a `"Category: "` prefix to all category names.

### CustomACL
Demonstrates how to create custom Access Control List (ACL) resources for admin pages, including a protected admin controller and a block that checks ACL permissions before rendering content.

### Greetings
Adds a custom CLI console command (`greetings:nameinfo`) that accepts a name parameter, greets the user, and dispatches a custom event via the event/observer system.

### Grid
Creates a custom admin UI grid for listing categories, featuring a custom data provider, an actions column with per-row links, and a mass-delete action.

### GridExtension
Extends the native Magento admin product grid by adding a custom mass action that reports the count of selected products.

### LastViewedProduct
Tracks the last product a customer viewed (stored in session) and displays it on subsequent pages using a frontend block with full-page cache support.

### LogCleaner
Provides a scheduled cron job that automatically clears the `var/log/system.log` file to prevent unbounded log growth.

### LoggerDemo
Demonstrates how to create a custom logger with a dedicated log file (`var/log/demo.log`) using a custom `Handler` and `Logger` class, with an example controller.

### MyConfiguration
Shows how to read custom store configuration values using `ScopeConfigInterface` inside a block, suitable as a reference for adding admin-configurable settings.

### OrderMessageQueue
Implements the Magento message queue pattern for asynchronous order processing: an observer publishes new orders to a queue, and a consumer processes them independently.

### PreferencesExamples
A reference module demonstrating all three Magento plugin interception types (before, after, around) as well as DI preferences, helpers, blocks, and resource model usage.

### ProductInfoGraphql
Adds a custom GraphQL query that accepts a product SKU and returns the product's name, price, and status.

### ProductNamePrefix
Demonstrates all three plugin types (before, after, around) applied to the Product model's `getName()` method, appending or transforming product names.

### ProductNote
Provides a complete product-note feature: a custom database table (via a schema patch), a repository with CRUD interface, REST API exposure, and GraphQL resolvers for querying and mutating notes by SKU.

### ProductPageBestsellers
Adds a ViewModel to the product detail page that queries for the top best-selling products in the same categories as the currently viewed product, displayed as a related-products section.

### ProductPagePriceNote
Injects a small promotional text block ("Always Top Quality") beneath the product price on the frontend product detail page using a layout XML update and a `.phtml` template.

### ProductSlider
Implements a configurable CMS widget (`ProductSlider`) that renders a slider of products from a chosen category, with pricing and image support, backed by a `ProductProviderInterface` contract.

### TaskMigrations
Demonstrates the Magento 2 declarative schema patch approach: includes schema patches to create and alter a custom table, and data patches to seed initial and additional rows.

## Requirements

- Magento 2.4.x
- PHP 8.1+
- Composer

## Installation

Each module follows the standard Magento 2 module structure. To install a module manually:

1. Copy the desired module directory into `app/code/<Vendor>/<Module>/`.
2. Enable the module:
   ```bash
   bin/magento module:enable <Vendor>_<Module>
   bin/magento setup:upgrade
   bin/magento cache:flush
   ```

## License

This project is intended for educational and practice purposes.
