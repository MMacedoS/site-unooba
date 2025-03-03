<header class="page-header">
    <!-- RD Navbar-->
    <div class="rd-navbar-wrap">
        <nav class="rd-navbar rd-navbar-classic" 
            data-layout="rd-navbar-fixed" 
            data-sm-layout="rd-navbar-fixed" 
            data-md-layout="rd-navbar-fixed" 
            data-md-device-layout="rd-navbar-fixed" 
            data-lg-layout="rd-navbar-static" 
            data-lg-device-layout="rd-navbar-fixed" 
            data-xl-layout="rd-navbar-static">
            <div class="rd-navbar-main-outer">
                <div class="rd-navbar-main">
                    <!-- RD Navbar Panel-->
                    <div class="rd-navbar-panel justify-content-between align-items-center">

                        <div class="left-item">
                            <!-- RD Navbar Toggle-->
                            <button class="rd-navbar-toggle" data-rd-navbar-toggle=".rd-navbar-nav-wrap"><span></span></button>
                        </div>
                            <!-- RD Navbar Brand-->
                        <div class="rd-navbar-brand">
                            <a class="brand" href="/">
                                <img class="brand-logo-dark" src="<?=$_ENV['URL_PREFIX_APP']?>/Public/site/sind/unooba-sem-fundo.png" alt="" width="100" height="10"/>
                                <img class="brand-logo-light" src="<?=$_ENV['URL_PREFIX_APP']?>/Public/site/sind/unooba-sem-fundo.png" alt="" width="100" height="10"/>
                            </a>
                        </div>
                    
                    </div>
                    <div class="rd-navbar-nav-wrap">
                    <!-- RD Navbar Nav		-->
                    <ul class="rd-navbar-nav float-right">
                        <li class="rd-nav-item <?=$active == 'principal'? 'active': ''?>"><a class="rd-nav-link" href="/">Principal</a>
                        </li>
                        <!-- <li class="rd-nav-item"><a class="rd-nav-link" href="about.html">Notícias</a> -->
                        </li>
                        <li class="rd-nav-item <?=$active == 'diretoria' ? 'active': ''?>"><a class="rd-nav-link" href="<?=$_ENV['URL_PREFIX_APP']?>/diretoria">Diretoria</a>
                        </li>
                        <!-- <li class="rd-nav-item"><a class="rd-nav-link" href="typography.html">Gestão</a>
                        </li> -->
                        <li class="rd-nav-item <?=$active == 'sobre'? 'active': ''?>"><a class="rd-nav-link" href="<?=$_ENV['URL_PREFIX_APP']?>/sobre">sobre</a>
                        </li>
                        <!-- <li class="rd-nav-item"><a class="rd-nav-link" href="contacts.html">Filiado</a>
                        </li> -->
                    </ul>
                    </div>
                </div>
            </div>
        </nav>
    </div>
</header>
      