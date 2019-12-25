<?php

namespace App\Observers;

use App\Models\Admin\Product;

class AdminProductObserver
{

    public function creating(Product $product)
    {
        $this->setAlias($product);
    }
    /**
     * Handle the product "created" event.
     *
     * @param  \App\Models\Admin\Product  $product
     * @return void
     */
    public function created(Product $product)
    {
        $product->alias = $product->alias . $product->id;
        $product->update();
    }

    /**
     * Handle the product "updated" event.
     *
     * @param  \App\Models\Admin\Product  $product
     * @return void
     */
    public function updated(Product $product)
    {
        //
    }

    /**
     * Handle the product "deleted" event.
     *
     * @param  \App\Models\Admin\Product  $product
     * @return void
     */
    public function deleted(Product $product)
    {
        //
    }

    /**
     * Handle the product "restored" event.
     *
     * @param  \App\Models\Admin\Product  $product
     * @return void
     */
    public function restored(Product $product)
    {
        //
    }

    /**
     * Handle the product "force deleted" event.
     *
     * @param  \App\Models\Admin\Product  $product
     * @return void
     */
    public function forceDeleted(Product $product)
    {
        //
    }
    
    /**
    * Set Alias for products
    */
    public function setAlias(Product $product)
    {
        if (empty($product->alias) || $product->isDirty('title')) {
            $product->alias = \Str::slug($product->title) . '-' . $product->id;
        }
    }
}
