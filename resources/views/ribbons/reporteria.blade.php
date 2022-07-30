@extends('layouts.tablaIndexSinAgregar')

@section('title', 'Reporte rollos')

@section('imgUrl',  asset('images/rollo-de-papel.svg'))

@section('namePage', 'Reporte de almacen de rollos')

@section('table')
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
        <a href="{{ route('ribbon.reporteriaPDF') }}" class="mx-2"><img src="{{asset('images/pdf.svg')}}" class="iconoTitle"></a>
        <button class="btn mx-2" onclick="exportTableToExcel('tabla')"><img src="{{asset('images/excel.svg')}}" class="iconoTitle"></button>
    </div>
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
@endsection