<?php
    include 'header.php';
?>

        <!-- Main Content -->
        <div class="flex-1 overflow-hidden">
            <!-- Header -->
            <header class="bg-white shadow-sm border-b border-gray-200 px-6 py-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800">All Documents</h2>
                        <p class="text-gray-600">Manage all your legal documents</p>
                    </div>
                    <div class="flex items-center space-x-3">
                        <button class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">
                            <i class="fas fa-plus mr-2"></i>
                            Upload Document
                        </button>
                        <button class="w-10 h-10 bg-black rounded-full flex items-center justify-center text-white hover:bg-gray-800 transition-colors">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="p-6 overflow-y-auto h-full">
                <!-- Filters -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 mb-6">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <div class="relative">
                                <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                                <input type="text" placeholder="Search documents..." class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <select class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option>All Types</option>
                                <option>Contracts</option>
                                <option>Agreements</option>
                                <option>Legal Documents</option>
                            </select>
                            <select class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option>All Status</option>
                                <option>Draft</option>
                                <option>Review</option>
                                <option>Approved</option>
                                <option>Signed</option>
                            </select>
                        </div>
                        <div class="flex items-center space-x-2">
                            <button class="p-2 text-gray-500 hover:text-gray-700">
                                <i class="fas fa-th-large"></i>
                            </button>
                            <button class="p-2 text-gray-500 hover:text-gray-700">
                                <i class="fas fa-list"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Documents List -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="p-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-800">Recent Documents</h3>
                    </div>
                    
                    <!-- Document Items -->
                    <div class="divide-y divide-gray-200">
                        <div class="document-item p-4 hover:bg-gray-50 cursor-pointer">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-file-alt text-blue-600"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-medium text-gray-800">Service Agreement - Tech Corp</h4>
                                        <p class="text-sm text-gray-500">Modified 2 hours ago • 1.2 MB</p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-3">
                                    <span class="px-2 py-1 bg-yellow-100 text-yellow-800 text-xs font-medium rounded-full">Review</span>
                                    <button class="text-gray-400 hover:text-gray-600">
                                        <i class="fas fa-ellipsis-h"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="document-item p-4 hover:bg-gray-50 cursor-pointer">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-file-contract text-green-600"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-medium text-gray-800">NDA - Client XYZ</h4>
                                        <p class="text-sm text-gray-500">Modified 1 day ago • 856 KB</p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-3">
                                    <span class="px-2 py-1 bg-green-100 text-green-800 text-xs font-medium rounded-full">Signed</span>
                                    <button class="text-gray-400 hover:text-gray-600">
                                        <i class="fas fa-ellipsis-h"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="document-item p-4 hover:bg-gray-50 cursor-pointer">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-file-pdf text-red-600"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-medium text-gray-800">Employment Contract - John Doe</h4>
                                        <p class="text-sm text-gray-500">Modified 3 days ago • 2.1 MB</p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-3">
                                    <span class="px-2 py-1 bg-gray-100 text-gray-800 text-xs font-medium rounded-full">Draft</span>
                                    <button class="text-gray-400 hover:text-gray-600">
                                        <i class="fas fa-ellipsis-h"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pagination -->
                    <div class="p-4 border-t border-gray-200">
                        <div class="flex items-center justify-between">
                            <p class="text-sm text-gray-500">Showing 1-3 of 12 documents</p>
                            <div class="flex items-center space-x-2">
                                <button class="px-3 py-1 border border-gray-300 rounded-lg text-sm hover:bg-gray-50">Previous</button>
                                <button class="px-3 py-1 bg-blue-500 text-white rounded-lg text-sm">1</button>
                                <button class="px-3 py-1 border border-gray-300 rounded-lg text-sm hover:bg-gray-50">2</button>
                                <button class="px-3 py-1 border border-gray-300 rounded-lg text-sm hover:bg-gray-50">3</button>
                                <button class="px-3 py-1 border border-gray-300 rounded-lg text-sm hover:bg-gray-50">Next</button>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script>
        function toggleSubmenu(id) {
            const submenu = document.getElementById(id + '-submenu');
            const arrow = document.getElementById(id + '-arrow');
            
            submenu.classList.toggle('hidden');
            arrow.classList.toggle('rotate-180');
        }
    </script>
<?php
    include 'footer.php';
?>