<?php 
    require_once __DIR__ . "/../layout/top.php";
?>

    <div class="row mt-3">
        <div class="col-md-4">
            <div class="card text-dark bg-primary mb-3">
                <div class="card-header text-primary opacity-100">Slides Cadastrados</div>
                <div class="card-body">
                    <h3 class="card-title" id="slidesCount"><?=count($slides)?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-dark bg-success mb-3">
                <div class="card-header text-primary opacity-100">Parceiros Cadastrados</div>
                <div class="card-body">
                    <h3 class="card-title" id="partnersCount"><?=count($parceiros)?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-dark bg-warning mb-3">
                <div class="card-header text-primary opacity-100">Colaboradores Cadastrados</div>
                <div class="card-body">
                    <h3 class="card-title" id="employeesCount"><?=count($colaboradores)?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-dark bg-danger mb-3">
                <div class="card-header text-primary opacity-100">Linhas de Tempo Cadastrados</div>
                <div class="card-body">
                    <h3 class="card-title" id="departmentsCount"><?=count($linhas)?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-dark bg-info mb-3">
                <div class="card-header text-primary opacity-100">Documentos Cadastrados</div>
                <div class="card-body">
                    <h3 class="card-title" id="documentsCount"><?=count($documentos)?></h3>
                </div>
            </div>
        </div>
    </div>


<?php 
    require_once __DIR__ . "/../layout/bottom.php";
?>