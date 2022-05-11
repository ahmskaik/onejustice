<ul class="kt-checkbox-list list-unstyled">
    @foreach($subCategories as $child)
        @if(isset($category,$category->id) && $category->id==$child->id)
            <label class="kt-radio kt-radio--success">
                <i class="fa fa-stop"></i> {{ $child->name->{$locale} }}
            </label>
        @else
            <li>
                <label
                    class="kt-{{$type==='radio'?'radio':'checkbox'}} kt-{{$type==='radio'?'radio':'checkbox'}}--success">
                    <input type="{{$type==='radio'?'radio':'checkbox'}}"
                           @if(isset($category)&& $category->parent_id  == $child->id) checked @endif
                           name="product[categories][]"
                           value="{{$child->id}}"> {{ $child->name->{$locale} }}
                    <span></span>
                </label>
                @if(sizeof($child->subCategories))
                    @include('cp.categories.parts.subCategoriesList',['subCategories' => $child->subCategories])
                @endif
            </li>
        @endif
    @endforeach
</ul>
