<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Shoppingcart as Cart;

class Shoppingcart extends Component
{
    public $cartitems, $sub_total = 0, $total = 0, $discount = 0;

    public function render()
    {
        $this->cartitems = Cart::with('product')->where(['user_id'=>auth()->user()->id])->get();
        $this->sub_total = 0; $this->total =0; $this->discount = 5;

        foreach($this->cartitems as $item){
            $this->sub_total += $item->product->price * $item->quantity;
        }
        $this->total = $this->sub_total - $this->discount;

        return view('livewire.shoppingcart');
    }

    public function incrementQty($id){
        $cart = Cart::whereId($id)->first();
        $cart->quantity += 1;
        $cart->save();
        session()->flash('success', 'Product quantity has update!!');
    }

    public function decrementQty($id){
        $cart = Cart::whereId($id)->first();
        if($cart->quantity > 1){
            $cart->quantity -= 1;
            $cart->save();
            session()->flash('success', 'Product quantity has update!!');
        }else{
            session()->flash('info', 'You cannot have less than 1 quantity');
        }
    }

    public function removeItem($id){
        $cart = Cart::whereId($id)->first();

        if($cart){
            $cart->delete();
            $this->emit('updateCartCount');
        }
        session()->flash('success', 'Product remove from cart!!!');
    }
    
    public function showSummary(){
        session()->flash('success', 'Your Order Is Ready, Next Please Confirm Payment Method');
    }
}
