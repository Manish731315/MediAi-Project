<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 12px; color: #333; }
        .invoice-box { max-width: 800px; margin: auto; padding: 30px; }
        .header { border-bottom: 2px solid #3b82f6; padding-bottom: 10px; margin-bottom: 20px; }
        .company-name { font-size: 24px; color: #3b82f6; font-weight: bold; }
        .table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .table th { background: #f3f4f6; padding: 10px; text-align: left; border: 1px solid #ddd; }
        .table td { padding: 10px; border: 1px solid #ddd; }
        .total-section { margin-top: 20px; text-align: right; }
        .address-box { margin-bottom: 20px; }
        .address-box div { margin-bottom: 5px; }
    </style>
</head>
<body>
    <div class="invoice-box">
        <div class="header">
            <span class="company-name">MediAI Invoice</span>
            <div style="float: right; text-align: right;">
                Order ID: #{{ $order->id }}<br>
                Date: {{ $order->created_at->format('d/m/Y') }}
            </div>
        </div>

        <div class="address-box">
            <strong>Billed To:</strong><br>
            {{ $order->user->name }}<br>
            {{ $order->delivery_address }}<br>
            {{ $order->city }}, {{ $order->state }} - {{ $order->pincode }}<br>
            Phone: {{ $order->user->phone }}
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>Medicine</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                <tr>
                    <td>{{ $item->medicine->name }}</td>
                    <td>₹{{ number_format($item->price, 2) }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>₹{{ number_format($item->price * $item->quantity, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="total-section">
            <h3 style="color: #3b82f6;">Total Amount: ₹{{ number_format($order->total_amount, 2) }}</h3>
            <p>Payment Method: {{ strtoupper($order->payment_method) }}</p>
        </div>

        <div style="margin-top: 50px; text-align: center; font-size: 10px; color: #777;">
            This is a computer-generated invoice. No signature required.
        </div>
    </div>
</body>
</html>