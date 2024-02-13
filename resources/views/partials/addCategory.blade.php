<div class="form-group">
    @if (isset($categories))
        <label for="categories">Categories</label>
        <select name="categories[]" id="categories" class="form-control" multiple>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
    @endif
</div>
