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
            var cantidadesBolsas = @json($cantidadesBolsas);

            for(i = 0; i < cantidadesBolsas.length; i++)
            {
                var tipoUnidad = cantidadesBolsas[i].tipoUnidad;
                
                //Eliminamos los caracteres de espacio y el diagonal ya que los id's de html no pueden contener dichos caracteres
                var medida = cantidadesBolsas[i].medida.replace(/ /g, "");
                var medida = medida.replace('/', "");
                
                //Redondeamos la suma_cantidad a un máximo de 4 decimales
                var suma_cantidad = Math.round(cantidadesBolsas[i].suma_cantidad * 10000) / 10000;                

                $('#' + tipoUnidad + medida).text(suma_cantidad);
            }
            window.print();
        }
    </script>
    <table class="table table-striped my-4" id="tabla">
        <thead class="bg-info">
            <tr style="text-align: center;">
                @foreach( $medidasBolsas as $medidaBolsa )
                    <th colspan="2">{{ $medidaBolsa->medida }}</th>                 
                @endforeach
            </tr>
            <tr style="text-align: center;">
                @for( $i = 0; $i < count($medidasBolsas); $i++ )
                    <th>MILLAR</th>
                    <th>CIENTO</th>                
                @endfor
            </tr>
        </thead>
        <tbody id="tabla">
            <tr style="text-align: center;">
            @foreach( $medidasBolsas as $medidaBolsa )
                @php
                    //Eliminamos los caracteres de espacio y el diagonal ya que los id's de html no pueden contener dichos caracteres
                    $medida = str_replace(' ', '', $medidaBolsa->medida);
                    $medida = str_replace('/', '', $medida);
                @endphp
                <td id="MILLAR{{ $medida }}"></td>
                <td id="CIENTO{{ $medida }}"></td>
            @endforeach
            </tr>
        </tbody>
    </table>

    <script type="text/javascript">   
        insertar();
    </script>
</body>
</html>