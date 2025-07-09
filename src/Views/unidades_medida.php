<?= $this->include('julio101290\boilerplate\Views\load\select2') ?>
<?= $this->include('julio101290\boilerplate\Views\load\datatables') ?>
<?= $this->include('julio101290\boilerplate\Views\load\nestable') ?>
<!-- Extend from layout index -->
<?= $this->extend('julio101290\boilerplate\Views\layout\index') ?>

<!-- Section content -->
<?= $this->section('content') ?>

<?= $this->include('modulesUnidades_medida/modalCaptureUnidades_medida') ?>

<!-- SELECT2 EXAMPLE -->
<div class="card card-default">
    <div class="card-header">
        <div class="float-right">
            <div class="btn-group">

                <button class="btn btn-primary btnAddUnidades_medida" data-toggle="modal" data-target="#modalAddUnidades_medida"><i class="fa fa-plus"></i>

                    <?= lang('unidades_medida.add') ?>

                </button>

            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table id="tableUnidades_medida" class="table table-striped table-hover va-middle tableUnidades_medida">
                        <thead>
                            <tr>

                                <th>#</th>
                                <th><?= lang('unidades_medida.fields.idEmpresa') ?></th>
                                <th><?= lang('unidades_medida.fields.descripcion') ?></th>
                                <th><?= lang('unidades_medida.fields.created_at') ?></th>
                                <th><?= lang('unidades_medida.fields.updated_at') ?></th>
                                <th><?= lang('unidades_medida.fields.deleted_at') ?></th>

                                <th><?= lang('unidades_medida.fields.actions') ?> </th>

                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.card -->

<?= $this->endSection() ?>


<?= $this->section('js') ?>
<script>

    /**
     * Cargamos la tabla
     */

    var tableUnidades_medida = $('#tableUnidades_medida').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        autoWidth: false,
        order: [[1, 'asc']],

        ajax: {
            url: '<?= base_url('admin/unidades_medida') ?>',
            method: 'GET',
            dataType: "json"
        },
        columnDefs: [{
                orderable: false,
                targets: [6],
                searchable: false,
                targets: [6]

            }],
        columns: [{
                'data': 'id'
            },

            {
                'data': 'nombreEmpresa'
            },

            {
                'data': 'descripcion'
            },

            {
                'data': 'created_at'
            },

            {
                'data': 'updated_at'
            },

            {
                'data': 'deleted_at'
            },

            {
                "data": function (data) {
                    return `<td class="text-right py-0 align-middle">
                         <div class="btn-group btn-group-sm">
                             <button class="btn btn-warning btnEditUnidades_medida" data-toggle="modal" idUnidades_medida="${data.id}" data-target="#modalAddUnidades_medida">  <i class=" fa fa-edit"></i></button>
                             <button class="btn btn-danger btn-delete" data-id="${data.id}"><i class="fas fa-trash"></i></button>
                         </div>
                         </td>`
                }
            }
        ]
    });



    $(document).on('click', '#btnSaveUnidades_medida', function (e) {


        var idUnidades_medida = $("#idUnidades_medida").val();
        var idEmpresa = $("#idEmpresa").val();
        var descripcion = $("#descripcion").val();

        $("#btnSaveUnidades_medida").attr("disabled", true);

        var datos = new FormData();
        datos.append("idUnidades_medida", idUnidades_medida);
        datos.append("idEmpresa", idEmpresa);
        datos.append("descripcion", descripcion);


        $.ajax({

            url: "<?= base_url('admin/unidades_medida/save') ?>",
            method: "POST",
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            success: function (respuesta) {
                if (respuesta.match(/Correctamente.*/)) {

                    Toast.fire({
                        icon: 'success',
                        title: "Guardado Correctamente"
                    });

                    tableUnidades_medida.ajax.reload();
                    $("#btnSaveUnidades_medida").removeAttr("disabled");


                    $('#modalAddUnidades_medida').modal('hide');
                } else {

                    Toast.fire({
                        icon: 'error',
                        title: respuesta
                    });

                    $("#btnSaveUnidades_medida").removeAttr("disabled");


                }

            }

        }

        ).fail(function (jqXHR, textStatus, errorThrown) {

            if (jqXHR.status === 0) {

                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "No hay conexión.!" + jqXHR.responseText
                });

                $("#btnSaveUnidades_medida").removeAttr("disabled");


            } else if (jqXHR.status == 404) {

                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Requested page not found [404]" + jqXHR.responseText
                });

                $("#btnSaveUnidades_medida").removeAttr("disabled");

            } else if (jqXHR.status == 500) {

                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Internal Server Error [500]." + jqXHR.responseText
                });


                $("#btnSaveUnidades_medida").removeAttr("disabled");

            } else if (textStatus === 'parsererror') {

                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Requested JSON parse failed." + jqXHR.responseText
                });

                $("#btnSaveUnidades_medida").removeAttr("disabled");

            } else if (textStatus === 'timeout') {

                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Time out error." + jqXHR.responseText
                });

                $("#btnSaveUnidades_medida").removeAttr("disabled");

            } else if (textStatus === 'abort') {

                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Ajax request aborted." + jqXHR.responseText
                });

                $("#btnSaveUnidades_medida").removeAttr("disabled");

            } else {

                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: 'Uncaught Error: ' + jqXHR.responseText
                });


                $("#btnSaveUnidades_medida").removeAttr("disabled");

            }
        })

    });



    /**
     * Carga datos actualizar
     */


    /*=============================================
     EDITAR Unidades_medida
     =============================================*/
    $(".tableUnidades_medida").on("click", ".btnEditUnidades_medida", function () {

        var idUnidades_medida = $(this).attr("idUnidades_medida");

        var datos = new FormData();
        datos.append("idUnidades_medida", idUnidades_medida);

        $.ajax({

            url: "<?= base_url('admin/unidades_medida/getUnidades_medida') ?>",
            method: "POST",
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function (respuesta) {
                $("#idUnidades_medida").val(respuesta["id"]);

                $("#idEmpresa").val(respuesta["idEmpresa"]).trigger("change");
                $("#descripcion").val(respuesta["descripcion"]);


            }

        })

    })


    /*=============================================
     ELIMINAR unidades_medida
     =============================================*/
    $(".tableUnidades_medida").on("click", ".btn-delete", function () {

        var idUnidades_medida = $(this).attr("data-id");

        Swal.fire({
            title: '<?= lang('boilerplate.global.sweet.title') ?>',
            text: "<?= lang('boilerplate.global.sweet.text') ?>",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '<?= lang('boilerplate.global.sweet.confirm_delete') ?>'
        })
                .then((result) => {
                    if (result.value) {
                        $.ajax({
                            url: `<?= base_url('admin/unidades_medida') ?>/` + idUnidades_medida,
                            method: 'DELETE',
                        }).done((data, textStatus, jqXHR) => {
                            Toast.fire({
                                icon: 'success',
                                title: jqXHR.statusText,
                            });


                            tableUnidades_medida.ajax.reload();
                        }).fail((error) => {
                            Toast.fire({
                                icon: 'error',
                                title: error.responseJSON.messages.error,
                            });
                        })
                    }
                })
    })

    $(function () {
        $("#modalAddUnidades_medida").draggable();

    });


</script>
<?= $this->endSection() ?>
        