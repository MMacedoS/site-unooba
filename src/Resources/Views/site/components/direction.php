    <div class="page">
        <div class="breadcrumbs-custom">
          <div class="container breadcrumbs-custom-container">
            <div class="breadcrumbs-custom-inner context-dark">
              <div class="breadcrumbs-custom-item">                
                <h1 class="breadcrumbs-custom-title">Diretoria</h1>
              </div>
            </div>
          </div>
        </div>

        <?php
            require_once ('pages/about/page-about-history.php');
        ?> 

        <section class="section section-lg bg-default">
            <div class="container">              
              <h2 class="wow fadeIn">Colaboradores</h2>
              <div class="row row-50 flex-lg-row-reverse">
                  <div class="col-xl-12">
                      <div class="container">
                          <div class="row">
                            <? foreach ($colaborators as $key => $value) {
                            ?>
                            <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                              <div class="card mb-3">
                                  <div class="card-img">
                                      <img src="/Public/<?=getJsonToObject($value->arquivo)->path?>" background-size:="" cover;=""
                                      class="card-img-top img-fluid h-15-rem" alt="<?=getJsonToObject($value->pessoa_fisica)->nome?>" />
                                  </div>
                                  <div class="card-body">
                                      <h5 class="card-title mb-3"><?=getJsonToObject($value->pessoa_fisica)->nome?></h5>
                                      <p class="mb-3">
                                        <?=getJsonToObject($value->setor)->nome?>
                                      </p>
                                      <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#colaborator-<?=$value->id?>">
                                        Ver Biografia
                                      </button>
                                  </div>
                                </div>
                            </div> 

                            <div class="modal fade" id="colaborator-<?=$value->id?>" tabindex="-1" aria-labelledby="marianaModalLabel" aria-hidden="true">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="marianaModalLabel"><?=getJsonToObject($value->pessoa_fisica)->nome?></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                                  </div>
                                  <div class="modal-body">
                                    <div class="card-img">
                                        <img src="/Public/<?=getJsonToObject($value->arquivo)->path?>" background-size:="" cover;=""
                                        class="card-img-top img-fluid h-15-rem" alt="<?=getJsonToObject($value->pessoa_fisica)->nome?>" />
                                    </div>
                                    <p><strong>Cargo:</strong> <?=getJsonToObject($value->setor)->nome?></p>
                                    <p><strong>Biografia:</strong></p>
                                    <p class="text-justify"><?=$value->descricao?></p>                                    
                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <? }
                            ?>
                          </div>
                      </div>
                  </div>
              </div>
            </div>
        </section>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>