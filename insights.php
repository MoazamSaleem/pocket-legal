<?php
    include 'header.php';
?>

    <!-- Main Content -->
    <div class="flex-1 overflow-hidden">
        <!-- Header -->
        <header class="bg-white shadow-sm border-b border-gray-200 px-6 py-4">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Insights</h2>
                    <p class="text-gray-600">Analytics and performance metrics</p>
                </div>
                <div class="flex items-center space-x-3">
                    <select class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option>Last 30 days</option>
                        <option>Last 60 days</option>
                        <option>Last 90 days</option>
                        <option>Last year</option>
                    </select>
                    <button class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">
                        <i class="fas fa-download mr-2"></i>
                        Export Report
                    </button>
                </div>
            </div>
        </header>

        <!-- Main Content Area -->
        <main class="p-6 overflow-y-auto h-full">
            <!-- Key Metrics -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Total Documents</p>
                            <p class="text-2xl font-bold text-gray-800">1,247</p>
                            <p class="text-sm text-green-600">+12% from last month</p>
                        </div>
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-file-alt text-blue-600"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Contracts Signed</p>
                            <p class="text-2xl font-bold text-gray-800">89</p>
                            <p class="text-sm text-green-600">+8% from last month</p>
                        </div>
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-signature text-green-600"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Avg. Review Time</p>
                            <p class="text-2xl font-bold text-gray-800">2.4 days</p>
                            <p class="text-sm text-red-600">+15% from last month</p>
                        </div>
                        <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-clock text-yellow-600"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">AI Queries</p>
                            <p class="text-2xl font-bold text-gray-800">456</p>
                            <p class="text-sm text-green-600">+25% from last month</p>
                        </div>
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-robot text-purple-600"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Row -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <!-- Document Activity Chart -->
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Document Activity</h3>
                    <canvas id="documentChart" width="400" height="200"></canvas>
                </div>

                <!-- Contract Status Chart -->
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Contract Status Distribution</h3>
                    <canvas id="statusChart" width="400" height="200"></canvas>
                </div>
            </div>

            <!-- Performance Metrics -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Top Document Types -->
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Top Document Types</h3>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-file-contract text-blue-600 text-sm"></i>
                                </div>
                                <span class="text-sm font-medium text-gray-800">Service Agreements</span>
                            </div>
                            <span class="text-sm text-gray-500">45%</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-handshake text-green-600 text-sm"></i>
                                </div>
                                <span class="text-sm font-medium text-gray-800">NDAs</span>
                            </div>
                            <span class="text-sm text-gray-500">32%</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-user-tie text-purple-600 text-sm"></i>
                                </div>
                                <span class="text-sm font-medium text-gray-800">Employment</span>
                            </div>
                            <span class="text-sm text-gray-500">23%</span>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Recent Activity</h3>
                    <div class="space-y-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-file-plus text-blue-600 text-sm"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-800">New contract created</p>
                                <p class="text-xs text-gray-500">2 hours ago</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-check text-green-600 text-sm"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-800">Document approved</p>
                                <p class="text-xs text-gray-500">4 hours ago</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-robot text-purple-600 text-sm"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-800">AI analysis completed</p>
                                <p class="text-xs text-gray-500">6 hours ago</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Performance Score -->
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Performance Score</h3>
                    <div class="flex items-center justify-center mb-4">
                        <div class="relative w-32 h-32">
                            <svg class="w-32 h-32 transform -rotate-90" viewBox="0 0 36 36">
                                <path class="text-gray-200" stroke="currentColor" stroke-width="2" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"></path>
                                <path class="text-blue-500" stroke="currentColor" stroke-width="2" fill="none" stroke-dasharray="85, 100" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"></path>
                            </svg>
                            <div class="absolute inset-0 flex items-center justify-center">
                                <span class="text-2xl font-bold text-gray-800">85%</span>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <p class="text-sm text-gray-600">Overall efficiency rating</p>
                        <p class="text-xs text-green-600 mt-1">+5% from last month</p>
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

    // Initialize charts
    document.addEventListener('DOMContentLoaded', function() {
        // Document Activity Chart
        const documentCtx = document.getElementById('documentChart').getContext('2d');
        new Chart(documentCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    label: 'Documents Created',
                    data: [65, 59, 80, 81, 56, 55],
                    borderColor: 'rgb(59, 130, 246)',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Contract Status Chart
        const statusCtx = document.getElementById('statusChart').getContext('2d');
        new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: ['Signed', 'Review', 'Draft', 'Expired'],
                datasets: [{
                    data: [45, 25, 20, 10],
                    backgroundColor: [
                        'rgb(34, 197, 94)',
                        'rgb(251, 191, 36)',
                        'rgb(59, 130, 246)',
                        'rgb(239, 68, 68)'
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    });
</script>
<?php
    include 'footer.php';
?>