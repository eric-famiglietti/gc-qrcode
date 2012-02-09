<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * GC QR Code
 *
 * Wrapper class for generating a QR code using the Google Charts API.
 *
 * @author Eric Famiglietti <eric.famiglietti@gmail.com>
 * @link   http://ericfamiglietti.com/
 */
class Gc_qrcode {

    // The size in pixels of the QR code
    private $_size = null;

    private $_data = null;

    private $_output_encoding = null;

    private $_error_correction_level = null;

    private $_margin = null;

    // The minimum size in pixels that is allowed by the API
    const MINIMUM_SIZE = 100;

    // The maximum size in pixels that is allowed by the API
    const MAXIMUM_SIZE = 545;

    // The output encodings that are accepted by the API
    private static $_valid_output_encodings = array('UTF-8', 'Shift_JIS', 'ISO-8859-1');

    // The error correction levels that are accepted by the API
    private static $_valid_error_correction_levels = array('L', 'M', 'Q', 'H');

    public function __construct()
    {
        log_message('debug', "Gc_qrcode class initialized.");
    }

    /**
     * Set size
     *
     * @access public
     * @param  int
     * @return void
     */
    public function size($size)
    {
        if (!ctype_digit((string) $size)) {
            log_message('error', 'GC_QRCode: Size must be of type integer.');
        } elseif (((int) $size < self::MINIMUM_SIZE) || ((int) $size > self::MAXIMUM_SIZE)) {
            log_message('error', 'GC_QRCode: Size must be between ' . self::MINIMUM_SIZE . ' and ' . self::MAXIMUM_SIZE . '.');
        }

        $this->_size = (int) $size;

        return $this;
    }

    /**
     * Set data
     *
     * @access public
     * @param  string
     * @return void
     */
    public function data($data)
    {
        $this->_data = (string) $data;

        return $this;
    }

    /**
     * Set output encoding
     *
     * @access public
     * @param  string
     * @return void
     */
    public function output_encoding($output_encoding)
    {
        if (!in_array($output_encoding, self::$_valid_output_encodings)) {
            log_message('error', 'GC_QRCode: Output encoding must be a valid value.');
        }

        $this->_output_encoding = (string) $output_encoding;

        return $this;
    }

    /**
     * Set error correction level
     *
     * @access public
     * @param  string
     * @return void
     */
    public function error_correction_level($error_correction_level)
    {
        if (!in_array($error_correction_level, self::$_valid_error_correction_levels)) {
            log_message('error', 'GC_QRCode: Error correction level must be a valid value.');
        }

        $this->_error_correction_level = (string) $error_correction_level;

        return $this;
    }

    /**
     * Set margin
     *
     * @access public
     * @param  int
     * @return void
     */
    public function margin($margin)
    {
        if (!ctype_digit((string) $margin)) {
            log_message('error', 'GC_QRCode: Margin must be of type integer.');
        }

        $this->_margin = (int) $margin;

        return $this;
    }

    /**
     * Generate QR code
     * 
     * Returns a URL to a QR code.
     *
     * @access public
     * @return string
     */
    public function url()
    {
        $url = config_item('google_charts_base_url') . '?cht=qr';

        $url .= '&chs=' . $this->_size . 'x' . $this->_size;
        $url .= '&chl=' . $this->_data;

        if (null !== ($output_encoding = $this->_output_encoding)) {
            $url .= '&choe=' . $output_encoding;
        }

        // max() is used to execute both clauses so both variables get assigned
        if (max(null !== ($error_correction_level = $this->_error_correction_level),
                null !== ($margin = $this->_margin)))
        {
            $url .= '&chld=';

            if (null !== $error_correction_level) {
                $url .= $error_correction_level;
            }

            if (null !== $margin) {
                $url .= '|' . $margin;
            }
        }

        return (string) $url;
    }

    /**
     * Generate <img> tag
     *
     * Returns an <img> tag containing the QR code.
     *
     * @access public
     * @param array
     * @param bool
     * @return string
     */
    public function img($attributes = array(), $self_closing = TRUE)
    {
        $attributes_string = '';
        if (count($attributes) > 0) {
            foreach ($attributes as $key => $value) {
                $attributes_string .= " {$key}=\"{$value}\"";
            }
        }

        $img = "<img src=\"{$this->url()}\" width=\"{$this->_size}\" height=\"{$this->_size}\"{$attributes_string}";

        if ($self_closing) {
            $img .= " /";
        }
        $img .= ">";

        return $img;
    }

    /**
     * Clear QR code
     *
     * Initializes all QR code variables to an empty state
     *
     * @access public
     * @return void
     */
    public function clear()
    {
        $this->_size = null;
        $this->_data = null;
        $this->_output_encoding = null;
        $this->_error_correction_level = null;
        $this->_margin = null;

        return $this;
    }

}
