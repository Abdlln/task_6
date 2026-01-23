<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

$arComponentParameters = [
    'PARAMETERS' => [
        'IBLOCK_TYPE' => [
            'PARENT' => 'BASE',
            'NAME' => 'Тип инфоблока',
            'TYPE' => 'STRING',
            'DEFAULT' => 'news',
        ],
        'IBLOCK_ID' => [
            'PARENT' => 'BASE',
            'NAME' => 'ID инфоблока (опционально)',
            'TYPE' => 'STRING',
            'DEFAULT' => '',
        ],
        'FILTER_ACTIVE' => [
            'PARENT' => 'ADDITIONAL',
            'NAME' => 'Только активные элементы',
            'TYPE' => 'CHECKBOX',
            'DEFAULT' => 'Y',
        ],
        'FILTER_NAME' => [
            'PARENT' => 'ADDITIONAL',
            'NAME' => 'Фильтр по содержанию',
            'TYPE' => 'STRING',
            'DEFAULT' => '',
        ],
        'FILTER_DATE_FROM' => [
            'PARENT' => 'ADDITIONAL',
            'NAME' => 'Дата создания от (Год-Месяц-Дата)',
            'TYPE' => 'STRING',
            'DEFAULT' => '',
        ],
        'FILTER_DATE_TO' => [
            'PARENT' => 'ADDITIONAL',
            'NAME' => 'Дата создания до (Год-Месяц-Дата)',
            'TYPE' => 'STRING',
            'DEFAULT' => '',
        ],
    ],
];