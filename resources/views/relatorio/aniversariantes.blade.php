<div>

    <div style="font-size: x-large;text-align: center;">
        <h2>Aniversariantes do Mês {{$mes}}</h2>
    </div>

    <div>
        <table border="1" style="border: thin;width: 100%;border-collapse: collapse">
            <thead>
            <tr style="text-align: center">
                <td><strong>Cliente</strong></td>
                <td><strong>Dia</strong></td>
            </tr>
            </thead>
            <tbody>
                @foreach($cliente as $c)
                    <tr>
                        <td>{{$c->nome}}</td>
                        <td style="text-align: center">{{$c->dia}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
