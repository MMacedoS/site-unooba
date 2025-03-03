
<div class="col-12">
  <div class="card mb-3">
    <div class="card-body">
      <div class="m-0">
        <label class="form-label">Titulo</label>
        <input type="text" class="form-control" name="title" required placeholder="Digite o titulo" value="<?=$slide->titulo ?? ''?>" />
      </div>
    </div>
  </div>
</div>

<div class="col-12">
  <div class="card mb-3">
    <div class="card-body">
      <div class="m-0">
        <label class="form-label">Descricao</label>
        <textarea name="description" rows="5" class="form-control" required id=""><?= $slide->descricao ?? ''?></textarea>
      </div>
    </div>
  </div>
</div>

<div class="col-lg-4 col-sm-4 col-12">
  <div class="card mb-3">
    <div class="card-body">
      <div class="m-0">
        <label class="form-label">Setor</label>
        <select name="sector" class="form-control" id="" required>
          <option <?=(isset($slide) && $slide->setor =='comunicação') ? 'selected': ''?> value="comunicação">Comunicação</option>
          <option <?=(isset($slide) && $slide->setor =='política') ? 'selected': ''?> value="política">Política</option>
          <option <?=(isset($slide) && $slide->setor =='educação') ? 'selected': ''?> value="educação">Educação</option>
          <option <?=(isset($slide) && $slide->setor =='saúde') ? 'selected': ''?> value="saúde">Saúde</option>
          <option <?=(isset($slide) && $slide->setor =='evento') ? 'selected': ''?> value="evento">Evento</option>
        </select>
      </div>
    </div>
  </div>
</div>

<div class="col-lg-4 col-sm-4 col-12">
  <div class="card mb-3">
    <div class="card-body">
      <div class="m-0">
        <label class="form-label">Link informativo</label>
        <input type="url" name="link" class="form-control" value="<?= $slide->link ?? '' ?>" placeholder="ex: https://unooba.org.br" required id="">
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
            <option value="0" <?php if(isset($sector->ativo) && $sector->ativo == '0') { echo 'selected'; } ?>>Impedido</option>
            <option value="1" selected <?php if(isset($sector->ativo) && $sector->ativo == '1') { echo 'selected'; } ?>>Disponivel</option>
        </select>
      </div>
   </div>
  </div>
</div>

<div class="col-xxl-12">
    <div class="card mb-3">
        <div class="card-body">
            <div class="d-flex flex-wrap gap-2 justify-content-end">
                <a href="/admin/slides" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">Salvar</button>
            </div>
        </div>
    </div>
</div>

