@extends('layouts.admin')

@section('title')
<title>Daftar Pesanan</title>
@endsection

@section('content')
<main class="main">
  <ol class="breadcrumb">
    <li class="breadcrumb-item">Home</li>
    <li class="breadcrumb-item active">Orders</li>
  </ol>
  <div class="container-fluid">
    <div class="animated fadeIn">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <h4 class="card-title">
                Daftar Pesanan
              </h4>
            </div>
            <div class="card-body">
              @if (session('success'))
              <div class="alert alert-success">{{ session('success') }}</div>
              @endif

              @if (session('error'))
              <div class="alert alert-danger">{{ session('error') }}</div>
              @endif



              <!-- TABLE UNTUK MENAMPILKAN DATA ORDER -->
              <div class="table-responsive">
                <table class="table table-hover table-bordered">
                  <thead>
                    <tr>
                      <th>InvoiceID</th>
                      <th>Pelanggan</th>
                      <th>Subtotal</th>
                      <th>Tanggal</th>
                      <th>Status</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse ($orders as $row)
                    <tr>
                      <td><strong>{{ $row->invoice }}</strong></td>
                      <td>
                        <strong>{{ $row->customer_name }}</strong><br>
                        <label><strong>Telp:</strong> {{ $row->customer_phone }}</label><br>
                        <label><strong>Alamat:</strong> {{ $row->customer_address }} </label>
                      </td>
                      <td>Rp {{ number_format($row->subtotal) }}</td>
                      <td>{{ $row->created_at->format('d-m-Y') }}</td>
                      <td>{!! $row->status_label !!}</td>
                      <td>
                        <form action="{{ route('orders.destroy', $row->id) }}" method="post">
                          @csrf
                          @method('DELETE')
                          <a href="{{ route('orders.view', $row->invoice) }}" class="btn btn-warning btn-sm">Lihat</a>
                          <button class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                      </td>
                    </tr>
                    @empty
                    <tr>
                      <td colspan="6" class="text-center">Tidak ada data</td>
                    </tr>
                    @endforelse
                  </tbody>
                </table>
              </div>
              {!! $orders->links() !!}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
@endsection