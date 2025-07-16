<?php
require_once 'includes/auth.php';
require_once 'config/database.php';

$auth = new Auth();
$auth->requireLogin();

$database = new Database();
$conn = $database->getConnection();

// Get dashboard stats
$stats = [];

// Total documents
$stmt = $conn->prepare("SELECT COUNT(*) as count FROM documents WHERE user_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$stats['documents'] = $stmt->fetch(PDO::FETCH_ASSOC)['count'];

// Total tasks
$stmt = $conn->prepare("SELECT COUNT(*) as count FROM tasks WHERE assigned_to = ?");
$stmt->execute([$_SESSION['user_id']]);
$stats['tasks'] = $stmt->fetch(PDO::FETCH_ASSOC)['count'];

// Completed tasks
$stmt = $conn->prepare("SELECT COUNT(*) as count FROM tasks WHERE assigned_to = ? AND status = 'completed'");
$stmt->execute([$_SESSION['user_id']]);
$stats['completed_tasks'] = $stmt->fetch(PDO::FETCH_ASSOC)['count'];

// Recent documents
$stmt = $conn->prepare("SELECT * FROM documents WHERE user_id = ? ORDER BY created_at DESC LIMIT 5");
$stmt->execute([$_SESSION['user_id']]);
$recent_documents = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pocketlegal Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .sidebar-item:hover {
            background-color: #f3f4f6;
        }
        .sidebar-item.active {
            background-color: #3b82f6;
            color: white;
        }
        .card-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
        .transition-all {
            transition: all 0.3s ease;
        }
        
        /* Task Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
        }
        
        .modal.show {
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .modal-content {
            background-color: white;
            border-radius: 8px;
            width: 90%;
            max-width: 500px;
            max-height: 90vh;
            overflow-y: auto;
        }
        
        .toggle-switch {
            position: relative;
            display: inline-block;
            width: 44px;
            height: 24px;
        }
        
        .toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }
        
        .toggle-slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 24px;
        }
        
        .toggle-slider:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }
        
        input:checked + .toggle-slider {
            background-color: #3b82f6;
        }
        
        input:checked + .toggle-slider:before {
            transform: translateX(20px);
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-white shadow-lg border-r border-gray-200">
            <!-- Logo -->
            <div class="p-4 border-b border-gray-200">
                <h1 class="text-xl font-bold text-gray-800">Pocketlegal</h1>
            </div>

            <!-- Search -->
            <div class="p-4 border-b border-gray-200">
                <div class="relative">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                    <input type="text" placeholder="Search" class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <span class="absolute right-3 top-2 text-xs text-gray-400">Ctrl+K</span>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="p-4">
                <ul class="space-y-1">
                    <li>
                        <a href="index.php" class="sidebar-item active flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-all">
                            <i class="fas fa-tachometer-alt mr-3"></i>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <div class="sidebar-item flex items-center px-3 py-2 text-sm font-medium rounded-lg cursor-pointer transition-all" onclick="toggleSubmenu('repository')">
                            <i class="fas fa-folder mr-3"></i>
                            Repository
                            <i class="fas fa-chevron-down ml-auto transform transition-transform" id="repository-arrow"></i>
                        </div>
                        <ul class="ml-6 mt-1 space-y-1 hidden" id="repository-submenu">
                            <li><a href="folders.php" class="sidebar-item flex items-center px-3 py-2 text-sm rounded-lg transition-all">Folders</a></li>
                            <li><a href="documents.php" class="sidebar-item flex items-center px-3 py-2 text-sm rounded-lg transition-all">All documents</a></li>
                            <li><a href="templates.php" class="sidebar-item flex items-center px-3 py-2 text-sm rounded-lg transition-all">Template drafts</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="insights.php" class="sidebar-item flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-all">
                            <i class="fas fa-chart-line mr-3"></i>
                            Insights
                        </a>
                    </li>
                    <li>
                        <a href="tasks.php" class="sidebar-item flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-all">
                            <i class="fas fa-tasks mr-3"></i>
                            Tasks
                        </a>
                    </li>
                    <li>
                        <a href="template-library.php" class="sidebar-item flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-all">
                            <i class="fas fa-file-alt mr-3"></i>
                            Templates
                        </a>
                    </li>
                    <li>
                        <div class="sidebar-item flex items-center px-3 py-2 text-sm font-medium rounded-lg cursor-pointer transition-all" onclick="toggleSubmenu('settings')">
                            <i class="fas fa-cog mr-3"></i>
                            Settings
                            <i class="fas fa-chevron-down ml-auto transform transition-transform" id="settings-arrow"></i>
                        </div>
                        <ul class="ml-6 mt-1 space-y-1 hidden" id="settings-submenu">
                            <li><a href="users-teams.php" class="sidebar-item flex items-center px-3 py-2 text-sm rounded-lg transition-all">Users & teams</a></li>
                            <li><a href="account.php" class="sidebar-item flex items-center px-3 py-2 text-sm rounded-lg transition-all">Account</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="knowledge-hub.php" class="sidebar-item flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-all">
                            <i class="fas fa-book mr-3"></i>
                            Knowledge hub
                        </a>
                    </li>
                </ul>
            </nav>

            <!-- User Profile -->
            <div class="absolute bottom-0 w-64 p-4 border-t border-gray-200 bg-white">
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center text-white font-semibold">
                        <?php echo strtoupper(substr($_SESSION['user_name'], 0, 1)); ?>
                    </div>
                    <div class="ml-3 flex-1">
                        <p class="text-sm font-medium text-gray-800"><?php echo explode(' ', $_SESSION['user_name'])[0]; ?></p>
                        <p class="text-xs text-gray-500"><?php echo $_SESSION['user_company'] ?? 'Pocketlegal'; ?></p>
                    </div>
                    <div class="relative">
                        <button class="text-gray-400 hover:text-gray-600" onclick="toggleUserMenu()">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                        <div id="user-menu" class="hidden absolute bottom-full right-0 mb-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                            <a href="account.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Account Settings</a>
                            <a href="logout.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Sign out</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>