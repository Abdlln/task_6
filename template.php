<?php

if (!empty($arResult['ITEMS'])):
    foreach ($arResult['ITEMS'] as $iblockId => $items):
        ?>
        <h3>Инфоблок ID: <?= htmlspecialchars($iblockId) ?></h3>
        <ul>
            <?php foreach ($items as $item): ?>
                <li>
                    <div class="news-item__title"><?= htmlspecialchars($item['NAME']) ?></div>
                    <?php if (!empty($item['PREVIEW_TEXT'])): ?>
                        <div class="news-item__preview-text"><?= nl2br(htmlspecialchars($item['PREVIEW_TEXT'])) ?></div>
                    <?php endif; ?>
                    <?php if (!empty($item['PREVIEW_PICTURE'])):
                        $file = \CFile::GetFileArray($item['PREVIEW_PICTURE']);
                        if ($file): ?>
                            <img src="<?= htmlspecialchars($file['SRC']) ?>" alt="" class="news-item__image">
                        <?php endif; ?>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endforeach;
else:
    ?>
    <p>Нет элементов для отображения.</p>
<?php endif;