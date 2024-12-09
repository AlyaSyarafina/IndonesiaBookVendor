<div class="book-slider-widget">
    <h3><?= esc($title) ?></h3>
    <div class="book-slider">
        <?php if (!empty($books)) : ?>
            <?php foreach ($books as $book) : ?>
                <div class="book-item">
                    <img src="<?= esc($book['image_path'] ?? 'default.jpg') ?>" alt="<?= esc($book['title']) ?>" />
                    <h4><?= esc($book['title']) ?></h4>
                    <p>Author: <?= esc($book['author']) ?></p>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <p>No books available.</p>
        <?php endif; ?>
    </div>
</div>
