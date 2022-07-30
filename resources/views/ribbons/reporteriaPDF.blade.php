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
            var rollos = @json($rollos);
            console.log(rollos);
            for(i = 0; i < rollos.length; i++)
            {
                var medidaId = rollos[i].medida;
                var providerId = rollos[i].proveedor;
                var cintilla = '';

                $('#medida' + medidaId + providerId).text(rollos[i].cantidad);
                
                (rollos[i].cintilla == null) ? cintilla = 'S/P'
                    : cintilla = 'C/P';

                $('#pestania'   + medidaId + providerId).text(cintilla);
            }
            window.print();
        }
    </script>
    <table class="table table-striped my-4" id="tabla">
        <thead class="bg-info">
            <tr>
                <th scope="col">Tamaño</th>            
                <th>Total de piezas</th>
                <th>Total (KG)</th>
                @foreach ($providers as $provider)
                    <th>{{$provider->nombreEmpresa}}</th>
                    <th>Pestaña</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($medidas as $medida)
                <tr>
                    <th>{{$medida->alias}}</th>       
                    <td>{{$medida->total_de_piezas}}</th>
                    <td>{{round($medida->total_kg, 4)}}</th>
                    @foreach ($providers as $provider)
                        <td id="medida{{$medida->id . $provider->id}}"></td>
                        <td id="pestania{{$medida->id . $provider->id}}"></td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
        {{--<tfoot class="bg-info">
            <tr>
                <td></td>
                <th>{{$sumaDeTotales[0]->suma_total_piezas}}</th>
                <th>{{$sumaDeTotales[0]->suma_total_peso}}</th>
                @foreach($totalesDeProveedores as $total)
                    <th>{{$total->cantidad}}</th>
                    <th></th>
                @endforeach
            </tr>
        </tfoot>--}}
        <script type="text/javascript">   
            insertar();
        </script>
    </table>
</body>
</html>