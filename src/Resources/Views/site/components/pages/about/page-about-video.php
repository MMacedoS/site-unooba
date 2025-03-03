<section class="section section-lg bg-default">
    <div class="container">
        <div class="row row-50 justify-content-center justify-content-xl-between flex-lg-row-reverse">
            <div class="col-md-11 col-lg-6 col-xl-5">
              <div class="box-1">
                <h2><?= $paginas->titulo?></h2>
                <p class="text-justify">
                  <?=$paginas->descricao?>
                </p>
              </div>
            </div>
            <div class="col-md-11 col-lg-6">
              <!-- Thumbnail Media-->
              <div class="thumbnail-media" 
                    style="background-image: url(/Public/site/images/girl-2605526_1280.jpg);">
                    <a class="icon thumbnail-media-icon mdi mdi-play-circle-outline" 
                        href="//<?=$paginas->link_video?>" data-lightgallery="item">
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>