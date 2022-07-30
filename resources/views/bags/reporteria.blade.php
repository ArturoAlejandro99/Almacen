@extends('layouts.tablaIndexSinAgregar')

@section('title', 'Reporte bolsas')

@section('imgUrl',  asset('images/rollo-de-papel.svg'))

@section('namePage', 'Reporte de almacen de bolsas')

@section('table')
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
        }
        
        function exportTableToExcel(tableID, filename = ''){
        var downloadLink;
        var dataType = 'application/vnd.ms-excel';
        var tableSelect = document.getElementById(tableID);
        var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
        
        // Specify file name
        filename = filename?filename+'.xls':'excel_data.xls';
        
        // Create download link element
        downloadLink = document.createElement("a");
        
        document.body.appendChild(downloadLink);
        
        if(navigator.msSaveOrOpenBlob){
            var blob = new Blob(['ufeff', tableHTML], {
                type: dataType
            });
            navigator.msSaveOrOpenBlob( blob, filename);
        }else{
            // Create a link to the file
            downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
        
            // Setting the file name
            downloadLink.download = filename;
            
            //triggering the function
            downloadLink.click();
        }
    }
    </script>
    <div class="mt-3">
        <a href="{{ route('bag.reporteriaPDF') }}" class="mx-2"><img src="{{asset('images/pdf.svg')}}" class="iconoTitle"></a>
        <button class="btn mx-2" onclick="exportTableToExcel('tabla')"><img src="{{asset('images/excel.svg')}}" class="iconoTitle"></button>
    </div>
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
@endsection