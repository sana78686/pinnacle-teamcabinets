@extends('layouts.tenant.products-form')
@section('title', 'Catalog PDF')

@section('products_title')
    {{ $product_catalog->name }} — PDF
@endsection

@section('products_content')
    <div class="mb-3">
        <a href="{{ route('tenant_product_catalog_index') }}" class="btn btn-light btn-sm">
            <i class="fa fa-arrow-left"></i> Back to catalog list
        </a>
        <a href="{{ $product_catalog->pdf_url }}" target="_blank" rel="noopener" class="btn btn-outline-primary btn-sm">
            <i class="fa-solid fa-external-link-alt"></i> Open in new tab
        </a>
    </div>
    <div class="tc-catalog-pdf-viewer border rounded overflow-hidden bg-light">
        <iframe src="{{ $product_catalog->pdf_url }}#toolbar=1" title="{{ $product_catalog->name }} PDF" class="tc-catalog-pdf-frame"></iframe>
    </div>
@endsection

@section('style')
    <style>
        .tc-catalog-pdf-viewer {
            min-height: calc(100vh - 220px);
        }
        .tc-catalog-pdf-frame {
            width: 100%;
            height: calc(100vh - 220px);
            border: 0;
            display: block;
        }
    </style>
@endsection
