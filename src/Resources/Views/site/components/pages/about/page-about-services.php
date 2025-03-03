    <section class="section section-lg bg-gray-100 text-center">
        <div class="container">
          <h2 class="wow fadeIn">Parceiros</h2>
          <p class="wow fadeIn" data-wow-delay=".2s">
            <span class="text-gray-900" style="max-width: 570px;">
                Em nossos parceiros, você encontrará empresas diversificadas, com atuação em vários ramos, oferecendo oportunidades únicas, serviços especializados e soluções personalizadas para atender às necessidades do mercado.
            </span>
          </p>
          <div class="row row-30 row-xl-90 justify-content-center">
            <?
              if (!empty($parceiros)) {
                  foreach ($parceiros as $key => $value) {
            ?>

            <div class="col-sm-6 col-lg-4 col-xl-3 wow fadeIn" data-wow-delay=".2s">
              <!-- Box Classic-->
              <article class="box-classic">
                <span class="icon box-classic-icon">
                    <img class="img-article-total" src="/Public/<?=getJsonToObject($value->arquivo)->path?>" alt="">
                </span>
                <a class="box-classic-main mt-3" href="#">
                  <h4 class="box-classic-title"><?=$value->nome?></h4>
                  <div class="box-classic-inner">
                    <p><?=$value->descricao?></p>
                  </div>
                </a>
              </article>
            </div>
            <?
                  }
              }
            ?>
          </div>
        </div>
      </section>