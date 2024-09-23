<h2>Purchase Order # {{ (isset($order->ponumber)) ? $order->ponumber : ''  }}</h2>



<div style="display: flex;" > <p style="min-width: 155px;font-weight: 700;" >Shipping Name:</p><p> {{ $order->shippingName }}</p></div>
<div style="display: flex;" > <p style="min-width: 155px;font-weight: 700;" >Phone:</p><p> {{ $order->phone }}</p></div>
<div style="display: flex;" > <p style="min-width: 155px;font-weight: 700;" >Shipping Address1:</p><p> {{ $order->shippingAddress1 }}</p></div>
<div style="display: flex;" > <p style="min-width: 155px;font-weight: 700;" >Shipping Address2:</p><p> {{ $order->shippingAddress2 }}</p></div>
<div style="display: flex;" > <p style="min-width: 155px;font-weight: 700;" >Shipping PostalCode:</p><p> {{ $order->shippingPostalCode }}</p></div>
<div style="display: flex;" > <p style="min-width: 155px;font-weight: 700;" >Shipping City:</p><p> {{ $order->shippingCity }}</p></div>
<div style="display: flex;" > <p style="min-width: 155px;font-weight: 700;" >Shipping Country:</p><p> {{ $order->shippingCountry }}</p></div>
<div style="display: flex;" > <p style="min-width: 155px;font-weight: 700;" >Shipping Region:</p><p> {{ $order->shippingRegion }}</p></div>

<br>

<table class="reportWrapperTable" cellspacing="0" cellpadding="4" rules="rows" style="color:#1f2240;background-color:#ffffff;width: 100%;text-align: center;border: 1px solid;font-weight: 600;">
	<thead style="font-weight:bold">
		<tr>
			<th style="border: 1px solid;" scope="col">Description/Items</th>
			<th style="border: 1px solid;" scope="col">Qty</th>
			
			
			
		</tr>
	</thead>

	<tbody>
	    <?php $cat = ''; 
	    $total =0;
	    $qty = $order->qty[0];
	    foreach ($order->items as $item) {  $trq = \DB::table('pf')->where('SKU','LIKE','%'.$item.'%')->first(); if (isset($trq->PRICE)) { $price = $trq->PRICE; } else {  $price= 0; } ?>
	   
	    <tr>
			<td style="text-align: left;  border: 1px solid;" >{{ $item }}</td>
			<td style="text-align: right; border: 1px solid; "  >{{ $qty }}</td>
		
		</tr>
		<?php
	    }
	    ?>
	   
	
	
	</tbody>
</table>



<p style="margin-top: 78px;color: #535252;font-size: 12px;">CONFIDENTIALITY NOTICE: This communication, including attachments, is for the exclusive use of intended recipient and may contain proprietary, confidential or privileged information. If you are not the intended recipient, any use, copying, disclosure, dissemination or distribution is strictly prohibited. If you are not the intended recipient, please notify the sender immediately by email and delete this communication and destroy all copies.</p>


<style>
    td {
        border: 1px solid;
        text-align: right;
    }
    tr {
        border: 1px solid;
    }
    td:nth-child(1) {
      text-align: left;  
    }
    th {
        border: 1px solid;
    }
    p {
        margin: 2px;
    }
</style>