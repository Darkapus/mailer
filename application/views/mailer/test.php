<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script id="angularScript" src="//ajax.googleapis.com/ajax/libs/angularjs/1.3.0-beta.7/angular.js"></script>
    <script id="angularScript" src="/public/js/angular/angular-route.js"></script>
    <link type="text/css" rel="stylesheet" href="/public/css/inbox.css" />
    <link type="text/css" rel="stylesheet" href="/public/css/bootstrap.min.css" />
    <link type="text/css" rel="stylesheet" href="/public/css/webmail.css" />
    
    <style>
        .ac-panel, .ac-table{
            width: 100%;
        }
        .ac-header .ac-header-row .ac-header-cell{
            background-color: #3d4166;
            color: white;
            padding: 8px;
            line-height: 1.42857143;
            vertical-align: top;
            border-top: 1px solid #ddd;
            border-left-width: 0px;
            cursor: pointer;
            font-weight: bold;
        }
        .ac-body .ac-body-row {
            background-color: #f9f9f9;
            vertical-align: top;
            border-top: 1px solid #ddd;
            border-left-width: 0px;
            cursor: pointer;
        }
        .ac-body .ac-body-row:hover , .ac-body .ac-body-row.ac-selected{
            background-color: #9ecdf7;
        }
        .ac-body .ac-body-row .ac-body-cell{
            line-height: 1.42857143;
            padding: 8px;
        }
        .unselectable {
            -moz-user-select: none;
            -webkit-user-select: none;
        }
    </style>
</head>
<body>
<?php

$storage = new \AngularComponent\Storage\JsonStorage('storageTest','[{label:"toto",name:"tata"},{label:"toto",name:"tata"},{label:"toto",name:"tata"}]');

$grid = new \AngularComponent\Grid\Grid($storage);
$grid->addColumn('name', 'name');
$grid->addColumn('label', 'label');

\AngularComponent\Renderer::i()->show($grid);

?>
</body>
</html>