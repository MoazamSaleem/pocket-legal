<?php
    include 'header.php';
?>

        <!-- Main Content -->
        <div class="flex-1 overflow-hidden">
            <!-- Header -->
            <header class="bg-white shadow-sm border-b border-gray-200 px-6 py-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800">Template Drafts</h2>
                        <p class="text-gray-600">Your work-in-progress templates</p>
                    </div>
                    <div class="flex items-center space-x-3">
                        <button class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">
                            <i class="fas fa-plus mr-2"></i>
                            New Template
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
                                <input type="text" placeholder="Search templates..." class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <select class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option>All Templates</option>
                                <option>Contracts</option>
                                <option>Agreements</option>
                                <option>Legal Forms</option>
                            </select>
                            <select class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option>All Status</option>
                                <option>Draft</option>
                                <option>Review</option>
                                <option>Approved</option>
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

                <!-- Templates List -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="p-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-800">Draft Templates</h3>
                    </div>
                    
                    <div class="divide-y divide-gray-200">
                        <!-- Template Item -->
                        <div class="template-item p-4 hover:bg-gray-50 cursor-pointer">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-file-alt text-yellow-600"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-medium text-gray-800">Service Agreement Template v2</h4>
                                        <p class="text-sm text-gray-500">Last modified 1 hour ago • 2.3 KB</p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-3">
                                    <span class="px-2 py-1 bg-yellow-100 text-yellow-800 text-xs font-medium rounded-full">Draft</span>
                                    <div class="flex items-center space-x-2">
                                        <button class="p-1 text-gray-400 hover:text-blue-600">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="p-1 text-gray-400 hover:text-green-600">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="p-1 text-gray-400 hover:text-red-600">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Template Item -->
                        <div class="template-item p-4 hover:bg-gray-50 cursor-pointer">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-handshake text-blue-600"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-medium text-gray-800">NDA Template - Updated</h4>
                                        <p class="text-sm text-gray-500">Last modified 2 days ago • 1.8 KB</p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-3">
                                    <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs font-medium rounded-full">Review</span>
                                    <div class="flex items-center space-x-2">
                                        <button class="p-1 text-gray-400 hover:text-blue-600">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="p-1 text-gray-400 hover:text-green-600">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="p-1 text-gray-400 hover:text-red-600">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Template Item -->
                        <div class="template-item p-4 hover:bg-gray-50 cursor-pointer">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-user-tie text-green-600"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-medium text-gray-800">Employment Contract - Remote</h4>
                                        <p class="text-sm text-gray-500">Last modified 1 week ago • 3.1 KB</p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-3">
                                    <span class="px-2 py-1 bg-green-100 text-green-800 text-xs font-medium rounded-full">Approved</span>
                                    <div class="flex items-center space-x-2">
                                        <button class="p-1 text-gray-400 hover:text-blue-600">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="p-1 text-gray-400 hover:text-green-600">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="p-1 text-gray-400 hover:text-red-600">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Template Item -->
                        <div class="template-item p-4 hover:bg-gray-50 cursor-pointer">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-shield-alt text-purple-600"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-medium text-gray-800">Privacy Policy Template</h4>
                                        <p class="text-sm text-gray-500">Last modified 2 weeks ago • 4.2 KB</p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-3">
                                    <span class="px-2 py-1 bg-yellow-100 text-yellow-800 text-xs font-medium rounded-full">Draft</span>
                                    <div class="flex items-center space-x-2">
                                        <button class="p-1 text-gray-400 hover:text-blue-600">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="p-1 text-gray-400 hover:text-green-600">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="p-1 text-gray-400 hover:text-red-600">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Template Actions -->
                    <div class="p-4 border-t border-gray-200 bg-gray-50">
                        <div class="flex items-center justify-between">
                            <p class="text-sm text-gray-500">4 templates found</p>
                            <div class="flex items-center space-x-2">
                                <button class="px-3 py-1 bg-blue-500 text-white rounded-lg text-sm hover:bg-blue-600">Publish Selected</button>
                                <button class="px-3 py-1 border border-gray-300 rounded-lg text-sm hover:bg-gray-50">Archive</button>
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