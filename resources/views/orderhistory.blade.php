@extends('mainlayout')

@section('content')

        <section class="shoping-cart spad">
            <div class="container">
                <div class="alert alert-info" role="alert">
                    Please Note: ALL "DRAFT" ORDERS NOT PAID FOR WILL AUTOMATICALLY BE DELETED IN 48-HOURS
                </div>

                @include('partials.alerts')

                <div class="row">
                    <div class="col-lg-12">
                        <div class="shoping__cart__table">

                            <table id="orderHistory" class="display">
                                <thead>
                                <tr>
                                    <th>Order Date</th>
                                    <th>Order Status</th>
                                    <th>Payment Status</th>
                                    <th>Invoice Number</th>
                                    <th>M-Pesa Acc Number</th>
                                    <th>Payment Method</th>
                                    <th>Total</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($orders as $o)
                                    <tr>
                                        <td>
                                            {{\Carbon\Carbon::parse($o->transaction_date)->format('d/m/Y')}}
                                        </td>

                                        <td>{{$o->status}}</td>

                                        <td> {{$o->payment_status}}</td>

                                        <td>{{$o->invoice_no}}</td>

                                        <td>{{$o->staff_note}}</td>

                                        <td>{{$o->additional_notes}}</td>

                                        <td>{{number_format($o->final_total,2)}}</td>

                                        <td>
                                            <a href="/orderproducts/{{$o->id}}" class="btn btn-success">
                                                Order Details
                                            </a>
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


        <div class="modal fade bd-example-modal-lg" id="orderdetails" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Order Number</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <table id="orderHistory" class="display">
                            <thead>
                            <tr>
                                <th>Item Name</th>
                                <th>QTY</th>
                                <th>Unit Price</th>
                                <th>Sub-total</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>KABRAS SUGAR 10*2KG</td>
                                <td>1</td>
                                <td>260.0</td>
                                <td>260.0</td>
                            </tr>
                            </tbody>
                        </table>

                    </div>

                    <div style="align-content: center">
                        <label>Order Payments</label>
                    </div>

                    <div class="modal-body">

                        <table id="orderPayments" class="display">
                            <thead>
                            <tr>
                                <th>Paid Amount</th>
                                <th>PaymentMethod</th>
                                <th>Transaction No.</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>100</td>
                                <td>M-Pesa</td>
                                <td>VVCV</td>
                            </tr>
                            </tbody>
                        </table>

                    </div>

                    <div class="modal-body">

                        <div class="blog__details__widget">
                            <label>Pay Using M-Pesa:</label>
                            <ul>
                                <li><span>PayBill Number:</span> 123456 </li>
                                <li><span>Account Number:</span> AX233</li>
                                <li><span>Remaining Balance:</span> KES 120</li>
                            </ul>

                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
@endsection
