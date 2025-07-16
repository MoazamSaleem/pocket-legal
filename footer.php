    <script>
        function toggleSubmenu(id) {
            const submenu = document.getElementById(id + '-submenu');
            const arrow = document.getElementById(id + '-arrow');
            
            submenu.classList.toggle('hidden');
            arrow.classList.toggle('rotate-180');
        }

        function toggleUserMenu() {
            const menu = document.getElementById('user-menu');
            menu.classList.toggle('hidden');
        }

        // Task Modal Functions
        function openTaskModal() {
            document.getElementById('taskModal').classList.add('show');
        }

        function closeTaskModal() {
            document.getElementById('taskModal').classList.remove('show');
            document.getElementById('taskForm').reset();
            // Hide optional inputs
            document.getElementById('dueDateInput').classList.add('hidden');
            document.getElementById('reminderInput').classList.add('hidden');
            document.getElementById('assignInput').classList.add('hidden');
        }

        function toggleDueDateInput() {
            document.getElementById('dueDateInput').classList.toggle('hidden');
        }

        function toggleReminderInput() {
            document.getElementById('reminderInput').classList.toggle('hidden');
        }

        function toggleAssignInput() {
            document.getElementById('assignInput').classList.toggle('hidden');
        }

        // Upload Modal Functions
        function openUploadModal() {
            document.getElementById('uploadModal').classList.add('show');
        }

        function closeUploadModal() {
            document.getElementById('uploadModal').classList.remove('show');
            document.getElementById('uploadForm').reset();
        }

        // Task Form Submission
        document.getElementById('taskForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const data = Object.fromEntries(formData);
            
            fetch('api/tasks.php?action=create', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    closeTaskModal();
                    location.reload(); // Refresh to show new task
                } else {
                    alert('Error creating task: ' + result.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error creating task');
            });
        });

        // Upload Form Submission
        document.getElementById('uploadForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            
            fetch('api/documents.php?action=upload', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    closeUploadModal();
                    location.reload(); // Refresh to show new document
                } else {
                    alert('Error uploading document: ' + result.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error uploading document');
            });
        });

        // Status Tab Functionality
        document.querySelectorAll('.status-tab').forEach(tab => {
            tab.addEventListener('click', function() {
                // Remove active class from all tabs
                document.querySelectorAll('.status-tab').forEach(t => {
                    t.classList.remove('active', 'border-blue-500', 'text-gray-700');
                    t.classList.add('text-gray-500');
                });
                
                // Add active class to clicked tab
                this.classList.add('active', 'border-blue-500', 'text-gray-700');
                this.classList.remove('text-gray-500');
                
                // Filter documents by status
                const status = this.dataset.status;
                filterDocuments(status);
            });
        });

        function filterDocuments(status) {
            fetch(`api/documents.php?action=list&status=${status}`)
                .then(response => response.json())
                .then(result => {
                    if (result.success) {
                        updateDocumentsList(result.data);
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        function updateDocumentsList(documents) {
            const container = document.getElementById('documents-list');
            
            if (documents.length === 0) {
                container.innerHTML = `
                    <div class="text-center py-12">
                        <i class="fas fa-file-alt text-4xl text-gray-400 mb-4"></i>
                        <h4 class="text-lg font-medium text-gray-800 mb-2">No documents</h4>
                        <p class="text-gray-500 mb-4">No documents found</p>
                        <button onclick="window.location.href='documents.php'" class="text-blue-500 hover:text-blue-600 font-medium">View all</button>
                    </div>
                `;
            } else {
                const documentsHtml = documents.map(doc => {
                    const statusColor = doc.status === 'signed' ? 'green' : (doc.status === 'draft' ? 'gray' : 'yellow');
                    return `
                        <div class="flex items-center justify-between p-3 border border-gray-200 rounded-lg hover:bg-gray-50">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-file-alt text-blue-600"></i>
                                </div>
                                <div>
                                    <h4 class="font-medium text-gray-800">${doc.title}</h4>
                                    <p class="text-sm text-gray-500">Modified ${new Date(doc.updated_at).toLocaleDateString()}</p>
                                </div>
                            </div>
                            <span class="px-2 py-1 bg-${statusColor}-100 text-${statusColor}-800 text-xs font-medium rounded-full">
                                ${doc.status.charAt(0).toUpperCase() + doc.status.slice(1).replace('_', ' ')}
                            </span>
                        </div>
                    `;
                }).join('');
                
                container.innerHTML = `<div class="space-y-3">${documentsHtml}</div>`;
            }
        }

        // Load tasks on page load
        document.addEventListener('DOMContentLoaded', function() {
            loadTasks('todo');
        });

        function loadTasks(status) {
            fetch(`api/tasks.php?action=list&status=${status}`)
                .then(response => response.json())
                .then(result => {
                    if (result.success) {
                        updateTasksList(result.data, status);
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        function updateTasksList(tasks, status) {
            const container = document.getElementById('tasks-list');
            
            if (tasks.length === 0) {
                if (status === 'completed') {
                    container.innerHTML = `
                        <div class="text-center py-8">
                            <i class="fas fa-check-circle text-4xl text-green-500 mb-4"></i>
                            <h4 class="text-lg font-medium text-gray-800 mb-2">Well done!</h4>
                            <p class="text-gray-500">You have completed all your tasks</p>
                        </div>
                    `;
                } else {
                    container.innerHTML = `
                        <div class="text-center py-8">
                            <i class="fas fa-tasks text-4xl text-gray-400 mb-4"></i>
                            <h4 class="text-lg font-medium text-gray-800 mb-2">No tasks</h4>
                            <p class="text-gray-500 mb-4">Create your first task to get started</p>
                            <button onclick="openTaskModal()" class="text-blue-500 hover:text-blue-600 font-medium">Add Task</button>
                        </div>
                    `;
                }
            } else {
                const tasksHtml = tasks.slice(0, 3).map(task => {
                    const priorityColor = task.priority === 'high' ? 'red' : (task.priority === 'medium' ? 'yellow' : 'green');
                    const statusColor = task.status === 'completed' ? 'green' : (task.status === 'in_progress' ? 'yellow' : 'blue');
                    
                    return `
                        <div class="flex items-center justify-between p-3 border border-gray-200 rounded-lg hover:bg-gray-50">
                            <div class="flex items-center space-x-3">
                                <input type="checkbox" ${task.status === 'completed' ? 'checked' : ''} class="w-4 h-4 text-blue-500 rounded">
                                <div>
                                    <h4 class="font-medium text-gray-800 ${task.status === 'completed' ? 'line-through opacity-70' : ''}">${task.title}</h4>
                                    <p class="text-sm text-gray-500">${task.due_date ? 'Due: ' + new Date(task.due_date).toLocaleDateString() : 'No due date'}</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                <span class="px-2 py-1 bg-${priorityColor}-100 text-${priorityColor}-800 text-xs font-medium rounded-full">
                                    ${task.priority.charAt(0).toUpperCase() + task.priority.slice(1)}
                                </span>
                                <span class="px-2 py-1 bg-${statusColor}-100 text-${statusColor}-800 text-xs font-medium rounded-full">
                                    ${task.status.replace('_', ' ').charAt(0).toUpperCase() + task.status.replace('_', ' ').slice(1)}
                                </span>
                            </div>
                        </div>
                    `;
                }).join('');
                
                container.innerHTML = `<div class="space-y-3">${tasksHtml}</div>`;
            }
        }

        // Task Tab Functionality
        document.querySelectorAll('.task-tab').forEach(tab => {
            tab.addEventListener('click', function() {
                // Remove active class from all tabs
                document.querySelectorAll('.task-tab').forEach(t => {
                    t.classList.remove('active', 'border-blue-500', 'text-gray-700');
                    t.classList.add('text-gray-500');
                });
                
                // Add active class to clicked tab
                this.classList.add('active', 'border-blue-500', 'text-gray-700');
                this.classList.remove('text-gray-500');
                
                // Load tasks by status
                const status = this.dataset.status;
                loadTasks(status);
            });
        });

        // Close modals when clicking outside
        window.addEventListener('click', function(event) {
            const taskModal = document.getElementById('taskModal');
            const uploadModal = document.getElementById('uploadModal');
            
            if (event.target === taskModal) {
                closeTaskModal();
            }
            if (event.target === uploadModal) {
                closeUploadModal();
            }
        });

        // Auto-fill document title from filename
        document.getElementById('documentFile').addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const titleInput = document.getElementById('documentTitle');
                if (!titleInput.value) {
                    titleInput.value = file.name.replace(/\.[^/.]+$/, ""); // Remove extension
                }
            }
        });
    </script>
</body>
</html>