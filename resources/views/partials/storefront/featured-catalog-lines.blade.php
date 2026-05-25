@php
    $catalogRows = isset($catalogRows) ? $catalogRows : (isset($catalogs) ? $catalogs->filter(fn ($c) => $c->doorColors && $c->doorColors->count() > 0) : collect());
    $defaultBrands = $defaultBrands ?? [];
@endphp
<section id="hz-catalog-lines" class="hz-section sf-catalog-lines" aria-labelledby="sf-catalog-lines-title">
    <div class="hz-container">
        <header class="sf-catalog-lines__head">
            <span class="sf-catalog-lines__eyebrow">Cabinet collections</span>
            <h2 id="sf-catalog-lines-title" class="hz-section__title sf-catalog-lines__title">Explore our featured cabinetry lines</h2>
            <p class="hz-section__sub sf-catalog-lines__sub">Dive into our flagship brands — each line offers unique styles, finishes, and price points.</p>
        </header>

        @if ($catalogRows->count())
            <div class="sf-catalog-lines__list">
                @foreach ($catalogRows as $catalog)
                    <article class="sf-catalog-block">
                        <div class="sf-catalog-block__aside">
                            @if ($catalog->image)
                                <img class="sf-catalog-block__logo" src="{{ $sf->publicAsset($catalog->image) }}" alt="">
                            @endif
                            <h3 class="sf-catalog-block__name">{{ $catalog->name }}</h3>
                            @if (!empty($catalog->pdf_url))
                                <a href="{{ $catalog->pdf_url }}" target="_blank" rel="noopener" class="sf-catalog-block__pdf">
                                    <i class="fa-solid fa-file-pdf" aria-hidden="true"></i>
                                    <span>View catalog PDF</span>
                                </a>
                            @endif
                        </div>
                        <div class="sf-catalog-block__gallery">
                            <div class="sf-catalog-block__track" tabindex="0" role="region" aria-label="{{ $catalog->name }} finishes">
                                @foreach ($catalog->doorColors as $door)
                                    <figure class="sf-finish-tile">
                                        @if (!empty($door->image))
                                            <span class="sf-finish-tile__img">
                                                <img src="{{ $sf->publicAsset($door->image) }}" alt="{{ $door->product_label }}" loading="lazy">
                                            </span>
                                        @else
                                            <span class="sf-finish-tile__img sf-finish-tile__img--empty" aria-hidden="true"></span>
                                        @endif
                                        <figcaption class="sf-finish-tile__label">{{ $door->product_label }}</figcaption>
                                    </figure>
                                @endforeach
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        @elseif (isset($doorstyles) && $doorstyles->count())
            <div class="sf-catalog-block sf-catalog-block--solo">
                <div class="sf-catalog-block__aside">
                    <h3 class="sf-catalog-block__name">Featured finishes</h3>
                </div>
                <div class="sf-catalog-block__gallery">
                    <div class="sf-catalog-block__track" tabindex="0">
                        @foreach ($doorstyles as $door)
                            <figure class="sf-finish-tile">
                                @if (!empty($door->image))
                                    <span class="sf-finish-tile__img">
                                        <img src="{{ $sf->publicAsset($door->image) }}" alt="{{ $door->product_label }}" loading="lazy">
                                    </span>
                                @else
                                    <span class="sf-finish-tile__img sf-finish-tile__img--empty" aria-hidden="true"></span>
                                @endif
                                <figcaption class="sf-finish-tile__label">{{ $door->product_label ?? 'Finish' }}</figcaption>
                            </figure>
                        @endforeach
                    </div>
                </div>
            </div>
        @else
            <div class="sf-catalog-lines__list">
                @foreach ($defaultBrands as $brand)
                    <article class="sf-catalog-block">
                        <div class="sf-catalog-block__aside">
                            <h3 class="sf-catalog-block__name">{{ $brand['name'] }}</h3>
                        </div>
                        <div class="sf-catalog-block__gallery">
                            <div class="sf-catalog-block__track sf-catalog-block__track--demo" tabindex="0">
                                @for ($i = 0; $i < 4; $i++)
                                    <figure class="sf-finish-tile">
                                        <span class="sf-finish-tile__img sf-finish-tile__img--empty" aria-hidden="true"></span>
                                        <figcaption class="sf-finish-tile__label">Sample finish</figcaption>
                                    </figure>
                                @endfor
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        @endif
    </div>
</section>
