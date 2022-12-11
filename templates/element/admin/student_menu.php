<?php
$student_menu = [
    'general' => [
        'url' => ['controller' => 'Students', 'action' => 'view', $student_id],
        'label' => __('General'),
    ],
    'info' => [
        'url' => ['controller' => 'Students', 'action' => 'info', $student_id],
        'label' => __('Info'),
    ],
    'tracking' => [
        'url' => ['controller' => 'Students', 'action' => 'tracking', $student_id],
        'label' => __('Seguimiento'),
    ],
    'prints' => [
        'url' => ['controller' => 'Students', 'action' => 'prints', $student_id],
        'label' => __('Planillas'),
    ],
    'settings' => [
        'url' => ['controller' => 'Students', 'action' => 'settings', $student_id],
        'label' => __('Configuración'),
    ],
];
?>

<ul class="nav nav-pills">
    <?php foreach ($student_menu as $key => $item) {
        if ($active == $key) {
            $link = $this->Html->tag('span', $item['label'], ['class' => 'nav-link active']);
        } else {
            $link = $this->Html->link($item['label'], $item['url'], ['class' => 'nav-link']);
        }

        echo $this->Html->tag('li', $link, ['class' => 'nav-item']);
    } ?>
</ul>