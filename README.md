# A simple PHP library for handling Emoji

An emoji encoder/parser for Laravel 5. This will encode and decode html to unified and vice versa. In order to handle emojies in database where you care about light weight things, performance and don't want to use blob data type.

## Installation

[PHP](https://php.net) 5.5+

To get the latest version of rvish Emoji, simply require the project using [Composer](https://getcomposer.org):

```bash
$ composer require rvish/emoji
```

Instead, you may of course manually update your require block and run `composer update` if you so choose:

```json
{
    "require": {
        "rvish/emoji": "*"
    }
}
```

Once rvish Emoji is installed, you need to register the service provider. 
Open up `config/app.php` and <br>
1. add the `Rvish\Emoji\EmojiServiceProvider::class` to the `providers` <br>
2. add the `'Emoji' => Rvish\Emoji\Facades\Emoji::class` to the `aliases`.<br>

## Usage

For encoding to Bytes (UTF-8)
```php
Emoji::encode("Test1 Test2 💡 Test3"); // encoding to Bytes (UTF-8)
```
For decoding to Native
```php
Emoji::decode("Test1 Test2 \xf0\x9f\x92\xa1 Test3"); // decoding to Native
```

## Contributing

We welcome contributions! If you would like to hack on Emoji, please
follow these steps:

1. Fork this repository
2. Make your changes
3. Install the requirements
4. Submit a pull request after running `make check` (ensure it does not error!)

Please give us adequate time to review your submission. Thanks!

## License

Rvish Emoji is licensed under [The MIT License (MIT)](LICENSE).
