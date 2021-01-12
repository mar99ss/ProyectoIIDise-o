<link rel="stylesheet" href="{{ mix('css/ippopup.css') }}">

<div class="modal fade" id="registro" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="ippopup-modal-content modal-content ">
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-3"></div>
                    <div class="col-sm-8">
                        <h4 class="nunito-bold">Registro</h4>
                    </div>
                </div>
                <form method="post" id="registroform">
                    @method('put')
                    @csrf
                    <input type="hidden" name="miembro" id="registromiembro">
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
                            <div class="col-sm-3"><label>Usuario: </label></div>
                            <div class="col-sm-offset-1 col-sm-5">
                                <input class="personalInfo inner-shadow" type="email" id="email"
                                       name="email" placeholder="Correo electrónico">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3"><label>Contraseña: </label></div>
                            <div class="col-sm-offset-1 col-sm-5">
                                <input class="personalInfo inner-shadow" type="password" id="password"
                                       name="password" placeholder="Contraseña">
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
    function showRegistroModal(data = null) {$("#registromiembro").val("");
        $("#registro #identificacion").val("");
        $("#registro #email").val("");
        $("#registro #password").val(""); 

        $("#registro input[name=_method]").val("post");

        $("#registroform").attr("action", "{{route('miembros.create')}}"); 

        $('#registro').modal('show');
    }
</script>