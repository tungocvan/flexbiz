<div class="space-y-6">
    {{-- 1. Header & Filters --}}
    <div class="flex flex-col sm:flex-row justify-between gap-4 items-center bg-white p-4 rounded-xl shadow-sm border border-gray-200">
        <h2 class="text-xl font-bold text-gray-800">Quản lý Đối Tác & Hoa Hồng</h2>
        
        <div class="flex gap-3 w-full sm:w-auto">
            <select wire:model.live="statusFilter" class="border-gray-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500">
                <option value="all">Tất cả trạng thái</option>
                <option value="pending">Chờ duyệt (Pending)</option>
                <option value="approved">Đã duyệt (Approved)</option>
                <option value="rejected">Đã hủy (Rejected)</option>
            </select>
            
            <div class="relative flex-1 sm:w-64">
                <input type="text" wire:model.live.debounce.300ms="search" 
                       placeholder="Tìm mã đơn hàng..." 
                       class="w-full border-gray-300 rounded-lg text-sm pl-10 focus:ring-blue-500 focus:border-blue-500">
                <div class="absolute left-3 top-2.5 text-gray-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </div>
            </div>
        </div>
    </div>

    {{-- 2. Data Table --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Mã Đơn</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Đối tác (Affiliate)</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Giá trị đơn</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Hoa hồng</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Trạng thái</th>
                    <th class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Hành động</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
                @forelse($commissions as $item)
                    <tr wire:key="comm-{{ $item->id }}" class="hover:bg-blue-50/30 transition">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <button wire:click="openDetail({{ $item->id }})" 
                                    class="text-blue-600 font-bold hover:underline flex items-center gap-1 group">
                                {{ $item->order_code }}
                                <svg class="w-4 h-4 opacity-0 group-hover:opacity-100" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </button>
                            <div class="text-[10px] text-gray-400 mt-1">{{ $item->created_at->format('d/m/Y H:i') }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <img class="h-8 w-8 rounded-full border border-gray-200" src="https://ui-avatars.com/api/?name={{ urlencode($item->affiliate->name ?? 'N/A') }}&background=random" alt="">
                                <div class="ml-3">
                                    <div class="text-sm font-bold text-gray-900">{{ $item->affiliate->name ?? 'Unknown' }}</div>
                                    <div class="text-xs text-gray-500">{{ $item->affiliate->email ?? '' }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 font-medium">
                            {{ number_format($item->total) }}đ
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-black text-blue-600">
                            {{ number_format($item->commission_amount) }}đ
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($item->commission_status === 'approved')
                                <span class="px-2.5 py-1 text-[10px] font-bold uppercase rounded-full bg-green-100 text-green-700 border border-green-200">Đã duyệt</span>
                            @elseif($item->commission_status === 'rejected')
                                <span class="px-2.5 py-1 text-[10px] font-bold uppercase rounded-full bg-red-100 text-red-700 border border-red-200">Từ chối</span>
                            @else
                                <span class="px-2.5 py-1 text-[10px] font-bold uppercase rounded-full bg-yellow-100 text-yellow-700 border border-yellow-200">Chờ duyệt</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right">
                            <button wire:click="openDetail({{ $item->id }})" class="text-gray-400 hover:text-blue-600 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-400 italic">Không có dữ liệu hoa hồng.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $commissions->links() }}</div>

    {{-- 3. MODAL CHI TIẾT & ĐỐI SOÁT (Master UI) --}}
    @if($isModalOpen && $selectedOrder)
        @teleport('body')
            <div class="fixed inset-0 z-[999] overflow-y-auto">
                <div class="flex min-h-full items-center justify-center p-4">
                    <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" wire:click="closeModal"></div>

                    <div class="relative w-full max-w-2xl bg-white rounded-2xl shadow-2xl border border-gray-100 overflow-hidden transform transition-all">
                        {{-- Header --}}
                        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                            <h3 class="text-lg font-bold text-gray-900">Chi tiết đối soát: #{{ $selectedOrder->order_code }}</h3>
                            <button wire:click="closeModal" class="text-gray-400 hover:text-gray-600"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                        </div>

                        {{-- Body --}}
                        <div class="p-6 space-y-6 max-h-[75vh] overflow-y-auto">
                            
                            {{-- Thông tin đối tác --}}
                            <div class="flex items-center justify-between p-4 bg-blue-50 rounded-xl border border-blue-100">
                                <div>
                                    <p class="text-[10px] font-bold text-blue-600 uppercase tracking-widest">Người thụ hưởng</p>
                                    <p class="text-sm font-bold text-gray-900">{{ $selectedOrder->affiliate->name }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-[10px] font-bold text-blue-600 uppercase tracking-widest">Tổng hoa hồng</p>
                                    <p class="text-xl font-black text-blue-700">{{ number_format($selectedOrder->commission_amount) }}đ</p>
                                </div>
                            </div>

                            {{-- Bảng kê sản phẩm (Giai đoạn 3: Snapshot hoa hồng) --}}
                            <div>
                                <h4 class="text-xs font-bold text-gray-400 uppercase mb-3">Bảng kê sản phẩm & Tỷ lệ %</h4>
                                <div class="border border-gray-100 rounded-xl overflow-hidden">
                                    <table class="w-full text-sm">
                                        <thead class="bg-gray-50 text-gray-500 font-bold">
                                            <tr>
                                                <th class="px-4 py-2 text-left">Sản phẩm</th>
                                                <th class="px-4 py-2 text-center">%</th>
                                                <th class="px-4 py-2 text-right">Hoa hồng</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-100">
                                            @foreach($selectedOrder->items as $item)
                                                <tr>
                                                    <td class="px-4 py-3">
                                                        <div class="font-bold text-gray-800">{{ $item->product_name }}</div>
                                                        <div class="text-[10px] text-gray-400">Giá: {{ number_format($item->price) }}đ x {{ $item->quantity }}</div>
                                                    </td>
                                                    <td class="px-4 py-3 text-center">
                                                        <span class="px-2 py-0.5 rounded bg-blue-100 text-blue-700 text-[10px] font-bold">
                                                            {{ $item->commission_rate ?? '10' }}%
                                                        </span>
                                                    </td>
                                                    <td class="px-4 py-3 text-right font-bold text-gray-900">
                                                        {{ number_format($item->commission_amount ?? ($item->total * 0.1)) }}đ
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            {{-- Form từ chối --}}
                            @if($showRejectForm)
                                <div class="p-4 bg-red-50 border border-red-100 rounded-xl animate-pulse-once">
                                    <label class="block text-xs font-bold text-red-700 uppercase mb-2">Lý do từ chối chi trả:</label>
                                    <textarea wire:model="rejectionReason" class="w-full border-red-200 rounded-lg text-sm focus:ring-red-500 focus:border-red-500" rows="3" placeholder="Nhập lý do (VD: Đơn hàng bị hoàn trả, gian lận...)"></textarea>
                                    @error('rejectionReason') <span class="text-[10px] text-red-600 font-bold mt-1">{{ $message }}</span> @enderror
                                    <div class="flex gap-2 mt-3">
                                        <button wire:click="reject" class="flex-1 bg-red-600 text-white py-2 rounded-lg font-bold text-sm hover:bg-red-700 transition">Xác nhận từ chối</button>
                                        <button wire:click="$set('showRejectForm', false)" class="px-4 py-2 bg-white border border-gray-200 rounded-lg text-sm font-bold text-gray-600">Hủy</button>
                                    </div>
                                </div>
                            @endif

                            @if($selectedOrder->commission_status === 'rejected')
                                <div class="p-4 bg-gray-100 rounded-xl border border-gray-200">
                                    <p class="text-xs font-bold text-gray-500 uppercase">Lý do đã từ chối:</p>
                                    <p class="text-sm italic text-gray-700 mt-1">"{{ $selectedOrder->rejection_reason }}"</p>
                                </div>
                            @endif
                        </div>

                        {{-- Footer Actions --}}
                        <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex justify-end gap-3">
                            @if($selectedOrder->commission_status === 'pending' && !$showRejectForm)
                                <button wire:click="approve({{ $selectedOrder->id }})" 
                                        wire:confirm="Xác nhận duyệt chi trả hoa hồng cho đơn hàng này?"
                                        class="px-6 py-2 bg-green-600 text-white rounded-lg font-bold text-sm hover:bg-green-700 shadow-lg shadow-green-200 transition">
                                    Duyệt Hoa Hồng
                                </button>
                                <button wire:click="$set('showRejectForm', true)" class="px-6 py-2 bg-white border border-red-200 text-red-600 rounded-lg font-bold text-sm hover:bg-red-50 transition">
                                    Từ chối
                                </button>
                            @endif
                            <button wire:click="closeModal" class="px-6 py-2 bg-white border border-gray-300 rounded-lg text-sm font-bold text-gray-700 hover:bg-gray-100 transition">Đóng</button>
                        </div>
                    </div>
                </div>
            </div>
        @endteleport
    @endif
</div>