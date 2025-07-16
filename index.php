<?php
    include 'header.php';
?>

        <!-- Main Content -->
        <div class="flex-1 overflow-hidden">
            <!-- Header -->
            <header class="bg-white shadow-sm border-b border-gray-200 px-6 py-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800">Welcome back <?php echo explode(' ', $_SESSION['user_name'])[0]; ?>,</h2>
                        <p class="text-gray-600">Here is what's happening in your account</p>
                    </div>
                    <button id="task-modal-btn" class="w-10 h-10 bg-black rounded-full flex items-center justify-center text-white hover:bg-gray-800 transition-colors">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="p-6 overflow-y-auto h-full">
                <!-- Action Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <!-- AI Review Card -->
                    <div class="ai-review-btn bg-gradient-to-br from-blue-500 to-blue-600 text-white p-6 rounded-lg shadow-lg card-hover transition-all cursor-pointer">
                        <div class="flex items-center mb-3">
                            <i class="fas fa-robot text-2xl mr-3"></i>
                            <span class="text-sm font-medium opacity-90">AI</span>
                        </div>
                        <h3 class="text-xl font-bold mb-2">Review contract with AI</h3>
                        <p class="text-sm opacity-90">Get immediate responses to your questions and AI assistance with drafting and summarizing</p>
                    </div>

                    <!-- Create Document Card -->
                    <div class="bg-gray-800 text-white p-6 rounded-lg shadow-lg card-hover transition-all cursor-pointer" onclick="window.location.href='template-library.php'">
                        <div class="flex items-center mb-3">
                            <i class="fas fa-file-alt text-2xl mr-3"></i>
                            <span class="text-sm font-medium opacity-90">Template library</span>
                        </div>
                        <h3 class="text-xl font-bold mb-2">Create a document</h3>
                        <p class="text-sm opacity-90">Create a contract based on a template</p>
                    </div>

                    <!-- Upload Documents Card -->
                    <div id="upload-modal-btn" class="bg-gray-800 text-white p-6 rounded-lg shadow-lg card-hover transition-all cursor-pointer">
                        <div class="flex items-center mb-3">
                            <i class="fas fa-cloud-upload-alt text-2xl mr-3"></i>
                            <span class="text-sm font-medium opacity-90">Repository</span>
                        </div>
                        <h3 class="text-xl font-bold mb-2">Upload documents</h3>
                        <p class="text-sm opacity-90">Upload files or folders to the repository and autotag metadata with AI</p>
                    </div>

                    <!-- eSignature Card -->
                    <div class="esignature-btn bg-gray-800 text-white p-6 rounded-lg shadow-lg card-hover transition-all cursor-pointer">
                        <div class="flex items-center mb-3">
                            <i class="fas fa-signature text-2xl mr-3"></i>
                            <span class="text-sm font-medium opacity-90">eSigning</span>
                        </div>
                        <h3 class="text-xl font-bold mb-2">Send for eSignature</h3>
                        <p class="text-sm opacity-90">Upload a document and send for eSigning instantly</p>
                    </div>
                </div>

                <!-- Content Grid -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Contract Workflow -->
                    <div class="lg:col-span-2">
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                            <div class="flex items-center justify-between mb-6">
                                <h3 class="text-lg font-semibold text-gray-800">Contract workflow</h3>
                                <div class="flex items-center space-x-4">
                                    <div class="flex items-center space-x-2">
                                        <button class="px-3 py-1 bg-gray-100 text-gray-700 rounded-lg text-sm">My documents</button>
                                        <select class="px-3 py-1 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            <option>Last 30 days</option>
                                            <option>Last 60 days</option>
                                            <option>Last 90 days</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Status Tabs -->
                            <div class="flex space-x-1 mb-6 overflow-x-auto">
                                <button class="px-4 py-2 text-sm font-medium text-gray-700 border-b-2 border-blue-500 whitespace-nowrap status-tab active" data-status="">All</button>
                                <button class="px-4 py-2 text-sm font-medium text-gray-500 hover:text-gray-700 whitespace-nowrap status-tab" data-status="draft">Draft</button>
                                <button class="px-4 py-2 text-sm font-medium text-gray-500 hover:text-gray-700 whitespace-nowrap status-tab" data-status="review">Review</button>
                                <button class="px-4 py-2 text-sm font-medium text-gray-500 hover:text-gray-700 whitespace-nowrap status-tab" data-status="agreed_form">Agreed form</button>
                                <button class="px-4 py-2 text-sm font-medium text-gray-500 hover:text-gray-700 whitespace-nowrap status-tab" data-status="esigning">eSigning</button>
                                <button class="px-4 py-2 text-sm font-medium text-gray-500 hover:text-gray-700 whitespace-nowrap status-tab" data-status="signed">Signed</button>
                                <button class="px-4 py-2 text-sm font-medium text-gray-500 hover:text-gray-700 whitespace-nowrap status-tab" data-status="unknown">Unknown</button>
                            </div>

                            <!-- Documents List -->
                            <div id="documents-list">
                                <div class="text-center py-12">
                                    <i class="fas fa-file-alt text-4xl text-gray-400 mb-4"></i>
                                    <h4 class="text-lg font-medium text-gray-800 mb-2">No documents</h4>
                                    <p class="text-gray-500 mb-4">No documents with All status</p>
                                    <button onclick="window.location.href='documents.php'" class="text-blue-500 hover:text-blue-600 font-medium">View all</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tasks -->
                    <div class="lg:col-span-1">
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                            <div class="flex items-center justify-between mb-6">
                                <h3 class="text-lg font-semibold text-gray-800">Tasks</h3>
                                <button onclick="window.location.href='tasks.php'" class="text-blue-500 hover:text-blue-600 font-medium">Show all</button>
                            </div>

                            <!-- Task Tabs -->
                            <div class="flex space-x-1 mb-6">
                                <button class="px-4 py-2 text-sm font-medium text-gray-700 border-b-2 border-blue-500 task-tab active" data-status="todo">To-do</button>
                                <button class="px-4 py-2 text-sm font-medium text-gray-500 hover:text-gray-700 task-tab" data-status="completed">Completed</button>
                            </div>

                            <!-- Tasks List -->
                            <div id="tasks-list">
                                <div class="text-center py-8">
                                    <i class="fas fa-tasks text-4xl text-gray-400 mb-4"></i>
                                    <h4 class="text-lg font-medium text-gray-800 mb-2">No tasks</h4>
                                    <p class="text-gray-500 mb-4">Create your first task to get started</p>
                                    <button onclick="pocketLegal.openTaskModal()" class="text-blue-500 hover:text-blue-600 font-medium">Add Task</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Add Task Modal -->
    <div id="taskModal" class="modal">
        <div class="modal-content">
            <div class="p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-800">Add task</h3>
                    <button data-close-modal="taskModal" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                
                <form id="taskForm">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Title</label>
                            <input type="text" id="taskTitle" name="title" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                            <textarea id="taskDescription" name="description" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                        </div>
                        
                        <div class="flex items-center justify-between py-3">
                            <div class="flex items-center space-x-3">
                                <i class="fas fa-eye text-gray-400"></i>
                                <span class="text-sm text-gray-700">Visible to everyone in your company</span>
                            </div>
                            <label class="toggle-switch">
                                <input type="checkbox" id="visibleToCompany" name="visible_to_company" checked>
                                <span class="toggle-slider"></span>
                            </label>
                        </div>
                        
                        <div class="space-y-3">
                            <button type="button" data-toggle="dueDateInput" class="flex items-center space-x-3 text-blue-500 hover:text-blue-600">
                                <i class="fas fa-calendar"></i>
                                <span>Add due date</span>
                            </button>
                            
                            <div id="dueDateInput" class="hidden">
                                <input type="datetime-local" id="taskDueDate" name="due_date" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            
                            <button type="button" data-toggle="reminderInput" class="flex items-center space-x-3 text-blue-500 hover:text-blue-600">
                                <i class="fas fa-bell"></i>
                                <span>Add reminder</span>
                            </button>
                            
                            <div id="reminderInput" class="hidden">
                                <input type="datetime-local" id="taskReminder" name="reminder_date" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            
                            <button type="button" data-toggle="assignInput" class="flex items-center space-x-3 text-blue-500 hover:text-blue-600">
                                <i class="fas fa-user"></i>
                                <span>Assign users</span>
                            </button>
                            
                            <div id="assignInput" class="hidden">
                                <select id="taskAssignee" name="assigned_to" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="<?php echo $_SESSION['user_id']; ?>"><?php echo $_SESSION['user_name']; ?> (Me)</option>
                                </select>
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Related attachment</label>
                            <button type="button" class="flex items-center space-x-3 text-blue-500 hover:text-blue-600">
                                <i class="fas fa-paperclip"></i>
                                <span>Attach document</span>
                            </button>
                        </div>
                        
                        <div class="flex items-center space-x-3 pt-4">
                            <button type="submit" class="px-6 py-2 bg-black text-white rounded-lg hover:bg-gray-800 transition-colors">
                                Add
                            </button>
                            <button type="button" data-close-modal="taskModal" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                                Cancel
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Upload Modal -->
    <div id="uploadModal" class="modal">
        <div class="modal-content">
            <div class="p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-800">Upload Document</h3>
                    <button data-close-modal="uploadModal" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                
                <form id="uploadForm" enctype="multipart/form-data">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Document Title</label>
                            <input type="text" id="documentTitle" name="title" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Select File</label>
                            <input type="file" id="documentFile" name="file" required accept=".pdf,.doc,.docx,.txt" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Document Type</label>
                            <select name="document_type" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="contract">Contract</option>
                                <option value="agreement">Agreement</option>
                                <option value="legal_document">Legal Document</option>
                                <option value="template">Template</option>
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                            <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="draft">Draft</option>
                                <option value="review">Review</option>
                                <option value="agreed_form">Agreed Form</option>
                                <option value="esigning">eSigning</option>
                                <option value="signed">Signed</option>
                            </select>
                        </div>
                        
                        <div class="flex items-center space-x-3 pt-4">
                            <button type="submit" class="px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">
                                Upload
                            </button>
                            <button type="button" data-close-modal="uploadModal" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                                Cancel
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php
    include 'footer.php';
?>