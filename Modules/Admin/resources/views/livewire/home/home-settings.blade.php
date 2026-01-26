<div class="max-w-6xl mx-auto pb-20">

    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Quản trị Trang Chủ</h1>
            <p class="text-sm text-gray-500 mt-1">Tùy chỉnh bố cục, nội dung hiển thị và các khối chức năng.</p>
        </div>
        <button wire:click="save" wire:loading.attr="disabled"
            class="btn-primary flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-lg shadow-sm font-medium transition-all">
            <svg wire:loading wire:target="save" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none"
                viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                </circle>
                <path class="opacity-75" fill="currentColor"
                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                </path>
            </svg>
            <span wire:loading.remove wire:target="save">Lưu thay đổi</span>
            <span wire:loading wire:target="save">Đang lưu...</span>
        </button>
    </div>
    <div class="border-b border-gray-200 mb-6">
        <nav class="-mb-px flex space-x-8" aria-label="Tabs">
            @foreach ([
        'layout' => 'Bố cục & Hiển thị',
        'data' => 'Dữ liệu Danh mục & Sản phẩm',
        'trust_badges' => 'Cam kết (Trust Badges)',
    ] as $key => $label)
                <button wire:click="setTab('{{ $key }}')"
                    class="{{ $activeTab === $key ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium transition-colors">
                    {{ $label }}
                </button>
            @endforeach
        </nav>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 min-h-[400px]">

        {{-- TAB 1: LAYOUT CONTROL --}}
        @if ($activeTab === 'layout')
            <div class="grid grid-cols-1 gap-4 animate-fadeIn">
                @php
                    $sections = [
                        'show_hero' => ['Banner Slider', 'Slider chính đầu trang'],
                        'show_categories' => ['Danh mục nổi bật', 'Lưới hình ảnh danh mục'],
                        'show_flash_sale' => ['Flash Sale', 'Sản phẩm giảm giá có đếm ngược'],
                        'show_featured' => ['Sản phẩm nổi bật', 'Khối sản phẩm ghim thủ công'],
                        'show_new_arrivals' => ['Hàng mới về', 'Sản phẩm mới nhất tự động'],
                        'show_blog' => ['Tin tức / Blog', 'Bài viết mới nhất'],
                    ];
                @endphp

                @foreach ($sections as $key => $info)
                    <div
                        class="flex items-center justify-between p-4 border border-gray-200 rounded-lg bg-white hover:border-indigo-300 transition shadow-sm">

                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-indigo-50 text-indigo-600 rounded-lg">
                                {{-- Icon tùy biến hoặc mặc định --}}
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-gray-900">{{ $info[0] }}</h3>
                                <p class="text-xs text-gray-500">{{ $info[1] }}</p>
                            </div>
                        </div>

                        <div class="w-48">
                            <select wire:model="layout.{{ $key }}"
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 cursor-pointer">
                                <option value="all">Hiện tất cả</option>
                                <option value="desktop">Chỉ hiện Desktop</option>
                                <option value="mobile">Chỉ hiện Mobile</option>
                                <option value="none">Ẩn hoàn toàn</option>
                            </select>

                            {{-- Hiển thị label nhỏ trạng thái --}}
                            <div class="mt-1 text-right">
                                @if ($layout[$key] == 'all')
                                    <span class="text-[10px] text-green-600 font-medium">● Hiển thị Full</span>
                                @elseif($layout[$key] == 'desktop')
                                    <span class="text-[10px] text-blue-600 font-medium">● Chỉ PC</span>
                                @elseif($layout[$key] == 'mobile')
                                    <span class="text-[10px] text-orange-600 font-medium">● Chỉ Mobile</span>
                                @else
                                    <span class="text-[10px] text-gray-400 font-medium">● Đang ẩn</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        {{-- TAB 2: DATA CONTROL --}}
        @if ($activeTab === 'data')
            <div class="space-y-8 animate-fadeIn">

                <div>
                    <h3 class="text-base font-semibold text-gray-900 mb-4">Danh mục nổi bật</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                        @foreach ($allCategories as $cat)
                            <label
                                class="relative flex items-center p-3 rounded-lg border cursor-pointer hover:bg-gray-50 {{ in_array($cat->id, $data['category_ids']) ? 'border-indigo-500 bg-indigo-50 ring-1 ring-indigo-500' : 'border-gray-200' }}">
                                <input type="checkbox" value="{{ $cat->id }}" wire:model="data.category_ids"
                                    class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600 mr-3">
                                <span class="text-sm font-medium text-gray-900">{{ $cat->name }}</span>
                            </label>
                        @endforeach
                    </div>
                    <p class="text-xs text-gray-500 mt-2">Chọn các danh mục bạn muốn hiển thị ở Section "Danh mục nổi
                        bật".</p>
                </div>

                <div class="border-t border-gray-100"></div>

                <div>
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h3 class="text-base font-semibold text-gray-900">Sản phẩm Nổi bật (Ghim thủ công)</h3>
                            <p class="text-sm text-gray-500">Những sản phẩm này sẽ hiện ở khối "Featured Products".</p>
                        </div>
                        <button type="button" wire:click="openProductPicker"
                            class="text-sm bg-gray-100 text-gray-700 px-3 py-1.5 rounded-md hover:bg-gray-200 font-medium flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4" />
                            </svg>
                            Chọn sản phẩm
                        </button>
                    </div>

                    @if (count($selectedProducts) > 0)
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach ($selectedProducts as $product)
                                <div
                                    class="flex items-center gap-3 p-2 border rounded-lg bg-white shadow-sm relative group">
                                    <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://placehold.co/50' }}"
                                        class="w-12 h-12 rounded object-cover bg-gray-100">
                                    <div class="min-w-0 flex-1">
                                        <h4 class="text-sm font-medium text-gray-900 truncate">{{ $product->title }}
                                        </h4>
                                        <p class="text-xs text-gray-500">ID: {{ $product->id }}</p>
                                    </div>
                                    <button wire:click="toggleProduct({{ $product->id }})"
                                        class="absolute top-2 right-2 text-gray-400 hover:text-red-500 opacity-0 group-hover:opacity-100 transition">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8 bg-gray-50 rounded border border-dashed text-gray-400 text-sm">Chưa
                            chọn sản phẩm nào.</div>
                    @endif
                </div>

            </div>
        @endif

        {{-- TAB 3: TRUST BADGES (REPEATER) --}}
        @if ($activeTab === 'trust_badges')
        <div class="animate-fadeIn space-y-6">

            {{-- Header hướng dẫn --}}
            <div class="bg-blue-50 text-blue-700 px-4 py-3 rounded-lg text-sm flex items-start gap-2">
                <svg class="w-5 h-5 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                <div>
                    <strong>Lưu ý:</strong> Bạn có thể nhập class icon của FontAwesome (ví dụ: <code>fa-solid fa-truck</code>) hoặc dán đường dẫn ảnh (URL) vào ô Icon.
                </div>
            </div>

            <div class="space-y-4">
                {{-- Kiểm tra nếu mảng tồn tại thì mới lặp --}}
                @if(isset($data['trust_badges']) && count($data['trust_badges']) > 0)
                    @foreach ($data['trust_badges'] as $index => $badge)
                        <div class="flex gap-4 items-start p-4 bg-gray-50 border border-gray-200 rounded-lg group hover:border-indigo-300 transition shadow-sm relative"
                            wire:key="badge-{{ $index }}"> {{-- wire:key rất quan trọng khi dùng repeater --}}

                            {{-- Số thứ tự --}}
                            <div class="pt-2">
                                <span class="flex items-center justify-center w-8 h-8 rounded-full bg-white border border-gray-200 text-xs font-bold text-gray-600 shadow-sm">
                                    {{ $index + 1 }}
                                </span>
                            </div>

                            {{-- Form Inputs --}}
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 flex-1">
                                {{-- 1. Icon --}}
                                <div>
                                    <label class="block text-xs font-bold text-gray-700 mb-1">
                                        Icon / Ảnh
                                    </label>
                                    <div class="relative">
                                        <input type="text" wire:model.live="data.trust_badges.{{ $index }}.icon"
                                            placeholder="fa-solid fa-truck hoặc Link ảnh"
                                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm pl-9">
                                        {{-- Preview Icon nhỏ trong input --}}
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                            <i class="fa-solid fa-icons"></i>
                                        </div>
                                    </div>
                                </div>

                                {{-- 2. Tiêu đề --}}
                                <div>
                                    <label class="block text-xs font-bold text-gray-700 mb-1">Tiêu đề chính</label>
                                    <input type="text" wire:model="data.trust_badges.{{ $index }}.title"
                                        placeholder="VD: Miễn phí vận chuyển"
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm font-medium">
                                </div>

                                {{-- 3. Mô tả phụ (Dùng sub_title để khớp với frontend) --}}
                                <div>
                                    <label class="block text-xs font-bold text-gray-700 mb-1">Mô tả phụ</label>
                                    <input type="text" wire:model="data.trust_badges.{{ $index }}.sub_title"
                                        placeholder="VD: Đơn hàng > 500k"
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm text-gray-500">
                                </div>
                            </div>

                            {{-- Button Xóa --}}
                            <button wire:click="removeBadge({{ $index }})"
                                class="absolute top-2 right-2 md:static md:mt-7 text-gray-400 hover:text-red-500 p-1.5 rounded-full hover:bg-red-50 transition"
                                title="Xóa mục này">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </div>
                    @endforeach
                @else
                    <div class="text-center py-8 border-2 border-dashed border-gray-300 rounded-lg">
                        <p class="text-gray-500 mb-2">Chưa có cam kết nào.</p>
                    </div>
                @endif
            </div>

            {{-- Button Thêm Mới --}}
            <div class="mt-4">
                <button wire:click="addBadge" type="button"
                    class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                    <svg class="-ml-1 mr-2 w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Thêm Cam Kết
                </button>
            </div>
        </div>
        @endif

    </div>
    @if ($showProductPicker)
        <div class="fixed inset-0 z-[999] overflow-y-auto" aria-labelledby="modal-title" role="dialog"
            aria-modal="true">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
                wire:click="$set('showProductPicker', false)"></div>

            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div
                    class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-2xl">

                    <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                        <h3 class="text-lg font-semibold leading-6 text-gray-900 mb-4" id="modal-title">Chọn sản phẩm
                        </h3>

                        <div class="mb-4">
                            <input type="text" wire:model.live.debounce.300ms="productSearchQuery"
                                placeholder="Gõ tên sản phẩm để tìm..."
                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2 px-3 border">
                        </div>

                        <div class="max-h-60 overflow-y-auto space-y-2 border-t border-gray-100 pt-2">
                            @forelse($searchProducts as $prod)
                                <div wire:click="toggleProduct({{ $prod->id }})"
                                    class="flex items-center gap-3 p-2 rounded cursor-pointer hover:bg-gray-50 transition {{ in_array($prod->id, $data['featured_ids']) ? 'bg-indigo-50 ring-1 ring-indigo-200' : '' }}">

                                    <div class="shrink-0">
                                        <img src="{{ $prod->image ? asset('storage/' . $prod->image) : 'https://placehold.co/40' }}"
                                            class="h-10 w-10 object-cover rounded bg-gray-200">
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900 truncate">{{ $prod->title }}</p>
                                        <p class="text-xs text-gray-500">{{ number_format($prod->regular_price) }}đ
                                        </p>
                                    </div>
                                    <div class="shrink-0">
                                        @if (in_array($prod->id, $data['featured_ids']))
                                            <svg class="h-5 w-5 text-indigo-600" viewBox="0 0 20 20"
                                                fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div class="text-center text-sm text-gray-500 py-4">
                                    {{ empty($productSearchQuery) ? 'Gõ từ khóa để tìm kiếm...' : 'Không tìm thấy sản phẩm nào.' }}
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                        <button type="button" wire:click="$set('showProductPicker', false)"
                            class="inline-flex w-full justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 sm:ml-3 sm:w-auto">Xong</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

{{-- Script để hiển thị Toast Notification --}}
@push('scripts')
    <script>
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('show-toast', (event) => {
                // Sử dụng thư viện Toast có sẵn (ví dụ SweetAlert2 hoặc Toastr)
                // Nếu chưa có, alert tạm hoặc tự build custom toast
                if (typeof Swal !== 'undefined') {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                    });
                    Toast.fire({
                        icon: event.type,
                        title: event.message
                    });
                } else {
                    alert(event.message); // Fallback
                }
            });
        });
    </script>
@endpush
