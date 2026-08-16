@extends('layout')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Product Details</h1>
        </div>
        <a href="{{ route('products.index') }}" class="px-4 py-2 rounded-xl bg-slate-100 text-slate-600 font-medium hover:bg-slate-200 transition-colors flex items-center gap-2">
            <i class="fa-solid fa-arrow-left"></i> Back to Catalog
        </a>
    </div>

    <div class="glass-card rounded-2xl overflow-hidden shadow-xl shadow-slate-200/50 border border-white/60">
        <div class="flex flex-col md:flex-row">
            <!-- Image Side -->
            <div class="md:w-2/5 bg-slate-100 relative min-h-[300px]">
                @if($product->image)
                    <img src="{{ str_starts_with($product->image, 'http') ? $product->image : asset($product->image) }}" alt="{{ $product->pro_name }}" class="absolute inset-0 w-full h-full object-cover">
                @else
                    <div class="absolute inset-0 w-full h-full flex flex-col items-center justify-center text-slate-400 bg-slate-100">
                        <i class="fa-regular fa-image text-6xl mb-4"></i>
                        <span class="font-medium">No Image Available</span>
                    </div>
                @endif
                <div class="absolute top-4 left-4">
                    <span class="px-4 py-1.5 bg-white/90 backdrop-blur shadow-sm rounded-full text-sm font-bold text-primary border border-white/50">
                        {{ $product->category }}
                    </span>
                </div>
            </div>

            <!-- Details Side -->
            <div class="md:w-3/5 p-8 lg:p-10 flex flex-col justify-center relative bg-white/50">
                <h2 class="text-3xl font-extrabold text-slate-900 mb-2">{{ $product->pro_name }}</h2>
                
                <div class="text-3xl font-bold text-emerald-600 mb-8">
                    ${{ number_format($product->price, 2) }}
                </div>
                
                <div class="space-y-6 flex-grow">
                    <div class="flex items-center gap-4 p-4 rounded-xl bg-white/80 border border-slate-100 shadow-sm">
                        <div class="w-12 h-12 rounded-full bg-indigo-50 flex items-center justify-center text-indigo-500">
                            <i class="fa-solid fa-boxes-stacked text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm text-slate-500 font-medium mb-0.5">Inventory Status</p>
                            <p class="text-lg font-bold text-slate-800">
                                {{ $product->qty }} <span class="text-sm font-normal text-slate-500">units in stock</span>
                            </p>
                        </div>
                    </div>
                    
                    <div class="flex items-center gap-4 p-4 rounded-xl bg-white/80 border border-slate-100 shadow-sm">
                        <div class="w-12 h-12 rounded-full bg-rose-50 flex items-center justify-center text-rose-500">
                            <i class="fa-regular fa-calendar-plus text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm text-slate-500 font-medium mb-0.5">Date Added</p>
                            <p class="text-lg font-bold text-slate-800">
                                {{ $product->created_at->format('M d, Y') }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="mt-8 pt-6 border-t border-slate-200/60 flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('products.edit', $product->id) }}" class="flex-1 text-center py-3 rounded-xl bg-indigo-50 text-indigo-600 font-bold hover:bg-indigo-600 hover:text-white transition-colors shadow-sm border border-indigo-100 hover:border-transparent">
                        <i class="fa-solid fa-pen mr-2"></i> Edit Product
                    </a>
                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full text-center py-3 rounded-xl bg-rose-50 text-rose-600 font-bold hover:bg-rose-600 hover:text-white transition-colors shadow-sm border border-rose-100 hover:border-transparent" onclick="return confirm('Are you sure you want to delete this product?')">
                            <i class="fa-regular fa-trash-can mr-2"></i> Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
