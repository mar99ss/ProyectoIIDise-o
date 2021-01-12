<div id="reserveModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="posiciones-modal-content modal-content">
            <div class="modal-body">
                <h4 class="modal-title nunito-bold d-flex justify-content-center">Posiciones en Jerarquía </h4>
                <div class="row d-flex justify-content-center">
                    <div class="boxPosiciones mt-4 my-custom-scrollbarPosiciones">

                        <table class="table table-hove tableFixHead">
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col">Nivel</th>
                                <th scope="col">Rol</th>
                                <th scope="col">Cambio</th>
                            </tr>
                            <tr id="templatePosicionesJerarquia" class="d-none">
                                <th scope="row" class="nivel"></th>
                                <td class="rol">Rol</td>
                                <td>
                                    <button type="button" class="btn btn-primary btn-green-moon">
                                        Cambiar
                                    </button>
                                </td>
                            </tr>
                            </thead>
                            <tbody id="posicionesJerarquiaBody">
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="d-flex justify-content-end">
                    <button type="button" class="btn btn-secondary btn-green-moon" data-dismiss="modal">Salir</button>
                </div>

            </div>
        </div>
    </div>
</div>
@include('partials.cambio-jerarquia')

<script>
    function showModalPosicionesJerarquia(miembro) {

        $.ajax('/rolesMiembros/' + miembro.componente_id)
            .done(function (respuesta) {
                mostrarConDatos(respuesta, miembro);
            });

    }

    function mostrarConDatos(data, miembro) {

        const body = $("#posicionesJerarquiaBody");
        body.html("");

        data.forEach(function (rol) {
            const template = $("#templatePosicionesJerarquia").clone();
            template.removeClass("d-none");

            const boton = template.find("button")[0];

            $(boton).click(function () {
                showCambioJerarquiaModal(rol, miembro);
            });

            $(template.find(".nivel")[0]).html(rol[0].nombre);
            $(template.find(".rol")[0]).html(rol[1].replace(/^\w/, (c) => c.toUpperCase()));

            body.append(template);
        });

        $('#reserveModal').modal('show');
    }
</script>
