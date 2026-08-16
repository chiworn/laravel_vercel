@extends('layout')

@section('content')
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
    <div>
        <h1 class="text-3xl font-bold text-slate-900 tracking-tight">Product Catalog</h1>
        <p class="text-slate-500 mt-1">Manage and view your premium inventory.</p>
    </div>
    <a href="{{ route('products.create') }}" class="btn-primary px-5 py-2.5 rounded-xl font-medium flex items-center gap-2 shadow-lg shadow-indigo-200 shrink-0">
        <i class="fa-solid fa-plus"></i>
        <span>New Product</span>
    </a>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
    @forelse ($products as $product)
    <div class="glass-card rounded-2xl overflow-hidden group hover:shadow-xl transition-all duration-300 border border-white/50 flex flex-col">
        <!-- Image Section -->
        <div class="relative h-56 bg-slate-100 overflow-hidden shrink-0">
            @if($product->image)
                <img src="{{ str_starts_with($product->image, 'http') ? $product->image : asset($product->image) }}" alt="{{ $product->pro_name }}" class="w-full h-full object-cover transition-transform duration-500">
            @else
                <div class="w-full h-full flex flex-col items-center justify-center text-slate-400">
                    <i class="fa-regular fa-image text-4xl mb-2"></i>
                    <span class="text-sm font-medium">No Image</span>
                </div>
            @endif
            
            <div class="absolute top-3 right-3">
                <span class="px-3 py-1 bg-white/90 backdrop-blur text-xs font-semibold rounded-full text-primary shadow-sm border border-white/50">
                    {{ $product->category }}
                </span>
            </div>
        </div>

        <!-- Content Section -->
        <div class="p-5 flex flex-col flex-grow">
            <div class="flex justify-between items-start mb-2 gap-2">
                <h3 class="text-lg font-bold text-slate-800 line-clamp-1" title="{{ $product->pro_name }}">{{ $product->pro_name }}</h3>
                <span class="font-bold text-lg text-emerald-600 shrink-0">${{ number_format($product->price, 2) }}</span>
            </div>
            
            <div class="flex items-center text-sm text-slate-500 mb-4 gap-4">
                <div class="flex items-center gap-1.5">
                    <i class="fa-solid fa-box-open text-slate-400"></i>
                    <span>Stock: <span class="font-medium text-slate-700">{{ $product->qty }}</span></span>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex items-center gap-2 pt-4 border-t border-slate-100 mt-auto">
                <a href="{{ route('products.show', $product->id) }}" class="flex-1 flex justify-center items-center gap-1.5 py-2 px-3 rounded-lg bg-slate-100 text-slate-600 hover:bg-slate-200 hover:text-slate-900 transition-colors text-sm font-medium">
                    <i class="fa-regular fa-eye"></i> View
                </a>
                <a href="{{ route('products.edit', $product->id) }}" class="flex-1 flex justify-center items-center gap-1.5 py-2 px-3 rounded-lg bg-indigo-50 text-indigo-600 hover:bg-indigo-100 transition-colors text-sm font-medium">
                    <i class="fa-solid fa-pen"></i> Edit
                </a>
                <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="flex-none">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="flex justify-center items-center w-9 h-9 rounded-lg bg-rose-50 text-rose-500 hover:bg-rose-500 hover:text-white transition-colors" onclick="return confirm('Are you sure you want to delete this product?')" title="Delete">
                        <i class="fa-regular fa-trash-can"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
    @empty
    <div class="col-span-full py-16 flex flex-col items-center justify-center text-slate-400 glass-card rounded-2xl border-dashed border-2 border-slate-200">
        <i class="fa-solid fa-inbox text-6xl mb-4 text-slate-300"></i>
        <h3 class="text-xl font-medium text-slate-600">No products found</h3>
        <p class="mt-1 text-sm mb-6">Get started by creating a new product.</p>
        <a href="{{ route('products.create') }}" class="btn-primary px-6 py-2.5 rounded-xl font-medium flex items-center gap-2 shadow-lg shadow-indigo-200">
            <i class="fa-solid fa-plus"></i>
            <span>Create Product</span>
        </a>
    </div>
    @endforelse
</div>
@endsection
