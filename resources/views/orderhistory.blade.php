@extends('mainlayout')

@section('content')
    <section class="shoping-cart spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="shoping__cart__table">
                        <table>
                            <thead>
                            <tr>
                                <th>Order Date</th>
                                <th>Order Status</th>
                                <th>Payment Status</th>
                                <th>Invoice Number</th>
                                <th>Sub-Total</th>
                                <th>VAT</th>
                                <th>Total</th>
                                <th>Action</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($orders as $o)
                            <tr>
                                <td class="shoping__cart__item2">
                                    {{\Carbon\Carbon::parse($o->transaction_date)->format('d/m/Y')}}
                                </td>

                                <td class="shoping__cart__item2">
                                    {{$o->status}}
                                </td>

                                <td class="shoping__cart__item2">
                                    {{$o->payment_status}}
                                </td>

                                <td class="shoping__cart__item2">
                                    {{$o->invoice_no}}
                                </td>

                                <td class="shoping__cart__item2">
                                    {{number_format($o->total_before_tax,2)}}
                                </td>

                                <td class="shoping__cart__item2">
                                    {{number_format($o->tax_amount,2)}}
                                </td>

                                <td class="shoping__cart__item2">
                                    {{number_format($o->final_total,2)}}
                                </td>

                                <td class="shoping__cart__item__close">
                                    <button type="submit" class="site-btn">View Order</button>
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
