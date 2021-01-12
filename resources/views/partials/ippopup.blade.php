{{-- <link rel="stylesheet" href="{{ mix('css/ippopup.css') }}"> --}}

<div class="modal fade" id="popup" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="ippopup-modal-content modal-content ">
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-3"></div>
                    <div class="col-sm-8">
                        <h4 class="nunito-bold">Informacion personal</h4>
                    </div>
                </div>
                <form method="post" id="ippopupform">
                    @method('put')
                    @csrf
                    <input type="hidden" name="miembro" id="ippopupmiembro">
                    <div class="contenedor-inputs">
                        <img class="d-sm-none d-md-block" src="{{ asset('svg/informacion-personal.svg') }}"
                             alt="info-personal">
                        <div class="row">
                            <div class="col-sm-3"><label>Identificación</label></div>
                            <div class="col-sm-offset-1 col-sm-5">
                                <input class="personalInfo inner-shadow" type="text" id="identificacion"
                                       name="identificacion" placeholder="Identificación">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3"><label>Nombre completo</label></div>
                            <div class="col-sm-offset-1 col-sm-5">
                                <input class="personalInfo inner-shadow" type="text" id="name"
                                       name="nombreCompleto" placeholder="Nombre completo">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3"><label>Telefono</label></div>
                            <div class="col-sm-offset-1 col-sm-5">
                                <input class="personalInfo inner-shadow" type="text" id="phone"
                                       name="telefono" placeholder="Telefono">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3"><label>Email</label></div>
                            <div class="col-sm-offset-1 col-sm-5">
                                <input class="personalInfo inner-shadow" type="email" id="email"
                                       name="email" placeholder="Correo electrónico">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3"><label>Direccion</label></div>
                            <div class="col-sm-offset-1 col-sm-2">
                                <input class="personalInfo inner-shadow" type="text"
                                       id="province" name="provincia" placeholder="Provincia">
                            </div>
                            <div class="col-sm-2">
                                <input class="personalInfo inner-shadow" type="text"
                                       id="canton" name="canton" placeholder="Cantón">
                            </div>
                            <div class="col-sm-2">
                                <input class="personalInfo inner-shadow" type="text"
                                       id="district" name="distrito" placeholder="Distrito">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3"><label>Señas</label></div>
                            <div class="col-sm-offset-1 col-sm-7">
                                <textarea class="personalInfo innerShadow" type="text"
                                          id="sennas"
                                          name="sennas" placeholder="Señas"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3"></div>
                            <div class="col-sm-3">
                                <button type="submit" class="btn btn-primary btn-block">Guardar cambios</button>
                            </div>
                            <div class="col-sm-3 col-sm-offset-1">
                                <button type="button" class="btn btn-secondary btn-block" data-dismiss="modal">Close
                                </button>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function showIppopupModal(data = null) {
        if (data != null) {

            $("#ippopupmiembro").val(data.componente_id);
            $("#popup #identificacion").val(data.identificacion);
            $("#popup #name").val(data.nombreCompleto);
            $("#popup #phone").val(data.telefono);
            $("#popup #email").val(data.email);
            $("#popup #province").val(data.provincia);
            $("#popup #canton").val(data.canton);
            $("#popup #district").val(data.distrito);
            $("#popup #sennas").html(data.sennas);
            $("#popup input[name=_method]").val("put");

            $("#ippopupform").attr("action", "{{route('miembros.edit')}}");
        } else {
            $("#ippopupmiembro").val("");
            $("#popup #name").val("");
            $("#popup #name").val("");
            $("#popup #phone").val("");
            $("#popup #email").val("");
            $("#popup #province").val("");
            $("#popup #canton").val("");
            $("#popup #district").val("");
            $("#popup #sennas").html("");

            $("#popup input[name=_method]").val("post");

            $("#ippopupform").attr("action", "{{route('miembros.create')}}");
        }

        $('#popup').modal('show');
    }
</script>
