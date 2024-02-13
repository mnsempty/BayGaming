<div class="form-group">
    <label for="categories">Categories</label>
    <select name="categories[]" id="categories" class="form-control" multiple>
        @if (isset($products))
            @foreach ($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        @endif
    </select>
</div>
