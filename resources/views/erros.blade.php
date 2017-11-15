@if($errors->any())
    <div class="col-md-10 col-md-offset-1">
        <div class="box alert alert-danger">
            <div class="box-header with-border">
                <h3 class="box-title" style="color:white">Favor preencher os campos corretamente!</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool"
                            data-widget="remove" data-toggle="tooltip" title="Fechar">
                        <i class="fa fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="box-body">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endif