<?php

/**
 * Wrapper Widget to use jQuery Multiple Select in Yii application.
 *
 * @author Tonin R. Bolzan <tonin@bolzan.io>
 * @copyright Copyright &copy; 2014 bolzan.io
 * @package extensions
 * @subpackage MultipleSelect
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 * @version 1.1.0 rev.1
 *
 * @see http://wenzhixin.net.cn/p/multiple-select/ jQuery Multiple Select
 */
class MultipleSelect extends CInputWidget
{
    /** @var string Path to assets directory published in init() */
    private $assetsDir;

    /** @var array Settings passed to $.fn.multipleSelect() */
    private $settings = array();

    /** @var bool Multiple or single item should be selected */
    public $multiple = true;

    /** @var bool Use filter */
    public $filter = true;

    /** @var array See CHtml::listData() */
    public $data;

    /** Publish assets and set default values for properties */
    public function init()
    {
        $this->assetsDir = Yii::app()->assetManager->publish(__DIR__ . '/assets');

        $this->htmlOptions['multiple'] = $this->multiple;

        $this->settings = array('single' => !$this->multiple, 'filter' => $this->filter);

        if (isset($this->htmlOptions['placeholder'])) {
            $this->settings = CMap::mergeArray($this->settings, array('placeholder' => $this->htmlOptions['placeholder']));
            unset($this->htmlOptions['placeholder']);
        }

        if (isset($this->htmlOptions['multiSelectOptions'])) {
            $this->settings = CMap::mergeArray($this->settings, $this->htmlOptions['multiSelectOptions']);
            unset($this->htmlOptions['multiSelectOptions']);
        }

        parent::init();
    }

    /** Render widget html and register client scripts */
    public function run()
    {
        list($name, $id) = $this->resolveNameID();

        if (isset($this->htmlOptions['id'])) {
            $id = $this->htmlOptions['id'];
        } else {
            $this->htmlOptions['id'] = $id;
        }

        if (isset($this->htmlOptions['name'])) {
            $name = $this->htmlOptions['name'];
        }

        if (isset($this->model)) {
            echo CHtml::dropDownList($name, $this->model->{$this->attribute}, $this->data, $this->htmlOptions);
        } else {
            echo CHtml::dropDownList($name, $this->value, $this->data, $this->htmlOptions);
        }

        $this->registerScripts($id);
    }

    /** Register client scripts */
    private function registerScripts($id)
    {
        $min = YII_DEBUG ? '' : '.min';
        $lang = Yii::app()->language;

        $cs = Yii::app()->clientScript;
        $cs->registerCoreScript('jquery');
        $cs->registerCssFile($this->assetsDir . '/multiple-select' . $min . '.css');
        $cs->registerScriptFile($this->assetsDir . '/jquery.multiple.select' . $min . '.js');

        if ($lang != 'en') {
            $cs->registerScriptFile($this->assetsDir . '/i18n/jquery.multiple.select.' . $lang . $min . '.js');
        }

        $settings = CJavaScript::encode($this->settings) ? : '';

        $cs->registerScript("{$id}_multipleSelect", "jQuery('#{$id}').multipleSelect({$settings});");
    }

    /** Single item select */
    public static function dropDownList($name, $select, $data, $htmlOptions = array())
    {
        return Yii::app()->getController()->widget(__CLASS__, array(
            'name' => $name,
            'value' => $select,
            'data' => $data,
            'htmlOptions' => $htmlOptions,
            'multiple' => false,
        ), true);
    }

    public static function activeDropDownList($model, $attribute, $data, $htmlOptions = array())
    {
        return self::dropDownList(CHtml::activeName($model, $attribute), CHtml::value($model, $attribute), $data, $htmlOptions);
    }

    /** Multiple items select */
    public static function multiSelect($name, $select, $data, $htmlOptions = array())
    {
        return Yii::app()->getController()->widget(__CLASS__, array(
            'name' => $name,
            'value' => $select,
            'data' => $data,
            'htmlOptions' => $htmlOptions,
            'multiple' => true,
        ), true);
    }

    public static function activeMultiSelect($model, $attribute, $data, $htmlOptions = array())
    {
        return self::multiSelect(CHtml::activeName($model, $attribute) . '[]', CHtml::value($model, $attribute), $data, $htmlOptions);
    }

}
