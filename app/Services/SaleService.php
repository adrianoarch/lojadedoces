<?php

namespace App\Services;

use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class SaleService {

    public function total() {
        $cart = session()->get('cart');
        $total = 0;
        if ($cart) {
            foreach ($cart as $item) {
                $total += $item['price'] * $item['quantity'];
            }
        }
        return $total;
    }
    

    public function finalizeSale($products = [], User $user) {

        
        try {
            DB::beginTransaction();
            $order = new Order();
            $order->user_id = $user->id;
            $order->status = 'Processando';
            $order->total = $this->total($products);
            $order->payment = $_REQUEST['payment'];
            $order->save();

            $cart = Session::get('cart');
            
            foreach ($cart as $product) {
                $orderItem = new OrderItem();
                $orderItem->order_id = $order->id;
                $orderItem->product_id = $product['id'];
                $orderItem->price = $product['price'];
                $orderItem->quantity = $product['quantity'];
                $orderItem->subtotal = $product['price'] * $product['quantity'];
                $orderItem->image_products = $product['photo'];
                $orderItem->save();
            }

            $products = Product::whereIn('id', array_column($cart, 'id'))->get();
            $products->each(function($product) use ($cart) {
                $product->update([
                    'quantity' => $product->quantity - $cart[$product->id]['quantity'],
                ]);
            });
        
            
            
            DB::commit();
    
            return ['status' => 'success', 'message' => 'Pedido finalizado com sucesso! Agora é só aguardar!', 'orderid' => $order->id];
        }
        
        
         catch (\Exception $e) {
            DB::rollBack();
            Log::error('ERRO: VENDA SERVICE', ['message' => $e->getMessage()]);
            return ['status' => 'error', 'message' => 'Erro ao finalizar venda! Tente mais tarde.'];
                
        }
        // $order = $user->orders()->create([
        //     'status' => 'open',
        // ]);

        // foreach ($products as $product) {
        //     $order->orderItems()->create([
        //         'product_id' => $product['id'],
        //         'quantity' => $product['quantity'],
        //         'subtotal' => $product['price'],
        //     ]);
        // }
    }
    
}
// $orderItem = new OrderItem();
// $orderItem->order_id = $order->id;
// $orderItem->product_id = $product->id;
// $orderItem->price = $product->salesPrice;
// $orderItem->quantity = $product->quantity;
// // $orderItem->subtotal = $product->price * $product->quantity;
// $orderItem->save();
// }