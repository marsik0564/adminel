<h1>
    @if (isset($title)) {{ $title }} @endif
</h1>
<ol class="breadcrumb">
    <li><a href="{{ route('market.admin.index.index') }}"><i class="fa fa-dashboard"></i>{{ $parent }}</a></li>
    @if (isset($order))
        <li><a href="{{ route('market.admin.orders.index') }}"><i></i>{{ $order }}</a></li>
    @endif
    @if (isset($category))
        <li><a href="{{ route('market.admin.categories.index') }}"><i></i>{{ $category }}</a></li>
    @endif
    @if (isset($user))
        <li><a href="{{ route('market.admin.users.index') }}"><i></i>{{ $user }}</a></li>
    @endif
    @if (isset($product))
        <li><a href="{{ route('market.admin.products.index') }}"><i></i>{{ $product }}</a></li>
    @endif
    @if (isset($group_filter))
        <li><a href="{{ url('/admin/filter/group-filter') }}"><i></i>{{ $group_filter }}</a></li>
    @endif
    @if (isset($attr_filter))
        <li><a href="{{ url('/admin/filter/value-filter') }}"><i></i>{{ $attr_filter }}</a></li>
    @endif
    @if (isset($currency))
        <li><a href="{{ route('market.admin.currencies.index') }}"><i></i>{{ $currency }}</a></li>
    @endif
    <li><i class="active"></i>{{ $active }}</li>
</ol>