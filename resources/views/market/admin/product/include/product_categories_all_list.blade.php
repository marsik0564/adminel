@foreach ($categories as $category_list)
    <option value="{{ $category_list->id ?? ''}}"
        @isset($product->category_id)
            @if ($category_list->id == $product->category_id) selected @endif
        @endisset
    > {!! $delimiter ?? '' !!} {{ $category_list->title }}
    </option>
    @if (count($category_list->children) > 0)
        @include('market.admin.product.include.product_categories_all_list',
        [
            'categories' => $category_list->children,
            'delimiter' => '-' . $delimiter,
        ])
    @endif
@endforeach