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

    {{-- 2. STATS GRID --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        
        {{-- Card 1: Chờ duyệt --}}
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-orange-100 text-orange-600 flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <p class="text-sm text-gray-500 font-medium">Hoa hồng chờ duyệt</p>
                <p class="text-2xl font-black text-gray-900">{{ number_format($stats['pending_earnings']) }}đ</p>
            </div>
        </div>

        {{-- Card 2: Đã duyệt --}}
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-green-100 text-green-600 flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <p class="text-sm text-gray-500 font-medium">Thu nhập khả dụng</p>
                <p class="text-2xl font-black text-gray-900">{{ number_format($stats['total_earnings']) }}đ</p>
            </div>
        </div>

        {{-- Card 3: Tổng đơn --}}
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
            </div>
            <div>
                <p class="text-sm text-gray-500 font-medium">Tổng đơn giới thiệu</p>
                <p class="text-2xl font-black text-gray-900">{{ number_format($stats['total_orders']) }} đơn</p>
            </div>
        </div>
    </div>

    {{-- 3. RECENT COMMISSIONS TABLE --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center">
            <h3 class="text-lg font-bold text-gray-900">Lịch sử giới thiệu</h3>
            <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded">Cập nhật realtime</span>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 text-gray-500 font-bold uppercase text-xs">
                    <tr>
                        <th class="px-6 py-4">Mã đơn hàng</th>
                        <th class="px-6 py-4">Ngày đặt</th>
                        <th class="px-6 py-4">Giá trị đơn</th>
                        <th class="px-6 py-4">Hoa hồng (10%)</th>
                        <th class="px-6 py-4">Trạng thái</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($commissions as $order)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 font-bold text-gray-900">
                                #{{ $order->order_code }}
                            </td>
                            <td class="px-6 py-4 text-gray-500">
                                {{ $order->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-6 py-4 font-medium">
                                {{ number_format($order->total) }}đ
                            </td>
                            <td class="px-6 py-4 font-bold text-green-600">
                                +{{ number_format($order->commission_amount) }}đ
                            </td>
                            <td class="px-6 py-4">
                                @if($order->commission_status === 'approved')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-green-100 text-green-800">
                                        Đã duyệt
                                    </span>
                                @elseif($order->commission_status === 'pending')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-yellow-100 text-yellow-800">
                                        Chờ duyệt
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-red-100 text-red-800">
                                        Đã hủy
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                <div class="flex flex-col items-center">
                                    <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    <p>Chưa có đơn hàng giới thiệu nào.</p>
                                    <p class="text-xs mt-1">Hãy copy link ở trên và chia sẻ ngay!</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($commissions->hasPages())
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $commissions->links() }}
            </div>
        @endif
    </div>
</div>