<div>

    <div style="font-size: x-large;text-align: center;">
        <h2>Cardápio do dia</h2>
    </div>

    <div>
        @foreach($item as $i)

            <p>{{$i->descricao}}</p>

        @endforeach

        <br>

    </div>

</div>
