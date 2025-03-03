<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title><?=$_ENV['APP_NAME']?></title>
        <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <!-- Meta Description -->
        <meta name="description" content="União dos Ópticos e Optometristas do Estado da Bahia (UNOOBA) - Promovendo a excelência na óptica e optometria, representando e fortalecendo os profissionais da área na Bahia.">

        <!-- Meta Keywords (opcional) -->
        <meta name="keywords" content="UNOOBA, ópticos Bahia, optometristas Bahia, óptica, optometria, União dos Ópticos, União dos Optometristas, Bahia, óptica e optometria">

        <!-- Open Graph Tags (para redes sociais) -->
        <meta property="og:title" content="<?=$_ENV['APP_NAME']?>">
        <meta property="og:description" content="União dos Ópticos e Optometristas do Estado da Bahia (UNOOBA) - Promovendo a excelência na óptica e optometria, representando e fortalecendo os profissionais da área na Bahia.">
        <meta property="og:image" content="<?=$_ENV['URL_PREFIX_APP']?>/Public/site/sind/unooba-sem-fundo.png">
        <meta property="og:url" content="<?=$_ENV['URL_PREFIX_APP']?>">
        <meta property="og:type" content="website">

        <!-- Canonical URL -->
        <link rel="canonical" href="<?=$_ENV['URL_PREFIX_APP']?>">

        <!-- Autor e Copyright -->
        <meta name="author" content="UNOOBA - União dos Ópticos e Optometristas da Bahia">
        <meta name="copyright" content="UNOOBA">

        <!-- Favicon -->
        <link rel="icon" href="<?=$_ENV['URL_PREFIX_APP']?>/Public/site/sind/unooba-sem-fundo.png" type="image/x-icon">

        <!-- Fonts -->
        <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Work+Sans:300,400,500,700%7CZilla+Slab:300,400,500,700,700i%7CGloria+Hallelujah">

        <!-- Stylesheets -->
        <link rel="stylesheet" href="<?=$_ENV['URL_PREFIX_APP']?>/Public/site/css/bootstrap.css">
        <link rel="stylesheet" href="<?=$_ENV['URL_PREFIX_APP']?>/Public/site/css/fonts.css">
        <link rel="stylesheet" href="<?=$_ENV['URL_PREFIX_APP']?>/Public/site/css/style.css">

        <!-- IE Panel -->
        <style>
            .ie-panel {
            display: none;
            background: #212121;
            padding: 10px 0;
            box-shadow: 3px 3px 5px 0 rgba(0,0,0,.3);
            clear: both;
            text-align: center;
            position: relative;
            z-index: 1;
            }
            html.ie-10 .ie-panel, html.lt-ie-10 .ie-panel {
            display: block;
            }
        </style>
    </head>
    <body>
    
