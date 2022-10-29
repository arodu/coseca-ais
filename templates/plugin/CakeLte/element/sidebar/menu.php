<?php
$menu = [
    'home' => [
        'label' => 'Inicio',
        'uri' => ['controller' => 'Stages', 'action' => 'index', 'plugin' => false, 'prefix' => 'Student'],
        'show' => function () {
            // logic condition to show item, return a bool
            return true;
        }
    ],
    'startPages' => [
        'label' => 'Start Pages',
        'icon' => 'fas fa-tachometer-alt',
        'dropdown' => [
            'activePage' => [
                'label' => 'Active Page',
                'uri' => ['controller' => 'Pages', 'action' => 'display', 'home', 'plugin' => false],
            ],
            'inactivePage' => [
                'label' => 'Inactive Page',
                'uri' => '#',
            ],
        ],
    ],
    'simpleLink' => [
        'label' => 'Simple Link',
        'extra' => '<span class="right badge badge-danger">New</span>',
        'uri' => ['controller' => 'Pages', 'action' => 'display', 'home', 'plugin' => false],
        'show' => function () {
            // logic condition to show item, return a bool
            return true;
        }
    ],
];

echo $this->MenuLte->render($menu);

/*

- To activate an item, you can pass the `active` variable, or use method `activeItem` from the template
    Example: 
        $this->MenuLte->activeItem('startPages.activePage');

- It is also possible to create the menu using the html code
    <li class="nav-item has-treeview menu-open">
        <a href="#" class="nav-link active">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
                Starter Pages
                <i class="right fas fa-angle-left"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="#" class="nav-link active">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Active Page</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Inactive Page</p>
                </a>
            </li>
        </ul>
    </li>
    <li class="nav-item">
        <a href="#" class="nav-link">
            <i class="nav-icon fas fa-th"></i>
            <p>
                Simple Link
                <span class="right badge badge-danger">New</span>
            </p>
        </a>
    </li>
*/