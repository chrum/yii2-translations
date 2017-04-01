Translations module for yii2
==========
Create and edit translations and access them as json

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
    'aliases' => [
        '@chrum' => '@vendor/chrum',
    ],
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
            ],
            // OPTIONAL
            // To restrict access
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
* In order to have [CodeMirror](http://codemirror.net/) instead of raw textarea as translations editor
..* install this yii2 [extension](https://github.com/borodulin/yii2-codemirror)
..* Tweak config file:
~~~php
return [
    ......
    'modules' => [
        'translations' => [
            ...
                'codeMirror' => [
                    'presetsDir' => '@vendor/chrum/yii2-translations/components/codeMirrorPresets',
                    'preset' => 'html'
                ],
            ...
        ],
    ],
]
~~~


* Apply migrations

    './yii migrate --migrationPath=@vendor/chrum/yii2-translations/migrations'
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

# How to use
* To edit your language strings go to
    /translations
* Endpoint for your app to read language strings:
    /translation/{language code}
for example (mainly through api):
    /translation/en
but mainly through api
    
    
