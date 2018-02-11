<html lang="en">
        
    <head>
        <meta charset="utf-8">
        <title>ZF Skeleton Application</title>
        <link href="{$baseUrl}/img/favicon.ico" rel="shortcut icon" type="image/vnd.microsoft.icon" />
        <link href="{$baseUrl}/css/bootstrap-theme.min.css" rel="stylesheet" type="text/css" />
        <link href="{$baseUrl}/css/style.css" rel="stylesheet" type="text/css" />
        <link href="{$baseUrl}/css/bootstrap.min.css" rel="stylesheet" type="text/css" />

        <!-- Scripts -->
        <script type="text/javascript" src="{$baseUrl}/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="{$baseUrl}/js/jquery-2.2.4.min.js"></script>
    </head>
    <body>
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="{$baseUrl}">
                        <img src="{$baseUrl}/img/zf-logo.png" alt="Zend Framework 3"/>&nbsp;Skeleton Application
                    </a>
                </div>
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="{$baseUrl}">Home Page</a></li>
                        <li class=""><a href="{$baseUrl}/users/index">Users</a></li>
                        <li class=""><a href="{$baseUrl}/news/index">Articles</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="container">
            {block 'content'}{/block}
            <hr>
            <footer>
                <p>2018 Zend Framework 3 - Developer's Guide</p>
            </footer>
        </div>
    </body>
</html>
