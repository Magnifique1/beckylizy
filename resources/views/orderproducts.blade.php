@extends('mainlayout')

@section('content')

    <section class="shoping-cart spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="shoping__cart__table">
                        <table id="orderHistoryProducts" class="display">
                            <thead>
                            <tr>
                                <th>Item Name</th>
                                <th>QTY</th>
                                <th>Unit Price</th>
                                <th>Sub-total</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($orderProducts as $oP)
                                <tr>
                                    <td >
                                        {{$oP->name}}
                                    </td>

                                    <td>
                                        {{number_format($oP->quantity,2)}}
                                    </td>

                                    <td>
                                        {{number_format($oP->unit_price,2)}}
                                    </td>

                                    <td>
                                        {{number_format($oP->subtotal,2)}}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <br>
                        <br>



                        <div class="blog__details__widget">

                            @foreach($payDetails as $pD)

                                @if($pD->additional_notes == 'Cash On Delivery' && ($pD->final_total - $pD->paid) > 0)
                                    <div class="alert alert-success" role="alert">
                                        No Further Action Required You Have Opted For - {{$pD -> additional_notes}}
                                    </div>
                                @elseif(($pD->additional_notes != 'Cash On Delivery' && $pD->final_total - $pD->paid) > 0)
                                    <h4>Pay Using M-Pesa Pay Bill:</h4>
                                    <br>
                                    <ul>
                                        <li><span>PayBill Number:</span> 4029313 - BECKY LIZY ONLINE STORES </li>
                                        <li><span>Account Number:</span> {{$pD->staff_note}}</li>
                                        <li><span>Remaining Balance:</span> KES {{number_format(($pD->final_total - $pD->paid),2)}}</li>
                                    </ul>
                                    <br>
                                    <div class="blog__details__widget">
                                        <h4>Cash On Delivery:</h4>
                                        <br>
                                        <button type="submit" class="btn btn-success"
                                                data-toggle="modal"
                                                data-target="#COD" >
                                            CLICK HERE FOR CASH ON DELIVERY
                                        </button>
                                    </div>
                                @else
                                    <div class="alert alert-success" role="alert">
                                        You're All Set. This Order Is Fully Paid! Thank You For Your Order.
                                    </div>
                                @endif
                            @endforeach
                        </div>



                    </div>
                </div>
            </div>
        </div>
    </section>


    <div class="modal fade bd-example-modal-lg" id="COD" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Cash On Delivery</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h3>ATTENTION</h3>
                    <br>
                    <p>
                        By opting for Cash On Delivery. You agree to make full payment to driver once goods arrive.
                        A representative will call you shortly to confirm convenient time(s) for delivery.
                    </p>
                    <form action="{{route('postCOD')}}" method="POST">
                        @csrf
                        <input type="hidden" name="OID" value="{{$orderID}}">
                        <button type="submit" class="btn btn-success">CASH ON DELIVERY</button>
                    </form>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close
                    </button>
                </div>
            </div>
        </div>
    </div>

@endsection
