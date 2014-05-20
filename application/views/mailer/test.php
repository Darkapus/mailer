<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script id="angularScript" src="//ajax.googleapis.com/ajax/libs/angularjs/1.3.0-beta.7/angular.js"></script>
    <script id="angularScript" src="/public/js/angular/angular-route.js"></script>
    <link type="text/css" rel="stylesheet" href="/public/css/bootstrap.min.css" />
    <link type="text/css" rel="stylesheet" href="/public/css/webmail.css" />
    
    <style>
    
        ::-webkit-scrollbar
        {
          width: 12px;  /* for vertical scrollbars */
          height: 12px; /* for horizontal scrollbars */
        }
        
        ::-webkit-scrollbar-track
        {
          background: rgba(0, 0, 0, 0.1);
        }
        
        ::-webkit-scrollbar-thumb
        {
          background: rgba(0, 0, 0, 0.2);
        }
        .ac-panel{
            position: absolute;
        }
        .ac-strategy-fit .ac-panel{
        	top: 0;
        	left: 0;
        	bottom: 0;
        	right: 0;
        }
        .ac-panel-body{
        	position: absolute;
       		width: 100%;
       		top: 30px;
        	left: 0;
        	bottom: 0;
        	right: 0;
        	overflow: auto;
        }
        .ac-panel-header{
       		position: absolute;
       		width: 100%;
       		height:30px;
       		background-color: #3d4166;
            line-height: 1.42857143;
            color: white;
            padding: 8px;
            font-weight: bold;
            top: 0;
        	left: 0;
        	
        }
        .ac-table{
        	height: 100%;
        }
        .ac-table-header .ac-table-header-row .ac-table-header-cell{
            background-color: #bfbfbf;
            color: white;
            /*padding: 8px;*/
            padding-top: 8px;
			padding-bottom: 8px;
            line-height: 1.42857143;
            vertical-align: top;
            border-top: 1px solid #ddd;
            border-left-width: 0px;
            cursor: pointer;
            font-weight: bold;
            text-align: center;
            background-image: -webkit-linear-gradient(top,#f9f9f9,#e3e4e6);
			background-image: -moz-linear-gradient(top,#f9f9f9,#e3e4e6);
			background-image: -o-linear-gradient(top,#f9f9f9,#e3e4e6);
			border-right: 1px solid #c5c5c5;
			color: black;
			font: normal 11px/13px tahoma,arial,verdana,sans-serif;
        }
        .ac-table-header{
        	display: table-header-group;
        }
        .ac-table-header-row{
        	display: block;
        	position: relative;
        }
        .ac-table-body{
        	position: absolute;
        	top: 30px;
        	bottom: 0;
        	display: block;
			
			overflow-y: auto;
			overflow-x: hidden;
			width: 100%;
        }
        .ac-table-body .ac-table-body-row {
            background-color: #f9f9f9;
            vertical-align: top;
            border-top: 1px solid #ddd;
            border-left-width: 0px;
            cursor: pointer;
            transition: all 1s;
        }
        .ac-table-body .ac-table-body-row:hover, .ac-table-body .ac-table-body-row.unread:hover {
        	background-color: #d1d1d1;
        }
        
        .ac-table-body .ac-table-body-row.ac-selected{
            background-color: #9ecdf7 !important;
        }
        .ac-table-body .ac-table-body-row .ac-table-body-cell{
            line-height: 1.42857143;
            /*padding: 8px;*/
        }
        .ac-table-body .ac-table-body-row.unread{
            background-color: #ffffcf;
        }
        .ac-inner-cell{
        	text-overflow: ellipsis;
        	overflow: hidden;
			white-space: nowrap;
			padding-top: 8px;
			padding-bottom: 8px;
        }
        
        .unselectable {
            -moz-user-select: none;
            -webkit-user-select: none;
        }
        
        body .ac-panel{
        	position:absolute;
        	bottom:0; 
        	top:0;
        	left:0;
        	right:0;
        	
        }
        
    </style>
</head>
<body>

	
	<?php
	
	// la vue principale
	$global = new \AngularComponent\Panel\Panel("Visuel");
	
	// les données
	$storage = new \AngularComponent\Storage\ExternalJsonStorage('storageTest','/mailer/checkmail?folder=INBOX');
	
	// la grille
	$grid = new \AngularComponent\Grid\Grid($storage, 'Vos mails');
	$grid->addColumn('From', 'from'		, 200);
	$grid->addColumn('Sujet', 'subject'	, 300);
	$grid->addColumn('Date', 'date'		, 150);
	$grid->setWidth(650);
	
	// définition d'une classe en fonction de la donnée dans row
	$grid->setRowClass("'unread': row.seen=='unread'");
	
	// le panel de lecture des mails
	$reader = new \AngularComponent\Panel\Panel("Reader");
	
	// on ajoute les 2 panels à la vue principale
	$global->addChild($grid);
	$global->addChild($reader);
	
	
	$grid->onRowClick($reader->bLoad("'/mailer/readmail'", 'POST', '{id: row.id, folder: row.folder}'));
	
	\AngularComponent\Renderer::i()->show($global);
	
	?>
	

</body>
</html>