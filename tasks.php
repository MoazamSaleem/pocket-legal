<?php
    include 'header.php';
?>
        <!-- Main Content -->
        <div class="flex-1 overflow-hidden">
            <!-- Header -->
            <header class="bg-white shadow-sm border-b border-gray-200 px-6 py-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800">Tasks</h2>
                        <p class="text-gray-600">Manage your legal tasks and workflow</p>
                    </div>
                    <div class="flex items-center space-x-3">
                        <button class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">
                            <i class="fas fa-plus mr-2"></i>
                            New Task
                        </button>
                        <button class="w-10 h-10 bg-black rounded-full flex items-center justify-center text-white hover:bg-gray-800 transition-colors">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="p-6 overflow-y-auto h-full">
                <!-- Task Stats -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Total Tasks</p>
                                <p class="text-2xl font-bold text-gray-800">24</p>
                            </div>
                            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-tasks text-blue-600"></i>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">In Progress</p>
                                <p class="text-2xl font-bold text-gray-800">8</p>
                            </div>
                            <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-clock text-yellow-600"></i>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Completed</p>
                                <p class="text-2xl font-bold text-gray-800">14</p>
                            </div>
                            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-check-circle text-green-600"></i>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Overdue</p>
                                <p class="text-2xl font-bold text-gray-800">2</p>
                            </div>
                            <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-exclamation-triangle text-red-600"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Task Filters -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 mb-6">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <div class="relative">
                                <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                                <input type="text" placeholder="Search tasks..." class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <select class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option>All Tasks</option>
                                <option>To Do</option>
                                <option>In Progress</option>
                                <option>Completed</option>
                                <option>Overdue</option>
                            </select>
                            <select class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option>All Priorities</option>
                                <option>High</option>
                                <option>Medium</option>
                                <option>Low</option>
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

                <!-- Task List -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="p-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-800">Active Tasks</h3>
                    </div>
                    
                    <div class="divide-y divide-gray-200">
                        <!-- Task Item -->
                        <div class="task-item p-4 hover:bg-gray-50 cursor-pointer">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <input type="checkbox" class="w-5 h-5 text-blue-500 rounded border-gray-300 focus:ring-blue-500">
                                    <div class="flex-1">
                                        <h4 class="font-medium text-gray-800">Review NDA with TechCorp</h4>
                                        <p class="text-sm text-gray-500">Due: Tomorrow at 3:00 PM</p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-3">
                                    <span class="px-2 py-1 bg-red-100 text-red-800 text-xs font-medium rounded-full">High</span>
                                    <span class="px-2 py-1 bg-yellow-100 text-yellow-800 text-xs font-medium rounded-full">In Progress</span>
                                    <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center text-white text-sm font-medium">
                                        U
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Task Item -->
                        <div class="task-item p-4 hover:bg-gray-50 cursor-pointer">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <input type="checkbox" class="w-5 h-5 text-blue-500 rounded border-gray-300 focus:ring-blue-500">
                                    <div class="flex-1">
                                        <h4 class="font-medium text-gray-800">Draft employment contract for new hire</h4>
                                        <p class="text-sm text-gray-500">Due: Friday at 5:00 PM</p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-3">
                                    <span class="px-2 py-1 bg-yellow-100 text-yellow-800 text-xs font-medium rounded-full">Medium</span>
                                    <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs font-medium rounded-full">To Do</span>
                                    <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center text-white text-sm font-medium">
                                        J
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Task Item -->
                        <div class="task-item p-4 hover:bg-gray-50 cursor-pointer">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <input type="checkbox" checked class="w-5 h-5 text-blue-500 rounded border-gray-300 focus:ring-blue-500">
                                    <div class="flex-1">
                                        <h4 class="font-medium text-gray-800 task-completed">Update privacy policy</h4>
                                        <p class="text-sm text-gray-500">Completed yesterday</p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-3">
                                    <span class="px-2 py-1 bg-gray-100 text-gray-800 text-xs font-medium rounded-full">Low</span>
                                    <span class="px-2 py-1 bg-green-100 text-green-800 text-xs font-medium rounded-full">Completed</span>
                                    <div class="w-8 h-8 bg-purple-500 rounded-full flex items-center justify-center text-white text-sm font-medium">
                                        S
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Task Item -->
                        <div class="task-item p-4 hover:bg-gray-50 cursor-pointer">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <input type="checkbox" class="w-5 h-5 text-blue-500 rounded border-gray-300 focus:ring-blue-500">
                                    <div class="flex-1">
                                        <h4 class="font-medium text-gray-800">Prepare contract amendments</h4>
                                        <p class="text-sm text-gray-500">Due: Next Monday at 9:00 AM</p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-3">
                                    <span class="px-2 py-1 bg-yellow-100 text-yellow-800 text-xs font-medium rounded-full">Medium</span>
                                    <span class="px-2 py-1 bg-yellow-100 text-yellow-800 text-xs font-medium rounded-full">In Progress</span>
                                    <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center text-white text-sm font-medium">
                                        U
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Task Actions -->
                    <div class="p-4 border-t border-gray-200 bg-gray-50">
                        <div class="flex items-center justify-between">
                            <p class="text-sm text-gray-500">4 tasks selected</p>
                            <div class="flex items-center space-x-2">
                                <button class="px-3 py-1 bg-blue-500 text-white rounded-lg text-sm hover:bg-blue-600">Mark Complete</button>
                                <button class="px-3 py-1 border border-gray-300 rounded-lg text-sm hover:bg-gray-50">Delete</button>
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

        // Task completion toggle
        $(document).ready(function() {
            $('input[type="checkbox"]').change(function() {
                const taskText = $(this).siblings('div').find('h4');
                if (this.checked) {
                    taskText.addClass('task-completed');
                } else {
                    taskText.removeClass('task-completed');
                }
            });
        });
    </script>
<?php
    include 'footer.php';
?>