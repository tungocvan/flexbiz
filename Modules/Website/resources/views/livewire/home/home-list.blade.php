<div>
    {{-- 1. Hero Banner (Hiển thị ngay - Above the fold) --}}
    <div class="container mx-auto px-4 mt-4">
        @livewire('website.home.hero-banner')
    </div>

    {{-- Container chính cho nội dung --}}
    <div class="container mx-auto px-4 py-8 space-y-12">

        {{-- 2. Danh mục nổi bật --}}
        @livewire('website.home.category-highlight')

        {{-- 3. Flash Sale (Lazy Load: Vì cần tính toán thời gian & query phức tạp) --}}
        @livewire('website.home.flash-sale', ['lazy' => true])

        {{-- 4. Promo Banner (Điểm ngắt nhịp) --}}
        @livewire('website.home.promo-banner', ['lazy' => true])

        {{-- 5. Sản phẩm nổi bật (Core Business) --}}
         @livewire('website.home.featured-products', ['lazy' => true])

        {{-- 6. Hàng mới về --}}
        @livewire('website.home.new-arrivals', ['lazy' => true])

        {{-- 7. Top bán chạy (Query nặng - Bắt buộc Lazy Load) --}}
        @livewire('website.home.best-sellers', ['lazy' => true])

        {{-- 8. Trust Badges (Cam kết) --}}
        @livewire('website.home.trust-badges', ['lazy' => true])

        {{-- 9. Blog tin tức --}}
        @livewire('website.home.blog-highlight', ['lazy' => true])

        {{-- 10. Đăng ký nhận tin --}}
        @livewire('website.home.newsletter-signup', ['lazy' => true])

    </div>
</div>
