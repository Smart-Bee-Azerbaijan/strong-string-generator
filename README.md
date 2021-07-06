# ::lock_with_ink_pen:: Strong String Generator

Strong String Generator from Smartbee. Easy to use and can be used for strong passwords.

## Usage

```php

  $password = new StrongStringGenerator();
  echo $password->CreateStrongString();

  // Sample Output should be like cg^U*t{BD^6xzUgk+|YV@iPkh4

```

## Default Variables

Class uses min-lenght as ```26``` charachters and uses alphabet set as ```ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789?#$!@`.~^&*-_+={}[]|()%```. You can set max-lenght and character set when you call class. As Example

```php

  $password = new StrongStringGenerator(13,"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz");
  echo $password->CreateStrongString();

  // Sample Output should be like BrQSBFSPBcBcB

```

This class brought you by ![Smartbee](https://smartbee.az/images/logo-main.svg)
