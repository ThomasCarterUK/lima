<div class="nav-menu">
    <ul class="menu">
        <?php foreach ($menu_items as $item): ?>
            <li <?php if (!empty($item['class'])) echo 'class="' . $item['class'] . '"'; ?>><a href="<?php echo $item['link']; ?>"><?php echo $item['text']; ?></a></li>
        <?php endforeach; ?>
    </ul>
</div>