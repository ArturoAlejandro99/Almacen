@extends('layouts.tablaIndexSinAgregar')

@section('title', 'Reporte bobinas')

@section('imgUrl',  asset('images/bobina.svg'))

@section('namePage', 'Reporte de almacen de bobinas')

@section('table')
    <script type="text/javascript">   
        function insertar()
        {
            var bobinas = @json($bobinas);
            for(i = 0; i < bobinas.length; i++)
            {
                var medidaId = bobinas[i].medida;
                var providerId = bobinas[i].proveedor;
                $('#medida' + medidaId + providerId).text(bobinas[i].cantidad);
                $('#peso'   + medidaId + providerId).text( bobinas[i].peso);
            }
            console.log(bobinas);

        }

    function exportTableToExcel(tableID, filename = ''){
        var downloadLink;
        var dataType = 'application/vnd.ms-excel';
        var tableSelect = document.getElementById(tableID);
        var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
        // Specify file name
        filename = 'excel_data.xls';
        
        // Create download link element
        downloadLink = document.createElement("a");
        
        document.body.appendChild(downloadLink);
        
        if(navigator.msSaveOrOpenBlob){
            var blob = new Blob(['ufeff', tableHTML], {
                type: dataType
            });
            navigator.msSaveOrOpenBlob( blob, filename);
        }else{
            console.log(tableHTML);
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
        <a href="{{ route('coil.reporteriaPDF') }}" class="mx-2"><img src="{{asset('images/pdf.svg')}}" class="iconoTitle"></a>
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
                    <th>Peso (KG)</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($medidas as $medida)
                <tr>
                    <th>{{$medida->alias}}</th>       
                    <td>{{$medida->total_de_piezas}}</td>
                    <td>{{round($medida->total_kg, 2)}}</td>
                    @foreach ($providers as $provider)
                        <td id="medida{{$medida->id . $provider->id}}"></th>
                        <td id="peso{{$medida->id . $provider->id}}"></th>
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
                    <th>{{round($total->peso),2}}</th>
                @endforeach
            </tr>
        </tfoot>--}}
        <script type="text/javascript">   
            insertar();
        </script>
    </table>
@endsection