<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script type="text/javascript" src="//cdn.jsdelivr.net/jquery/1/jquery.min.js"></script>
    <script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
    <style>
    body { -webkit-print-color-adjust: exact; }

    table{
        width: 100%;
        border-spacing: 0px;
    }
    .bigWidth{
        width: 120px;
    }

    .smallWidth{
        width: 80px;
        padding-left: 6px;
    } 

    th{
        background-color: #3490dc;
        height: 25px;
        text-align: left;
    } 

    tr:nth-child(even){
        background-color: rgba(0, 0, 0, 0.05);
    }  
    </style>
</head>
<body>
    <script type="text/javascript">   
        function insertar()
        {
            var bobinas = @json($bobinas);
            for(i = 0; i < bobinas.length; i++)
            {
                var medidaId = bobinas[i].medida;
                var providerId = bobinas[i].proveedor;
                if(bobinas[i].cantidad == null)
                    $('#medida' + medidaId + providerId).text('-');    
                else
                    $('#medida' + medidaId + providerId).text(bobinas[i].cantidad);
                $('#peso'   + medidaId + providerId).text(Math.round(bobinas[i].peso * 100) / 100);
            }
            console.log(bobinas);
            window.print();
            
        }
    </script>
    <table class="table table-striped my-4" id="tabla">
        <thead class="bg-info">
            <tr>
                <th scope="col" class="smallWidth">Tamaño</th>            
                <th class="smallWidth">Total de piezas</th>
                <th class="smallWidth">Total (KG)</th>
                @foreach ($providers as $provider)
                    <th class="bigWidth">{{$provider->nombreEmpresa}}</th>
                    <th class="smallWidth">Peso (KG)</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($medidas as $medida)
                <tr>
                    <th class="smallWidth">{{$medida->alias}}</th>       
                    <td class="bigWidth">{{$medida->total_de_piezas}}</td>
                    <td class="smallWidth">{{round($medida->total_kg, 4)}}</td>
                    @foreach ($providers as $provider)
                        <td class="smallWidth" id="medida{{$medida->id . $provider->id}}"></th>
                        <td class="smallWidth" id="peso{{$medida->id . $provider->id}}"></th>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
        {{--<tfoot class="bg-info">
            <tr>
                <td class="smallWidth">_</td>
                <th class="bigWidth">{{$sumaDeTotales[0]->suma_total_piezas}}</th>
                <th class="smallWidth">{{$sumaDeTotales[0]->suma_total_peso}}</th>
                @foreach($totalesDeProveedores as $total)
                    <th class="bigWidth">{{$total->cantidad}}</th>
                    <th class="smallWidth">{{$total->peso}}</th>
                @endforeach
            </tr>
        </tfoot>--}}
        <script type="text/javascript">   
            insertar();
        </script>
    </table>
</body>
</html>