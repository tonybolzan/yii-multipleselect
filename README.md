# jQuery Multiple Select for Yii

Wrapper Widget to use jQuery Multiple Select in Yii application.

MultiSelect script:
http://wenzhixin.net.cn/p/multiple-select/

## Installation
Download or clone this repository and paste in `/protected/extensions/MultipleSelect`

## Usage
In your source code
```php
Yii::import('ext.MultipleSelect.MultipleSelect');
```
Or in config
```php
    ...
    'import' => array(
        ...
        'ext.MultipleSelect.MultipleSelect',
        ...
    ),
    ...
```

## Example:
You can replace the <br>
`CHtml::dropDownList()` by `MultipleSelect::dropDownList()` <br>
`CHtml::activeDropDownList()` by `MultipleSelect::activeDropDownList()` <br>
or
```php
    ...
    echo MultipleSelect::multiSelect("test", null, array('test1','test2'), array(
        'required' => 'required',
        'placeholder' => 'This is a placeholder',
        'multiSelectOptions' => array(
            'filter' => false,
        ),
    ));
    ...
    echo MultipleSelect::activeMultiSelect($model, "attr", array('test1','test2'), array(
        'placeholder' => 'This is a placeholder',
    ));
    ...
```
Or this

```php
    ...
    $this->widget('MultipleSelect', array(
       'name' => 'inputName',
       'value' => 2,
       'data' => array(
           1 => 'Option 1',
           2 => 'Option 2',
           3 => 'Option 3',
           4 => 'Option 4',
        ),
    ));
    ...
```
