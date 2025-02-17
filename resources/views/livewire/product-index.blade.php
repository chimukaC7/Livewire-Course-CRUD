<div>
    <div class="row">
        <div class="col-md-3">
            <input wire:model="searchQuery" type="text" placeholder="Search for product..." class="form-control" />
        </div>
        <div class="col-md-3">
            <select wire:model="searchCategory" name="category" class="form-control">
                <option value="">-- choose category --</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6 text-right">
            {{--link to blade not a livewire link --}}
            <a href="{{ route('products.create') }}" class="btn btn-primary">Add new product</a>
        </div>
    </div>
    <hr />

    {{--div shows when data is loading meaning when a network request is happening--}}
    <div class="alert alert-success col-md-12" wire:loading>
        <p>Loading data, please wait...</p>
    </div>
    {{--using a class--}}
    <div class="alert alert-success col-md-12" wire:loading.class="bg-primary">
        <p>Loading data, please wait...</p>
    </div>

    <table class="table">
    <thead>
    <tr>
        <th>Photo</th>
        <th>Name</th>
        <th>Categories</th>
        <th>Description</th>
        <th>Stock date</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    @forelse($products as $product)
        <tr>
            <td>
                @if ($product->photo)
                    <img src="/storage/{{ $product->photo }}" width="50" />
                @endif
            </td>
            <td>{{ $product->name }}</td>
            <td>
                @foreach ($product->categories as $category)
                    {{ $category->name }}<br />
                @endforeach
            </td>
            <td>{{ $product->description }}</td>
            <td>{{ $product->stock_date }}</td>
            <td>
                <a class="btn btn-sm btn-primary"  href="{{ route('products.edit', $product) }}">Edit</a>
                {{--  deleting  --}}
                <a onclick="return confirm('Are you sure?') || event.stopImmediatePropagation()"
                   wire:click="deleteProduct('{{ $product->id }}')"  class="btn btn-sm btn-danger" href="#">Delete </a>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="100%" class="text-center">No products found.</td>
        </tr>
    @endforelse
    </tbody>
    </table>
    {{ $products->links() }}
</div>
