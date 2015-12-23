  <!-- START REGISTER POPUP -->
<div class="modal fade bs-example-modal-sm2" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title"><?=$data["language_data"]["val64"]?></h4>
        </div>
        <div class="modal-body">
          <div class="selectoptionspopup">
          	<input type="text" class="form-control selectoptionspopup-item" value="option" />
          </div>
          <a href="javascript:void(0)" class="selectoptionspopup-item-add" style="margin-top:5px;"><?=$data["language_data"]["val27"]?></a>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><?=$data["language_data"]["val33"]?></button>
          <button type="button" class="btn btn-primary insert-options"><?=$data["language_data"]["val65"]?></button>
        </div>
    </div>
  </div>
</div>
<!-- END REGISTER POPUP -->

<!-- START REGISTER POPUP -->
<div class="modal fade bs-example-modal-sm3" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title"><?=$data["language_data"]["val66"]?></h4>
        </div>
        <div class="modal-body">
          <div class="selectoptionspopup3">
          	<input type="text" class="form-control selectoptionspopup3-item" value="Text" />
          </div>
          <a href="javascript:void(0)" class="selectoptionspopup3-item-add" style="margin-top:5px;"><?=$data["language_data"]["val27"]?></a>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><?=$data["language_data"]["val33"]?></button>
          <button type="button" class="btn btn-primary insert-checkbox-options"><?=$data["language_data"]["val65"]?></button>
        </div>
    </div>
  </div>
</div>
<!-- END REGISTER POPUP -->

<!-- START REGISTER POPUP -->
<div class="modal fade" id="bs-example-modal-sm4" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title"><?=$data["language_data"]["val67"]?></h4>
        </div>
        <div class="modal-body ">
			<div class="form-group">
				<label><?=$data["language_data"]["val68"]?></label>
				<select class="form-control" id="database-option-list">
					<option></option>
				</select>
			</div>

			<div class="form-group">
				<label><?=$data["language_data"]["val70"]?></label>
				<select class="form-control" id="column-type">
					<option value="int">Int (11)</option>
					<option value="varchar">Varchar (255)</option>
					<option value="text">Text</option>
					<option value="longtext">Long Text</option>
				</select>
			</div>

			<div class="form-group thedbcolumnname">
				<label><?=$data["language_data"]["val69"]?> (a-z)</label>
				<input type="text" class="form-control" value="" id="column-name" onkeyup="bindName(this, 'thedbcolumnname')" />
			</div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><?=$data["language_data"]["val33"]?></button>
          <button type="button" class="btn btn-primary add-database-button"><?=$data["language_data"]["val27"]?></button>
        </div>
    </div>
  </div>
</div>
<!-- END REGISTER POPUP -->

<!-- START REGISTER POPUP -->
<div class="modal fade bs-example-modal-sm5" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title"><?=$data["language_data"]["val67"]?></h4> 
        </div>
        <div class="modal-body">
			<div class="form-group">
				<label><?=$data["language_data"]["val70"]?></label>
				<select class="form-control" id="edit-column-type" disabled="disabled">
					<option value="1">Int (11)</option>
					<option value="2">Varchar (255)</option>
					<option value="3">Text</option>
					<option value="4">Long Text</option>
				</select>
			</div>

			<div class="form-group thedbcolumnname">
				<label><?=$data["language_data"]["val69"]?> (a-z)</label>
				<input type="text" class="form-control" value="" id="edit-column-name" data-editcolumndatatype="" data-editcolumnnameold="" onkeyup="bindName(this, 'thedbcolumnname')" />
			</div>

			<div class="form-group">
				<label><?=$data["language_data"]["val71"]?></label>
				<select class="form-control" id="edit-action">
					<option value="edit"><?=$data["language_data"]["val74"]?></option>
					<option value="delete"><?=$data["language_data"]["val73"]?></option>
				</select>
			</div> 

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><?=$data["language_data"]["val33"]?></button>
          <button type="button" class="btn btn-primary edit-database-button"><?=$data["language_data"]["val72"]?></button>
        </div>
    </div>
  </div>
</div>
<!-- END REGISTER POPUP -->