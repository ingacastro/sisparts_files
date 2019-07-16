<style type="text/css" media="all">
  #title {
    text-align: center;
  }
  table {
      width: 100%;
      border: solid 1px #DDEEEE;
      border-collapse: collapse;
      border-spacing: 0;
      font: normal 13px Arial, sans-serif;
  }
  table thead th {
      background-color: #DDEFEF;
      border: solid 1px #DDEEEE;
      color: #336B6B;
      padding: 10px;
      text-align: left;
      text-shadow: 1px 1px 1px #fff;
  }
  table tbody td {
      border: solid 1px #DDEEEE;
      color: #333;
      padding: 10px;
      text-shadow: 1px 1px 1px #fff;
  }
  /*BarryVdh css*/
  .page-break {
      page-break-after: always;
  }
</style>
<h1 id="title">Reporte de Cotizaciones</h1>
<table>
  <thead>
    <tr>
      <th>Fecha recibida</th>
      <th>Fecha enviada</th>
      <th>Tiempo de respuesta (días)</th>
      <th>Empresa</th>
      <th>Folio</th>
      <th>Referencia</th>
      <th>Cotizador</th>
      <th>Cliente</th>
      <th>Items cotizados</th>
      <th>Estatus</th>
      <th>No. CTZ</th>
    </tr>
  </thead>
  <tbody>
    @foreach($pcts as $pct)
      <tr>
        <td>{{ $pct->sync_date }}</td>
        <td>{{ $pct->send_date }}</td>
        <td>{{ $pct->elapsed_days }}</td>
        <td>{{ $pct->company }}</td>
        <td>{{ $pct->number }}</td>
        <td>{{ $pct->reference }}</td>
        <td>{{ $pct->dealership }}</td>
        <td>{{ $pct->customer }}</td>
        <td>{{ $pct->ctz_supplies }}</td>
        <td>{{ $pct->status }}</td>
        <td>{{ $pct->siavcom_ctz_number }}</td>
      </tr>
    @endforeach
  </tbody>
</table>
<div class="page-break"></div>
<h1 id="title">Cotizaciones por cotizador y empresa</h1>
<table>
  <thead>
    <tr>
      <th>Cotizador</th>
      <th>Empresa</th>
      <th>Cotizaciones</th>
    </tr>
  </thead>
  <tbody>
    @foreach($matrix as $entry)
      <tr>
        <td>{{ $entry->dealership }}</td>
        <td>{{ $entry->connection }}</td>
        <td>{{ $entry->amount }}</td>
      </tr>
    @endforeach
  </tbody>
</table>
