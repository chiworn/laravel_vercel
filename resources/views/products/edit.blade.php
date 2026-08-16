@extends('layout')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Edit Product</h1>
            <p class="text-slate-500 text-sm mt-1">Update the details for {{ $product->pro_name }}.</p>
        </div>
        <a href="{{ route('products.index') }}" class="px-4 py-2 rounded-xl bg-slate-100 text-slate-600 font-medium hover:bg-slate-200 transition-colors flex items-center gap-2">
            <i class="fa-solid fa-arrow-left"></i> Back
        </a>
    </div>

    @if ($errors->any())
        <div class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-100 text-rose-700 shadow-sm animate-fade-in">
            <div class="flex items-center gap-2 font-bold mb-2">
                <i class="fa-solid fa-triangle-exclamation"></i> Please fix the following errors:
            </div>
            <ul class="list-disc list-inside text-sm space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="glass-card rounded-2xl p-6 sm:p-8 border border-white/60 shadow-xl shadow-slate-200/50 relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-amber-400 to-orange-500"></div>
        
        <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- Name -->
                <div class="sm:col-span-2">
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Product Name</label>
                    <input type="text" name="pro_name" value="{{ old('pro_name', $product->pro_name) }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-white/50 focus:bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all placeholder-slate-400">
                </div>
                
                <!-- Category -->
                <div class="sm:col-span-2">
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Category</label>
                    <input type="text" name="category" value="{{ old('category', $product->category) }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-white/50 focus:bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all placeholder-slate-400">
                </div>

                <!-- Price -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Price ($)</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                            <i class="fa-solid fa-dollar-sign"></i>
                        </div>
                        <input type="number" step="0.01" name="price" value="{{ old('price', $product->price) }}" class="w-full pl-8 pr-4 py-2.5 rounded-xl border border-slate-200 bg-white/50 focus:bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all placeholder-slate-400">
                    </div>
                </div>

                <!-- Quantity -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Stock Quantity</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                            <i class="fa-solid fa-boxes-stacked"></i>
                        </div>
                        <input type="number" name="qty" value="{{ old('qty', $product->qty) }}" class="w-full pl-9 pr-4 py-2.5 rounded-xl border border-slate-200 bg-white/50 focus:bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all placeholder-slate-400">
                    </div>
                </div>

                <!-- Image -->
                <div class="sm:col-span-2">
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Product Image</label>
                    
                    @if($product->image)
                    <div class="mb-4 flex items-center gap-4 p-3 bg-white border border-slate-200 rounded-xl">
                        <img src="{{ str_starts_with($product->image, 'http') ? $product->image : asset($product->image) }}" alt="Current image" class="w-16 h-16 object-cover rounded-lg shadow-sm">
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-slate-700">Current Image</p>
                            <p class="text-xs text-slate-500 truncate">{{ $product->image }}</p>
                        </div>
                    </div>
                    @endif

                    <div class="flex justify-center px-6 pt-5 pb-6 border-2 border-slate-200 border-dashed rounded-xl bg-slate-50/50 hover:bg-slate-50 transition-colors group relative cursor-pointer overflow-hidden">
                        <input type="file" name="image" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" id="file-upload">
                        <div class="space-y-2 text-center relative z-0">
                            <div class="mx-auto h-12 w-12 text-slate-300 group-hover:text-amber-500 transition-colors flex items-center justify-center rounded-full bg-white shadow-sm border border-slate-100">
                                <i class="fa-solid fa-cloud-arrow-up text-xl"></i>
                            </div>
                            <div class="text-sm text-slate-600">
                                <span class="font-medium text-amber-600 hover:text-amber-500">Upload new image</span> or drag and drop
                            </div>
                            <p class="text-xs text-slate-500">PNG, JPG, GIF up to 2MB. Leave empty to keep current.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="pt-4 flex flex-col-reverse sm:flex-row justify-end gap-3">
                <a href="{{ route('products.index') }}" class="px-6 py-2.5 rounded-xl border border-slate-200 text-slate-600 font-medium hover:bg-slate-50 transition-colors text-center">Cancel</a>
                <button type="submit" class="px-8 py-2.5 rounded-xl font-medium shadow-lg shadow-orange-200 flex justify-center items-center gap-2 bg-gradient-to-r from-amber-500 to-orange-500 text-white hover:shadow-xl hover:shadow-orange-300 hover:-translate-y-0.5 transition-all">
                    <i class="fa-solid fa-check"></i> Update Product
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
