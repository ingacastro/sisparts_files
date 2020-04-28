@forelse ($global_supplier_manufacturers as $global_supplier_manufacturer)
<tr>
    <td>{{ $global_supplier_manufacturer->id }}</td>
    <td>{{ $global_supplier_manufacturer->name }}</td>
    <td>
        <button type="button" class="delete-r btn btn-sm btn-danger" data-id="{{$global_supplier_manufacturer->manufacturer_id}}">Eliminar</button>
    </td>
</tr>
@empty
    <tr>
        <td colspan="3" style="text-align: center;"> Ningún dato disponible en esta tabla </td>
    </tr>
@endforelse