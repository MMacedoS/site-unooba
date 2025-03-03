<footer class="section footer-classic bg-primary">
    <div class="footer-classic-main">
        <div class="container"> 
            <div class="row " style="color: #000;">
                <div class="col-sm-4 col-lg-4 col-xl-4">
                    <h3>Redes Sociais</h3>
                    <div class="share-buttons">
                        <ul>
                            <li class="mt-2">
                            <!-- Botão do Instagram -->
                            <a style="color: #FFF;" href="https://www.instagram.com/unooba.bahia?igsh=MXJ1bWcwYXdxYmYzZw==" target="_blank" class="share-button instagram">
                                <i class="fab fa-instagram"></i>
                                <span class="text-dark button-text" style="color: #FFF;">Instagram</span>
                            </a>
                            </li>
                            <li class="mt-2">
                            <!-- Botão do Facebook -->
                            <a style="color: #FFF;" href="https://www.facebook.com/unooba.bahia" target="_blank" class="share-button facebook">
                                <i class="fab fa-facebook"></i>
                                <span class="button-text">Facebook</span>
                            </a>
                            </li>
                            <li class="mt-2">
                            <!-- Botão do WhatsApp -->
                            <a style="color: #FFF;" href="https://wa.me/557191699255?text=Vim%20através%20do%20site%20para%20saber%20mais%20informações" target="_blank" class="share-button whatsapp">
                                <i class="fab fa-whatsapp"></i>
                                <span class="button-text">WhatsApp</span>
                            </a>
                            </li>
                        </ul>
                        </div>
                    
                </div>
                <div class="col-sm-8 col-lg-8 col-xl-8">
                    <div class="row row-50 row-xl-70">
                        <div class="col-12">
                            <? 
                                if (!empty($paginas)) {?>
                                <h3><?=$paginas->titulo?></h3>
                                <p class="text-justify">
                                <?=$paginas->descricao?>
                                </p>    
                            <?
                              }
                            ?>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-classic-aside">
        <div class="container">
            <!-- Rights-->
            <p class="rights" style="color: #000;">
                <span>&copy;&nbsp;</span>
                <span class="copyright-year"></span>
                <span>&nbsp;</span>
                <span>All Rights Reserved.</span>
                <span>&nbsp;</span>
               <br class="d-sm-none"/>
                <a href="#">Terms of Use</a><span> and</span><span>&nbsp;</span><a href="#">Privacy Policy</a>. 
                Desenvolvido por&nbsp;&nbsp;<a href="https://www.codigoerede.com.br">Mauricio Macedo</a></p>
        </div>
    </div>
</footer>        
        <script src="<?=$_ENV['URL_PREFIX_APP']?>/Public/site/js/core.min.js"></script>
        <script src="<?=$_ENV['URL_PREFIX_APP']?>/Public/site/js/script.js"></script>
    </body>
</html>