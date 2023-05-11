<ul class="nav nav-tabs">
    <?php foreach ($student_menu as $key => $item) {
        if ($activeItem == $key) {
            $link = $this->Html->tag('span', $item['label'], ['class' => 'nav-link active']);
        } else {
            $link = $this->Html->link($item['label'], $item['url'], ['class' => 'nav-link']);
        }

        echo $this->Html->tag('li', $link, ['class' => 'nav-item']);
    } ?>
</ul>