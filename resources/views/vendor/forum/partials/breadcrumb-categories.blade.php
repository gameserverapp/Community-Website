@if (!is_null($category->parent))
    @include ('forum::partials.breadcrumb-categories', ['category' => $category->parent])
@endif
<li itemprop="child" itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
    <a itemprop="url" title="{{ $category->title }}" href="{{ Forum::route('category.show', $category) }}">{{ $category->title }}</a>
</li>
