# Currently Reading Widget for Craft CMS

A Craft CMS plugin that displays your currently reading books in a beautiful slider widget. Supports multiple book data sources including OpenLibrary.

## Features

- Beautiful slider interface for displaying books
- Multiple data source support (OpenLibrary, Mock API)
- Customizable templates
- Responsive design
- Easy to extend with custom book APIs

## Installation

1. Open your terminal and go to your Craft project:

```bash
cd /path/to/project
```

2. Then tell Composer to load the plugin:

```bash
composer require jaymeh/craft-currently-reading-widget
```

3. In the Control Panel, go to Settings → Plugins and click the "Install" button for Currently Reading Widget.

## Configuration

1. Go to Settings → Plugins → Currently Reading Widget
2. Select your preferred book data source (OpenLibrary or Mock API)
3. Configure any additional settings specific to your chosen data source

## Customization

### Overriding Templates

You can override the default templates by creating your own versions in your Craft project:

1. Create a directory in your project:
```
templates/currently-reading/
```

2. Copy the template files from the plugin's `templates/currently-reading/` directory to your project's directory.

3. Modify the templates as needed. Available templates:
- `slider.twig` - Renders books in a slider template

### Customizing Styles

The plugin's styles can be customized in two ways:

1. **Override the CSS file:**
   Create your own CSS file in your project and override the plugin's classes:
   ```css
   .currently-reading-widget__slider {
       /* Your custom styles */
   }
   ```

2. **Add custom classes:**
   The plugin's templates use BEM-style class names that you can extend or override in your own CSS.

### Extending with Custom APIs

You can add your own book data source by:

1. Creating a new class that implements `BookServiceInterface`
2. Registering your API in the `RegisterBookApiEvent` event:

```php
use jaymeh\craftcurrentlyreadingwidget\events\RegisterBookApiEvent;

Event::on(
    BookApiService::class,
    RegisterBookApiEvent::class,
    function(RegisterBookApiEvent $event) {
        $event->apis['myapi'] = MyCustomApi::class;
    }
);
```

### Available Template Variables

In the slider template, you have access to the following variables:

- `books` - Array of book objects with properties:
  - `title` - Book title
  - `author` - Book author
  - `coverImageUrl` - URL to book cover image

## Support

For support, please open an issue in the GitHub repository or contact the plugin author.

## License

This plugin is licensed under the MIT License.
