<div class="modal fade bs-modal" id="edit_set_modal" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title" id="edit_set_modal_title"></h4>
            </div>
            <div class="modal-body">
                <div id="error_messages"></div>
                <div id="success_message"></div>
                {{-- <input type="hidden" name="document_id" id="document_id"> --}}
                <div class="tabbable-line boxless tabbable-reversed">
                    <ul class="nav nav-tabs" id="">
                        <li class="active">
                            <a href="#tab_budget_content" id="tab_0" data-toggle="tab"> Presupuesto </a>
                        </li>
                        <li>
                            <a href="#tab_conditions_content" id="tab_1" data-toggle="tab"> Condiciones </a>
                        </li>
                        <li>
                            <a href="#tab_files_content" id="tab_2" data-toggle="tab"> Archivos </a>
                        </li>
                    </ul>
                    <div class="tab-content" style="padding-top: 2px">
                        <div class="tab-pane active" id="tab_budget_content"></div>
                        <div class="tab-pane " id="tab_conditions_content"></div>
                        <div class="tab-pane " id="tab_files_content"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>