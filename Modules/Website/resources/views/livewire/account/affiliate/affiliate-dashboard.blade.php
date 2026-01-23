<div class="space-y-8 font-sans">

    {{-- 1. HERO SECTION: CÔNG CỤ TẠO LINK --}}
    <div class="bg-gradient-to-r from-blue-900 to-blue-700 rounded-3xl p-8 md:p-12 text-white shadow-xl relative overflow-hidden">
        {{-- Background Pattern --}}
        <div class="absolute top-0 right-0 opacity-10 pointer-events-none">
            <svg class="w-64 h-64" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/></svg>
        </div>

        <div class="relative z-10 max-w-3xl">
            <h1 class="text-3xl font-black tracking-tight mb-4">Chương Trình Đối Tác FlexBiz</h1>
            <p class="text-blue-100 text-lg mb-8">Chia sẻ link sản phẩm và nhận ngay <span class="font-bold text-yellow-300">10% hoa hồng</span> cho mỗi đơn hàng thành công.</p>

            <div class="bg-white/10 backdrop-blur-md border border-white/20 p-2 rounded-2xl flex flex-col md:flex-row gap-2"
                 x-data="{
                     link: '{{ $referralLink }}',
                     copy() {
                        navigator.clipboard.writeText(this.link);
                        alert('Đã sao chép link!');
                     }
                 }">
                <div class="flex-1 flex items-center bg-white rounded-xl px-4 py-3">
                    <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                    <input type="text" x-model="link" readonly class="w-full bg-transparent border-none focus:ring-0 text-gray-800 font-bold text-sm truncate">
                </div>
                <button @click="copy()" class="bg-yellow-400 hover:bg-yellow-300 text-blue-900 font-bold px-8 py-3 rounded-xl transition shadow-lg flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"></path></svg>
                    Sao chép
                </button>
            </div>
            <p class="mt-3 text-sm text-blue-200">💡 Mẹo: Bạn có thể thêm <code class="bg-white/20 px-1 rounded">?ref={{ $referralCode }}</code> vào bất kỳ link sản phẩm nào.</p>
        </div>
    </div>

    {{-- 2. LỊCH SỬ HOA HỒNG (CÓ FILTER & MODAL) --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

        {{-- Header & Filter Tabs --}}
        <div class="px-6 py-5 border-b border-gray-100 flex flex-col sm:flex-row justify-between items-center gap-4">
            <h3 class="text-lg font-bold text-gray-900">Lịch sử giới thiệu</h3>

            {{-- Filter Tabs --}}
            <div class="flex p-1 bg-gray-100 rounded-xl">
                @foreach([
                    'all' => 'Tất cả',
                    'approved' => 'Đã nhận',
                    'pending' => 'Đang chờ',
                    'rejected' => 'Đã hủy'
                ] as $key => $label)
                    <button wire:click="$set('statusFilter', '{{ $key }}')"
                            class="px-4 py-2 text-xs font-bold rounded-lg transition-all {{ $statusFilter === $key ? 'bg-white text-blue-600 shadow-sm' : 'text-gray-500 hover:text-gray-900' }}">
                        {{ $label }}
                    </button>
                @endforeach
            </div>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 text-gray-500 font-bold uppercase text-xs">
                    <tr>
                        <th class="px-6 py-4">Mã đơn</th>
                        <th class="px-6 py-4">Khách hàng</th>
                        <th class="px-6 py-4">Giá trị đơn</th>
                        <th class="px-6 py-4">Hoa hồng</th>
                        <th class="px-6 py-4">Trạng thái</th>
                        <th class="px-6 py-4 text-center">Chi tiết</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($commissions as $order)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 font-bold text-gray-900">
                                #{{ $order->order_code }}
                                <div class="text-[10px] text-gray-400 font-normal">{{ $order->created_at->format('d/m/Y') }}</div>
                            </td>
                            <td class="px-6 py-4 text-gray-600">
                                {{ $order->customer_name }}
                            </td>
                            <td class="px-6 py-4 font-medium">
                                {{ number_format($order->total) }}đ
                            </td>
                            <td class="px-6 py-4 font-bold {{ $order->commission_status === 'rejected' ? 'text-gray-400 line-through' : 'text-green-600' }}">
                                +{{ number_format($order->commission_amount) }}đ
                            </td>
                            <td class="px-6 py-4">
                                @if($order->commission_status === 'approved')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-green-100 text-green-800 border border-green-200">
                                        Đã duyệt
                                    </span>
                                @elseif($order->commission_status === 'pending')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-yellow-100 text-yellow-800 border border-yellow-200">
                                        Chờ duyệt
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-red-100 text-red-800 border border-red-200">
                                        Đã hủy
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                <button wire:click="openOrderModal({{ $order->id }})"
                                        class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-full transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                <p>Không tìm thấy đơn hàng nào.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 border-t border-gray-100">
            {{ $commissions->links() }}
        </div>
    </div>

    {{-- 3. MODAL CHI TIẾT (ĐÃ CHỈNH NHỎ GỌN & CĂN GIỮA) --}}
    @if($isModalOpen && $selectedOrder)
        @teleport('body')
            {{-- Wrapper tổng: Z-index cao nhất, bao phủ toàn màn hình --}}
            <div class="relative" style="z-index: 999999;" aria-labelledby="modal-title" role="dialog" aria-modal="true">

                {{-- A. BACKDROP (Lớp nền tối mờ) --}}
                <div class="fixed inset-0 bg-gray-900/75 transition-opacity backdrop-blur-sm"
                     wire:click="closeModal"></div>

                {{-- B. CONTAINER CĂN GIỮA (Quan trọng) --}}
                <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                    {{--
                        flex min-h-full items-center: Căn giữa theo chiều dọc
                        justify-center: Căn giữa theo chiều ngang
                        p-4: Padding để không dính sát mép trên Mobile
                    --}}
                    <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">

                        {{-- C. MODAL BOX (Nội dung chính) --}}
                        {{--
                            w-full max-w-lg: Giới hạn chiều rộng tối đa là LG (khoảng 512px) -> Nhỏ gọn
                            rounded-2xl: Bo góc mềm mại
                        --}}
                        <div class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 w-full max-w-lg border border-gray-100">

                            {{-- Header --}}
                            <div class="bg-white px-5 py-4 border-b border-gray-100 flex justify-between items-center sticky top-0 z-20">
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900">Chi tiết hoa hồng</h3>
                                    <p class="text-xs text-gray-500 mt-0.5">Mã đơn: <span class="font-mono font-bold text-blue-600">#{{ $selectedOrder->order_code }}</span></p>
                                </div>
                                <button wire:click="closeModal" class="rounded-full p-2 bg-gray-50 hover:bg-gray-100 text-gray-400 hover:text-gray-600 transition focus:outline-none">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>
                            </div>

                            {{-- Body (Scrollable) --}}
                            <div class="p-5 max-h-[70vh] overflow-y-auto custom-scrollbar bg-white">

                                {{-- 1. Trạng thái --}}
                                <div class="mb-5 p-3 rounded-xl {{ $selectedOrder->commission_status === 'rejected' ? 'bg-red-50 border border-red-100' : ($selectedOrder->commission_status === 'approved' ? 'bg-green-50 border border-green-100' : 'bg-yellow-50 border border-yellow-100') }}">
                                    <div class="flex justify-between items-center">
                                        <span class="text-xs font-bold text-gray-500 uppercase tracking-wider">Trạng thái</span>
                                        @if($selectedOrder->commission_status === 'approved')
                                            <span class="inline-flex items-center gap-1 px-2 py-1 rounded bg-green-100 text-green-700 text-xs font-bold border border-green-200">
                                                ĐÃ DUYỆT
                                            </span>
                                        @elseif($selectedOrder->commission_status === 'rejected')
                                            <span class="inline-flex items-center gap-1 px-2 py-1 rounded bg-red-100 text-red-700 text-xs font-bold border border-red-200">
                                                ĐÃ TỪ CHỐI
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-2 py-1 rounded bg-yellow-100 text-yellow-700 text-xs font-bold border border-yellow-200">
                                                ĐANG CHỜ
                                            </span>
                                        @endif
                                    </div>

                                    @if($selectedOrder->commission_status === 'rejected' && $selectedOrder->rejection_reason)
                                        <div class="mt-2 pt-2 border-t border-red-200/50">
                                            <p class="text-[10px] font-bold text-red-600 mb-1 uppercase">Lý do từ chối:</p>
                                            <p class="text-xs text-red-800 italic bg-white/60 p-2 rounded border border-red-100">
                                                "{{ $selectedOrder->rejection_reason }}"
                                            </p>
                                        </div>
                                    @endif
                                </div>

                                {{-- 2. Sản phẩm --}}
                                <div class="mb-5">
                                    <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Sản phẩm ({{ $selectedOrder->items->count() }})</h4>
                                    <div class="border border-gray-100 rounded-lg overflow-hidden">
                                        <table class="w-full text-sm">
                                            <tbody class="divide-y divide-gray-100 bg-gray-50/30">
                                                @foreach($selectedOrder->items as $item)
                                                    <tr>
                                                        <td class="px-3 py-2 text-gray-800">
                                                            <div class="font-medium line-clamp-1 text-xs sm:text-sm">{{ $item->product_name }}</div>
                                                            <div class="text-[10px] text-gray-400">SL: {{ $item->quantity }}</div>
                                                        </td>
                                                        <td class="px-3 py-2 text-right font-bold text-gray-900 text-xs sm:text-sm">{{ number_format($item->total) }}đ</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                {{-- 3. Tổng kết --}}
                                <div class="bg-gray-50 rounded-xl p-4 space-y-2">
                                    <div class="flex justify-between items-center text-xs sm:text-sm">
                                        <span class="text-gray-500">Doanh thu đơn hàng</span>
                                        <span class="font-bold text-gray-900">{{ number_format($selectedOrder->total) }}đ</span>
                                    </div>
                                    <div class="flex justify-between items-center text-xs sm:text-sm">
                                        <span class="text-gray-500">Tỷ lệ hoa hồng</span>
                                        <span class="font-bold text-gray-700">10%</span>
                                    </div>
                                    <div class="border-t border-gray-200 border-dashed my-2"></div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm font-bold text-blue-900 uppercase">Hoa hồng bạn nhận</span>
                                        <span class="text-lg sm:text-xl font-black text-blue-600">+{{ number_format($selectedOrder->commission_amount) }}đ</span>
                                    </div>
                                </div>
                            </div>

                            {{-- Footer --}}
                            <div class="bg-gray-50 px-5 py-3 text-right border-t border-gray-100">
                                <button wire:click="closeModal" class="w-full sm:w-auto px-4 py-2 bg-white border border-gray-300 rounded-lg shadow-sm text-sm font-bold text-gray-700 hover:bg-gray-100 transition focus:outline-none">
                                    Đóng
                                </button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        @endteleport
    @endif

</div>
