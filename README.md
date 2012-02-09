# gc-qrcode

Wrapper class for generating QR codes via the Google Charts API.

## Installation

Available via the Sparks package management system for CodeIgniter.  For info about how to install sparks, go to http://getsparks.org/install.

You can load the spark using:

    $this->load->spark('gc-qrcode/[version #]/');

## Usage

### Configuring your code

The following methods are provided for configuring your QR code.  Only size is required to generate a code.

    $this->gc_qrcode->size(350)
                    ->data('http://example.com/')
                    ->output_encoding('UTF-8')
                    ->error_correction_level('L')
                    ->margin(0);

#### Output encodings

The valid output encodings are `UTF-8`, `Shift_JIS`, and `ISO-8859-1`.

#### Error correction levels

The valid error correction levels are `L`, `M`, `Q`, `H`.

### Generating your code

Generate the URL for your QR code:

    $url = $this->gc_qrcode->url();

Generate an &lt;img&gt; tag containg your QR code:

    $img = $this->gc_qrcode->img();

By default, the image tag will contain the `src`, `width`, and `height` attributes.

You can optionally pass an array of attributes as the first parameter:

    $img = $this->gc_qrcode->img(array('class' => 'qr-code'));

You can also specify whether or not you want the &lt;img&gt; tag to be self-closing.  This is also optional.

    $this->gc_qrcode->img(array(), TRUE); // Self-closing
    
    $this->gc_qrcode->img(array(), FALSE); // Non self-closing

### Reseting the class

Use clear() to initialize the class to an empty state.

    $this->gc_qrcode->clear();
