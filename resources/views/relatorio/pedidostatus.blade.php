<div>

    <div style="font-size: x-large;text-align: center;">
        <h2>Pedidos por Status</h2>
    </div>

    <div>
        <table border="1" style="border: thin;width: 100%;border-collapse: collapse">
            <thead>
            <tr style="text-align: center">
                <td><strong>Status</strong></td>
                <td><strong>Quantidade</strong></td>
            </tr>
            </thead>
            <tbody>
                @foreach($pedido as $p)
                    <tr>
                        <td>{{$p->status}}</td>
                        <td style="text-align: center">{{$p->quantidade_pedidos}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
