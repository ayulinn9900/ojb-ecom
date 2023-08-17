@extends('layouts.frontend')

@section('title', 'Checkout Page')

@section('content')
	<!-- header end -->
	<div class="breadcrumb-area pt-205 breadcrumb-padding pb-210" style="background-image: url({{ asset('frontend/assets/img/bg/ayuN.jpg') }})">
		<div class="container">
			<div class="breadcrumb-content text-center">
				<h2>HALAMAN CHECKOUT</h2>
				<ul>
					<li><a href="{{ url('/') }}">home</a></li>
					<li> Halaman Checkout</li>
				</ul>
			</div>
		</div>
	</div>
	<!-- checkout-area start -->
	<div class="checkout-area ptb-100">
		<div class="container">
        <form action="{{ route('checkout') }}" method="post">
            @csrf
			<div class="row">
				<div class="col-lg-6 col-md-12 col-12">
					<div class="checkbox-form">						
						<h3>Alamat Pengiriman</h3>
						<div class="row">
							<div class="col-md-12">
								<div class="checkout-form-list">
									<label>Username <span class="required">*</span></label>
                                    <input type="text" name="username" value="{{ auth()->user()->username }}" placeholder="Username ...">
								</div>
							</div>
							<div class="col-md-6">
								<div class="checkout-form-list">
									<label>Nama Depan <span class="required">*</span></label>
                                    <input type="text" name="first_name" value="{{ auth()->user()->first_name }}" placeholder="Nama Depan ...">
								</div>
							</div>
							<div class="col-md-6">
								<div class="checkout-form-list">
									<label>Nama Belakang <span class="required">*</span></label>
                                    <input type="text" name="last_name" value="{{ auth()->user()->last_name }}" placeholder="Nama Belakang ...">
								</div>
							</div>
							<div class="col-md-12">
								<div class="checkout-form-list">
									<label>Nama Jalan, Gedung, No. Rumah <span class="required">*</span></label>
                                    <input type="text" name="address1" value="{{ auth()->user()->address1 }}" placeholder="Nama Jalan, Gedung, No. Rumah...">
								</div>
							</div>
							<div class="col-md-12">
								<div class="checkout-form-list">
                                <input type="text" name="address2" value="{{ auth()->user()->address2}}" placeholder="Blok/Unit No. Patokan...">
								</div>
							</div>
							<div class="col-md-12">
								<div class="checkout-form-list">
									<label>Provinsi<span class="required">*</span></label>
									<select name="province_id"id="province-id" value="{{ auth()->user()->province_id }}">
											@foreach($provinces as $province => $pro)
											<option {{ auth()->user()->province_id == $province ? 'selected' : null }} value="{{ $province }}">{{ $pro }}</option>
											@endforeach
									</select> 
								</div>
							</div>
							<div class="col-md-6">
								<div class="checkout-form-list">
									<label>Kota<span class="required">*</span></label>
									<select name="city_id" id="city-id" value="{{ auth()->user()->city_id }}" >
											@foreach($cities as $id => $city)
											<option {{ auth()->user()->city_id == $id ? 'selected' : null }} value="{{ $id }}">{{ $city }}</option>
											@endforeach
                                 	</select> 
								</div>
							</div>
							<div class="col-md-6">
								<div class="checkout-form-list">
									<label>Kode Pos <span class="required">*</span></label>						
									<input type="number" name="postcode" placeholder="Kode Pos..." value="{{ auth()->user()->postcode }}">
								</div>
							</div>
							<div class="col-md-6">
								<div class="checkout-form-list">
									<label>Nomor Handphone  <span class="required">*</span></label>		
									<input type="text" name="phone" placeholder="Nomor Handphone ..." value="{{ auth()->user()->phone }}">
								</div>
							</div>
							<div class="col-md-6">
								<div class="checkout-form-list">
									<label>Alamat E-Mail </label>
									<input type="text" name="email" readonly placeholder="Email..." value="{{ auth()->user()->email}}">								
								</div>
							</div>							
						</div>
						<div class="different-address">
							<div class="ship-different-title">
								<h3>
							</div>
							<div class="order-notes">
								<div class="checkout-form-list mrg-nn">
									<label for="note">Pesan</label>
									<textarea name="note" id="note" cols="30" rows="10" placeholder="(Optional) Tinggalkan pesan ke penjual "></textarea>
								</div>									
							</div>
						</div>													
					</div>
				</div>	
				<div class="col-lg-6 col-md-12 col-12">
					<div class="your-order">
						<h3>Produk Dipesan</h3>
						<div class="your-order-table table-responsive">
							<table>
								<thead>
									<tr>
										<th class="product-name">Produk</th>
										<th class="product-total">Total</th>
									</tr>							
								</thead>
								<tbody>
									@forelse ($items as $item)
										@php
                                            $product = $item->associatedModel;
											$image = !empty($product->firstMedia) ? asset('storage/images/products/'. $product->firstMedia->file_name) : asset('frontend/assets/img/cart/3.jpg')
											
										@endphp
										<tr class="cart_item">
											<td class="product-name">
												{{ $item->name }}	<strong class="product-quantity"> × {{ $item->quantity }}</strong>
											</td>
											<td class="product-total">
												<span class="amount">{{ number_format(\Cart::get($item->id)->getPriceSum()) }}</span>
											</td>
										</tr>
									@empty
										<tr>
											<td colspan="2">Keranjang Kosong! </td>
										</tr>
									@endforelse
								</tbody>
								<tfoot>
									<tr class="cart-subtotal">
										<th>Subtotal</th>
										<td><span class="amount">{{ number_format(\Cart::getSubTotal()) }}</span></td>
									</tr>
									<tr class="cart-subtotal">
										<th>Opsi Pengiriman ({{ $totalWeight }} gram)</th>
										<td><select id="shipping-cost-option" required name="shipping_service"></select></td>
									</tr>
									<tr class="order-total">
										<th>Total Pesanan</th>
										<td><strong><span class="total-amount">{{ number_format(\Cart::getTotal()) }}</span></strong>
										</td>
									</tr>								
								</tfoot>
							</table>
						</div>
						<div class="payment-method">
							<div class="payment-accordion">
								<div class="panel-group" id="faq">
									<div class="panel panel-default">
										<div class="panel-heading">
											<h5 class="panel-title"><a data-toggle="collapse" aria-expanded="true" data-parent="#faq" href="#payment-1">Transfer Bank Langsung.</a></h5>
										</div>
										<div id="payment-1" class="panel-collapse collapse show">
											<div class="panel-body">
												<p>Lakukan pembayaran langsung ke rekening bank kami. Harap gunakan ID Pesanan Anda sebagai referensi pembayaran. Pesanan Anda tidak akan dikirim sampai dana telah dicairkan di rekening kami.</p>
											</div>
									</div>
								</div>
								<div class="order-button-payment" >
									<input type="submit" id="test" value="BUAT PESANAN" />
								</div>								
							</div>
						</div>
					</div>
				</div>
			</div>
			</form>
		</div>
	</div>
	<!-- checkout-area end -->	
@endsection