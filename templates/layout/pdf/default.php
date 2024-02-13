<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COSECA - AIS</title>

    <style>
        @page {
            margin-top: <?= $this->Pdf->getMarginTopBase() . 'px' ?>;
            margin-bottom: <?= $this->Pdf->getMarginBottonBase() . 'px' ?>;
            margin-left: 40pt;
            margin-right: 40pt;
        }

        .page-break {
            page-break-after: always;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
        }

        header {
            position: fixed;
            top: <?= $this->Pdf->getHeaderTopBase() . 'px' ?>;
            left: 0px;
            right: 0px;
            height: 100px;
        }

        footer {
            position: fixed;
            bottom: <?= $this->Pdf->getFooterBottomBase() . 'px' ?>;
            left: 0px;
            right: 0px;
            height: 50px;
            text-align: center;
        }

        .title-header img {
            max-width: 100pt;
            max-height: 50pt;
        }

        .title-header td {
            vertical-align: middle;
        }

        .title-header .logo {
            width: 100pt;
            height: 50pt;
            text-align: center;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        table td {
            padding: 4px;
        }

        .truncate {
            width: 250px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .border-cells th, .border-cells td, td.border-cells, th.border-cells {
            border: 1px solid black;
        }
    </style>

</head>

<body>
    <header>
        <?= $this->element('Documents/titleHeader') ?>
        <div><?= $this->fetch('contentHeader') ?></div>
    </header>

    <footer>
        <?= $this->fetch('contentFooter') ?>
    </footer>

    <main>
        <?= $this->fetch('content') ?>
    </main>
</body>

</html>