
<div class="col-lg-6 col-sm-6 col-12">
  <div class="card mb-3">
    <div class="card-body">
      <div class="m-0">
        <label class="form-label">Setores</label>
        <input type="text" class="form-control" name="name" required placeholder="Digite o nome" value="<?=$sector->nome ?? ''?>" />
      </div>
    </div>
  </div>
</div>

<div class="col-lg-2 col-sm-2 col-12">
  <div class="card mb-3">
    <div class="card-body">
      <div class="m-0">
        <label class="form-label">Hierarquia</label>
        <input type="number" step="0" min="1" class="form-control" name="order" required placeholder="Posição 1 => 1º" value="<?=$sector->ordem ?? ''?>" />
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
                <a href="/admin/sectors" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">Salvar</button>
            </div>
        </div>
    </div>
</div>

