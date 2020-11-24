@extends('adminlte::page')

@section('title', 'Fornecedores')

@section('content_header')
@stop

@section('css')
@stack('css')
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
@stop


@if(isset($fornecedor))
    @section('js')
        <script>
                $("#uf>option[value={{$fornecedor->uf}}]").attr("selected", true);
        </script>
    @stop
@endif

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.js"></script>
<script src="{{ asset('js/cepForne.js') }}"></script>

<script>
    $(document).ready(function() {
        $('#cep').mask('00000-000');
        $('#telefone').mask('(00) 0000-0000');
        $('#telefone2').mask('(00) 00000-0000');
        $('#cpf').mask('000.000.000-00', {
            reverse: true
        });
        $('#rg').mask('00.000.000-00', {
            reverse: true
        });
    });
        
</script>
@stop
<!------ Include the above in your HEAD tag ---------->
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-5">
            <hr>
        </div>
        <div class="col-auto">Informações Pessoais e Contato</div>
        <div class="col">
            <hr>
        </div>
    </div>

    @if(!isset($fornecedor))
    <form class="form-horizontal" method='POST' action="{{route('fornecedor.store')}}">
        {!! method_field('POST') !!}
        {!! csrf_field() !!}
    @elseif(isset($fornecedor))
    <form class="form-horizontal" method='POST' action="{{route('fornecedor.update',$fornecedor->ID_fornecedor)}}">
        {!! method_field('PUT') !!}
        {!! csrf_field() !!}
    @endif
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="nome">Nome</label>
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-address-card"></i>
                        </div>
                        <input required id="nome" name="nome" type="text" class="form-control" value="{{$fornecedor->nome ?? '' }}">
                    </div>
                </div>

                <div class="form-group col-md-5">
                    <label for="email">Email</label>
                    <div class="input-group">
                        <div class="input-group-addon ">
                            <i class="fa fa-envelope"></i>
                        </div>
                        <input id="email" name="email" type="text" class="form-control" value="{{$fornecedor->email ?? '' }}">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-6">
                    <label for="cpf_cnpj">CPF / CNPJ</label>
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-wpforms"></i>
                        </div>
                        <input id="cpf_cnpj" name="cpf_cnpj" type="text" class="form-control" value="{{$fornecedor->cpf_cnpj ?? '' }}">
                    </div>
                </div>

                <div class= "form-group col-md-5">
                    <label for="contato">Contato</label>
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-address-book"></i>
                        </div>
                        <input id="contato" name="contato" type="text" class="form-control" value="{{$fornecedor->contato ?? '' }}">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-5">
                    <hr>
                </div>
                <div class="col-auto">Informações de Endereço</div>
                <div class="col">
                    <hr>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-4">
                    <label for="logradouro">Rua</label>
                    <input id="rua" name="logradouro" type="text" class="form-control" value="{{$fornecedor->logradouro ?? '' }}">
                </div>
                <div class="form-group col-md-4">
                    <label for="cidade">Cidade</label>
                    <input id="cidade" name="cidade" type="text" class="form-control" value="{{$fornecedor->cidade ?? '' }}">
                </div>
                <div class="form-group col-md-3">
                    <label for="numero">Número</label>
                    <input id="numero" name="numero" type="text" class="form-control" value="{{$fornecedor->numero ?? '' }}">
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-4">
                    <label for="cep">CEP</label>
                    <div class="input-group">
                        <input id="cep" name="cep" type="text" class="form-control" size="10" maxlength="9" value="{{$fornecedor->cep ?? '' }}">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="button" onclick="pesquisacep(cep.value);">Pesquisar</button>
                        </div>
                    </div>
                </div>

                <div class="form-grou col-md-4">
                    <label for="bairro">Bairro</label>
                    <input id="bairro" name="bairro" type="text" class="form-control" value="{{$fornecedor->bairro ?? '' }}">
                </div>

                <div class="form-group col-md-3">
                    <label for="uf">Estado</label>
                    <div>
                        <select id="uf" name="uf" class="custom-select">
                            <option value="AC">Acre</option>
                            <option value="AL">Alagoas</option>
                            <option value="AP">Amapá</option>
                            <option value="AM">Amazonas</option>
                            <option value="BA">Bahia</option>
                            <option value="CE">Ceará</option>
                            <option value="DF">Distrito Federal</option>
                            <option value="ES">Espírito Santo</option>
                            <option value="GO">Goiás</option>
                            <option value="MA">Maranhão</option>
                            <option value="MT">Mato Grosso</option>
                            <option value="MS">Mato Grosso do Sul</option>
                            <option value="MG">Minas Gerais</option>
                            <option value="PA">Pará</option>
                            <option value="PB">Paraíba</option>
                            <option value="PR">Paraná</option>
                            <option value="PE">Pernambuco</option>
                            <option value="PI">Piauí</option>
                            <option value="RJ">Rio de Janeiro</option>
                            <option value="RN">Rio Grande do Norte</option>
                            <option value="RS">Rio Grande do Sul</option>
                            <option value="RO">Rondônia</option>
                            <option value="RR">Roraima</option>
                            <option value="SC">Santa Catarina</option>
                            <option value="SP">São Paulo</option>
                            <option value="SE">Sergipe</option>
                            <option value="TO">Tocantins</option>
                            <option value="EX">Estrangeiro</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-4">
                    <label for="telefone">Telefone</label>
                    <input id="telefone" name="telefone" type="text" class="form-control" value="{{$fornecedor->telefone ?? '' }}">
                </div>
                <div class="form-group col-md-4">
                    <label for="telefone2">Celular</label>
                    <input id="telefone2" name="telefone2" type="text" class="form-control" value="{{$fornecedor->telefone2 ?? '' }}">
                </div>
                <div class="form-group col-md-3">
                    <label for="inscricao_estadual">Inscrição Estadual</label>
                    <input id="inscricao_estadual" name="inscricao_estadual" type="text" class="form-control" value="{{$fornecedor->inscricao_estadual ?? '' }}">
                </div>
            </div>
            <div class="form-group">
                <button name="submit" type="submit" class="btn btn-primary">Confirmar</button>
            </div>

        </form>
</div>
@stop