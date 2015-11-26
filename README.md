[Work in progress, do not use]
Translations module for yii2
==========

some description, to be written...

# Requirements
- yii2

# Installation
Update composer.json
~~~json
...
    "repositories":[
        {
            "type": "vcs",
            "url": "https://github.com/chrum/yii2-translations"
        }
    ],

...

    "require-dev": {
            "chrum/yii2-translations": "*@dev",
        },
...
~~~
Update the project by running 'composer update'

Enable the module in the config/main.php file adjusting 'class' to your needs:
~~~php
return array(
    ......
    'modules'=>array(
        'translations' => [
            'class' => 'chrum\yii2\translations\Module',
            "defaultLang" => "dk",
            "langs" => [
                "dk" => "Danish",
                "se" => "Swedish",
                "no" => "Norwegian",
                "fi" => "Finnish"
            ]
        ],
    ),
)
~~~

* Apply migrations
'./yii migrate --migrationPath=vendor/chrum/yii2-translations/migrations'
* Use gii to generate 'Translation' model for table {'%translations'}
