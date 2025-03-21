<?php require_once __DIR__ . '/../layout/top.php'; ?>

<!-- Row start -->
<div class="row gx-3">
    <div class="col-8 col-xl-6">
        <!-- Breadcrumb start -->
        <ol class="breadcrumb mb-3">
            <li class="breadcrumb-item">
                <i class="icon-house_siding lh-1"></i>
                <a href="\dashboard" class="text-decoration-none">Início</a>
            </li>
            <li class="breadcrumb-item">Usuarios</li>
        </ol>
       <!-- Breadcrumb end -->
    </div>
    <div class="col-2 col-xl-6">
        <div class="float-end">
         <a href="\usuario\criar" class="btn btn-outline-primary" > + </a>
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
        <form id="users-form" action="/usuario" method="GET">            
            <div class="accordion mt-2" id="accordionSpecialTitle">
                <div class="accordion-item bg-transparent">
                    <h2 class="accordion-header" id="headingSpecialTitleTwo">
                        <button 
                            class=" bg-transparent accordion-button <?= isset($situation) || isset($searchFilter) ? '' : 'collapsed'?>" 
                            type="button" data-bs-toggle="collapse"
                            data-bs-target="#filters-users" 
                            aria-expanded="false"
                            aria-controls="collapseSpecialTitleTwo">
                            <h5 class="m-0">Filtros</h5>
                        </button>
                    </h2>
                    <div id="filters-users" 
                        class="accordion-collapse <?= isset($situation) || isset($searchFilter) ? '' : 'collapse'?>"
                        aria-labelledby="headingSpecialTitleTwo" 
                        data-bs-parent="#accordionSpecialTitle">
                      <div class="accordion-body">
                        <div class="row justify-content-start">
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="m-0">
                                            <label class="form-label">Busca por nome ou email</label>
                                            <input 
                                                class="form-input form-control" 
                                                type="text" 
                                                name="name_email" 
                                                id="name_email" 
                                                value="<?= isset($searchFilter) ? $searchFilter : null ?>" 
                                                placeholder="Digite o nome ou o email">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 mb-2">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="m-0">
                                            <label class="form-label">Acesso</label>
                                            <select class="form-select form-control" name="access" id="access">
                                                <option <?= (isset($access) && $access == '') ? 'selected' : ''?> value="">Ambos</option>
                                                <option value="administrativo" <?= (isset($access) && $access == "administrativo") ? 'selected' : ''?>>Administrativo</option>
                                                <option value="coordenador" <?= (isset($access) && $access == "coordenador") ? 'selected' : ''?>>Coordenador</option>
                                                <option value="comunicacao" <?= (isset($access) && $access == "comunicacao") ? 'selected' : ''?>>Comunicação</option>
                                                <option value="estudante" <?= (isset($access) && $access == "estudante") ? 'selected' : ''?>>Estudante</option>
                                                <option value="professor" <?= (isset($access) && $access == "professor") ? 'selected' : ''?>>Professor</option>
                                                <option value="responsavel_legal" <?= (isset($access) && $access == "responsavel_legal") ? 'selected' : ''?>>Responsável Legal</option>
                                                <option value="secretaria" <?= (isset($access) && $access == "secretaria") ? 'selected' : ''?>>Secretaria</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 mb-2">
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
                                            <a href="\usuario" class="btn btn-secondary <?= isset($situation) || isset($searchFilter) || isset($shift) || isset($coordinator) ? 'd-block' : 'd-none'?>">Limpar</a>
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
                                    <th class="d-none d-xl-table-cell d-lg-table-cell d-md-table-cell">Nome</th>
                                    <th>email</th>
                                    <th class="d-none d-xl-table-cell d-lg-table-cell d-md-table-cell">Acesso</th>
                                    <th class="d-none d-xl-table-cell d-lg-table-cell d-md-table-cell">Situação</th>
                                    <th>Ação</th>
                                </tr>
                            </thead>
                            
                            <tbody>
                            <? foreach ($data['usuarios'] as $usuario) { ?>
                                    <tr>
                                        <td><?=$usuario->id?></td>
                                        <td class="d-none d-xl-table-cell d-lg-table-cell d-md-table-cell fw-bold"> <?=$usuario->nome?>
                                        </td>
                                        <td>
                                        <?=$usuario->email?>
                                        </td>
                                        <td class="d-none d-xl-table-cell d-lg-table-cell d-md-table-cell">
                                        <?=$usuario->painel?>
                                        </td>
                                        <td class="d-none d-xl-table-cell d-lg-table-cell d-md-table-cell">    
                                            <div class="d-flex align-items-center">
                                                <? if($usuario->ativo == 0) { ?>
                                                    <i class="icon-circle1 me-2 text-danger fs-5"></i>
                                                    Impedido
                                                <? } ?>
                                                <? if($usuario->ativo == 1) { ?>
                                                    <i class="icon-circle1 me-2 text-success fs-5"></i>
                                                    Disponivel
                                                <? } ?>
                                            </div>
                                        </td>
                                        <td >
                                            <div class="d-none d-xl-flex d-lg-flex d-md-flex">
                                                <a class="mb-1 me-2 mt-1" href="/usuario/<?=$usuario->uuid?>/editar">
                                                    <div class="border p-2 rounded-3">
                                                        <i class="icon-edit fs-5"></i>
                                                    </div>
                                                </a>
                                                <button class="btn btn-outline btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal_<?=$usuario->uuid?>">                                                     
                                                    <div class="border p-2 rounded-3">
                                                        <span class="fs-5 text-danger icon-delete1"></span>
                                                    </div>
                                                </button>
                                                
                                                <a href="/usuario/<?=$usuario->uuid?>/permissao" class="mb-1 ms-2 mt-1">
                                                    <div class="border p-2 rounded-3">
                                                    <span class="fs-5 icon-edit_road"></span>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="d-block d-xl-none d-lg-none d-md-none dropdown ms-3">
                                                <a class="dropdown-toggle d-flex py-2 align-items-center text-decoration-none"
                                                    role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="icon-menu"></i>
                                                </a>
                                                <div class="dropdown-menu">
                                                    <div class="header-action-links float-end">
                                                        <a class="mb-1 me-2 mt-1" href="/usuario/<?=$usuario->uuid?>/editar">
                                                            <div class="border p-2 rounded-3">
                                                                <i class="icon-edit fs-5"></i>
                                                            </div>
                                                        </a>
                                                        <button class="btn btn-outline btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal_<?=$usuario->uuid?>">                                                     
                                                            <div class="border p-2 rounded-3">
                                                                <span class="fs-5 text-danger icon-delete1"></span>
                                                            </div>
                                                        </button>
                                                        
                                                        <a href="/usuario/<?=$usuario->uuid?>/permissao" class="mb-1 ms-2 mt-1">
                                                            <div class="border p-2 rounded-3">
                                                            <span class="fs-5 icon-edit_road"></span>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>

                                            <form action="/usuario/<?=$usuario->uuid?>/deletar" method="post">  
                                                <div class="modal fade" id="exampleModal_<?=$usuario->uuid?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">Confirmação de Exclusão</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                Tem certeza que deseja excluir este registro? 
                                                                <p>usuario <?=$usuario->nome?></p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                                <button type="submit" class="btn btn-danger">Confirmar Exclusão</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </td>
                                    </tr>
                            <? } ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="text-end ">
                        Total <b><?=count($data['usuarios'])?></b> registros
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="float-end">
        <?=$data['links']?>
    </div>
</div>

<?php require_once __DIR__ . '/../layout/bottom.php'; ?>
