<div>

    <div style="font-size: x-large;text-align: center;">
        <h2>Total de Marmitas do Dia {{$mesRelatorio}}</h2>
    </div>

    <div>
        <table border="1" style="border: thin;width: 100%;border-collapse: collapse">
            <thead>
            <tr style="text-align: center">
                <td><strong>Quantidade</strong></td>
                <td><strong>Total (R$)</strong></td>
            </tr>
            </thead>
            <tbody>
                @foreach($marmitas as $m)
                    <tr style="text-align: center">
                        <td>{{$m->quantidade}}</td>
                        <td>{{isset($m->total) ? $m->total : '0.00'}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
