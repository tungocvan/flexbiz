<footer class="bg-gray-900 text-gray-400 border-t border-gray-800 font-sans relative">

    {{-- Decorative Gradient Top --}}
    <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-blue-500 via-purple-500 to-pink-500"></div>

    <div class="container mx-auto px-4 pt-16 pb-8">

        {{-- MAIN FOOTER GRID --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-12 mb-16">

            {{-- COL 1: Brand Info (4 Cột) --}}
            <div class="lg:col-span-4 space-y-6">
                {{-- Logo --}}
                <a href="/" class="flex items-center gap-2">
                    <div
                        class="w-10 h-10 bg-white rounded-lg flex items-center justify-center text-gray-900 font-black text-2xl">
                        F</div>
                    <span class="text-2xl font-bold text-white tracking-tight">FlexBiz<span
                            class="text-blue-500">.</span></span>
                </a>

                <p class="text-sm leading-relaxed text-gray-500">
                    Nền tảng thương mại điện tử hàng đầu, mang đến trải nghiệm mua sắm đẳng cấp với những sản phẩm được
                    tuyển chọn kỹ lưỡng và dịch vụ khách hàng tận tâm.
                </p>

                <div class="space-y-3">
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-gray-500 mt-0.5" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span class="text-sm">Tầng 12, Tòa nhà Bitexco, Q.1, TP.HCM</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                            </path>
                        </svg>
                        <span class="text-sm">contact@flexbiz.com</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                            </path>
                        </svg>
                        <span class="text-sm font-bold text-white">1900 123 456</span>
                    </div>
                </div>
            </div>

            {{-- COL 2: Về FlexBiz (Đã cập nhật Link) --}}
            <div class="lg:col-span-2">
                <h3 class="text-white font-bold text-lg mb-6">Về FlexBiz</h3>
                <ul class="space-y-4 text-sm">
                    <li><a href="{{ route('blog.detail', 'cau-chuyen-thuong-hieu') }}"
                            class="hover:text-blue-500 transition-colors">Câu chuyện thương hiệu</a></li>
                    <li><a href="{{ route('blog.detail', 'tuyen-dung') }}"
                            class="hover:text-blue-500 transition-colors">Tuyển dụng</a></li>
                    {{-- Blog News dùng route index --}}
                    <li><a href="{{ route('blog.index') }}" class="hover:text-blue-500 transition-colors">Tin
                            tức & Sự kiện</a></li>
                    <li><a href="{{ route('blog.detail', 'lien-he-hop-tac') }}"
                            class="hover:text-blue-500 transition-colors">Liên hệ hợp tác</a></li>
                </ul>
            </div>

            {{-- COL 3: Hỗ Trợ Khách Hàng (Đã cập nhật Link) --}}
            <div class="lg:col-span-3">
                <h3 class="text-white font-bold text-lg mb-6">Hỗ Trợ Khách Hàng</h3>
                <ul class="space-y-4 text-sm">
                    {{-- Giả sử trang Help Center chưa có thì trỏ về contact hoặc hướng dẫn --}}
                    <li><a href="{{ route('blog.detail', 'huong-dan-mua-hang') }}"
                            class="hover:text-blue-500 transition-colors">Trung tâm trợ giúp</a></li>
                    <li><a href="{{ route('blog.detail', 'huong-dan-mua-hang') }}"
                            class="hover:text-blue-500 transition-colors">Hướng dẫn mua hàng</a></li>
                    <li><a href="{{ route('blog.detail', 'chinh-sach-van-chuyen') }}"
                            class="hover:text-blue-500 transition-colors">Chính sách vận chuyển</a></li>
                    <li><a href="{{ route('blog.detail', 'chinh-sach-doi-tra') }}"
                            class="hover:text-blue-500 transition-colors">Chính sách đổi trả</a></li>
                    {{-- Link kiểm tra đơn hàng thường là chức năng riêng, tạm thời để # --}}
                    <li><a href="#" class="hover:text-blue-500 transition-colors">Kiểm tra đơn hàng</a></li>
                </ul>
            </div>

            {{-- COL 4: App & Social (3 Cột) --}}
            <div class="lg:col-span-3">
                <h3 class="text-white font-bold text-lg mb-6">Tải Ứng Dụng</h3>
                <p class="text-xs text-gray-500 mb-4">Mua sắm dễ dàng hơn với App FlexBiz</p>
                <div class="flex flex-col gap-3 mb-8">
                    {{-- Fake App Store Buttons --}}
                    <a href="#"
                        class="flex items-center gap-3 bg-gray-800 hover:bg-gray-700 border border-gray-700 rounded-lg p-2 transition-all">
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M16.365 1.43c0 1.14-.493 2.27-1.177 3.08-.978 1.13-2.338 1.545-2.88 1.545-.095 0-.187 0-.252-.012-.138-1.525.88-2.906 1.885-3.666.903-.68 2.018-1.07 2.424-1.07.03 0 .03 1.123 0 1.123zm-4.39 5.753c-1.385 0-2.48.917-3.13.917-.635 0-1.63-.873-2.707-.873-2.14 0-4.14 1.73-4.14 4.195 0 2.29 1.95 5.76 3.99 5.76.712 0 1.15-.46 2.08-.46.907 0 1.34.46 2.08.46 1.575 0 3.33-2.22 3.915-3.32-.085-.05-2.29-1.34-2.29-4.005 0-2.44 1.95-3.51 2.05-3.565-.96-1.425-2.44-1.585-2.95-1.61z" />
                        </svg>
                        <div class="flex flex-col">
                            <span class="text-[10px] leading-none uppercase">Download on the</span>
                            <span class="text-sm font-bold text-white leading-tight">App Store</span>
                        </div>
                    </a>
                    <a href="#"
                        class="flex items-center gap-3 bg-gray-800 hover:bg-gray-700 border border-gray-700 rounded-lg p-2 transition-all">
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M3,20.5V3.5C3,2.91 3.34,2.39 3.84,2.15L13.69,12L3.84,21.85C3.34,21.6 3,21.09 3,20.5M16.81,15.12L6.05,21.34L14.54,12.85L16.81,15.12M20.16,10.81C20.5,11.08 20.75,11.5 20.75,12C20.75,12.5 20.53,12.92 20.16,13.19L17.89,14.5L15.39,12L17.89,9.5L20.16,10.81M6.05,2.66L16.81,8.88L14.54,11.15L3.84,2.15C3.84,2.15 6.05,2.66 6.05,2.66Z" />
                        </svg>
                        <div class="flex flex-col">
                            <span class="text-[10px] leading-none uppercase">Get it on</span>
                            <span class="text-sm font-bold text-white leading-tight">Google Play</span>
                        </div>
                    </a>
                </div>

                <div class="flex gap-4">
                    {{-- Social Icons --}}
                    <a href="#"
                        class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center text-gray-400 hover:bg-blue-600 hover:text-white transition-all transform hover:-translate-y-1">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                        </svg>
                    </a>
                    <a href="#"
                        class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center text-gray-400 hover:bg-pink-600 hover:text-white transition-all transform hover:-translate-y-1">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                        </svg>
                    </a>
                    <a href="#"
                        class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center text-gray-400 hover:bg-red-600 hover:text-white transition-all transform hover:-translate-y-1">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        {{-- BOTTOM BAR --}}
        <div class="border-t border-gray-800 pt-8 flex flex-col md:flex-row items-center justify-between gap-6">

            {{-- Copyright --}}
            <div class="text-xs text-gray-500 text-center md:text-left">
                <p>&copy; 2024 FlexBiz. All rights reserved.</p>
                <div class="flex gap-4 mt-2 justify-center md:justify-start">
                    <a href="#" class="hover:text-white">Privacy Policy</a>
                    <a href="#" class="hover:text-white">Terms of Service</a>
                    <a href="#" class="hover:text-white">Cookie Settings</a>
                </div>
            </div>

            {{-- Trust Badges / Payment Icons --}}
            <div
                class="flex items-center gap-4 grayscale opacity-70 hover:grayscale-0 hover:opacity-100 transition-all duration-300">
                {{-- Ví dụ icon thanh toán (SVG placeholder) --}}
                <img src="https://upload.wikimedia.org/wikipedia/commons/5/5e/Visa_Inc._logo.svg"
                    class="h-6 w-auto bg-white rounded p-1">
                <img src="https://upload.wikimedia.org/wikipedia/commons/2/2a/Mastercard-logo.svg"
                    class="h-6 w-auto bg-white rounded p-1">
                <img src="https://upload.wikimedia.org/wikipedia/commons/b/b5/PayPal.svg"
                    class="h-6 w-auto bg-white rounded p-1">

                {{-- Logo Bộ Công Thương (Bắt buộc với Website VN) --}}
                <img src="https://webmedia.com.vn/images/2021/09/logo-da-thong-bao-bo-cong-thuong-mau-xanh.png"
                    class="h-10 w-auto">
            </div>
        </div>
    </div>
</footer>

{{-- Nút Back to Top (Master UI Feature) --}}
<button x-data="{ show: false }" x-on:scroll.window="show = window.pageYOffset > 300" x-show="show"
    x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-10"
    x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-300"
    x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-10"
    @click="window.scrollTo({top: 0, behavior: 'smooth'})"
    class="fixed bottom-8 right-8 z-40 p-3 rounded-full bg-blue-600 text-white shadow-xl hover:bg-blue-700 hover:-translate-y-1 transition-all duration-300"
    style="display: none;">
    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
    </svg>
</button>
