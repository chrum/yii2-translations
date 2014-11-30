Translations module
==========

some description, to be written...

# Requirements

# Installation

Copy the module files to location of your choice

Enable the module in the config/main.php file adjusting 'class' to your needs:
~~~php
return array(
    ......
    'modules'=>array(
        'translations' => [
            'class' => 'common.lib.yii-translations.TranslationsModule',
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
'php yii migrate --migrationPath=common/modules/yii2-translations/migrations'
* Use gii to generate 'Translations' model
