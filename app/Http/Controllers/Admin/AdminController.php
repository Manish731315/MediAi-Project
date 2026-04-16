<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Models\Prescription;
use App\Models\SymptomSession;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminController extends Controller
{
    /**
     * Show the admin dashboard.
     */
    public function dashboard()
    {
        // Fetch some stats
        $pendingOrders = Order::whereIn('status', ['pending', 'pending_approval'])->count();
        $totalOrders = Order::count();
        $chatLogsCount = SymptomSession::count();

        return view('admin.dashboard', compact('pendingOrders', 'totalOrders', 'chatLogsCount'));
    }

    /**
     * Display a listing of all orders.
     */
    public function ordersIndex()
    {
        $orders = Order::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(15);
            
        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Display the specified order.
     */
    public function ordersShow(Order $order)
    {
        // Eager load all related data
        $order->load('user', 'items.medicine', 'prescriptions');
        
        return view('admin.orders.show', compact('order'));
    }
    /**
     * Display a listing of all users.
     */
    public function usersIndex()
    {
        // Fetch users, paginated (10 per page)
        // You might want to filter out admins if you only want customers
        // $users = User::where('role', 'user')->latest()->paginate(10);
        
        $users = User::latest()->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Update the status of an order.
     */
    public function ordersUpdateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|string|in:pending,pending_approval,processing,shipped,cancelled',
        ]);

        $order->update(['status' => $request->input('status')]);

        return back()->with('success', 'Order status updated.');
    }

    /**
     * Approve a prescription.
     */
    public function approvePrescription(Prescription $prescription)
    {
        $prescription->update(['status' => 'approved']);
        
        // Update the related order's status
        $prescription->order->update(['status' => 'processing']);

        return back()->with('success', 'Prescription approved. Order is now processing.');
    }

    /**
     * Reject a prescription.
     */
    public function rejectPrescription(Prescription $prescription)
    {
        $prescription->update(['status' => 'rejected']);
        
        // Cancel the related order
        $prescription->order->update(['status' => 'cancelled']);
        
        // TODO: We should also refund the payment and restore stock, but
        // for this project, just cancelling the order is sufficient.

        return back()->with('success', 'Prescription rejected. Order has been cancelled.');
    }

    /**
     * Display a listing of AI chat logs.
     */
    public function chatLogs()
    {
        $logs = SymptomSession::with('user')
            ->latest()
            ->paginate(20);
            
        return view('admin.chat-logs', compact('logs'));
    }

    public function exportOrdersPdf()
    {
        $orders = Order::with('user')->latest()->get();

        $pdf = Pdf::loadView('admin.orders.pdf', compact('orders'));

        return $pdf->download('orders.pdf');
    }

    public function exportUsersPdf()
    {
        $users = User::latest()->get();

        $pdf = Pdf::loadView('admin.users.pdf', compact('users'));

        return $pdf->download('users.pdf');
    }

    public function exportLogsPdf()
    {
        $logs = SymptomSession::with('user')->latest()->get();

        $pdf = Pdf::loadView('admin.logs.pdf', compact('logs'));

        return $pdf->download('ai_logs.pdf');
    }
}