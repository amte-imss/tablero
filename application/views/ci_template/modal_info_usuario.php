<div id="divModal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div  class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">
                    <?php
                    if (isset($titulo_modal))
                    {
                        echo $titulo_modal;
                    }
                    ?>
                </h4>
            </div>
            <div class="modal-body">
                <p>
                    <?php
                    if (isset($cuerpo_modal))
                    {
                        echo $cuerpo_modal;
                    }
                    ?>    
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
