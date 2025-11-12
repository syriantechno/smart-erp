@php
    $isActive = $currentCategory == $category->id;
    $hasChildren = $category->children->count() > 0;
@endphp

<div class="category-item p-3 rounded-lg mb-1 {{ $isActive ? 'active' : '' }}"
     onclick="filterByCategory('{{ $category->id }}')">
    <div class="flex items-center">
        <div class="w-5 h-5 mr-3 rounded" style="background-color: {{ $category->color }}20; border: 1px solid {{ $category->color }}40;">
            <x-base.lucide icon="{{ $category->icon }}" class="w-3 h-3 m-0.5" style="color: {{ $category->color }}" />
        </div>
        <div class="flex-1">
            <div class="font-medium">{{ $category->name }}</div>
            <div class="text-xs text-gray-500">{{ $category->document_count }} files</div>
        </div>
        @if($hasChildren)
            <x-base.lucide icon="chevron-right" class="w-4 h-4 text-gray-400" />
        @endif
    </div>
</div>

@if($hasChildren)
    <div class="nested-category">
        @foreach($category->children as $child)
            @include('documents.partials.category-item', ['category' => $child, 'level' => $level + 1])
        @endforeach
    </div>
@endif
