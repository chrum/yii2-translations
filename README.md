[Work in progress, do not use]
Translations module for yii2
==========

some description, to be written...

# Requirements
- yii2

# Installation
* Update composer.json

~~~json

...

    "repositories": [
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

* Update the project by running 'composer update'

* Enable the module in the config/main.php file adjusting 'class' to your needs:

~~~php

return [
    ......
    'modules' => [
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
    ],
]

~~~

* Apply migrations

    './yii migrate --migrationPath=vendor/chrum/yii2-translations/migrations'
* Use gii to generate 'Translation' model for table {{'%translations'}}
* Add Translation model class to config

~~~php
return [
    ......
    'modules' => [
        'translations' => [
            ...
            'translationsModelClass' => 'common\models\Translation',
            ...
        ],
    ],
]
~~~

* (OPTIONAL but good) In order to restrict access to this module, add to module configuration:
  
~~~php
return [
  ...
  'modules' => [
      'translations' => [
            ...
          'as access' => [
              'class' => 'yii\filters\AccessControl',
              'rules' => [
                  [
                      'allow' => true,
                      'roles' => ['@'],
                  ]
              ]
          ],
      ],
  ],
]
~~~