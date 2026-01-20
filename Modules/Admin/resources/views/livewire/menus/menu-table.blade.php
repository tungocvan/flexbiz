<div class="max-w-4xl mx-auto px-4 sm:px-6 md:px-8">
    
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Quản lý Menu</h1>
            <p class="mt-1 text-sm text-gray-500">Kéo thả để sắp xếp vị trí và phân cấp menu.</p>
        </div>
        <a href="{{ route('admin.menus.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg font-bold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
            <svg class="-ml-1 mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Thêm Menu Mới
        </a>
    </div>

    <div 
        x-data="menuSortable()"
        x-init="initSortable()"
        class="bg-gray-50 rounded-xl border border-gray-200 p-6 min-h-[400px]"
    >
        <ul id="root-menu-list" class="space-y-3 menu-list">
            @foreach($menus as $menu)
                <x-menu-item :menu="$menu" />
            @endforeach
        </ul>

        @if($menus->isEmpty())
            <div class="text-center py-10 text-gray-400 border-2 border-dashed border-gray-300 rounded-lg">
                Chưa có menu nào. Hãy thêm mới!
            </div>
        @endif
    </div>
    <script>
        function menuSortable() {
            return {
                initSortable() {
                    // Tìm tất cả các list (cả cha và con)
                    const nestedSortables = [].slice.call(document.querySelectorAll('.menu-list'));
    
                    // Khởi tạo Sortable cho từng list
                    nestedSortables.forEach((el) => {
                        new Sortable(el, {
                            group: 'nested', // Cho phép kéo qua lại giữa các cấp
                            animation: 150,
                            fallbackOnBody: true,
                            swapThreshold: 0.65,
                            handle: '.drag-handle', // Chỉ kéo được khi nắm vào icon này
                            ghostClass: 'bg-indigo-50', // Class khi đang kéo
                            onEnd: (evt) => {
                                this.saveOrder();
                            }
                        });
                    });
                },
                saveOrder() {
                    // Hàm đệ quy để lấy cấu trúc ID
                    const getIds = (root) => {
                        const items = [];
                        // Lấy các thẻ li trực tiếp của ul hiện tại
                        const lis = root.children; 
                        
                        for (let i = 0; i < lis.length; i++) {
                            const li = lis[i];
                            // Bỏ qua nếu không phải element node (hoặc template)
                            if (li.tagName !== 'LI') continue;
                            
                            const id = li.getAttribute('data-id');
                            // Tìm ul con bên trong li này (nếu có)
                            const childUl = li.querySelector('ul');
                            
                            const item = { id: id };
                            if (childUl && childUl.children.length > 0) {
                                item.children = getIds(childUl);
                            }
                            items.push(item);
                        }
                        return items;
                    };
    
                    const rootList = document.getElementById('root-menu-list');
                    const payload = getIds(rootList);
                    
                    // Gửi về Livewire
                    @this.updateMenuOrder(payload);
                }
            }
        }
    </script>
    <style>
        /* Style cho placeholder khi kéo */
        .bg-indigo-50 { background-color: #eef2ff; border: 1px dashed #6366f1; opacity: 0.8; }
    </style>
</div>

