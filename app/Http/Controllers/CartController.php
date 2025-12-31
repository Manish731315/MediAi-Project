<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Medicine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CartController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display the user's cart.
     */
    public function index()
    {
        $cartItems = Cart::with('medicine')
            ->where('user_id', Auth::id())
            ->get();
            
        $total = $cartItems->sum(function($item) {
            return $item->medicine->price * $item->quantity;
        });

        return view('cart.index', compact('cartItems', 'total'));
    }

    /**
     * Add a medicine to the cart.
     */
    public function add(Request $request, Medicine $medicine)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $quantity = $request->input('quantity');

        // Check stock
        if ($medicine->stock < $quantity) {
            return back()->with('error', 'Not enough stock available.');
        }

        // Check if item is already in cart
        $cartItem = Cart::where('user_id', Auth::id())
                        ->where('medicine_id', $medicine->id)
                        ->first();

        if ($cartItem) {
            // Update quantity
            $newQuantity = $cartItem->quantity + $quantity;
            if ($medicine->stock < $newQuantity) {
                return back()->with('error', 'Not enough stock to add more.');
            }
            $cartItem->update(['quantity' => $newQuantity]);
        } else {
            // Create new cart item
            Cart::create([
                'user_id' => Auth::id(),
                'medicine_id' => $medicine->id,
                'quantity' => $quantity,
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Item added to cart.');
    }

    /**
     * Update the quantity of a cart item.
     */
    public function update(Request $request, Cart $cart)
    {
        // Ensure the cart item belongs to the authenticated user
        $this->authorize('update', $cart);

        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $quantity = $request->input('quantity');

        // Check stock
        if ($cart->medicine->stock < $quantity) {
            return back()->with('error', 'Not enough stock available.');
        }
        
        $cart->update(['quantity' => $quantity]);
        return back()->with('success', 'Cart updated.');
    }

    /**
     * Remove an item from the cart.
     */
    public function remove(Cart $cart)
    {
        // Ensure the cart item belongs to the authenticated user
        $this->authorize('delete', $cart);
        
        $cart->delete();
        return back()->with('success', 'Item removed from cart.');
    }
}