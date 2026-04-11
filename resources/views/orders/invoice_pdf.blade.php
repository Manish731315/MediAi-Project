<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Invoice #{{ $order->id }}</title>
    <style>
        @page { margin: 0px; }
        
        /* 2. Change the font to DejaVu Sans for Rupee support */
        body { 
            font-family: 'DejaVu Sans', sans-serif; 
            margin: 0px; 
            padding: 0px; 
            color: #111827; 
            background-color: #ffffff;
        }
        
        .header-bar {
            background-color: #10b981;
            height: 15px;
            width: 100%;
        }

        .container { padding: 40px; }

        .invoice-header { width: 100%; margin-bottom: 40px; }
        .logo { 
            font-size: 28px; /* Slightly smaller as DejaVu is wider */
            font-weight: bold; 
            color: #10b981; 
            text-transform: uppercase;
        }
        
        .invoice-details { text-align: right; color: #6b7280; font-size: 11px; }
        .invoice-id { font-size: 16px; color: #111827; font-weight: bold; margin-bottom: 5px; }

        .address-container { width: 100%; margin-bottom: 40px; }
        .address-label { 
            font-size: 10px; 
            font-weight: bold; 
            text-transform: uppercase; 
            color: #10b981; 
            margin-bottom: 8px;
        }
        .address-text { font-size: 12px; line-height: 1.5; color: #374151; }

        .items-table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .items-table th { 
            background-color: #111827; 
            color: #ffffff; 
            text-align: left; 
            padding: 12px; 
            font-size: 10px; 
            text-transform: uppercase;
        }
        .items-table td { 
            padding: 12px; 
            border-bottom: 1px solid #f3f4f6; 
            font-size: 12px; 
        }
        .medicine-name { font-weight: bold; color: #111827; }

        .summary-wrapper { width: 100%; margin-top: 30px; }
        .total-box { 
            float: right; 
            width: 250px; 
            background-color: #f9fafb; 
            padding: 20px; 
            border-radius: 10px; 
        }
        .total-amount { 
            font-size: 20px; 
            font-weight: bold; 
            color: #10b981; 
            text-align: right; 
        }

        .footer { 
            position: fixed; 
            bottom: 30px; 
            width: 100%; 
            text-align: center; 
            font-size: 9px; 
            color: #9ca3af;
        }
    </style>
</head>
<body>
    <div class="header-bar"></div>
    <div class="container">
        <table class="invoice-header">
            <tr>
                <td class="logo">MediAI</td>
                <td class="invoice-details">
                    <div class="invoice-id">INVOICE #{{ $order->id }}</div>
                    Issued Date: {{ $order->created_at->format('M d, Y') }}<br>
                    Payment: {{ strtoupper($order->payment_method) }}
                </td>
            </tr>
            <hr style="border: none; border-top: 1px solid #e5e7eb; margin: 20px 0;">
            <tr>
                <td colspan="2">
                    <div class="address-container">
                        <div class="address-label">Billing To:</div>
                        <div class="address-text">
                            {{ $order->user->name }}<br>
                            {{ $order->user->email }}<br>
                            {{ $order->user->phone ?? 'N/A' }}<br>
                            {{ $order->user->address ?? 'N/A' }}
                        </div>
                    </div>
                </td>
        </table>

        <table class="items-table">
            <thead>
                <tr>
                    <th>Medicine Description</th>
                    <th>Price</th>
                    <th style="text-align: center;">Qty</th>
                    <th style="text-align: right;">Line Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                <tr>
                    <td><span class="medicine-name">{{ $item->medicine->name }}</span></td>
                    <td>₹{{ number_format($item->price, 2) }}</td>
                    <td style="text-align: center;">{{ $item->quantity }}</td>
                    <td style="text-align: right; font-weight: bold;">₹{{ number_format($item->price * $item->quantity, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="summary-wrapper">
            <div class="total-box">
                <table width="100%">
                    <tr><td style="font-size: 10px; color: #6b7280;">Grand Total</td></tr>
                    <tr><td class="total-amount">₹{{ number_format($order->total_amount, 2) }}</td></tr>
                </table>
            </div>
        </div>
    </div>
</body>
</html>