<div>

    <div style="font-size: x-large;text-align: center;">
        <h2>Marmitas dos Clientes</h2>
    </div>

    <div>
        <table border="1" style="border: thin;width: 100%;border-collapse: collapse">
            <thead>
            <tr style="text-align: center">
                <td><strong>Cod. Pedido</strong></td>
                <td><strong>Cod. Marmita</strong></td>
                <td><strong>Nome</strong></td>
                <td><strong>Tamanho</strong></td>
                <td><strong>Descrição</strong></td>
            </tr>
            </thead>
            <tbody>
                @foreach($marmitas as $m)
                    <tr style="text-align: center">
                        <td>{{$m->Codigo_Pedido}}</td>
                        <td>{{$m->Codigo_Marmita}}</td>
                        <td>{{$m->nome}}</td>
                        <td>{{$m->tamanho}}</td>
                        {{--@while($m->Codigo_Pedido === $m->Codigo_Marmita)--}}
                            <td>{{$m->descricao}}</td>
                        {{--@endwhile--}}
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
