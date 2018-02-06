<?php
namespace chrum\yii2\translations\models;

use chrum\yii2\translations\helpers\langHelper;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Translation;

/**
 * SearchTranslations represents the model behind the search form of `common\models\Translation`.
 */
class SearchTranslation extends Translation
{
    public $toggleLang = null;
    public $string_id = null;
    public $searchString = null;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['string_id', 'toggleLang', 'searchString'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }


    public function search($params)
    {
        $this->load($params, '');

        $class = \Yii::$app->getModule('translations')->translationsModelClass;

        /* @var $class \yii\db\ActiveRecord */
        $query = $class::find()
            ->orderBy("string_id ASC");

        // add conditions that should always apply here

        $availableLangs = array_keys(langHelper::getLangs());
        if (in_array($this->toggleLang, $availableLangs)) {
            $displayedLangs = \Yii::$app->session->get('yii2translations_displayedLangs', []);
            if (in_array($this->toggleLang, $displayedLangs)) {
                $displayedLangs = array_diff($displayedLangs, [$this->toggleLang]);
                if (count($displayedLangs) === 0) {
                    $displayedLangs[] = langHelper::getDefaultLangCode();
                }

            } else {
                $displayedLangs[] = $this->toggleLang;
            }

            \Yii::$app->session->set('yii2translations_displayedLangs', $displayedLangs);
        }

        $currentNamespace = TranslationNamespace::getCurrent();
        if ($currentNamespace !== null) {
            $query->where(['like', 'string_id', $currentNamespace . '%', false]);
        };

        if ($this->searchString) {
            foreach($availableLangs as $lang) {
                $query->orFilterWhere(['like', $lang, $this->searchString]);
            }
        }

        return $query;
    }
}
