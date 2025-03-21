
<div class="col-lg-3 col-sm-3 col-12">
  <div class="card mb-3">
    <div class="card-body">
      <div class="m-0">
        <label for="ano_inicio">Ano de Início:</label>
        <input type="number" class="form-control" id="ano_inicio" name="year_start" value="2023" min="2000" max="<?=date('Y')?>" onchange="atualizarAnoFim()">
      </div>
    </div>
  </div>
</div>

<div class="col-lg-3 col-sm-3 col-12">
  <div class="card mb-3">
    <div class="card-body">
      <div class="m-0">
        <label for="ano_fim">Ano de Fim:</label>
        <input type="number" class="form-control" readonly id="ano_fim" name="year_end" value="2024" min="2000" max="2100">
      </div>
    </div>
  </div>
</div>

<div class="col-lg-6 col-sm-6 col-12">
  <div class="card mb-3">
    <div class="card-body">
      <div class="m-0">
        <label for="title">Titulo:</label>
        <input type="text" class="form-control" id="title" name="title" value="<?=$page->titulo ?? ''?>">
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
                <a href="/admin/linhas" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">Salvar</button>
            </div>
        </div>
    </div>
</div>


<script>
  function atualizarAnoFim() {
    const anoInicio = document.getElementById('ano_inicio').value;
    if (anoInicio && !isNaN(anoInicio)) {
      const anoFim = parseInt(anoInicio) + 2;
      document.getElementById('ano_fim').value = anoFim;
      return;
    } 
    document.getElementById('ano_fim').value = '';
    return;
  }
</script>
