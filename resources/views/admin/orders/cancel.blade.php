@extends('layouts.admin')

@section('content')
<div class="content">
    <div class="row">
        <div class="col-lg-6">
            <div class="card card-default">
                <div class="card-header card-header-border-bottom">
                    <h2>Dibatalkan Pesanan #{{ $order->code }}</h2>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.orders.cancelUpdate', $order->id) }}" method="post">
                        @csrf 
                        @method('put')
                    <div class="form-group">
                        <label for="cancellation note">Catatan Dibatalkan</label>
                        <textarea name="cancellation_note" class="form-control" cols="30" rows="10"></textarea>
                        @error('cancellation_note')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-footer pt-5 border-top">
                        <button type="submit" class="btn btn-primary btn-default">Cancel Pesanan</button>
                        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary btn-default">Kembali</a>
                    </div>
                    </form>
                </div>
            </div>  
        </div>
        <div class="col-lg-6">
            <div class="card card-default">
                <div class="card-header card-header-border-bottom">
                    <h2>Detail Pesanan</h2>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-6 col-lg-6">
                            <p class="text-dark mb-2" style="font-weight: normal; font-size:16px; text-transform: uppercase;">Alamat Pengiriman</p>
                            <address>
                                {{ $order->customer_first_name }} {{ $order->customer_last_name }}
                                <br> {{ $order->customer_address1 }}
                                <br> {{ $order->customer_address2 }}
                                <br> Email: {{ $order->customer_email }}
                                <br> No. Telp: {{ $order->customer_phone }}
                                <br> Kode Pos: {{ $order->customer_postcode }}
                            </address>
                        </div>
                        <div class="col-xl-6 col-lg-6">
                            <p class="text-dark mb-2" style="font-weight: normal; font-size:16px; text-transform: uppercase;">Detail Pesanan</p>
                            <address>
                                    ID: <span class="text-dark">#{{ $order->code }}</span>
                                <br> Tanggal: <span>{{ $order->order_date }}</span>
                                <br>
                                Catatan: <span>{{ $order->note }}</span>
                                <br> Status: {{ $order->status }} {{ $order->cancelled_at }}
                                    <br> Catatan Dibatalkan : {{ $order->cancellation_note}}
                                <br> Status Pembayaran: {{ $order->payment_status }}
                                <br> Dikirim Oleh: {{ $order->shipping_service_name }}
                        </div>
                    </div>
                    <table class="table mt-3 table-striped table-responsive table-responsive-large" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Item</th>
                                <th>Qty</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($order->orderItems as $item)
                                <tr>
                                    <td>{{ $item->sku }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->qty }}</td>
                                    <td>{{ $item->sub_total }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6">Tidak ada Pesanan!</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="row justify-content-end">
                        <div class="col-lg-5 col-xl-6 col-xl-3 ml-sm-auto">
                            <ul class="list-unstyled mt-4">
                                <li class="mid pb-3 text-dark">Subtotal
                                    <span class="d-inline-block float-right text-default">{{ $order->base_total_price }}</span>
                                </li>
                                <!-- <li class="mid pb-3 text-dark">Tax(10%)
                                    <span class="d-inline-block float-right text-default">{{ $order->tax_amount }}</span>
                                </li>
                                 -->
                                <li class="mid pb-3 text-dark">Ongkos Kirim
                                    <span class="d-inline-block float-right text-default">{{ $order->shipping_cost }}</span>
                                </li>
                                <li class="pb-3 text-dark">Total
                                    <span class="d-inline-block float-right">{{ $order->grand_total }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection