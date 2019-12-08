<?php

namespace App\Repositories\Admin;

use App\Repositories\CoreRepository;
use App\Models\Admin\Category as Model;
use LavMenu;

class CategoryRepository extends CoreRepository
{

    public function __construct()
    {
        parent::__construct();
    }
    
    protected function getModelClass()
    {
        return Model::class;
    }
    
    public function buildMenu($arrMenu)
    {
        $mBuilder = LavMenu::make('MyNav', function($m) use ($arrMenu) {
            foreach ($arrMenu as $item){
                if ($item->parent_id == 0){
                    $m->add($item->title, $item->id)
                        ->id($item->id);
                } elseif ($m->find($item->parent_id)) {
                    $m->find($item->parent_id)
                        ->add($item->title, $item->id)
                        ->id($item->id);
                }
            }
        });
        return $mBuilder;
    }
}