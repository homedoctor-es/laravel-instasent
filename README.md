Instasent SDK integration for Laravel
===================================
Laravel integration for the Instasent SDK including a notification channel.

## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

With Composer installed, you can then install the extension using the following commands:

```bash
$ php composer.phar require homedoctor-es/laravel-instasent
```

or add 

```json
...
    "require": {
        "homedoctor-es/laravel-instasent": "*"
    }
```

to the ```require``` section of your `composer.json` file.

## Configuration

1. Register the ServiceProvider in your config/app.php service provider list.

config/app.php
```php
return [
    //other stuff
    'providers' => [
        //other stuff
        \HomedoctorEs\Laravel\Instasent\InstasentServiceProvider::class,
    ];
];
```

2. If you want, you can add the following facade to the $aliases section.

config/app.php
```php
return [
    //other stuff
    'aliases' => [
        //other stuff
        'Instasent' => \HomedoctorEs\Laravel\Instasent\Facades\Instasent::class,
    ];
];
```

3. Publish the package configuration file.

```bash
$ php artisan vendor:publish --provider='HomedoctorEs\Laravel\Instasent\InstasentServiceProvider'
```

4. Set the api_token in the config/instasent.php file or use the predefined env 
variables.

config/services.php
```php
return [
    'api_token' => '', // your account api token
    'default_from' => 'Laravel', // optional name of the sender
    'dry_run' => false, // only for the notification channel, if true, no sms's will be sent
    'throw_exception_on_error' => true // This will throw up the Instasent sdk exception if an exception is thrown by the dispatchService on the InstasentSmsChannel
];
```
or 
.env
```
//other configurations
INSTASENT_API_TOKEN=<YOUR_API_TOKEN>
```

## Usage

You can use the facade alias Instasent to execute services of the instasent sdk. The 
authentication params will be automaticaly injected.

```php
Instasent::clientSms()->sendSms(
    $sender
    , $phone
    , $text
);
```

You can see a full list of the instasent sdk services in [this page](https://docs.instasent.com/1.0/sdks/php-sdk).

## Notification Channel

A notification channel is included in this package and allows you to integrate 
the Instasent service with the Laravel notifications.

### Formatting Notifications

If a notification supports being sent as an SMS through Instasent, you should 
define a toInstasent method on the notification class. This method will receive a 
$notifiable entity and should return a HomedoctorEs\Laravel\Instasent\Notifications\Messages\InstasentMessage 
instance or a string containing the message to send:

```php
/**
 * Get the Instasent / SMS representation of the notification.
 *
 * @param  mixed  $notifiable
 * @return \HomedoctorEs\Laravel\Instasent\Notifications\Messages\InstasentMessage|string
 */
public function toInstasent($notifiable)
{
    return (new InstasentMessage)
                ->content('Your SMS message content');
}
```

Once done, you must add the notification channel in the array of the via() method 
of the notification:

```php
/**
 * Get the notification channels.
 *
 * @param  mixed  $notifiable
 * @return array|string
 */
public function via($notifiable)
{
    return [InstasentSmsChannel::class];
}
```

### Customizing The Name of the Sender

If you would like to send some notifications with a sender name that is 
different from the one specified in your config/services.php file, you may use 
the from method on a InstasentMessage instance:

```php
/**
 * Get the Instasent / SMS representation of the notification.
 *
 * @param  mixed  $notifiable
 * @return \HomedoctorEs\Laravel\Instasent\Notifications\Messages\InstasentMessage|string
 */
public function toInstasent($notifiable)
{
    return (new InstasentMessage)
                ->content('Your SMS message content')
                ->from('Popilio');
}
```

### Routing the Notifications

When sending notifications via the instasent channel, the notification system will 
automatically look for a phone_number attribute on the notifiable entity. If 
you would like to customize the phone number the notification is delivered to, 
define a routeNotificationForInstasent method on the entity:

```php
<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * Route notifications for the Instasent channel.
     *
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return string
     */
    public function routeNotificationForInstasent($notification)
    {
        return $this->phone;
    }
}
```

You can find more info about Laravel notifications in [this page](https://laravel.com/docs/5.8/notifications).

## License 

Copyright &copy; 2022 Homedoctor Smart Medicine S.L. <pepe@homedoctor.es>.

Licensed under the BSD 3-Clause License. See LICENSE.txt for details.
