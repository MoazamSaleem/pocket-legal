// Main JavaScript file for PocketLegal
class PocketLegal {
    constructor() {
        this.init();
    }

    init() {
        this.bindEvents();
        this.loadDashboardData();
        this.initializeModals();
        this.initializeFilters();
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

        // Task checkboxes
        document.addEventListener('change', (e) => {
            if (e.target.type === 'checkbox' && e.target.closest('.task-item')) {
                this.handleTaskStatusChange(e);
            }
        });

        // Document actions
        document.addEventListener('click', (e) => {
            if (e.target.closest('.document-action')) {
                const action = e.target.closest('.document-action').dataset.action;
                const documentId = e.target.closest('.document-action').dataset.id;
                this.handleDocumentAction(action, documentId);
            }
        });

        // Task actions
        document.addEventListener('click', (e) => {
            if (e.target.closest('.task-action')) {
                const action = e.target.closest('.task-action').dataset.action;
                const taskId = e.target.closest('.task-action').dataset.id;
                this.handleTaskAction(action, taskId);
            }
        });

        // Filter events
        document.addEventListener('change', (e) => {
            if (e.target.classList.contains('filter-select')) {
                this.applyFilters();
            }
        });

        document.addEventListener('input', (e) => {
            if (e.target.classList.contains('search-input')) {
                this.debounce(() => this.applyFilters(), 300)();
            }
        });

        // AI Review button
        document.addEventListener('click', (e) => {
            if (e.target.closest('.ai-review-btn')) {
                this.handleAIReview();
            }
        });

        // eSignature button
        document.addEventListener('click', (e) => {
            if (e.target.closest('.esignature-btn')) {
                this.handleESignature();
            }
        });

        // Invite user button
        document.addEventListener('click', (e) => {
            if (e.target.closest('.invite-user-btn')) {
                this.openInviteUserModal();
            }
        });

        // Create team button
        document.addEventListener('click', (e) => {
            if (e.target.closest('.create-team-btn')) {
                this.openCreateTeamModal();
            }
        });
    }

    initializeFilters() {
        // Initialize filter functionality for all pages
        this.currentFilters = {
            search: '',
            status: '',
            type: '',
            priority: '',
            role: ''
        };
    }

    applyFilters() {
        const searchInput = document.querySelector('.search-input');
        const statusSelect = document.querySelector('.status-filter');
        const typeSelect = document.querySelector('.type-filter');
        const prioritySelect = document.querySelector('.priority-filter');
        const roleSelect = document.querySelector('.role-filter');

        this.currentFilters = {
            search: searchInput ? searchInput.value : '',
            status: statusSelect ? statusSelect.value : '',
            type: typeSelect ? typeSelect.value : '',
            priority: prioritySelect ? prioritySelect.value : '',
            role: roleSelect ? roleSelect.value : ''
        };

        // Determine current page and apply appropriate filter
        const currentPage = window.location.pathname.split('/').pop();
        
        switch (currentPage) {
            case 'documents.php':
                this.filterDocuments();
                break;
            case 'tasks.php':
                this.filterTasks();
                break;
            case 'users-teams.php':
                this.filterUsers();
                break;
            case 'templates.php':
                this.filterTemplates();
                break;
            case 'template-library.php':
                this.filterTemplateLibrary();
                break;
            default:
                break;
        }
    }

    async filterDocuments() {
        try {
            const params = new URLSearchParams();
            Object.keys(this.currentFilters).forEach(key => {
                if (this.currentFilters[key]) {
                    params.append(key, this.currentFilters[key]);
                }
            });

            const response = await fetch(`api/documents.php?action=list&${params.toString()}`);
            const result = await response.json();
            
            if (result.success) {
                this.updateDocumentsList(result.data);
            }
        } catch (error) {
            console.error('Error filtering documents:', error);
        }
    }

    async filterTasks() {
        try {
            const params = new URLSearchParams();
            Object.keys(this.currentFilters).forEach(key => {
                if (this.currentFilters[key]) {
                    params.append(key, this.currentFilters[key]);
                }
            });

            const response = await fetch(`api/tasks.php?action=list&${params.toString()}`);
            const result = await response.json();
            
            if (result.success) {
                this.updateTasksList(result.data);
            }
        } catch (error) {
            console.error('Error filtering tasks:', error);
        }
    }

    async filterUsers() {
        try {
            const params = new URLSearchParams();
            Object.keys(this.currentFilters).forEach(key => {
                if (this.currentFilters[key]) {
                    params.append(key, this.currentFilters[key]);
                }
            });

            const response = await fetch(`api/users.php?action=list&${params.toString()}`);
            const result = await response.json();
            
            if (result.success) {
                this.updateUsersList(result.data);
            }
        } catch (error) {
            console.error('Error filtering users:', error);
        }
    }

    async filterTemplates() {
        try {
            const params = new URLSearchParams();
            Object.keys(this.currentFilters).forEach(key => {
                if (this.currentFilters[key]) {
                    params.append(key, this.currentFilters[key]);
                }
            });

            const response = await fetch(`api/templates.php?action=list&${params.toString()}`);
            const result = await response.json();
            
            if (result.success) {
                this.updateTemplatesList(result.data);
            }
        } catch (error) {
            console.error('Error filtering templates:', error);
        }
    }

    async filterTemplateLibrary() {
        try {
            const params = new URLSearchParams();
            Object.keys(this.currentFilters).forEach(key => {
                if (this.currentFilters[key]) {
                    params.append(key, this.currentFilters[key]);
                }
            });

            const response = await fetch(`api/template-library.php?action=list&${params.toString()}`);
            const result = await response.json();
            
            if (result.success) {
                this.updateTemplateLibraryList(result.data);
            }
        } catch (error) {
            console.error('Error filtering template library:', error);
        }
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

    openInviteUserModal() {
        // Create invite user modal dynamically
        const modalHtml = `
            <div id="inviteUserModal" class="modal show">
                <div class="modal-content">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-lg font-semibold text-gray-800">Invite User</h3>
                            <button data-close-modal="inviteUserModal" class="text-gray-400 hover:text-gray-600">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        
                        <form id="inviteUserForm">
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                                    <input type="email" name="email" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Role</label>
                                    <select name="role" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <option value="viewer">Viewer</option>
                                        <option value="editor">Editor</option>
                                        <option value="admin">Admin</option>
                                    </select>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Message (Optional)</label>
                                    <textarea name="message" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Welcome message..."></textarea>
                                </div>
                                
                                <div class="flex items-center space-x-3 pt-4">
                                    <button type="submit" class="px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">
                                        Send Invitation
                                    </button>
                                    <button type="button" data-close-modal="inviteUserModal" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                                        Cancel
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        `;
        
        document.body.insertAdjacentHTML('beforeend', modalHtml);
        
        // Bind form submit
        document.getElementById('inviteUserForm').addEventListener('submit', (e) => this.handleInviteUser(e));
        
        // Bind close button
        document.querySelector('[data-close-modal="inviteUserModal"]').addEventListener('click', () => {
            document.getElementById('inviteUserModal').remove();
        });
    }

    openCreateTeamModal() {
        // Create team modal dynamically
        const modalHtml = `
            <div id="createTeamModal" class="modal show">
                <div class="modal-content">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-lg font-semibold text-gray-800">Create Team</h3>
                            <button data-close-modal="createTeamModal" class="text-gray-400 hover:text-gray-600">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        
                        <form id="createTeamForm">
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Team Name</label>
                                    <input type="text" name="name" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                                    <textarea name="description" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                                </div>
                                
                                <div class="flex items-center space-x-3 pt-4">
                                    <button type="submit" class="px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">
                                        Create Team
                                    </button>
                                    <button type="button" data-close-modal="createTeamModal" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                                        Cancel
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        `;
        
        document.body.insertAdjacentHTML('beforeend', modalHtml);
        
        // Bind form submit
        document.getElementById('createTeamForm').addEventListener('submit', (e) => this.handleCreateTeam(e));
        
        // Bind close button
        document.querySelector('[data-close-modal="createTeamModal"]').addEventListener('click', () => {
            document.getElementById('createTeamModal').remove();
        });
    }

    closeModal(modalId) {
        if (modalId === 'taskModal') {
            this.closeTaskModal();
        } else if (modalId === 'uploadModal') {
            this.closeUploadModal();
        } else {
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.remove();
            }
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
                
                // Reload tasks based on current page
                const currentPage = window.location.pathname.split('/').pop();
                if (currentPage === 'tasks.php') {
                    this.loadTasks();
                } else {
                    this.loadDashboardData();
                }
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
                
                // Reload documents based on current page
                const currentPage = window.location.pathname.split('/').pop();
                if (currentPage === 'documents.php') {
                    this.loadDocuments();
                } else {
                    this.loadDashboardData();
                }
            } else {
                this.showNotification('Error uploading document: ' + result.message, 'error');
            }
        } catch (error) {
            console.error('Error:', error);
            this.showNotification('Error uploading document', 'error');
        }
    }

    async handleInviteUser(e) {
        e.preventDefault();
        
        const formData = new FormData(e.target);
        const data = Object.fromEntries(formData);
        
        try {
            const response = await fetch('api/users.php?action=invite', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data)
            });
            
            const result = await response.json();
            
            if (result.success) {
                document.getElementById('inviteUserModal').remove();
                this.showNotification('User invitation sent successfully!', 'success');
                this.filterUsers();
            } else {
                this.showNotification('Error sending invitation: ' + result.message, 'error');
            }
        } catch (error) {
            console.error('Error:', error);
            this.showNotification('Error sending invitation', 'error');
        }
    }

    async handleCreateTeam(e) {
        e.preventDefault();
        
        const formData = new FormData(e.target);
        const data = Object.fromEntries(formData);
        
        try {
            const response = await fetch('api/teams.php?action=create', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data)
            });
            
            const result = await response.json();
            
            if (result.success) {
                document.getElementById('createTeamModal').remove();
                this.showNotification('Team created successfully!', 'success');
                // Reload teams if on teams page
            } else {
                this.showNotification('Error creating team: ' + result.message, 'error');
            }
        } catch (error) {
            console.error('Error:', error);
            this.showNotification('Error creating team', 'error');
        }
    }

    async handleTaskStatusChange(e) {
        const taskId = e.target.closest('.task-item').dataset.taskId;
        const newStatus = e.target.checked ? 'completed' : 'todo';
        
        try {
            const response = await fetch(`api/tasks.php?action=update&id=${taskId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ status: newStatus })
            });
            
            const result = await response.json();
            
            if (result.success) {
                this.showNotification('Task status updated!', 'success');
                
                // Update UI
                const taskText = e.target.closest('.task-item').querySelector('h4');
                if (newStatus === 'completed') {
                    taskText.classList.add('line-through', 'opacity-70');
                } else {
                    taskText.classList.remove('line-through', 'opacity-70');
                }
            } else {
                // Revert checkbox state
                e.target.checked = !e.target.checked;
                this.showNotification('Error updating task status', 'error');
            }
        } catch (error) {
            console.error('Error:', error);
            e.target.checked = !e.target.checked;
            this.showNotification('Error updating task status', 'error');
        }
    }

    async handleDocumentAction(action, documentId) {
        switch (action) {
            case 'delete':
                if (confirm('Are you sure you want to delete this document?')) {
                    await this.deleteDocument(documentId);
                }
                break;
            case 'download':
                await this.downloadDocument(documentId);
                break;
            case 'share':
                await this.shareDocument(documentId);
                break;
        }
    }

    async handleTaskAction(action, taskId) {
        switch (action) {
            case 'delete':
                if (confirm('Are you sure you want to delete this task?')) {
                    await this.deleteTask(taskId);
                }
                break;
            case 'edit':
                await this.editTask(taskId);
                break;
            case 'complete':
                await this.completeTask(taskId);
                break;
        }
    }

    async deleteDocument(documentId) {
        try {
            const response = await fetch(`api/documents.php?action=delete&id=${documentId}`, {
                method: 'DELETE'
            });
            
            const result = await response.json();
            
            if (result.success) {
                this.showNotification('Document deleted successfully!', 'success');
                this.loadDocuments();
            } else {
                this.showNotification('Error deleting document', 'error');
            }
        } catch (error) {
            console.error('Error:', error);
            this.showNotification('Error deleting document', 'error');
        }
    }

    async deleteTask(taskId) {
        try {
            const response = await fetch(`api/tasks.php?action=delete&id=${taskId}`, {
                method: 'DELETE'
            });
            
            const result = await response.json();
            
            if (result.success) {
                this.showNotification('Task deleted successfully!', 'success');
                this.loadTasks();
            } else {
                this.showNotification('Error deleting task', 'error');
            }
        } catch (error) {
            console.error('Error:', error);
            this.showNotification('Error deleting task', 'error');
        }
    }

    handleAIReview() {
        // Create AI Review modal
        const modalHtml = `
            <div id="aiReviewModal" class="modal show">
                <div class="modal-content" style="max-width: 800px;">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-lg font-semibold text-gray-800">AI Contract Review</h3>
                            <button data-close-modal="aiReviewModal" class="text-gray-400 hover:text-gray-600">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Upload Document for Review</label>
                                <input type="file" id="aiReviewFile" accept=".pdf,.doc,.docx,.txt" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Ask AI a Question (Optional)</label>
                                <textarea id="aiQuestion" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="What specific aspects would you like me to review?"></textarea>
                            </div>
                            
                            <div id="aiReviewResult" class="hidden">
                                <h4 class="font-medium text-gray-800 mb-2">AI Review Results:</h4>
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <div id="aiReviewContent"></div>
                                </div>
                            </div>
                            
                            <div class="flex items-center space-x-3 pt-4">
                                <button id="startAIReview" class="px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">
                                    <i class="fas fa-robot mr-2"></i>
                                    Start AI Review
                                </button>
                                <button type="button" data-close-modal="aiReviewModal" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                                    Cancel
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        document.body.insertAdjacentHTML('beforeend', modalHtml);
        
        // Bind events
        document.getElementById('startAIReview').addEventListener('click', () => this.performAIReview());
        document.querySelector('[data-close-modal="aiReviewModal"]').addEventListener('click', () => {
            document.getElementById('aiReviewModal').remove();
        });
    }

    async performAIReview() {
        const fileInput = document.getElementById('aiReviewFile');
        const questionInput = document.getElementById('aiQuestion');
        const resultDiv = document.getElementById('aiReviewResult');
        const contentDiv = document.getElementById('aiReviewContent');
        
        if (!fileInput.files[0]) {
            this.showNotification('Please select a file to review', 'warning');
            return;
        }
        
        const formData = new FormData();
        formData.append('file', fileInput.files[0]);
        formData.append('question', questionInput.value);
        
        try {
            // Show loading
            contentDiv.innerHTML = '<div class="flex items-center"><i class="fas fa-spinner fa-spin mr-2"></i> AI is reviewing your document...</div>';
            resultDiv.classList.remove('hidden');
            
            const response = await fetch('api/ai-review.php', {
                method: 'POST',
                body: formData
            });
            
            const result = await response.json();
            
            if (result.success) {
                contentDiv.innerHTML = `
                    <div class="space-y-4">
                        <div>
                            <h5 class="font-medium text-gray-800 mb-2">Summary:</h5>
                            <p class="text-gray-700">${result.data.summary}</p>
                        </div>
                        <div>
                            <h5 class="font-medium text-gray-800 mb-2">Key Issues:</h5>
                            <ul class="list-disc list-inside text-gray-700">
                                ${result.data.issues.map(issue => `<li>${issue}</li>`).join('')}
                            </ul>
                        </div>
                        <div>
                            <h5 class="font-medium text-gray-800 mb-2">Recommendations:</h5>
                            <ul class="list-disc list-inside text-gray-700">
                                ${result.data.recommendations.map(rec => `<li>${rec}</li>`).join('')}
                            </ul>
                        </div>
                    </div>
                `;
            } else {
                contentDiv.innerHTML = `<div class="text-red-600">Error: ${result.message}</div>`;
            }
        } catch (error) {
            console.error('Error:', error);
            contentDiv.innerHTML = '<div class="text-red-600">Error performing AI review</div>';
        }
    }

    handleESignature() {
        // Create eSignature modal
        const modalHtml = `
            <div id="eSignatureModal" class="modal show">
                <div class="modal-content" style="max-width: 600px;">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-lg font-semibold text-gray-800">Send for eSignature</h3>
                            <button data-close-modal="eSignatureModal" class="text-gray-400 hover:text-gray-600">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        
                        <form id="eSignatureForm">
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Document</label>
                                    <input type="file" name="document" accept=".pdf,.doc,.docx" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Recipient Email</label>
                                    <input type="email" name="recipient_email" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Recipient Name</label>
                                    <input type="text" name="recipient_name" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Subject</label>
                                    <input type="text" name="subject" value="Please sign this document" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Message</label>
                                    <textarea name="message" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Please review and sign the attached document."></textarea>
                                </div>
                                
                                <div class="flex items-center space-x-3 pt-4">
                                    <button type="submit" class="px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">
                                        <i class="fas fa-signature mr-2"></i>
                                        Send for Signature
                                    </button>
                                    <button type="button" data-close-modal="eSignatureModal" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                                        Cancel
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        `;
        
        document.body.insertAdjacentHTML('beforeend', modalHtml);
        
        // Bind events
        document.getElementById('eSignatureForm').addEventListener('submit', (e) => this.handleESignatureSubmit(e));
        document.querySelector('[data-close-modal="eSignatureModal"]').addEventListener('click', () => {
            document.getElementById('eSignatureModal').remove();
        });
    }

    async handleESignatureSubmit(e) {
        e.preventDefault();
        
        const formData = new FormData(e.target);
        
        try {
            const response = await fetch('api/esignature.php?action=send', {
                method: 'POST',
                body: formData
            });
            
            const result = await response.json();
            
            if (result.success) {
                document.getElementById('eSignatureModal').remove();
                this.showNotification('Document sent for signature successfully!', 'success');
            } else {
                this.showNotification('Error sending document: ' + result.message, 'error');
            }
        } catch (error) {
            console.error('Error:', error);
            this.showNotification('Error sending document for signature', 'error');
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
        this.currentFilters.status = status;
        this.filterDocuments();
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
        this.currentFilters.status = status;
        this.filterTasks();
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

    async loadTasks(status = '') {
        try {
            const url = status ? `api/tasks.php?action=list&status=${status}` : 'api/tasks.php?action=list';
            const response = await fetch(url);
            const result = await response.json();
            
            if (result.success) {
                this.updateTasksList(result.data, status);
            }
        } catch (error) {
            console.error('Error:', error);
        }
    }

    async loadDocuments(status = '') {
        try {
            const url = status ? `api/documents.php?action=list&status=${status}` : 'api/documents.php?action=list';
            const response = await fetch(url);
            const result = await response.json();
            
            if (result.success) {
                this.updateDocumentsList(result.data);
            }
        } catch (error) {
            console.error('Error:', error);
        }
    }

    updateDocumentsList(documents) {
        const container = document.getElementById('documents-list') || document.querySelector('.documents-container');
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
                    <div class="document-item flex items-center justify-between p-4 border border-gray-200 rounded-lg hover:bg-gray-50" data-document-id="${doc.id}">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-file-alt text-blue-600"></i>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-800">${this.escapeHtml(doc.title)}</h4>
                                <p class="text-sm text-gray-500">Modified ${this.formatDate(doc.updated_at)} • ${this.formatFileSize(doc.file_size)}</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3">
                            <span class="px-2 py-1 bg-${statusColor}-100 text-${statusColor}-800 text-xs font-medium rounded-full">
                                ${this.formatStatus(doc.status)}
                            </span>
                            <div class="flex items-center space-x-1">
                                <button class="document-action p-1 text-gray-400 hover:text-blue-600" data-action="download" data-id="${doc.id}">
                                    <i class="fas fa-download"></i>
                                </button>
                                <button class="document-action p-1 text-gray-400 hover:text-green-600" data-action="share" data-id="${doc.id}">
                                    <i class="fas fa-share"></i>
                                </button>
                                <button class="document-action p-1 text-gray-400 hover:text-red-600" data-action="delete" data-id="${doc.id}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                `;
            }).join('');
            
            container.innerHTML = `<div class="space-y-3">${documentsHtml}</div>`;
        }
    }

    updateTasksList(tasks, status = '') {
        const container = document.getElementById('tasks-list') || document.querySelector('.tasks-container');
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
            const tasksHtml = tasks.map(task => {
                const priorityColor = this.getPriorityColor(task.priority);
                const statusColor = this.getStatusColor(task.status);
                
                return `
                    <div class="task-item flex items-center justify-between p-4 border border-gray-200 rounded-lg hover:bg-gray-50" data-task-id="${task.id}">
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
                            <div class="flex items-center space-x-1">
                                <button class="task-action p-1 text-gray-400 hover:text-blue-600" data-action="edit" data-id="${task.id}">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="task-action p-1 text-gray-400 hover:text-red-600" data-action="delete" data-id="${task.id}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                `;
            }).join('');
            
            container.innerHTML = `<div class="space-y-3">${tasksHtml}</div>`;
        }
    }

    updateUsersList(users) {
        const container = document.querySelector('.users-container');
        if (!container) return;
        
        if (users.length === 0) {
            container.innerHTML = `
                <div class="text-center py-8">
                    <i class="fas fa-users text-4xl text-gray-400 mb-4"></i>
                    <h4 class="text-lg font-medium text-gray-800 mb-2">No users found</h4>
                    <p class="text-gray-500">Try adjusting your filters</p>
                </div>
            `;
        } else {
            const usersHtml = users.map(user => `
                <div class="user-item p-4 hover:bg-gray-50 cursor-pointer">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center text-white font-semibold">
                                ${user.first_name.charAt(0)}
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-800">${this.escapeHtml(user.first_name + ' ' + user.last_name)}</h4>
                                <p class="text-sm text-gray-500">${this.escapeHtml(user.email)}</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3">
                            <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs font-medium rounded-full">${this.capitalize(user.role)}</span>
                            <span class="px-2 py-1 bg-green-100 text-green-800 text-xs font-medium rounded-full">${this.capitalize(user.status)}</span>
                            <div class="text-sm text-gray-500">Last seen: ${this.formatDate(user.created_at)}</div>
                            <button class="text-gray-400 hover:text-gray-600">
                                <i class="fas fa-ellipsis-h"></i>
                            </button>
                        </div>
                    </div>
                </div>
            `).join('');
            
            container.innerHTML = `<div class="divide-y divide-gray-200">${usersHtml}</div>`;
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

        // Load dashboard stats
        try {
            const response = await fetch('api/dashboard.php?action=stats');
            const result = await response.json();
            
            if (result.success) {
                this.updateDashboardStats(result.data);
            }
        } catch (error) {
            console.error('Error loading dashboard data:', error);
        }
    }

    updateDashboardStats(stats) {
        // Update stats if elements exist
        const documentsCount = document.getElementById('documents-count');
        const tasksCount = document.getElementById('tasks-count');
        const completedTasksCount = document.getElementById('completed-tasks-count');
        
        if (documentsCount) documentsCount.textContent = stats.documents || 0;
        if (tasksCount) tasksCount.textContent = stats.tasks || 0;
        if (completedTasksCount) completedTasksCount.textContent = stats.completed_tasks || 0;
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
            unknown: 'gray',
            active: 'green',
            inactive: 'red',
            pending: 'yellow'
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

    formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }
}

// Initialize the application when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    window.pocketLegal = new PocketLegal();
});