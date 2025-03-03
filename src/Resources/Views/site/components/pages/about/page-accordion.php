<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<section class="section section-lg bg-default">
    <div class="container">
        <h2>Documentos Públicos</h2>
        <div class="row gx-3">
            <? if(!empty($documentos)) {
                foreach ($documentos as $key => $value) {
            ?>

            <div class="accordion" id="filePDF<?=$value->id?>">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#filePDF<?=$value->id?>" aria-expanded="true" aria-controls="collapseOne">
                            <?=$value->nome?>
                        </button>
                    </h2>
                    <div id="filePDF<?=$value->id?>" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#pdfAccordion">
                        <div class="accordion-body">
                            <iframe id="pdfViewer" src="/Public/<?=getJsonToObject($value->arquivo)->path?>" width="100%" height="500px" style="border: none;"></iframe>
                        </div>
                    </div>
                </div>
            </div>
            
            <?
                }

            } ?>
        </div>
    </div>
</section>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>