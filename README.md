# gc-qrcode

Wrapper class for generating QR codes via the Google Charts API.

## Installation

Available via the Sparks package management system for CodeIgniter.  For info about how to install sparks, go to http://getsparks.org/install.

You can load the spark with this:

```php
$this->load->spark('gc-qrcode/[version #]/');
```

## Usage

```php
// Only size is required
$this->gc_qrcode->size(350)
                ->data("http://example.com/")
                ->output_encoding('UTF-8')
                ->error_correction_level('L')
                ->margin(0);

// Generate URL to QR code
$url = $this->gc_qrcode->url();

// Generate <img> tag pointing to QR code
$img = $this->gc_qrcode->img();

// You can also pass an array of attributes
$img = $this->gc_qrcode->img(array('class' => 'qr-code'));

// Initialize the code to an empty state
$this->gc_qrcode->clear();
```
