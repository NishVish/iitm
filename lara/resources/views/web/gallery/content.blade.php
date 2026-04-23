<div class="gallery-wrap">

    <h2>Image Gallery</h2>

    @php
        $images = glob(public_path('assets/*.{jpg,jpeg,png,webp,gif}'), GLOB_BRACE);
    @endphp

    <div class="gallery-grid">
        @forelse($images as $img)
            <div class="gallery-item">
                <img src="{{ asset('assets/' . basename($img)) }}" alt="Gallery Image">
            </div>
        @empty
            <p>No images found.</p>
        @endforelse
    </div>

</div>

<style>
    .gallery-wrap {
        max-width: 1100px;
        margin: auto;
        padding: 40px 20px;
        font-family: Inter, sans-serif;
    }

    .gallery-wrap h2 {
        font-size: 28px;
        margin-bottom: 20px;
        font-family: "Cormorant Garamond", serif;
    }

    .gallery-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 16px;
    }

    .gallery-item {
        overflow: hidden;
        border-radius: 12px;
        background: #f5f5f5;
        aspect-ratio: 1/1;
        position: relative;
    }

    .gallery-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: .3s ease;
    }

    .gallery-item:hover img {
        transform: scale(1.08);
    }
</style>