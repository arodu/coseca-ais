<?php
/**
 * Copyright 2024 ACGAMES - anthonyzok521@gmail.com
 * 
 * Template for 404 ERROR!
 * 
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 * @var \App\View\AppView $this
 */
?>
<!DOCTYPE html>
<html>
<head>

    <?php  // Responsive ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?= $this->Html->charset() ?>
    <title>
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>

    <link href="https://fonts.googleapis.com/css?family=Raleway:400,700" rel="stylesheet">
    <?php  // Icon Warning since flaticon.com ?>
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.3.0/uicons-solid-rounded/css/uicons-solid-rounded.css'>
    <?= $this->Html->css(['normalize.min', 'milligram.min', 'cake']) ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>

    <?php  // Style of template 404 error ?>
    <style>
        :root{
            --color-warning: #ffc107;
            --bg: #fafafa;
        }

        body{
            background-color: var(--bg);
            display: flex;
            justify-content: center;
            height: 100vh;
        }

        hr{
            width: 100%;
            border: solid 6px;
            margin: 0;
        }

        .img-404{
            clip-path: inset(23px 17px);
            margin-top: 68px;
        }

        .error-container{
            width: 80%;
            height: 500px;
        }

        .code {
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .code h2 {
            width: max-content;
            font-weight: 800;
            margin: 0;
            font-size: 1.6rem;
        }

        .title-error{
            display: flex;
            align-items: center;
            height: max-content;
        }

        .fi-sr-triangle-warning{
            margin-top: 5px;
            margin-right: 5px;
            color: var(--color-warning);
            font-size: 16px;
        }

        .content h2 {
            font-size: 2.2rem;          
        }

        .error{
            font-size: 10px;
        }

        @media screen and (width > 600px) {
            .content h2 {
                font-size: 20px;          
            }
        
            .img-404{
                object-fit: fill;
                height: 315px;
                margin-top: 20px;
                width: 65%;
            }

            .code {
                height: none;
            }

            .error-container{
                height: 100vh;
                width: 80%;
                display: flex;
                justify-content: flex-start;
            }

            .fi-sr-triangle-warning{
                margin-top: 4;
                font-size: 21px;
            }

            .code h2 {
                margin: 0;
                font-size: 18px;
            }

            .content{
                width: 607px;
            }

            hr{
                margin-top: 50px;
                width: 50%;
            }
        }
    </style>
</head>
<body>
    <div class="error-container">
        <?= $this->Flash->render() ?>
        <?= $this->fetch('content') ?>
        <?php  // Back button removed. Moved to template/Error/error400.php ?>
    </div>
</body>
</html>
