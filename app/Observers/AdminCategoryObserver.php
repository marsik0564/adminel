<?php

namespace App\Observers;

use App\Models\Admin\Category;

class AdminCategoryObserver
{
    /**
     * Handle the category "created" event.
     *
     * @param  \App\Models\Admin\Category  $category
     * @return void
     */
    public function created(Category $category)
    {
        $category->alias = $category->alias . $category->id;
        $category->update();
    }

    public function creating(Category $category)
    {
        $this->setAlias($category);
    }
    
    /**
     * Handle the category "updated" event.
     *
     * @param  \App\Models\Admin\Category  $category
     * @return void
     */
    public function updated(Category $category)
    {
        //
    }
    
    public function updating(Category $category)
    {
        $this->setAlias($category);
    }
    
    /**
     * Handle the category "deleted" event.
     *
     * @param  \App\Models\Admin\Category  $category
     * @return void
     */
    public function deleted(Category $category)
    {
        //
    }

    /**
     * Handle the category "restored" event.
     *
     * @param  \App\Models\Admin\Category  $category
     * @return void
     */
    public function restored(Category $category)
    {
        //
    }

    /**
     * Handle the category "force deleted" event.
     *
     * @param  \App\Models\Admin\Category  $category
     * @return void
     */
    public function forceDeleted(Category $category)
    {
        //
    }
    
    public function setAlias(Category $category)
    {
        if (empty($category->alias)) {
            $category->alias = \Str::slug($category->title) . '-';
        }
    }
}
