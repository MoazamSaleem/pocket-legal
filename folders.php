<?php
    include 'header.php';
?>

        <!-- Main Content -->
        <div class="flex-1 overflow-hidden">
            <!-- Header -->
            <header class="bg-white shadow-sm border-b border-gray-200 px-6 py-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800">Folders</h2>
                        <p class="text-gray-600">Organize your documents in folders</p>
                    </div>
                    <div class="flex items-center space-x-3">
                        <button class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">
                            <i class="fas fa-plus mr-2"></i>
                            Create Folder
                        </button>
                        <button class="w-10 h-10 bg-black rounded-full flex items-center justify-center text-white hover:bg-gray-800 transition-colors">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="p-6 overflow-y-auto h-full">
                <!-- Breadcrumb -->
                <nav class="mb-6">
                    <ol class="flex items-center space-x-2 text-sm text-gray-500">
                        <li><a href="#" class="hover:text-gray-700">Home</a></li>
                        <li><i class="fas fa-chevron-right"></i></li>
                        <li class="text-gray-900">Folders</li>
                    </ol>
                </nav>

                <!-- Folders Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    <!-- Folder Item -->
                    <div class="folder-item bg-white p-6 rounded-lg shadow-sm border border-gray-200 hover:shadow-md transition-shadow cursor-pointer">
                        <div class="flex items-center justify-between mb-4">
                            <i class="fas fa-folder text-3xl text-blue-500"></i>
                            <button class="text-gray-400 hover:text-gray-600">
                                <i class="fas fa-ellipsis-h"></i>
                            </button>
                        </div>
                        <h3 class="font-semibold text-gray-800 mb-2">Client Contracts</h3>
                        <p class="text-sm text-gray-500">15 documents</p>
                        <div class="mt-4 flex items-center text-xs text-gray-400">
                            <i class="fas fa-clock mr-1"></i>
                            Modified 2 hours ago
                        </div>
                    </div>

                    <!-- Folder Item -->
                    <div class="folder-item bg-white p-6 rounded-lg shadow-sm border border-gray-200 hover:shadow-md transition-shadow cursor-pointer">
                        <div class="flex items-center justify-between mb-4">
                            <i class="fas fa-folder text-3xl text-green-500"></i>
                            <button class="text-gray-400 hover:text-gray-600">
                                <i class="fas fa-ellipsis-h"></i>
                            </button>
                        </div>
                        <h3 class="font-semibold text-gray-800 mb-2">Legal Templates</h3>
                        <p class="text-sm text-gray-500">8 documents</p>
                        <div class="mt-4 flex items-center text-xs text-gray-400">
                            <i class="fas fa-clock mr-1"></i>
                            Modified 1 day ago
                        </div>
                    </div>

                    <!-- Folder Item -->
                    <div class="folder-item bg-white p-6 rounded-lg shadow-sm border border-gray-200 hover:shadow-md transition-shadow cursor-pointer">
                        <div class="flex items-center justify-between mb-4">
                            <i class="fas fa-folder text-3xl text-purple-500"></i>
                            <button class="text-gray-400 hover:text-gray-600">
                                <i class="fas fa-ellipsis-h"></i>
                            </button>
                        </div>
                        <h3 class="font-semibold text-gray-800 mb-2">HR Documents</h3>
                        <p class="text-sm text-gray-500">23 documents</p>
                        <div class="mt-4 flex items-center text-xs text-gray-400">
                            <i class="fas fa-clock mr-1"></i>
                            Modified 3 days ago
                        </div>
                    </div>

                    <!-- Folder Item -->
                    <div class="folder-item bg-white p-6 rounded-lg shadow-sm border border-gray-200 hover:shadow-md transition-shadow cursor-pointer">
                        <div class="flex items-center justify-between mb-4">
                            <i class="fas fa-folder text-3xl text-orange-500"></i>
                            <button class="text-gray-400 hover:text-gray-600">
                                <i class="fas fa-ellipsis-h"></i>
                            </button>
                        </div>
                        <h3 class="font-semibold text-gray-800 mb-2">Compliance</h3>
                        <p class="text-sm text-gray-500">12 documents</p>
                        <div class="mt-4 flex items-center text-xs text-gray-400">
                            <i class="fas fa-clock mr-1"></i>
                            Modified 1 week ago
                        </div>
                    </div>

                    <!-- Folder Item -->
                    <div class="folder-item bg-white p-6 rounded-lg shadow-sm border border-gray-200 hover:shadow-md transition-shadow cursor-pointer">
                        <div class="flex items-center justify-between mb-4">
                            <i class="fas fa-folder text-3xl text-red-500"></i>
                            <button class="text-gray-400 hover:text-gray-600">
                                <i class="fas fa-ellipsis-h"></i>
                            </button>
                        </div>
                        <h3 class="font-semibold text-gray-800 mb-2">Archived</h3>
                        <p class="text-sm text-gray-500">45 documents</p>
                        <div class="mt-4 flex items-center text-xs text-gray-400">
                            <i class="fas fa-clock mr-1"></i>
                            Modified 2 weeks ago
                        </div>
                    </div>

                    <!-- Folder Item -->
                    <div class="folder-item bg-white p-6 rounded-lg shadow-sm border border-gray-200 hover:shadow-md transition-shadow cursor-pointer">
                        <div class="flex items-center justify-between mb-4">
                            <i class="fas fa-folder text-3xl text-indigo-500"></i>
                            <button class="text-gray-400 hover:text-gray-600">
                                <i class="fas fa-ellipsis-h"></i>
                            </button>
                        </div>
                        <h3 class="font-semibold text-gray-800 mb-2">Drafts</h3>
                        <p class="text-sm text-gray-500">7 documents</p>
                        <div class="mt-4 flex items-center text-xs text-gray-400">
                            <i class="fas fa-clock mr-1"></i>
                            Modified 5 hours ago
                        </div>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="mt-8 bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="p-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-800">Recent Activity</h3>
                    </div>
                    <div class="divide-y divide-gray-200">
                        <div class="p-4 flex items-center space-x-3">
                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-folder-plus text-blue-600 text-sm"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-800">Created new folder "Client Contracts"</p>
                                <p class="text-xs text-gray-500">2 hours ago</p>
                            </div>
                        </div>
                        <div class="p-4 flex items-center space-x-3">
                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-file-upload text-green-600 text-sm"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-800">Uploaded 3 files to "Legal Templates"</p>
                                <p class="text-xs text-gray-500">1 day ago</p>
                            </div>
                        </div>
                        <div class="p-4 flex items-center space-x-3">
                            <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-edit text-purple-600 text-sm"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-800">Modified folder "HR Documents"</p>
                                <p class="text-xs text-gray-500">3 days ago</p>
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
<?php
    include 'footer.php';
?>