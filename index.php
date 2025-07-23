<?php
include_once 'header.php';
require_once 'config/database.php';
require_once 'classes/Document.php';

$database = new Database();
$db = $database->getConnection();
$document = new Document($db);

$user_documents = $document->getUserDocuments($_SESSION['user_id']);
$recent_documents = array_slice($user_documents, 0, 5); // Get 5 most recent
?>

    <!-- Main Content -->
    <div class="flex-1 overflow-auto">
        <!-- Header -->
        <div class="bg-white shadow-sm border-b px-8 py-6">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-semibold text-gray-800">Welcome back <?php echo htmlspecialchars($user_name); ?>,</h1>
                    <p class="text-gray-600 mt-1">Here is what's happening in your account</p>
                </div>
                <button class="w-10 h-10 bg-black text-white rounded-full flex items-center justify-center hover:bg-gray-800 transition-colors">
                    <i class="fas fa-plus"></i>
                </button>
            </div>
        </div>

        <!-- Dashboard Cards -->
        <div class="p-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Review Contract with AI -->
                <div class="gradient-blue text-white p-6 rounded-xl card-hover transition-all duration-300 cursor-pointer" onclick="openAIChat()">
                    <div class="flex items-center mb-4">
                        <i class="fas fa-robot text-2xl mr-3"></i>
                        <span class="text-sm opacity-90">AI</span>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Review contract with AI</h3>
                    <p class="text-sm opacity-90">Get immediate responses to your questions and AI assistance with drafting and summarizing</p>
                </div>

                <!-- Create Document -->
                <div class="gradient-dark text-white p-6 rounded-xl card-hover transition-all duration-300 cursor-pointer" onclick="openCreateDocumentModal()">
                    <div class="flex items-center mb-4">
                        <i class="fas fa-file-plus text-2xl mr-3"></i>
                        <span class="text-sm opacity-90">Template library</span>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Create a document</h3>
                    <p class="text-sm opacity-90">Create a contract based on a template</p>
                </div>

                <!-- Upload Documents -->
                <div class="gradient-gray text-white p-6 rounded-xl card-hover transition-all duration-300 cursor-pointer" onclick="openUploadModal()">
                    <div class="flex items-center mb-4">
                        <i class="fas fa-upload text-2xl mr-3"></i>
                        <span class="text-sm opacity-90">Repository</span>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Upload documents</h3>
                    <p class="text-sm opacity-90">Upload files to the repository for storage and management</p>
                </div>

                <!-- Send for eSignature -->
                <div class="gradient-purple text-white p-6 rounded-xl card-hover transition-all duration-300 cursor-pointer" onclick="openESignatureModal()">
                    <div class="flex items-center mb-4">
                        <i class="fas fa-signature text-2xl mr-3"></i>
                        <span class="text-sm opacity-90">eSigning</span>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Send for eSignature</h3>
                    <p class="text-sm opacity-90">Upload a document and send for eSigning instantly</p>
                </div>
            </div>

            <!-- Additional Feature Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                <!-- Legal Research -->
                <div class="gradient-green text-white p-6 rounded-xl card-hover transition-all duration-300 cursor-pointer" onclick="openLegalResearchModal()">
                    <div class="flex items-center mb-4">
                        <i class="fas fa-search text-2xl mr-3"></i>
                        <span class="text-sm opacity-90">Research</span>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Legal Research</h3>
                    <p class="text-sm opacity-90">Research legal precedents and case law</p>
                </div>

                <!-- Compliance Check -->
                <div class="gradient-orange text-white p-6 rounded-xl card-hover transition-all duration-300 cursor-pointer" onclick="openComplianceModal()">
                    <div class="flex items-center mb-4">
                        <i class="fas fa-shield-alt text-2xl mr-3"></i>
                        <span class="text-sm opacity-90">Compliance</span>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Compliance Check</h3>
                    <p class="text-sm opacity-90">Verify regulatory compliance requirements</p>
                </div>

                <!-- Contract Analytics -->
                <div class="bg-gradient-to-br from-indigo-500 to-purple-600 text-white p-6 rounded-xl card-hover transition-all duration-300 cursor-pointer" onclick="window.location.href='insights.php'">
                    <div class="flex items-center mb-4">
                        <i class="fas fa-chart-pie text-2xl mr-3"></i>
                        <span class="text-sm opacity-90">Analytics</span>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Contract Analytics</h3>
                    <p class="text-sm opacity-90">Analyze contract performance and risks</p>
                </div>
            </div>

            <!-- Contract Workflow and Tasks -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Contract Workflow -->
                <div class="lg:col-span-2 bg-white rounded-xl shadow-sm p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-lg font-semibold text-gray-800">Contract workflow</h2>
                        <div class="flex items-center space-x-4">
                            <select class="border rounded-lg px-3 py-1 text-sm">
                                <option>My documents</option>
                            </select>
                            <select class="border rounded-lg px-3 py-1 text-sm">
                                <option>Last 30 days</option>
                            </select>
                        </div>
                    </div>

                    <!-- Workflow Tabs -->
                    <div class="flex space-x-6 border-b mb-6">
                        <button class="pb-2 text-sm font-medium text-gray-900 border-b-2 border-blue-500">All</button>
                        <button class="pb-2 text-sm font-medium text-gray-500 hover:text-gray-700">Draft</button>
                        <button class="pb-2 text-sm font-medium text-gray-500 hover:text-gray-700">Review</button>
                        <button class="pb-2 text-sm font-medium text-gray-500 hover:text-gray-700">Agreed form</button>
                        <button class="pb-2 text-sm font-medium text-gray-500 hover:text-gray-700">eSigning</button>
                        <button class="pb-2 text-sm font-medium text-gray-500 hover:text-gray-700">Signed</button>
                        <button class="pb-2 text-sm font-medium text-gray-500 hover:text-gray-700">Unknown</button>
                    </div>

                    <!-- Recent Documents -->
                    <?php if (empty($recent_documents)): ?>
                        <div class="text-center py-12">
                            <i class="fas fa-file-alt text-4xl text-gray-300 mb-4"></i>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">No documents</h3>
                            <p class="text-gray-500 mb-4">Upload your first document to get started.</p>
                            <button onclick="openUploadModal()" class="text-blue-600 hover:text-blue-700 font-medium">Upload Document</button>
                        </div>
                    <?php else: ?>
                        <div class="space-y-3">
                            <?php foreach ($recent_documents as $doc): ?>
                                <div class="flex items-center justify-between p-3 hover:bg-gray-50 rounded-lg">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                            <i class="fas fa-file-alt text-blue-600 text-sm"></i>
                                        </div>
                                        <div>
                                            <div class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($doc['original_name']); ?></div>
                                            <div class="text-xs text-gray-500"><?php echo date('M j, Y', strtotime($doc['created_at'])); ?></div>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                            <?php echo $doc['status'] === 'uploaded' ? 'bg-green-100 text-green-800' : 
                                                        ($doc['status'] === 'processing' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800'); ?>">
                                            <?php echo ucfirst($doc['status']); ?>
                                        </span>
                                        <?php if ($doc['ai_processed']): ?>
                                            <i class="fas fa-check-circle text-green-500 text-sm"></i>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                            <div class="text-center pt-4">
                                <a href="documents.php" class="text-blue-600 hover:text-blue-700 font-medium text-sm">View all documents</a>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Tasks -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-lg font-semibold text-gray-800">Tasks</h2>
                        <button class="text-blue-600 hover:text-blue-700 text-sm font-medium">Show all</button>
                    </div>

                    <!-- Task Tabs -->
                    <div class="flex space-x-4 border-b mb-6">
                        <button class="pb-2 text-sm font-medium text-gray-500 hover:text-gray-700">To-do</button>
                        <button class="pb-2 text-sm font-medium text-gray-900 border-b-2 border-blue-500">Completed</button>
                    </div>

                    <!-- Completed State -->
                    <div class="text-center py-8">
                        <i class="fas fa-check-circle text-4xl text-green-300 mb-4"></i>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Well done!</h3>
                        <p class="text-gray-500">You have completed all your tasks</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- AI Chat Modal -->
<div id="aiChatModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-xl max-w-4xl w-full max-h-[90vh] flex flex-col">
            <div class="p-6 border-b">
                <div class="flex justify-between items-center">
                    <h2 class="text-xl font-semibold flex items-center">
                        <i class="fas fa-robot text-blue-600 mr-2"></i>
                        AI Contract Assistant
                    </h2>
                    <button onclick="closeAIChat()" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
            </div>
            
            <!-- Chat Messages Area -->
            <div id="chatMessages" class="flex-1 p-6 overflow-y-auto bg-gray-50 max-h-96">
                <div class="space-y-4">
                    <div class="flex items-start space-x-3">
                        <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center text-white text-sm">
                            <i class="fas fa-robot"></i>
                        </div>
                        <div class="bg-white p-4 rounded-lg shadow-sm max-w-md">
                            <p class="text-gray-800">Hello! I'm your AI contract assistant. Upload a contract and ask me anything about it - I can help with analysis, risk assessment, clause explanations, and more.</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- File Upload Area -->
            <div class="p-4 border-t border-b bg-white">
                <div class="flex items-center space-x-4">
                    <div class="flex-1">
                        <input type="file" id="chatFileInput" accept=".pdf,.doc,.docx,.txt" class="hidden" onchange="handleChatFileSelect(event)">
                        <button onclick="document.getElementById('chatFileInput').click()" class="flex items-center px-3 py-2 text-sm border border-gray-300 rounded-lg hover:bg-gray-50">
                            <i class="fas fa-paperclip mr-2"></i>
                            Attach Contract
                        </button>
                    </div>
                    <div id="chatFilePreview" class="flex items-center space-x-2"></div>
                </div>
            </div>
            
            <!-- Chat Input Area -->
            <div class="p-6 bg-white">
                <div class="flex space-x-3">
                    <div class="flex-1">
                        <textarea id="chatInput" rows="3" class="w-full border rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none" placeholder="Ask me about your contract... (e.g., 'What are the key risks in this agreement?', 'Explain the termination clause', 'Is this contract favorable?')"></textarea>
                    </div>
                    <button onclick="sendChatMessage()" id="sendChatBtn" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </div>
                <div class="flex items-center justify-between mt-3">
                    <div class="text-xs text-gray-500">
                        Press Shift+Enter for new line, Enter to send
                    </div>
                    <div class="text-xs text-gray-500">
                        <span id="charCount">0</span>/2000 characters
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Upload Modal -->
<div id="uploadModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-xl max-w-lg w-full">
            <div class="p-6 border-b">
                <div class="flex justify-between items-center">
                    <h2 class="text-xl font-semibold">Upload Documents</h2>
                    <button onclick="closeUploadModal()" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
            </div>
            <div class="p-6">
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center">
                    <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-4"></i>
                    <p class="text-gray-600 mb-4">Drag and drop files here, or click to select</p>
                    <input type="file" id="fileInput" multiple class="hidden" onchange="handleFileSelect(event)">
                    <button onclick="document.getElementById('fileInput').click()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Select Files
                    </button>
                </div>
                <div id="fileList" class="mt-4 space-y-2"></div>
                <div class="flex justify-end space-x-3 mt-6">
                    <button onclick="closeUploadModal()" class="px-4 py-2 text-gray-600 hover:text-gray-800">Cancel</button>
                    <button onclick="uploadFiles()" id="uploadBtn" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 disabled:opacity-50" disabled>
                        <i class="fas fa-upload mr-2"></i>Upload
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let selectedFiles = [];
    let chatFile = null;
    let messageCount = 1;

    function toggleSubmenu(id) {
        const submenu = document.getElementById(id + '-submenu');
        submenu.classList.toggle('hidden');
    }

    function openAIChat() {
        document.getElementById('aiChatModal').classList.remove('hidden');
    }

    function closeAIChat() {
        document.getElementById('aiChatModal').classList.add('hidden');
        document.getElementById('chatInput').value = '';
        chatFile = null;
        document.getElementById('chatFilePreview').innerHTML = '';
    }

    function openUploadModal() {
        document.getElementById('uploadModal').classList.remove('hidden');
    }

    function closeUploadModal() {
        document.getElementById('uploadModal').classList.add('hidden');
        selectedFiles = [];
        document.getElementById('fileList').innerHTML = '';
        document.getElementById('uploadBtn').disabled = true;
    }

    function showComingSoon(feature) {
        alert(feature + ' functionality will be implemented in the next phase.');
    }

    function handleChatFileSelect(event) {
        const file = event.target.files[0];
        if (file) {
            chatFile = file;
            const preview = document.getElementById('chatFilePreview');
            preview.innerHTML = `
                <div class="flex items-center space-x-2 bg-blue-50 px-3 py-1 rounded-lg">
                    <i class="fas fa-file text-blue-600"></i>
                    <span class="text-sm text-blue-800">${file.name}</span>
                    <button onclick="removeChatFile()" class="text-red-500 hover:text-red-700">
                        <i class="fas fa-times text-xs"></i>
                    </button>
                </div>
            `;
        }
    }

    function removeChatFile() {
        chatFile = null;
        document.getElementById('chatFilePreview').innerHTML = '';
        document.getElementById('chatFileInput').value = '';
    }

    function sendChatMessage() {
        const input = document.getElementById('chatInput');
        const query = input.value.trim();
        
        if (!query) {
            alert('Please enter a message');
            return;
        }

        // Add user message to chat
        addMessageToChat('user', query);
        
        // Clear input
        input.value = '';
        updateCharCount();
        
        // Show typing indicator
        addTypingIndicator();
        
        // Prepare form data for AI contract review
        const formData = new FormData();
        formData.append('query', query);
        
        // Add document if attached
        if (chatFile) {
            formData.append('document', chatFile);
        }
        
        $.ajax({
            url: 'api/ai_contract_review.php',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                removeTypingIndicator();
                if (response.success) {
                    let aiMessage = response.response;
                    if (response.document_processed) {
                        aiMessage = `📄 Document "${response.document_name}" processed successfully.\n\n${aiMessage}`;
                    }
                    addMessageToChat('ai', aiMessage);
                    if (response.note) {
                        console.log('Note:', response.note);
                    }
                } else {
                    addMessageToChat('ai', 'I apologize, but I encountered an error processing your request. Please try again.');
                }
                removeChatFile();
            },
            error: function(xhr, status, error) {
                removeTypingIndicator();
                addMessageToChat('ai', 'I apologize, but I encountered an error processing your request. Please try again.');
                console.error('AI Query Error:', error);
            }
        });
    }

    function addMessageToChat(sender, message) {
        const chatMessages = document.getElementById('chatMessages');
        const messageDiv = document.createElement('div');
        messageDiv.className = 'flex items-start space-x-3 animate-fade-in';
        
        if (sender === 'user') {
            messageDiv.innerHTML = `
                <div class="w-8 h-8 bg-gray-600 rounded-full flex items-center justify-center text-white text-sm">
                    <?php echo strtoupper(substr($user_name, 0, 1)); ?>
                </div>
                <div class="bg-blue-600 text-white p-4 rounded-lg shadow-sm max-w-md ml-auto">
                    <p>${message}</p>
                </div>
            `;
        } else {
            messageDiv.innerHTML = `
                <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center text-white text-sm">
                    <i class="fas fa-robot"></i>
                </div>
                <div class="bg-white p-4 rounded-lg shadow-sm max-w-md">
                    <p class="text-gray-800">${message}</p>
                </div>
            `;
        }
        
        chatMessages.appendChild(messageDiv);
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    function addTypingIndicator() {
        const chatMessages = document.getElementById('chatMessages');
        const typingDiv = document.createElement('div');
        typingDiv.id = 'typingIndicator';
        typingDiv.className = 'flex items-start space-x-3';
        typingDiv.innerHTML = `
            <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center text-white text-sm">
                <i class="fas fa-robot"></i>
            </div>
            <div class="bg-white p-4 rounded-lg shadow-sm">
                <div class="flex space-x-1">
                    <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce"></div>
                    <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.1s"></div>
                    <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
                </div>
            </div>
        `;
        chatMessages.appendChild(typingDiv);
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    function removeTypingIndicator() {
        const typingIndicator = document.getElementById('typingIndicator');
        if (typingIndicator) {
            typingIndicator.remove();
        }
    }

    function generateDemoResponse(query) {
        const responses = [
            "Based on my analysis of your contract, I've identified several key points that require your attention. The termination clause appears to favor the other party, and I recommend negotiating more balanced terms.",
            "This contract contains standard commercial terms, but I notice the liability limitation clause could expose you to significant risk. Consider adding mutual indemnification provisions.",
            "The payment terms in this agreement are reasonable, with a 30-day payment period. However, I recommend adding late payment penalties to protect your cash flow.",
            "I've reviewed the intellectual property clauses, and they appear comprehensive. The work-for-hire provisions are clearly defined, which is excellent for protecting your interests.",
            "The confidentiality provisions in this contract are robust and include appropriate carve-outs. The 5-year term for confidentiality obligations is industry standard."
        ];
        return responses[Math.floor(Math.random() * responses.length)];
    }

    function updateCharCount() {
        const input = document.getElementById('chatInput');
        const charCount = document.getElementById('charCount');
        charCount.textContent = input.value.length;
    }

    // Chat input event listeners
    document.getElementById('chatInput').addEventListener('input', updateCharCount);
    document.getElementById('chatInput').addEventListener('keydown', function(e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            sendChatMessage();
        }
    });

    function handleFileSelect(event) {
        const files = Array.from(event.target.files);
        selectedFiles = files;
        displayFileList();
        document.getElementById('uploadBtn').disabled = files.length === 0;
    }

    function displayFileList() {
        const fileList = document.getElementById('fileList');
        fileList.innerHTML = '';
        
        selectedFiles.forEach((file, index) => {
            const fileItem = document.createElement('div');
            fileItem.className = 'flex items-center justify-between p-2 bg-gray-50 rounded';
            fileItem.innerHTML = `
                <div class="flex items-center">
                    <i class="fas fa-file mr-2 text-gray-500"></i>
                    <span class="text-sm">${file.name}</span>
                    <span class="text-xs text-gray-500 ml-2">(${(file.size / 1024).toFixed(1)} KB)</span>
                </div>
                <button onclick="removeFile(${index})" class="text-red-500 hover:text-red-700">
                    <i class="fas fa-times"></i>
                </button>
            `;
            fileList.appendChild(fileItem);
        });
    }

    function removeFile(index) {
        selectedFiles.splice(index, 1);
        displayFileList();
        document.getElementById('uploadBtn').disabled = selectedFiles.length === 0;
    }

    function uploadFiles() {
        if (selectedFiles.length === 0) return;

        const formData = new FormData();
        selectedFiles.forEach((file, index) => {
            formData.append('documents[]', file);
        });

        const uploadBtn = document.getElementById('uploadBtn');
        uploadBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Uploading...';
        uploadBtn.disabled = true;

        $.ajax({
            url: 'api/upload.php',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                alert('Documents uploaded successfully!');
                closeUploadModal();
                // Refresh page to show new documents
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            },
            error: function(xhr, status, error) {
                alert('Error uploading documents: ' + error);
            },
            complete: function() {
                uploadBtn.innerHTML = '<i class="fas fa-upload mr-2"></i>Upload';
                uploadBtn.disabled = false;
            }
        });
    }

    // Additional Modal Functions
    function openCreateDocumentModal() {
        alert('Create Document functionality: Choose from professional templates, customize with AI assistance, and generate contracts instantly.');
    }

    function openESignatureModal() {
        alert('eSignature functionality: Upload documents, add signature fields, send to multiple parties, and track signing progress in real-time.');
    }

    function openLegalResearchModal() {
        alert('Legal Research functionality: Search case law, statutes, regulations, and legal precedents with AI-powered analysis.');
    }

    function openComplianceModal() {
        alert('Compliance Check functionality: Verify documents against regulatory requirements, industry standards, and legal compliance frameworks.');
    }

    // Drag and drop functionality
    const uploadArea = document.querySelector('#uploadModal .border-dashed');
    
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        uploadArea.addEventListener(eventName, preventDefaults, false);
    });

    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    ['dragenter', 'dragover'].forEach(eventName => {
        uploadArea.addEventListener(eventName, highlight, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        uploadArea.addEventListener(eventName, unhighlight, false);
    });

    function highlight(e) {
        uploadArea.classList.add('border-blue-500', 'bg-blue-50');
    }

    function unhighlight(e) {
        uploadArea.classList.remove('border-blue-500', 'bg-blue-50');
    }

    uploadArea.addEventListener('drop', handleDrop, false);

    function handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;
        
        selectedFiles = Array.from(files);
        displayFileList();
        document.getElementById('uploadBtn').disabled = files.length === 0;
    }

    // Add CSS animations
    const style = document.createElement('style');
    style.textContent = `
        @keyframes fade-in {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in {
            animation: fade-in 0.3s ease-out;
        }
    `;
    document.head.appendChild(style);
</script>
