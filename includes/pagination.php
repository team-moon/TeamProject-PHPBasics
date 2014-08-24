<div id="pagination">
    <ul>
        <?php $countAllPages = ceil($countFilteredPostsWithoutLimit / POSTS_PER_PAGE); ?>

        <?php if ($page > 1) { ?>
            <li>
                <a class="pagination-arrow" href="posts.php?page=<?php echo ($page - 1), $filterForPagination; ?>" title="Previous page">&laquo; Previous</a>
            </li>
        <?php } ?>

        <?php for ($i = 1; $i <= $countAllPages; $i++) { ?>
            <li>
                <?php
                if ($page == $i) {
                    $currentPage = 'class="current-page"';
                } else {
                    $currentPage = '';
                }
                ?>
                <a <?php echo $currentPage; ?> href="posts.php?page=<?php echo $i, $filterForPagination; ?>" title="Go to page <?php echo $i; ?>">
                    <?php echo $i; ?>
                </a>
            </li>
        <?php } ?>

        <?php if ($page < $countAllPages) { ?>
            <li>
                <a class="pagination-arrow" href="posts.php?page=<?php echo ($page + 1), $filterForPagination; ?>" title="Next page">Next &raquo;</a>
            </li>
        <?php } ?>
    </ul>
</div><!-- #pagination -->