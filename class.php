<?php

namespace Custom\NewsListMulti;

use Bitrix\Main\Loader;
use Bitrix\Iblock\IblockTable;
use Bitrix\Iblock\ElementTable;
use Bitrix\Main\ArgumentException;

class Component
{
    private $arParams;
    private $parentComponent;

    public function __construct($component)
    {
        $this->parentComponent = $component;
        $this->arParams = $component->arParams;
    }

    public function executeComponent(): array
    {
        try {
            $this->validateParameters();
            $iblockIds = $this->getIblockIds();
            $filter = $this->buildFilter($iblockIds);
            $elements = $this->fetchElements($filter);
            $arResult = $this->groupElementsByIblock($elements);

            return $arResult;
        } catch (\Exception $e) {
            $this->parentComponent->abortResultCache();
            ShowError($e->getMessage());

            return [];
        }
    }

    private function validateParameters(): void
    {
        if (empty($this->arParams['IBLOCK_TYPE'])) {
            throw new ArgumentException('отсутствует IBLOCK_TYPE');
        }
    }

    private function getIblockIds(): array
    {
        Loader::includeModule('iblock');

        $query = IblockTable::query()
            ->setSelect(['ID'])
            ->where('IBLOCK_TYPE_ID', $this->arParams['IBLOCK_TYPE']);

        if (!empty($this->arParams['IBLOCK_ID'])) {
            $query->where('ID', (int)$this->arParams['IBLOCK_ID']);
        }

        $iblocks = $query->fetchAll();

        if (empty($iblocks)) {
            throw new ArgumentException("нет инфоблоков типа {$this->arParams['IBLOCK_TYPE']}");
        }

        return array_column($iblocks, 'ID');
    }

    private function buildFilter(array $iblockIds): array
    {
        $filter = ['IBLOCK_ID' => $iblockIds];

        if ($this->arParams['FILTER_ACTIVE'] === 'Y') {
            $filter['ACTIVE'] = 'Y';
        }

        if (!empty($this->arParams['FILTER_NAME']) && $this->arParams['FILTER_NAME'] !== '') {
            $filter['%NAME'] = $this->arParams['FILTER_NAME'];
        }

        if (!empty($this->arParams['FILTER_DATE_FROM']) && $this->arParams['FILTER_DATE_FROM'] !== '') {
            $filter['>=DATE_CREATE'] = $this->arParams['FILTER_DATE_FROM'];
        }

        if (!empty($this->arParams['FILTER_DATE_TO']) && $this->arParams['FILTER_DATE_TO'] !== '') {
            $filter['<=DATE_CREATE'] = $this->arParams['FILTER_DATE_TO'];
        }

        return $filter;
    }

    private function fetchElements(array $filter): array
    {
        $elements = ElementTable::getList([
            'select' => [
                'ID',
                'IBLOCK_ID',
                'NAME',
                'ACTIVE',
                'DATE_CREATE',
                'PREVIEW_TEXT',
                'PREVIEW_PICTURE',
            ],
            'filter' => $filter,
            'order' => ['DATE_CREATE' => 'DESC'],
            'limit' => 100,
        ])->fetchAll();

        return $elements;
    }

    private function groupElementsByIblock(array $elements): array
    {
        $grouped = [];
        foreach ($elements as $el) {
            $iblockId = $el['IBLOCK_ID'];
            if (!isset($grouped[$iblockId])) {
                $grouped[$iblockId] = [];
            }
            $grouped[$iblockId][] = $el;
        }

        return ['ITEMS' => $grouped];
    }
}