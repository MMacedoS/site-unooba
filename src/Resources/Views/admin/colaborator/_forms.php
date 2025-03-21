
<div class="col-lg-4 col-sm-6 col-12">
  <div class="card mb-3">
    <div class="card-body">
      <div class="m-0">
        <label class="form-label">Nome Completo</label>
        <input type="text" class="form-control" required name="name" id="name" placeholder="Ex.: jose.santos@email.com" value="<?=$pessoa_fisica->nome ?? ''?>" />
        <div class="invalid-feedback" id="name_error"></div>
      </div>
    </div>
  </div>
</div>

<div class="col-lg-4 col-sm-4 col-12">
  <div class="card mb-3">
    <div class="card-body">
      <div class="m-0">
        <label class="form-label">Email de acesso</label>
        <input type="email" class="form-control" required name="email" id="email" placeholder="Ex.: jose.santos@email.com" value="<?=$pessoa_fisica->email ?? ''?>" />
        <div class="invalid-feedback" id="email_error"></div>
      </div>
    </div>
  </div>
</div>

<div class="col-lg-4 col-sm-4 col-12">
  <div class="card mb-3">
    <div class="card-body">
      <div class="m-0">
        <label class="form-label">Graduação</label>
        <input type="text" class="form-control" name="graduacao" placeholder="Ex.: Ciências Biológicas" value="<?=$colaborador->graduacao ?? ''?>" />
      </div>
    </div>
  </div>
</div>

<div class="col-lg-2 col-sm-2 col-12">
  <div class="card mb-3">
    <div class="card-body">
      <div class="m-0">
        <label class="form-label">Tipo documento</label>
        <select class="form-select" name="type_doc" id="type_doc">
          <option value="CPF" <?php if (isset($pessoa_fisica->type_doc) && $pessoa_fisica->type_doc === 'CPF') { echo 'selected';} ?>>CPF</option>
        </select>
        <div class="invalid-feedback" id="type_doc_error"></div>
      </div>
    </div>
  </div>
</div>

<div class="col-lg-2 col-sm-3 col-12">
  <div class="card mb-3">
    <div class="card-body">
      <div class="m-0">
        <label class="form-label">Nº do Documento</label>
        <input type="text" required class="form-control" name="cpf" id="doc" maxlength="14" placeholder="999.999.999-99" value="<?=$pessoa_fisica->cpf ?? ''?>" />
        <div class="invalid-feedback" id="doc_error"></div>
      </div>
    </div>
  </div>
</div>

<div class="col-lg-4 col-sm-6 col-12">
  <div class="card mb-3">
    <div class="card-body">
      <div class="m-0">
        <label class="form-label">Nome da Mãe</label>
        <input type="text" step="0" min="1" class="form-control" id="mother" required name="mother" placeholder="Ex.: Joana dos Santos" value="<?=$pessoa_fisica->nome_mae ?? ''?>" />
        <div class="invalid-feedback" id="mother_error"></div>
      </div>
    </div>
  </div>
</div>

<div class="col-lg-4 col-sm-6 col-12">
  <div class="card mb-3">
    <div class="card-body">
      <div class="m-0">
        <label class="form-label">Nome do Pai</label>
        <input type="text" step="0" min="1" class="form-control"id="father" name="father" placeholder="Ex.: João dos Santos" value="<?=$pessoa_fisica->nome_pai ?? ''?>" />
        <div class="invalid-feedback" id="father_error"></div>
      </div>
    </div>
  </div>
</div>

<div class="col-lg-4 col-sm-4 col-12">
  <div class="card mb-3">
    <div class="card-body">
      <div class="m-0">
        <label class="form-label">Gênero</label>
        <select name="gender" class="form-control" id="">
            <option value="1" <?php if(isset($pessoa_fisica->genero) && $pessoa_fisica->genero == "1") { echo 'selected'; } ?>>Masculino</option>
            <option value="2" <?php if(isset($pessoa_fisica->genero) && $pessoa_fisica->genero == "2") { echo 'selected'; } ?>>Feminino</option>            
            <option value="0" <?php if(!isset($pessoa_fisica->genero) || isset($pessoa_fisica->genero) && $pessoa_fisica->genero == "0") { echo 'selected'; } ?>>Prefiro não dizer</option>
        </select>
      </div>
    </div>
  </div>
</div>

<div class="col-lg-4 col-sm-4 col-12">
  <div class="card mb-3">
    <div class="card-body">
      <div class="m-0">
        <label class="form-label">Telefone</label>
        <input type="phone" class="form-control" name="phone" id="phone" maxlength="16" maxlength="15" placeholder="(99) 99999-9999" value="<?=$pessoa_fisica->telefone ?? ''?>" 
        required/>
        <div class="invalid-feedback">Telefone inválido</div>
      </div>
    </div>
  </div>
</div>

<div class="col-lg-4 col-sm-4 col-12">
  <div class="card mb-3">
    <div class="card-body">
      <div class="m-0">
        <label class="form-label">Setor de Posição</label>
        <select class="form-select" name="sector_id" id="sector_id">
         <option value="">Selecione uma disciplinas</option>
         <?php foreach ($setores as $key => $value) {?>
            <option <?php if(isset($colaborador->setor_id) && $colaborador->setor_id == $value->id) { echo 'selected'; } ?> value="<?=$value->id?>"><?=$value->nome?></option>
          <? } ?>
        </select>
      </div>
   </div>
  </div>
</div>

<div class="col-lg-12 col-sm-12 col-12">
  <div class="card mb-3">
    <div class="card-body">
      <div class="m-0">
        <label class="form-label">Endereço</label>
        <input type="text" step="0" min="1" class="form-control" name="address" placeholder="Ex.: Rua Antônio Cornélio, 123" value="<?=$pessoa_fisica->endereco ?? ''?>" />
      </div>
    </div>
  </div>
</div>

<div class="col-lg-12 col-sm-12 col-12">
  <div class="card mb-3">
    <div class="card-body">
      <div class="m-0">
        <label class="form-label">Descricao</label>
        <textarea name="description" rows="5" class="form-control" required id=""><?= $colaborador->descricao ?? ''?></textarea>
      </div>
    </div>
  </div>
</div>

<div class="col-xxl-12">
    <div class="card mb-3">
        <div class="card-body">
            <div class="d-flex flex-wrap gap-2 justify-content-end">
              <a href="\admin\colaborators\" class="btn btn-secondary">Cancelar</a>
              <button type="submit" class="btn btn-primary">Salvar</button>
            </div>
        </div>
    </div>
</div>
