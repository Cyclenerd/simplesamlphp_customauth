# SimpleSAMLphp Custom Username/Password Authentication Modules

In this repository you find my custom username/password authentication sources for [simpleSAMLphp](https://simplesamlphp.org/).
An authentication source is responsible for authenticating the user, typically by getting a username and password, and looking it up in some sort of database.

## Setup

### Create

First we need to copy the module directory:

```
cd modules
git clone https://github.com/Cyclenerd/simplesamlphp_customauth
```
Now that we have our own module, we can move on to creating an authentication source.


### Configuring

Before we can test our authentication source, we must add an entry for it in `config/authsources.php`.
`config/authsources.php` contains an list of enabled authentication sources.

The entry looks like this:

```
'velohero' => array(
    'velohero:VeloHero',
),
```

You can add it to the beginning of the list, so that the file looks something like this:

```
<?php
$config = array(
    'velohero' => array(
        'velohero:VeloHero',
     ),
    /* Other authentication sources follow. */
);
```

## More Info

More help and details can be found in the help of simpleSAMLphp:
https://simplesamlphp.org/docs/1.11/simplesamlphp-customauth