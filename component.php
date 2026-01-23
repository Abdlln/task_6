<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Custom\NewsListMulti\Component;

$component = new Component($this);
$this->arResult = $component->executeComponent();

$this->IncludeComponentTemplate();