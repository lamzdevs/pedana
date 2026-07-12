<?php $pager->setSurroundCount(2) ?>

<div class="pagination-container" id="paginationControls">
    <?php if ($pager->hasPreviousPage()) : ?>
        <a href="<?= $pager->getPreviousPage() ?>" class="pagination-arrow" id="prevPage" aria-label="Previous">
            <span aria-hidden="true">&lt;</span>
        </a>
    <?php else: ?>
        <a href="#" class="pagination-arrow disabled" aria-label="Previous" onclick="event.preventDefault();">
            <span aria-hidden="true">&lt;</span>
        </a>
    <?php endif ?>

    <?php foreach ($pager->links() as $link) : ?>
        <a href="<?= $link['uri'] ?>" class="pagination-link <?= $link['active'] ? 'active' : '' ?>">
            <?= $link['title'] ?>
        </a>
    <?php endforeach ?>

    <?php if ($pager->hasNextPage()) : ?>
        <a href="<?= $pager->getNextPage() ?>" class="pagination-arrow" id="nextPage" aria-label="Next">
            <span aria-hidden="true">&gt;</span>
        </a>
    <?php else: ?>
        <a href="#" class="pagination-arrow disabled" aria-label="Next" onclick="event.preventDefault();">
            <span aria-hidden="true">&gt;</span>
        </a>
    <?php endif ?>
</div>
