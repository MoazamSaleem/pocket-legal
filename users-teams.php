<?php
    include 'header.php';
?>

        <!-- Main Content -->
        <div class="flex-1 overflow-hidden">
            <!-- Header -->
            <header class="bg-white shadow-sm border-b border-gray-200 px-6 py-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800">Users & Teams</h2>
                        <p class="text-gray-600">Manage team members and permissions</p>
                    </div>
                    <div class="flex items-center space-x-3">
                        <button class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">
                            <i class="fas fa-plus mr-2"></i>
                            Invite User
                        </button>
                        <button class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                            <i class="fas fa-users mr-2"></i>
                            Create Team
                        </button>
                    </div>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="p-6 overflow-y-auto h-full">
                <!-- Team Overview -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Total Users</p>
                                <p class="text-2xl font-bold text-gray-800">12</p>
                            </div>
                            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-users text-blue-600"></i>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Active Users</p>
                                <p class="text-2xl font-bold text-gray-800">8</p>
                            </div>
                            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-user-check text-green-600"></i>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Teams</p>
                                <p class="text-2xl font-bold text-gray-800">3</p>
                            </div>
                            <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-layer-group text-purple-600"></i>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Pending Invites</p>
                                <p class="text-2xl font-bold text-gray-800">2</p>
                            </div>
                            <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-user-clock text-yellow-600"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tabs -->
                <div class="mb-6">
                    <div class="flex space-x-1">
                        <button class="px-4 py-2 text-sm font-medium text-white bg-blue-500 rounded-lg">All Users</button>
                        <button class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200">Teams</button>
                        <button class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200">Roles</button>
                    </div>
                </div>

                <!-- Users List -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="p-4 border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-semibold text-gray-800">Team Members</h3>
                            <div class="flex items-center space-x-3">
                                <div class="relative">
                                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                                    <input type="text" placeholder="Search users..." class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                                <select class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option>All Roles</option>
                                    <option>Admin</option>
                                    <option>Editor</option>
                                    <option>Viewer</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="divide-y divide-gray-200">
                        <!-- User Item -->
                        <div class="user-item p-4 hover:bg-gray-50 cursor-pointer">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center text-white font-semibold">
                                        U
                                    </div>
                                    <div>
                                        <h4 class="font-medium text-gray-800">Umar Khan</h4>
                                        <p class="text-sm text-gray-500">umar@company.com</p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-3">
                                    <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs font-medium rounded-full">Admin</span>
                                    <span class="px-2 py-1 bg-green-100 text-green-800 text-xs font-medium rounded-full">Active</span>
                                    <div class="text-sm text-gray-500">Last seen: 2 hours ago</div>
                                    <button class="text-gray-400 hover:text-gray-600">
                                        <i class="fas fa-ellipsis-h"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- User Item -->
                        <div class="user-item p-4 hover:bg-gray-50 cursor-pointer">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center text-white font-semibold">
                                        S
                                    </div>
                                    <div>
                                        <h4 class="font-medium text-gray-800">Sarah Johnson</h4>
                                        <p class="text-sm text-gray-500">sarah@company.com</p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-3">
                                    <span class="px-2 py-1 bg-purple-100 text-purple-800 text-xs font-medium rounded-full">Editor</span>
                                    <span class="px-2 py-1 bg-green-100 text-green-800 text-xs font-medium rounded-full">Active</span>
                                    <div class="text-sm text-gray-500">Last seen: 1 day ago</div>
                                    <button class="text-gray-400 hover:text-gray-600">
                                        <i class="fas fa-ellipsis-h"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- User Item -->
                        <div class="user-item p-4 hover:bg-gray-50 cursor-pointer">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-purple-500 rounded-full flex items-center justify-center text-white font-semibold">
                                        M
                                    </div>
                                    <div>
                                        <h4 class="font-medium text-gray-800">Michael Brown</h4>
                                        <p class="text-sm text-gray-500">michael@company.com</p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-3">
                                    <span class="px-2 py-1 bg-purple-100 text-purple-800 text-xs font-medium rounded-full">Editor</span>
                                    <span class="px-2 py-1 bg-green-100 text-green-800 text-xs font-medium rounded-full">Active</span>
                                    <div class="text-sm text-gray-500">Last seen: 3 hours ago</div>
                                    <button class="text-gray-400 hover:text-gray-600">
                                        <i class="fas fa-ellipsis-h"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- User Item -->
                        <div class="user-item p-4 hover:bg-gray-50 cursor-pointer">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-yellow-500 rounded-full flex items-center justify-center text-white font-semibold">
                                        E
                                    </div>
                                    <div>
                                        <h4 class="font-medium text-gray-800">Emily Davis</h4>
                                        <p class="text-sm text-gray-500">emily@company.com</p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-3">
                                    <span class="px-2 py-1 bg-gray-100 text-gray-800 text-xs font-medium rounded-full">Viewer</span>
                                    <span class="px-2 py-1 bg-yellow-100 text-yellow-800 text-xs font-medium rounded-full">Pending</span>
                                    <div class="text-sm text-gray-500">Invited 2 days ago</div>
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
                            <p class="text-sm text-gray-500">Showing 1-4 of 12 users</p>
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