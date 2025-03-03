    <section>   
        <!-- Swiper-->
        <div class="swiper-container swiper-slider swiper-slider-1" data-loop="false" data-autoplay="5000" data-simulate-touch="false">
          <div class="swiper-wrapper">
            <? 
            if (!empty($slides)) {
             foreach ($slides as $key => $value) { 
            ?>
            <div class="swiper-slide" data-slide-bg="<?=$_ENV['URL_PREFIX_APP']?>/Public/<?=getJsonToObject($value->arquivo)->path?>">
              <div class="swiper-slide-caption context-dark">
                <div class="container">
                  <div class="row">
                    <div class="col-md-10 col-lg-7">
                      <div class="box-animation">
                        <h2 data-caption-animate="slideInLeft" data-caption-delay="300">
                          <?=$value->titulo?>                          
                        </h2>
                        <div class="button-block" 
                            data-caption-animate="fadeInUp" 
                            data-caption-delay="450">
                            <? if (!is_null($value->link)) { ?>
                              <a class="button button-primary-gradient" href="<?=$value->link?>">
                                <span>mais informação</span>
                              </a>
                            <? } ?>

                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            
            <?
                }  
              }          
            ?>
          </div>
          <div class="swiper-pagination"></div>
        </div>
    </section>