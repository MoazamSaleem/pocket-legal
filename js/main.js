// Main JavaScript file for PocketLegal
class PocketLegal {
    constructor() {
        this.init();
    }

    init() {
        this.bindEvents();
        this.loadDashboardData();
        this.initializeModals();
    }

    bindEvents() {
        // Sidebar toggle events
        document.addEventListener('click', (e) => {
            if (e.target.closest('[data-submenu]')) {
                const submenuId = e.target.closest('[data-submenu]').dataset.submenu;
                this.toggleSubmenu(submenuId);
            }
        });

        // User menu toggle
        const userMenuBtn = document.getElementById('user-menu-btn');
        if (userMenuBtn) {
            userMenuBtn.addEventListener('click', () => this.toggleUserMenu());
        }

        // Task modal events
        const taskModalBtn = document.getElementById('task-modal-btn');
        const taskModal = document.getElementById('taskModal');
        const taskForm = document.getElementById('taskForm');
        
        if (taskModalBtn) {
            taskModalBtn.addEventListener('click', () => this.openTaskModal());
        }
        
        if (taskForm) {
            taskForm.addEventListener('submit', (e) => this.handleTaskSubmit(e));
        }

        // Upload modal events
        const uploadModalBtn = document.getElementById('upload-modal-btn');
        const uploadForm = document.getElementById('uploadForm');
        
        if (uploadModalBtn) {
            uploadModalBtn.addEventListener('click', () => this.openUploadModal());
        }
        
        if (uploadForm) {
            uploadForm.addEventListener('submit', (e) => this.handleUploadSubmit(e));
        }

        // Status tabs
        document.querySelectorAll('.status-tab').forEach(tab => {
            tab.addEventListener('click', (e) => this.handleStatusTab(e));
        });

        // Task tabs
        document.querySelectorAll('.task-tab').forEach(tab => {
            tab.addEventListener('click', (e) => this.handleTaskTab(e));
        });

        // Close modals on outside click
        window.addEventListener('click', (e) => {
            if (e.target.classList.contains('modal')) {
                this.closeModal(e.target.id);
            }
        });

        // Auto-fill document title from filename
        const documentFile = document.getElementById('documentFile');
        if (documentFile) {
            documentFile.addEventListener('change', (e) => this.handleFileChange(e));
        }

        // Task form toggles
        document.querySelectorAll('[data-toggle]').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                const targetId = btn.dataset.toggle;
                this.toggleElement(targetId);
            });
        });
    }

    toggleSubmenu(id) {
        const submenu = document.getElementById(id + '-submenu');
        const arrow = document.getElementById(id + '-arrow');
        
        if (submenu && arrow) {
            submenu.classList.toggle('hidden');
            arrow.classList.toggle('rotate-180');
        }
    }

    toggleUserMenu() {
        const menu = document.getElementById('user-menu');
        if (menu) {
            menu.classList.toggle('hidden');
        }
    }

    openTaskModal() {
        const modal = document.getElementById('taskModal');
        if (modal) {
            modal.classList.add('show');
        }
    }

    closeTaskModal() {
        const modal = document.getElementById('taskModal');
        const form = document.getElementById('taskForm');
        
        if (modal) {
            modal.classList.remove('show');
        }
        
        if (form) {
            form.reset();
            // Hide optional inputs
            this.hideElement('dueDateInput');
            this.hideElement('reminderInput');
            this.hideElement('assignInput');
        }
    }

    openUploadModal() {
        const modal = document.getElementById('uploadModal');
        if (modal) {
            modal.classList.add('show');
        }
    }

    closeUploadModal() {
        const modal = document.getElementById('uploadModal');
        const form = document.getElementById('uploadForm');
        
        if (modal) {
            modal.classList.remove('show');
        }
        
        if (form) {
            form.reset();
        }
    }

    closeModal(modalId) {
        if (modalId === 'taskModal') {
            this.closeTaskModal();
        } else if (modalId === 'uploadModal') {
            this.closeUploadModal();
        }
    }

    toggleElement(elementId) {
        const element = document.getElementById(elementId);
        if (element) {
            element.classList.toggle('hidden');
        }
    }

    hideElement(elementId) {
        const element = document.getElementById(elementId);
        if (element) {
            element.classList.add('hidden');
        }
    }

    showElement(elementId) {
        const element = document.getElementById(elementId);
        if (element) {
            element.classList.remove('hidden');
        }
    }

    async handleTaskSubmit(e) {
        e.preventDefault();
        
        const formData = new FormData(e.target);
        const data = Object.fromEntries(formData);
        
        try {
            const response = await fetch('api/tasks.php?action=create', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data)
            });
            
            const result = await response.json();
            
            if (result.success) {
                this.closeTaskModal();
                this.showNotification('Task created successfully!', 'success');
                this.loadTasks('todo'); // Reload tasks
            } else {
                this.showNotification('Error creating task: ' + result.message, 'error');
            }
        } catch (error) {
            console.error('Error:', error);
            this.showNotification('Error creating task', 'error');
        }
    }

    async handleUploadSubmit(e) {
        e.preventDefault();
        
        const formData = new FormData(e.target);
        
        try {
            const response = await fetch('api/documents.php?action=upload', {
                method: 'POST',
                body: formData
            });
            
            const result = await response.json();
            
            if (result.success) {
                this.closeUploadModal();
                this.showNotification('Document uploaded successfully!', 'success');
                this.loadDocuments(); // Reload documents
            } else {
                this.showNotification('Error uploading document: ' + result.message, 'error');
            }
        } catch (error) {
            console.error('Error:', error);
            this.showNotification('Error uploading document', 'error');
        }
    }

    handleStatusTab(e) {
        // Remove active class from all tabs
        document.querySelectorAll('.status-tab').forEach(t => {
            t.classList.remove('active', 'border-blue-500', 'text-gray-700');
            t.classList.add('text-gray-500');
        });
        
        // Add active class to clicked tab
        e.target.classList.add('active', 'border-blue-500', 'text-gray-700');
        e.target.classList.remove('text-gray-500');
        
        // Filter documents by status
        const status = e.target.dataset.status;
        this.filterDocuments(status);
    }

    handleTaskTab(e) {
        // Remove active class from all tabs
        document.querySelectorAll('.task-tab').forEach(t => {
            t.classList.remove('active', 'border-blue-500', 'text-gray-700');
            t.classList.add('text-gray-500');
        });
        
        // Add active class to clicked tab
        e.target.classList.add('active', 'border-blue-500', 'text-gray-700');
        e.target.classList.remove('text-gray-500');
        
        // Load tasks by status
        const status = e.target.dataset.status;
        this.loadTasks(status);
    }

    handleFileChange(e) {
        const file = e.target.files[0];
        if (file) {
            const titleInput = document.getElementById('documentTitle');
            if (titleInput && !titleInput.value) {
                titleInput.value = file.name.replace(/\.[^/.]+$/, ""); // Remove extension
            }
        }
    }

    async filterDocuments(status) {
        try {
            const response = await fetch(`api/documents.php?action=list&status=${status}`);
            const result = await response.json();
            
            if (result.success) {
                this.updateDocumentsList(result.data);
            }
        } catch (error) {
            console.error('Error:', error);
        }
    }

    async loadTasks(status) {
        try {
            const response = await fetch(`api/tasks.php?action=list&status=${status}`);
            const result = await response.json();
            
            if (result.success) {
                this.updateTasksList(result.data, status);
            }
        } catch (error) {
            console.error('Error:', error);
        }
    }

    async loadDocuments() {
        try {
            const response = await fetch('api/documents.php?action=list');
            const result = await response.json();
            
            if (result.success) {
                this.updateDocumentsList(result.data);
            }
        } catch (error) {
            console.error('Error:', error);
        }
    }

    updateDocumentsList(documents) {
        const container = document.getElementById('documents-list');
        if (!container) return;
        
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
                const statusColor = this.getStatusColor(doc.status);
                return `
                    <div class="flex items-center justify-between p-3 border border-gray-200 rounded-lg hover:bg-gray-50">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-file-alt text-blue-600"></i>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-800">${this.escapeHtml(doc.title)}</h4>
                                <p class="text-sm text-gray-500">Modified ${this.formatDate(doc.updated_at)}</p>
                            </div>
                        </div>
                        <span class="px-2 py-1 bg-${statusColor}-100 text-${statusColor}-800 text-xs font-medium rounded-full">
                            ${this.formatStatus(doc.status)}
                        </span>
                    </div>
                `;
            }).join('');
            
            container.innerHTML = `<div class="space-y-3">${documentsHtml}</div>`;
        }
    }

    updateTasksList(tasks, status) {
        const container = document.getElementById('tasks-list');
        if (!container) return;
        
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
                        <button onclick="pocketLegal.openTaskModal()" class="text-blue-500 hover:text-blue-600 font-medium">Add Task</button>
                    </div>
                `;
            }
        } else {
            const tasksHtml = tasks.slice(0, 3).map(task => {
                const priorityColor = this.getPriorityColor(task.priority);
                const statusColor = this.getStatusColor(task.status);
                
                return `
                    <div class="flex items-center justify-between p-3 border border-gray-200 rounded-lg hover:bg-gray-50">
                        <div class="flex items-center space-x-3">
                            <input type="checkbox" ${task.status === 'completed' ? 'checked' : ''} class="w-4 h-4 text-blue-500 rounded">
                            <div>
                                <h4 class="font-medium text-gray-800 ${task.status === 'completed' ? 'line-through opacity-70' : ''}">${this.escapeHtml(task.title)}</h4>
                                <p class="text-sm text-gray-500">${task.due_date ? 'Due: ' + this.formatDate(task.due_date) : 'No due date'}</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="px-2 py-1 bg-${priorityColor}-100 text-${priorityColor}-800 text-xs font-medium rounded-full">
                                ${this.capitalize(task.priority)}
                            </span>
                            <span class="px-2 py-1 bg-${statusColor}-100 text-${statusColor}-800 text-xs font-medium rounded-full">
                                ${this.formatStatus(task.status)}
                            </span>
                        </div>
                    </div>
                `;
            }).join('');
            
            container.innerHTML = `<div class="space-y-3">${tasksHtml}</div>`;
        }
    }

    async loadDashboardData() {
        // Load initial data for dashboard
        if (document.getElementById('documents-list')) {
            this.loadDocuments();
        }
        
        if (document.getElementById('tasks-list')) {
            this.loadTasks('todo');
        }
    }

    initializeModals() {
        // Initialize modal close buttons
        document.querySelectorAll('[data-close-modal]').forEach(btn => {
            btn.addEventListener('click', (e) => {
                const modalId = btn.dataset.closeModal;
                this.closeModal(modalId);
            });
        });
    }

    showNotification(message, type = 'info') {
        // Create notification element
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg max-w-sm ${this.getNotificationClass(type)}`;
        notification.innerHTML = `
            <div class="flex items-center">
                <i class="fas ${this.getNotificationIcon(type)} mr-2"></i>
                <span>${message}</span>
                <button class="ml-auto text-white hover:text-gray-200" onclick="this.parentElement.parentElement.remove()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        `;
        
        document.body.appendChild(notification);
        
        // Auto remove after 5 seconds
        setTimeout(() => {
            if (notification.parentElement) {
                notification.remove();
            }
        }, 5000);
    }

    getNotificationClass(type) {
        const classes = {
            success: 'bg-green-500 text-white',
            error: 'bg-red-500 text-white',
            warning: 'bg-yellow-500 text-white',
            info: 'bg-blue-500 text-white'
        };
        return classes[type] || classes.info;
    }

    getNotificationIcon(type) {
        const icons = {
            success: 'fa-check-circle',
            error: 'fa-exclamation-circle',
            warning: 'fa-exclamation-triangle',
            info: 'fa-info-circle'
        };
        return icons[type] || icons.info;
    }

    getStatusColor(status) {
        const colors = {
            signed: 'green',
            completed: 'green',
            draft: 'gray',
            todo: 'blue',
            in_progress: 'yellow',
            review: 'yellow',
            agreed_form: 'blue',
            esigning: 'purple',
            unknown: 'gray'
        };
        return colors[status] || 'gray';
    }

    getPriorityColor(priority) {
        const colors = {
            high: 'red',
            medium: 'yellow',
            low: 'green'
        };
        return colors[priority] || 'gray';
    }

    formatStatus(status) {
        return status.charAt(0).toUpperCase() + status.slice(1).replace('_', ' ');
    }

    capitalize(str) {
        return str.charAt(0).toUpperCase() + str.slice(1);
    }

    formatDate(dateString) {
        const date = new Date(dateString);
        return date.toLocaleDateString();
    }

    escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
}

// Initialize the application when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    window.pocketLegal = new PocketLegal();
});