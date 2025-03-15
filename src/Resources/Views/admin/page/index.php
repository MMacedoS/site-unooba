<?php 
    require_once __DIR__ . "/../layout/top.php";
?>

<!-- Row start -->
<div class="row gx-3">
    <div class="col-8 col-xl-6">
        <!-- Breadcrumb start -->
        <ol class="breadcrumb mb-3">
            <li class="breadcrumb-item">
                <i class="icon-house_siding lh-1"></i>
                <a href="\dashboard" class="text-decoration-none">Início</a>
            </li>
            <li class="breadcrumb-item">Paginas</li>
        </ol>
       <!-- Breadcrumb end -->
    </div>
    <div class="col-2 col-xl-6">
        <div class="float-end">
         <a href="/admin/pagina" class="btn btn-outline-primary" > + </a>
        </div>
    </div>
</div>
    <!-- Row end -->
<? if(isset($success)){?>
    <div class="alert border border-success alert-dismissible fade show text-success" role="alert">
      <b>Success!</b>.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<? }?>
<? if(isset($danger)){?>
    <div class="alert border border-danger alert-dismissible fade show text-danger" role="alert">
       <b>Danger!</b>.
       <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<? }?>
    <!-- Row start -->
<div class="row gx-3">
    <div class="col-12">
        <form id="disciplines-form" action="/admin/paginas" method="GET">
            <div class="accordion mt-2" id="accordionSpecialTitle">
                <div class="accordion-item bg-transparent">
                    <h2 class="accordion-header" id="headingSpecialTitleTwo">
                        <button 
                            class="bg-transparent accordion-button <?= isset($situation) || isset($sector) ? '' : 'collapsed'?>" 
                            type="button" data-bs-toggle="collapse"
                            data-bs-target="#filters-disciplines" 
                            aria-expanded="false"
                            aria-controls="collapseSpecialTitleTwo">
                            <h5 class="m-0">Filtros</h5>
                        </button>
                    </h2>
                    <div id="filters-disciplines" 
                        class="accordion-collapse <?= isset($situation) || isset($title) ? '' : 'collapse'?>"
                        aria-labelledby="headingSpecialTitleTwo" 
                        data-bs-parent="#accordionSpecialTitle">
                      <div class="accordion-body">
                        <div class="row justify-content-start">
                            <div class="col-sm-6 col-md-7">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="m-0">
                                            <label class="form-label">Titulo</label>
                                            <input 
                                                class="form-input form-control"
                                                type="text" 
                                                name="title" 
                                                id="title" 
                                                value="<?= isset($title) ? $title : null ?>" 
                                                placeholder="Busque por título">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 col-md-5 mb-2">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="m-0">
                                            <label class="form-label">Situação</label>
                                            <select class="form-select form-control" name="situation" id="situation">
                                                <option <?= (isset($situation) && $situation == '') ? 'selected' : ''?> value="">Ambas</option>
                                                <option value="1" <?= (isset($situation) && $situation == 1) ? 'selected' : ''?>>Disponível</option>
                                                <option value="0" <?= (isset($situation) && $situation == 0) ? 'selected' : ''?>>Impedido</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xxl-12">
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <div class="d-flex flex-wrap gap-2 justify-content-end">
                                            <a href="/admin/paginas" class="btn btn-secondary <?= isset($situation) || isset($sector) ? 'd-block' : 'd-none'?>">Limpar</a>
                                            <button type="submit" class="btn btn-primary">Buscar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                      </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="col-12">
        <div class="card mb-3">
            <div class="card-body">
                <div class="table-outer">
                    <div class="table-responsive">
                        <table class="table table-striped align-middle m-0">
                           <thead>
                                <tr>
                                    <th></th>
                                    <th>Titulo</th>
                                    <th class="d-none d-xl-table-cell d-lg-table-cell d-md-table-cell">Situação</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            
                            <tbody>
                            <? 
                            If (isset($paginas)) {
                                foreach ($paginas as $pagina) { 
                                ?>
                                    <tr>
                                        <td><?=$pagina->id?></td>
                                        <td class="fw-bold"> 
                                            <?=
                                                !is_null(getJsonToObject($pagina->arquivo)->path) ? 
                                                '<a href="#" data-bs-toggle="modal" data-bs-target="#staticBackdrop-'.$pagina->id.'" ><img src="/Public/'. getJsonToObject($pagina->arquivo)->path .'" class="img-2x me-2 rounded-3"
                                            alt="Bootstrap Gallery" /></a>' : 
                                                '<a href="#" data-bs-toggle="modal" data-bs-target="#staticBackdrop-'.$pagina->id.'" ><img src="/Public/admin/assets/images/bg.jpg" class="img-2x me-2 rounded-3"
                                            alt="Bootstrap Gallery" /></a>';
                                            ?>
                                            <span class="fw-semibold"><?=$pagina->titulo?></span>
                                            <div class="modal fade" id="staticBackdrop-<?=$pagina->id?>" data-bs-backdrop="static" data-bs-keyboard="false"
                                                tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="staticBackdropLabel">
                                                                imagem <?=$pagina->titulo?>
                                                            </h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row gx-3">
                                                                <div class="col-sm-12 col-12">
                                                                    <div id="update-profile" class="mb-3">
                                                                        <form action="/admin/pagina/<?=$pagina->uuid?>/upload" class="dropzone sm needsclick dz-clickable"
                                                                            id="update-profile-pic">
                                                                            <div class="dz-message needsclick">
                                                                                <button type="button" class="dz-button">
                                                                                    Inserir imagem.
                                                                                </button>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                                Close
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="d-none d-xl-table-cell d-lg-table-cell d-md-table-cell">    
                                            <div class="d-flex align-items-center">
                                                <? if($pagina->ativo == 0) { ?>
                                                    <i class="icon-circle1 me-2 text-danger fs-5"></i>
                                                    Impedido
                                                <? } ?>
                                                <? if($pagina->ativo == 1) { ?>
                                                    <i class="icon-circle1 me-2 text-success fs-5"></i>
                                                    Disponivel
                                                <? } ?>
                                            </div>
                                        </td>
                                        <td >
                                            <div class="d-none d-xl-flex d-lg-flex d-md-flex">
                                                <a class="mb-1 me-2 mt-1" href="/admin/pagina/<?=$pagina->uuid?>">
                                                    <div class="border p-2 rounded-3">
                                                        <i class="icon-edit fs-5"></i>
                                                    </div>
                                                </a>                                               
                                        
                                                <? 
                                                if ($pagina->ativo == 1) { ?>                                                    
                                                    <button class="btn btn-outline btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal_<?=$pagina->uuid?>">                                                     
                                                        <div class="border p-2 rounded-3">
                                                            <span class="fs-5 text-danger icon-delete1"></span>
                                                        </div>
                                                    </button>   
                                                <?  
                                                   }
                                                ?>    
                                                <? 
                                                if ($pagina->ativo == 0) { ?>
                                                    <a class="btn btn-outline btn-sm" href="\admin\pagina\<?=$pagina->uuid?>\active">                                                     
                                                        <div class="border p-2 rounded-3">
                                                           <span class="fs-5 text-success icon-check-circle"></span>
                                                        </div>
                                                    </a>
                                                <?  
                                                    }
                                                ?>  
                                            </div>
                                            <div class="d-block d-xl-none d-lg-none d-md-none dropdown ms-3">
                                                <a class="dropdown-toggle d-flex py-2 align-items-center text-decoration-none"
                                                    role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="icon-menu"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <div class="header-action-links float-end">
                                                        <a class="mb-1 me-2 mt-1" href="admin/pagina/<?=$pagina->uuid?>">
                                                            <div class="border p-2 rounded-3">
                                                                <i class="icon-edit fs-5"></i>
                                                            </div>
                                                        </a>                                          
                                        
                                                        <? 
                                                        if ($pagina->ativo == 1) { ?>                                                    
                                                            <button class="btn btn-outline btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal_<?=$pagina->uuid?>">                                                     
                                                                <div class="border p-2 rounded-3">
                                                                    <span class="fs-5 text-danger icon-delete1"></span>
                                                                </div>
                                                            </button>   
                                                        <?  
                                                        }
                                                        ?>    
                                                        <? 
                                                        if ($pagina->ativo == 0) { ?>
                                                            <a class="btn btn-outline btn-sm" href="\admin\pagina\<?=$pagina->uuid?>\active">                                                     
                                                                <div class="border p-2 rounded-3">
                                                                <span class="fs-5 text-success icon-check-circle"></span>
                                                                </div>
                                                            </a>
                                                        <?  
                                                            }
                                                        ?>  
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal fade" id="exampleModal_<?=$pagina->uuid?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Confirmação de Inativação</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Tem certeza que deseja excluir este registro? 
                                                            <p>setor: <?=$pagina->titulo?></p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                            <button type="submit" onclick="deleteData('/admin/pagina/<?=$pagina->uuid?>')" class="btn btn-danger">Confirmar Inativação</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                            <? }
                            } ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="text-end ">
                        Total <b><?=count($paginas ?? [])?></b> registros
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="float-end">
        <?=$links ?? ''?>
    </div>
</div>

<?php 
    require_once __DIR__ . "/../layout/bottom.php";
?>