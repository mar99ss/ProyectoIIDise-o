<div id="cambioJerarquiaModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="posiciones-modal-content modal-content">
            <div class="modal-body">
                <h4 class="modal-title nunito-bold d-flex justify-content-center">Cambio</h4>
                <div class="row d-flex justify-content-center">
                    <div class="boxPosiciones mt-4 my-custom-scrollbarPosiciones">
                        <table class="table table-hove tableFixHead">
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col">Nivel</th>
                                <th scope="col">Cambio</th>
                            </tr>
                            <tr id="templateCambioJerarquia" class="d-none">
                                <td scope="row" class="nivel"></td>
                                <td>
                                    <form action="{{ route('miembros.cambiarNivel') }}" method="post">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="viejoNivel">
                                        <input type="hidden" name="nuevoNivel">
                                        <input type="hidden" name="miembro">
                                        <input type="hidden" name="rol">
                                        <button type="submit" class="btn btn-primary btn-green-moon">Cambiar</button>
                                    </form>
                                </td>
                            </tr>
                            </thead>

                            <tbody id="cambioJerarquiaBody">

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="d-flex justify-content-end">
                    <button type="button" class="btn btn-secondary btn-green-moon" data-dismiss="modal">Atrás</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

    function showCambioJerarquiaModal(nivelJerarquico, miembro) {
        console.log(nivelJerarquico);
        console.log(nivelJerarquico[0].componente_id);
        $.ajax('/cambioJerarquico/' + nivelJerarquico[0].componente_id)
            .done((data) => _mostrarConDatos(data, nivelJerarquico, miembro));
    }

    function _mostrarConDatos(data, nivelJerarquico, miembro) {
        const body = $("#cambioJerarquiaBody");
        body.html("");
        console.log(data);
        data.forEach(function (nivelNuevo) {
            const template = $("#templateCambioJerarquia").clone();

            $(template.find("input[name=viejoNivel]")[0]).val(nivelJerarquico[0].componente_id);
            $(template.find("input[name=nuevoNivel]")[0]).val(nivelNuevo.componente_id);
            $(template.find("input[name=miembro]")[0]).val(miembro.componente_id);
            $(template.find("input[name=rol]")[0]).val(nivelJerarquico[1]);
            $(template.find(".nivel")[0]).html(nivelNuevo["nombre"]);

            template.removeClass("d-none");

            body.append(template);
        });

        $('#cambioJerarquiaModal').modal('show');
    }
</script>
