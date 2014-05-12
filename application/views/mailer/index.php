
<!doctype html>
<html lang="en" ng-app="mailApp">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <style>
        tr{
            cursor:pointer;
        }
        .selected td{
            background-color: #ccc !important;
        }
    #webmail_header{
        top:0;
        background-color: #931000;
        background-color: #56c1de;
        height:20px;
        display: block;
        position:fixed;
        width:100%;
    }
    #webmail_topbar{
        width:100%;
        top:20px;
        background-color: #dbe6f4;
        height: 35px;
        display: block;
        position:fixed;
        text-align:center;
    }
    table.webmail tbody tr.unread{
        background-color:#F9F3D1 !important;
    }
    table.webmail tbody tr.unread td{
        background-color:#F9F3D1 !important;
    }
    .folders a{
color: #428bca;
text-decoration: none;
background-color: #f9f9f9;
padding: 8px;
border-top: 1px solid #ddd;
display:block;
line-height: 1.42857143;
}
    </style>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script id="angularScript" src="//ajax.googleapis.com/ajax/libs/angularjs/1.3.0-beta.7/angular.js"></script>
    <script id="angularScript" src="/public/js/angular/angular-route.js"></script>
    <script id="angularScript" src="/public/js/MessageCtrl.js"></script>
    <script id="angularScript" src="/public/js/summernote.min.js"></script>
    <link type="text/css" rel="stylesheet" href="http://www.uitech.me/css/social.css" />
    <link type="text/css" rel="stylesheet" href="/public/css/inbox.css" />
    <link type="text/css" rel="stylesheet" href="/public/css/components.css" />
    <link href="/public/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
    <link type="text/css" rel="stylesheet" href="/public/css/bootstrap.min.css" />
    <link type="text/css" rel="stylesheet" href="/public/css/webmail.css" />
    <link type="text/css" rel="stylesheet" href="/public/css/summernote.css" />
<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.1/css/bootstrap.min.css">
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.1/js/bootstrap.min.js"></script>
<link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css">
<script>
$(document).ready(function() {
  $('#summernote').summernote({height: 400});
});
</script>
</head>
<body>
<img src="http://www.uitech.me/img/logo.png" class="webmail_logo" width="60px"/>
<div id='webmail_header'>
	
</div>
<div id='webmail_topbar' ng-controller="MenuCtrl">
  <span class="menu"><a href="#" onclick="$('#message_compose').toggleClass('hidden')">Compose</a></span>
  <span class='menu' ng-repeat="menu in menus">
    <a href='{{ menu.url }}'>{{ menu.label  }}</a>
  </span>
</div>
<div class="folders" ng-controller="FolderCtrl">
   <a href="/mailer/{{ folder }}" ng-repeat="folder in folders">{{ folder }}</a>
</div>
<div class="" ng-controller="MainCtrl">
    <div class='webmail allMail inbox-content' ng-view>
    </div>
</div>


<div id='message_consultation' data-x-div-type="body"></div>
<div id="message_compose" class="hidden" ng-include="'/public/js/view/compose.html'" ng-controller="ComposeCtrl"></div>

</body>

</html>
