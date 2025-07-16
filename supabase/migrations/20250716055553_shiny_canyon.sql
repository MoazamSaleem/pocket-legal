CREATE DATABASE IF NOT EXISTS pocketlegal;
USE pocketlegal;

-- Users table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    company VARCHAR(100),
    job_title VARCHAR(100),
    role ENUM('admin', 'editor', 'viewer') DEFAULT 'editor',
    status ENUM('active', 'inactive', 'pending') DEFAULT 'active',
    avatar VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Folders table
CREATE TABLE IF NOT EXISTS folders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    color VARCHAR(7) DEFAULT '#3B82F6',
    parent_id INT NULL,
    user_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (parent_id) REFERENCES folders(id) ON DELETE CASCADE
);

-- Documents table
CREATE TABLE IF NOT EXISTS documents (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    file_name VARCHAR(255) NOT NULL,
    file_path VARCHAR(500) NOT NULL,
    file_size INT NOT NULL,
    file_type VARCHAR(50) NOT NULL,
    folder_id INT NULL,
    user_id INT NOT NULL,
    status ENUM('draft', 'review', 'agreed_form', 'esigning', 'signed', 'unknown') DEFAULT 'draft',
    document_type ENUM('contract', 'agreement', 'legal_document', 'template') DEFAULT 'contract',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (folder_id) REFERENCES folders(id) ON DELETE SET NULL
);

-- Tasks table
CREATE TABLE IF NOT EXISTS tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    priority ENUM('low', 'medium', 'high') DEFAULT 'medium',
    status ENUM('todo', 'in_progress', 'completed', 'overdue') DEFAULT 'todo',
    due_date DATETIME NULL,
    reminder_date DATETIME NULL,
    assigned_to INT NOT NULL,
    created_by INT NOT NULL,
    document_id INT NULL,
    visible_to_company BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (assigned_to) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (document_id) REFERENCES documents(id) ON DELETE SET NULL
);

-- Templates table
CREATE TABLE IF NOT EXISTS templates (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    category VARCHAR(100),
    content TEXT,
    file_path VARCHAR(500),
    status ENUM('draft', 'review', 'approved', 'published') DEFAULT 'draft',
    user_id INT NOT NULL,
    rating DECIMAL(2,1) DEFAULT 0.0,
    reviews_count INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Knowledge base articles
CREATE TABLE IF NOT EXISTS knowledge_articles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    category VARCHAR(100),
    author_id INT NOT NULL,
    read_time INT DEFAULT 5,
    featured BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (author_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Insert default admin user
INSERT INTO users (first_name, last_name, email, password, role, company, job_title) 
VALUES ('Umar', 'Khan', 'umar@pocketlegal.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', 'Pocketlegal', 'Legal Counsel');

-- Insert sample folders
INSERT INTO folders (name, description, color, user_id) VALUES
('Client Contracts', 'All client-related contracts and agreements', '#3B82F6', 1),
('Legal Templates', 'Reusable legal document templates', '#10B981', 1),
('HR Documents', 'Human resources related documents', '#8B5CF6', 1),
('Compliance', 'Regulatory and compliance documents', '#F59E0B', 1),
('Archived', 'Archived documents', '#EF4444', 1),
('Drafts', 'Work in progress documents', '#6366F1', 1);

-- Insert sample tasks
INSERT INTO tasks (title, description, priority, status, due_date, assigned_to, created_by) VALUES
('Review NDA with TechCorp', 'Review and provide feedback on the non-disclosure agreement', 'high', 'in_progress', DATE_ADD(NOW(), INTERVAL 1 DAY), 1, 1),
('Draft employment contract for new hire', 'Create employment contract for John Doe starting next month', 'medium', 'todo', DATE_ADD(NOW(), INTERVAL 5 DAY), 1, 1),
('Update privacy policy', 'Update privacy policy to comply with latest regulations', 'low', 'completed', DATE_SUB(NOW(), INTERVAL 1 DAY), 1, 1),
('Prepare contract amendments', 'Prepare amendments for existing service agreements', 'medium', 'in_progress', DATE_ADD(NOW(), INTERVAL 7 DAY), 1, 1);

-- Insert sample templates
INSERT INTO templates (name, description, category, status, user_id, rating, reviews_count) VALUES
('Service Agreement', 'Comprehensive service agreement template for client engagements', 'Business', 'published', 1, 4.8, 24),
('Non-Disclosure Agreement', 'Standard NDA template for protecting confidential information', 'Business', 'published', 1, 4.9, 18),
('Employment Contract', 'Standard employment agreement with customizable terms', 'Employment', 'published', 1, 4.7, 31),
('Privacy Policy', 'GDPR compliant privacy policy template for websites', 'Privacy', 'published', 1, 4.6, 15),
('Lease Agreement', 'Residential lease agreement with standard clauses', 'Real Estate', 'published', 1, 4.5, 22),
('Terms of Service', 'Standard terms of service template for online platforms', 'Business', 'published', 1, 4.4, 19);

-- Insert sample knowledge articles
INSERT INTO knowledge_articles (title, content, category, author_id, read_time, featured) VALUES
('Contract Review Best Practices', 'Essential guidelines for reviewing and negotiating contracts effectively...', 'Contract Law', 1, 5, TRUE),
('GDPR Compliance Guide', 'Complete guide to ensuring GDPR compliance for your organization...', 'Compliance', 1, 12, TRUE),
('Employment Law Updates', 'Latest changes in employment law and their impact on businesses...', 'Employment', 1, 8, TRUE),
('Understanding Digital Signatures', 'Legal validity and implementation of digital signatures...', 'Contract Law', 1, 7, FALSE),
('Intellectual Property Protection', 'Safeguarding your company\'s intellectual property rights...', 'IP Law', 1, 10, FALSE),
('Remote Work Policies', 'Legal considerations for remote work arrangements...', 'Employment', 1, 6, FALSE);