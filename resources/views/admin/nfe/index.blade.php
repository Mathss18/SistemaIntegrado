<form class="form-horizontal" method='POST' action="{{route('nfe.store')}}">
        {!! method_field('POST') !!}
        {!! csrf_field() !!}
            <div class="row">
                <div class="form-group col-md-4">
                    <label for="nome">Nome do Produto</label>
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-address-card"></i>
                        </div>
                        <input required id="nome" name="nome" type="text" class="form-control">
                    </div>
                </div>


            </div>

            <div class="form-group">
                <button name="submit" type="submit" class="btn btn-primary">Confirmar</button>
            </div>

        </form>