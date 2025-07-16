<?php
    include 'header.php';
?>

        <!-- Main Content -->
        <div class="flex-1 overflow-hidden">
            <!-- Header -->
            <header class="bg-white shadow-sm border-b border-gray-200 px-6 py-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800">Template Library</h2>
                        <p class="text-gray-600">Ready-to-use legal document templates</p>
                    </div>
                    <div class="flex items-center space-x-3">
                        <button class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">
                            <i class="fas fa-plus mr-2"></i>
                            Create Template
                        </button>
                        <button class="w-10 h-10 bg-black rounded-full flex items-center justify-center text-white hover:bg-gray-800 transition-colors">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="p-6 overflow-y-auto h-full">
                <!-- Categories -->
                <div class="flex items-center space-x-4 mb-6">
                    <button class="px-4 py-2 bg-blue-500 text-white rounded-lg text-sm font-medium">All Templates</button>
                    <button class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-200">Contracts</button>
                    <button class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-200">Agreements</button>
                    <button class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-200">Legal Forms</button>
                    <button class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-200">Employment</button>
                    <button class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-200">Privacy</button>
                </div>

                <!-- Search and Filters -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 mb-6">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <div class="relative">
                                <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                                <input type="text" placeholder="Search templates..." class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 w-80">
                            </div>
                            <select class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option>All Categories</option>
                                <option>Business</option>
                                <option>Personal</option>
                                <option>Real Estate</option>
                                <option>Intellectual Property</option>
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

                <!-- Templates Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Template Card -->
                    <div class="template-card bg-white rounded-lg shadow-sm border border-gray-200 p-6 cursor-pointer">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-file-contract text-blue-600"></i>
                            </div>
                            <div class="flex items-center space-x-2">
                                <span class="px-2 py-1 bg-green-100 text-green-800 text-xs font-medium rounded-full">Popular</span>
                                <button class="text-gray-400 hover:text-gray-600">
                                    <i class="fas fa-ellipsis-h"></i>
                                </button>
                            </div>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Service Agreement</h3>
                        <p class="text-sm text-gray-600 mb-4">Comprehensive service agreement template for client engagements</p>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-2">
                                <i class="fas fa-star text-yellow-400"></i>
                                <span class="text-sm text-gray-600">4.8 (24 reviews)</span>
                            </div>
                            <button class="px-3 py-1 bg-blue-500 text-white rounded-lg text-sm hover:bg-blue-600">Use Template</button>
                        </div>
                    </div>

                    <!-- Template Card -->
                    <div class="template-card bg-white rounded-lg shadow-sm border border-gray-200 p-6 cursor-pointer">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-handshake text-green-600"></i>
                            </div>
                            <div class="flex items-center space-x-2">
                                <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs font-medium rounded-full">New</span>
                                <button class="text-gray-400 hover:text-gray-600">
                                    <i class="fas fa-ellipsis-h"></i>
                                </button>
                            </div>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Non-Disclosure Agreement</h3>
                        <p class="text-sm text-gray-600 mb-4">Standard NDA template for protecting confidential information</p>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-2">
                                <i class="fas fa-star text-yellow-400"></i>
                                <span class="text-sm text-gray-600">4.9 (18 reviews)</span>
                            </div>
                            <button class="px-3 py-1 bg-blue-500 text-white rounded-lg text-sm hover:bg-blue-600">Use Template</button>
                        </div>
                    </div>

                    <!-- Template Card -->
                    <div class="template-card bg-white rounded-lg shadow-sm border border-gray-200 p-6 cursor-pointer">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-user-tie text-purple-600"></i>
                            </div>
                            <div class="flex items-center space-x-2">
                                <button class="text-gray-400 hover:text-gray-600">
                                    <i class="fas fa-ellipsis-h"></i>
                                </button>
                            </div>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Employment Contract</h3>
                        <p class="text-sm text-gray-600 mb-4">Standard employment agreement with customizable terms</p>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-2">
                                <i class="fas fa-star text-yellow-400"></i>
                                <span class="text-sm text-gray-600">4.7 (31 reviews)</span>
                            </div>
                            <button class="px-3 py-1 bg-blue-500 text-white rounded-lg text-sm hover:bg-blue-600">Use Template</button>
                        </div>
                    </div>

                    <!-- Template Card -->
                    <div class="template-card bg-white rounded-lg shadow-sm border border-gray-200 p-6 cursor-pointer">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-shield-alt text-red-600"></i>
                            </div>
                            <div class="flex items-center space-x-2">
                                <button class="text-gray-400 hover:text-gray-600">
                                    <i class="fas fa-ellipsis-h"></i>
                                </button>
                            </div>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Privacy Policy</h3>
                        <p class="text-sm text-gray-600 mb-4">GDPR compliant privacy policy template for websites</p>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-2">
                                <i class="fas fa-star text-yellow-400"></i>
                                <span class="text-sm text-gray-600">4.6 (15 reviews)</span>
                            </div>
                            <button class="px-3 py-1 bg-blue-500 text-white rounded-lg text-sm hover:bg-blue-600">Use Template</button>
                        </div>
                    </div>

                    <!-- Template Card -->
                    <div class="template-card bg-white rounded-lg shadow-sm border border-gray-200 p-6 cursor-pointer">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-building text-indigo-600"></i>
                            </div>
                            <div class="flex items-center space-x-2">
                                <button class="text-gray-400 hover:text-gray-600">
                                    <i class="fas fa-ellipsis-h"></i>
                                </button>
                            </div>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Lease Agreement</h3>
                        <p class="text-sm text-gray-600 mb-4">Residential lease agreement with standard clauses</p>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-2">
                                <i class="fas fa-star text-yellow-400"></i>
                                <span class="text-sm text-gray-600">4.5 (22 reviews)</span>
                            </div>
                            <button class="px-3 py-1 bg-blue-500 text-white rounded-lg text-sm hover:bg-blue-600">Use Template</button>
                        </div>
                    </div>

                    <!-- Template Card -->
                    <div class="template-card bg-white rounded-lg shadow-sm border border-gray-200 p-6 cursor-pointer">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-balance-scale text-yellow-600"></i>
                            </div>
                            <div class="flex items-center space-x-2">
                                <button class="text-gray-400 hover:text-gray-600">
                                    <i class="fas fa-ellipsis-h"></i>
                                </button>
                            </div>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Terms of Service</h3>
                        <p class="text-sm text-gray-600 mb-4">Standard terms of service template for online platforms</p>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-2">
                                <i class="fas fa-star text-yellow-400"></i>
                                <span class="text-sm text-gray-600">4.4 (19 reviews)</span>
                            </div>
                            <button class="px-3 py-1 bg-blue-500 text-white rounded-lg text-sm hover:bg-blue-600">Use Template</button>
                        </div>
                    </div>
                </div>

                <!-- Pagination -->
                <div class="mt-8 flex items-center justify-center">
                    <div class="flex items-center space-x-2">
                        <button class="px-3 py-1 border border-gray-300 rounded-lg text-sm hover:bg-gray-50">Previous</button>
                        <button class="px-3 py-1 bg-blue-500 text-white rounded-lg text-sm">1</button>
                        <button class="px-3 py-1 border border-gray-300 rounded-lg text-sm hover:bg-gray-50">2</button>
                        <button class="px-3 py-1 border border-gray-300 rounded-lg text-sm hover:bg-gray-50">3</button>
                        <button class="px-3 py-1 border border-gray-300 rounded-lg text-sm hover:bg-gray-50">Next</button>
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