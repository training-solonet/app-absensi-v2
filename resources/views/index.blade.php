@extends('layouts.app')

@section('content')
<h3>SISWA AKTIF</h3>
<p>Hanya menampilkan data siswa yang aktif</p>

<table class="table table-bordered table-striped">
  <thead>
    <tr>
      <th>No</th>
      <th>Name</th>
      <th>ID Card</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($siswa as $index => $item)
      <tr>
        <td>{{ $index + 1 }}</td>
        <td>{{ $item->name }}</td>
        <td>{{ $item->id_card }}</td>
      </tr>
    @endforeach
  </tbody>
</table>
@endsection
