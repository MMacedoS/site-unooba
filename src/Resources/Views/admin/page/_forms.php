
<div class="col-12">
  <div class="card mb-3">
    <div class="card-body">
      <div class="m-0">
        <label class="form-label">Titulo</label>
        <input type="text" class="form-control" name="title" required placeholder="Digite o titulo" value="<?=$page->titulo ?? ''?>" />
      </div>
    </div>
  </div>
</div>

<div class="col-12">
  <div class="card mb-3">
    <div class="card-body">
      <div class="m-0">
        <label class="form-label">Descricao</label>
        <textarea name="description" rows="5" class="form-control" required id=""><?= $page->descricao ?? ''?></textarea>
      </div>
    </div>
  </div>
</div>

<div class="col-lg-4 col-sm-4 col-12">
  <div class="card mb-3">
    <div class="card-body">
      <div class="m-0">
        <label class="form-label">Link informativo</label>
        <input type="url" name="link_video" class="form-control" value="<?= $page->link_video ?? '' ?>" placeholder="ex: https://unooba.org.br" required id="">
      </div>
   </div>
  </div>
</div>

<div class="col-lg-4 col-sm-4 col-12">
  <div class="card mb-3">
    <div class="card-body">
      <div class="m-0">
        <label class="form-label">Tipo</label>
        <select name="type" class="form-control" id="" required>
          <option <?=(isset($page) && $page->tipo =='sobre') ? 'selected': ''?> value="sobre">Sobre</option>
          <option <?=(isset($page) && $page->tipo =='contato') ? 'selected': ''?> value="contato">Contato</option>
          <option <?=(isset($page) && $page->tipo =='diretoria') ? 'selected': ''?> value="diretoria">Diretoria</option>
        </select>
      </div>
    </div>
  </div>
</div>

<div class="col-lg-4 col-sm-4 col-12">
  <div class="card mb-3">
    <div class="card-body">
      <div class="m-0">
        <label class="form-label">Situação</label>
        <select name="active" class="form-control" id="" required>
            <option value="0" <?php if(isset($page->ativo) && $page->ativo == '0') { echo 'selected'; } ?>>Impedido</option>
            <option value="1" selected <?php if(isset($page->ativo) && $page->ativo == '1') { echo 'selected'; } ?>>Disponivel</option>
        </select>
      </div>
   </div>
  </div>
</div>

<div class="col-xxl-12">
    <div class="card mb-3">
        <div class="card-body">
            <div class="d-flex flex-wrap gap-2 justify-content-end">
                <a href="/admin/paginas" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">Salvar</button>
            </div>
        </div>
    </div>
</div>

