<?php
    include 'header.php';
?>
        <!-- Main Content -->
        <div class="flex-1 overflow-hidden">
            <!-- Header -->
            <header class="bg-white shadow-sm border-b border-gray-200 px-6 py-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800">Knowledge Hub</h2>
                        <p class="text-gray-600">Legal resources, guides, and best practices</p>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="relative">
                            <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                            <input type="text" placeholder="Search knowledge base..." class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 w-80">
                        </div>
                        <button class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">
                            <i class="fas fa-plus mr-2"></i>
                            Add Article
                        </button>
                    </div>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="p-6 overflow-y-auto h-full">
                <!-- Categories -->
                <div class="flex items-center space-x-4 mb-6">
                    <button class="px-4 py-2 bg-blue-500 text-white rounded-lg text-sm font-medium">All Articles</button>
                    <button class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-200">Contract Law</button>
                    <button class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-200">Employment</button>
                    <button class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-200">Compliance</button>
                    <button class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-200">Best Practices</button>
                    <button class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-200">Templates</button>
                </div>

                <!-- Featured Articles -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-8">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Featured Articles</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div class="article-card bg-gradient-to-br from-blue-50 to-blue-100 p-6 rounded-lg cursor-pointer">
                            <div class="w-12 h-12 bg-blue-500 rounded-lg flex items-center justify-center mb-4">
                                <i class="fas fa-file-contract text-white"></i>
                            </div>
                            <h4 class="font-semibold text-gray-800 mb-2">Contract Review Best Practices</h4>
                            <p class="text-sm text-gray-600 mb-4">Essential guidelines for reviewing and negotiating contracts effectively</p>
                            <span class="text-xs text-blue-600 font-medium">5 min read</span>
                        </div>

                        <div class="article-card bg-gradient-to-br from-green-50 to-green-100 p-6 rounded-lg cursor-pointer">
                            <div class="w-12 h-12 bg-green-500 rounded-lg flex items-center justify-center mb-4">
                                <i class="fas fa-shield-alt text-white"></i>
                            </div>
                            <h4 class="font-semibold text-gray-800 mb-2">GDPR Compliance Guide</h4>
                            <p class="text-sm text-gray-600 mb-4">Complete guide to ensuring GDPR compliance for your organization</p>
                            <span class="text-xs text-green-600 font-medium">12 min read</span>
                        </div>

                        <div class="article-card bg-gradient-to-br from-purple-50 to-purple-100 p-6 rounded-lg cursor-pointer">
                            <div class="w-12 h-12 bg-purple-500 rounded-lg flex items-center justify-center mb-4">
                                <i class="fas fa-users text-white"></i>
                            </div>
                            <h4 class="font-semibold text-gray-800 mb-2">Employment Law Updates</h4>
                            <p class="text-sm text-gray-600 mb-4">Latest changes in employment law and their impact on businesses</p>
                            <span class="text-xs text-purple-600 font-medium">8 min read</span>
                        </div>
                    </div>
                </div>

                <!-- Recent Articles -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-8">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Recent Articles</h3>
                    <div class="space-y-4">
                        <div class="flex items-center space-x-4 p-4 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer">
                            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-file-alt text-blue-600"></i>
                            </div>
                            <div class="flex-1">
                                <h4 class="font-medium text-gray-800">Understanding Digital Signatures</h4>
                                <p class="text-sm text-gray-600">Legal validity and implementation of digital signatures</p>
                                <div class="flex items-center mt-2 text-xs text-gray-500">
                                    <span>By Legal Team</span>
                                    <span class="mx-2">•</span>
                                    <span>2 days ago</span>
                                    <span class="mx-2">•</span>
                                    <span>7 min read</span>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">Contract Law</span>
                                <i class="fas fa-chevron-right text-gray-400"></i>
                            </div>
                        </div>

                        <div class="flex items-center space-x-4 p-4 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer">
                            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-balance-scale text-green-600"></i>
                            </div>
                            <div class="flex-1">
                                <h4 class="font-medium text-gray-800">Intellectual Property Protection</h4>
                                <p class="text-sm text-gray-600">Safeguarding your company's intellectual property rights</p>
                                <div class="flex items-center mt-2 text-xs text-gray-500">
                                    <span>By IP Specialist</span>
                                    <span class="mx-2">•</span>
                                    <span>1 week ago</span>
                                    <span class="mx-2">•</span>
                                    <span>10 min read</span>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">IP Law</span>
                                <i class="fas fa-chevron-right text-gray-400"></i>
                            </div>
                        </div>

                        <div class="flex items-center space-x-4 p-4 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer">
                            <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-user-tie text-purple-600"></i>
                            </div>
                            <div class="flex-1">
                                <h4 class="font-medium text-gray-800">Remote Work Policies</h4>
                                <p class="text-sm text-gray-600">Legal considerations for remote work arrangements</p>
                                <div class="flex items-center mt-2 text-xs text-gray-500">
                                    <span>By HR Legal</span>
                                    <span class="mx-2">•</span>
                                    <span>2 weeks ago</span>
                                    <span class="mx-2">•</span>
                                    <span>6 min read</span>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                <span class="px-2 py-1 bg-purple-100 text-purple-800 text-xs rounded-full">Employment</span>
                                <i class="fas fa-chevron-right text-gray-400"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Popular Topics -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Popular Topics</h3>
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-700">Contract Templates</span>
                                <span class="text-xs text-gray-500">24 articles</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-700">Data Privacy</span>
                                <span class="text-xs text-gray-500">18 articles</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-700">Employment Law</span>
                                <span class="text-xs text-gray-500">15 articles</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-700">Compliance</span>
                                <span class="text-xs text-gray-500">12 articles</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-700">Risk Management</span>
                                <span class="text-xs text-gray-500">9 articles</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Quick Access</h3>
                        <div class="space-y-3">
                            <button class="w-full text-left p-3 rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors">
                                <div class="flex items-center space-x-3">
                                    <i class="fas fa-download text-blue-600"></i>
                                    <span class="text-sm font-medium text-gray-800">Template Library</span>
                                </div>
                            </button>
                            <button class="w-full text-left p-3 rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors">
                                <div class="flex items-center space-x-3">
                                    <i class="fas fa-question-circle text-green-600"></i>
                                    <span class="text-sm font-medium text-gray-800">FAQ</span>
                                </div>
                            </button>
                            <button class="w-full text-left p-3 rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors">
                                <div class="flex items-center space-x-3">
                                    <i class="fas fa-video text-purple-600"></i>
                                    <span class="text-sm font-medium text-gray-800">Video Tutorials</span>
                                </div>
                            </button>
                            <button class="w-full text-left p-3 rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors">
                                <div class="flex items-center space-x-3">
                                    <i class="fas fa-headset text-red-600"></i>
                                    <span class="text-sm font-medium text-gray-800">Contact Support</span>
                                </div>
                            </button>
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