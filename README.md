# SharedCount for Craft3

Fred Carlsen's [SharedCount plugin](https://superbig.co/plugins/sharedcount) ported to Craft 3.

## Requirements
This plugin requires Craft CMS 3.0.0-RC1 or later.

## Install

- Install with Composer via: ``composer require balazscsaba2006/sharedcount``
- Navigate to `Settings -> Plugins` and click the "Install" button

## Configure
- Navigate to `Settings -> Plugins` and configure settings for SharedCount

### Overriding plugin settings

If you create a [config file](https://craftcms.com/docs/config-settings) in your `config/` folder called `sharedcount.php`, you can override
the plugin’s settings in the Control Panel. Since that config file is fully [multi-environment](https://craftcms.com/docs/multi-environment-configs) aware, this is
a handy way to have different settings across multiple environments.

Here’s what that config file might look like along with a list of all of the possible values you can override.

```php
<?php

return [
    'apiKey' => 'My40CharacterLongApiKey',
];
```

## Supported services
- Facebook
- Twitter
- Pinterest
- LinkedIn
- StumbleUpon
- Google+
 
## Usage
```twig
{% set stats = craft.sharedcount.likes({
    url: 'https://www.humandirect.eu/jobs/cluj-napoca/2018-06/full-stack-mobile-app-developer-ios-android'
}) %}

<ul>
{% for service,count in stats %}
    {% if count is iterable %}
        <li>{{ service }}
        <ul>

        {% for key,value in count %}
            <li>{{ key }}: {{ value }}</li>
        {% endfor %}
        </ul>
        </li>
    {% else %}
        <li>{{ service }}: {{ count ? count : 0 }}</li>
    {% endif %}
{% endfor %}
</ul>
```