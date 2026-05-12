// Smart Anti-Screenshot Protection Script
// Blocks screenshot tools while allowing legitimate browser functions

(function() {
    'use strict';
    
    let lastWarningTime = 0;
    const WARNING_COOLDOWN = 3000;
    let permissionDialogOpen = false;
    
    // Initialize smart protection
    function initializeSmartProtection() {
        // Block screenshot keyboard shortcuts only
        blockScreenshotShortcuts();
        
        // Apply smart CSS protection
        applySmartStyling();
        
        // Block copy-paste methods
        blockCopyPasteMethods();
        
        // Create subtle anti-screenshot measures
        createSubtleProtection();
        
        // Monitor for permission dialogs
        monitorPermissionDialogs();
    }
    
    // Block only screenshot-specific keyboard shortcuts
    function blockScreenshotShortcuts() {
        document.addEventListener('keydown', function(e) {
            // Block Print Screen key specifically
            if (e.keyCode === 44) {
                e.preventDefault();
                e.stopPropagation();
                hideContentTemporarily();
                showSmartWarning('Screenshot blocked!');
                return false;
            }
            
            // Block Windows + Shift + S (Snipping Tool) specifically
            if (e.metaKey && e.shiftKey && e.keyCode === 83) {
                e.preventDefault();
                e.stopPropagation();
                hideContentTemporarily();
                showSmartWarning('Snipping Tool blocked!');
                return false;
            }
            
            // Block Windows + Print Screen
            if (e.metaKey && e.keyCode === 44) {
                e.preventDefault();
                e.stopPropagation();
                hideContentTemporarily();
                showSmartWarning('Screenshot blocked!');
                return false;
            }
            
            // Block Alt + Print Screen
            if (e.altKey && e.keyCode === 44) {
                e.preventDefault();
                e.stopPropagation();
                hideContentTemporarily();
                showSmartWarning('Screenshot blocked!');
                return false;
            }
            
            // Block copy-paste shortcuts
            if (e.ctrlKey) {
                const copyPasteBlocked = [65, 67, 86, 88]; // A, C, V, X
                if (copyPasteBlocked.includes(e.keyCode)) {
                    e.preventDefault();
                    e.stopPropagation();
                    showSmartWarning('Copy/paste blocked!');
                    return false;
                }
            }
            
            // Block developer tools
            if (e.keyCode === 123 || // F12
                (e.ctrlKey && e.keyCode === 73) || // Ctrl+I
                (e.ctrlKey && e.keyCode === 74) || // Ctrl+J
                (e.ctrlKey && e.keyCode === 85)) { // Ctrl+U
                e.preventDefault();
                e.stopPropagation();
                showSmartWarning('Developer tools blocked!');
                return false;
            }
        }, true);
    }
    
    // Hide content temporarily (only for screenshot attempts)
    function hideContentTemporarily() {
        // Create temporary overlay
        const overlay = document.createElement('div');
        overlay.id = 'screenshot-protection-overlay';
        overlay.style.cssText = `
            position: fixed !important;
            top: 0 !important; left: 0 !important;
            width: 100vw !important; height: 100vh !important;
            background: #000 !important;
            color: #fff !important;
            z-index: 2147483647 !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            font-size: 24px !important;
            font-weight: bold !important;
            text-align: center !important;
            font-family: Arial, sans-serif !important;
        `;
        overlay.innerHTML = `
            <div>
                <div style="font-size: 48px; margin-bottom: 15px;">🚫</div>
                <div>SCREENSHOT BLOCKED</div>
                <div style="font-size: 16px; margin-top: 15px; opacity: 0.8;">Content protected from screen capture</div>
            </div>
        `;
        
        document.body.appendChild(overlay);
        
        // Remove overlay after 2 seconds
        setTimeout(() => {
            if (overlay.parentNode) {
                overlay.remove();
            }
        }, 2000);
    }
    
    // Smart warning system
    function showSmartWarning(message) {
        const now = Date.now();
        if (now - lastWarningTime < WARNING_COOLDOWN) return;
        lastWarningTime = now;
        
        const warning = document.createElement('div');
        warning.style.cssText = `
            position: fixed !important;
            top: 20px !important; right: 20px !important;
            background: #dc2626 !important;
            color: white !important;
            padding: 15px 20px !important;
            border-radius: 8px !important;
            font-size: 14px !important;
            font-weight: 600 !important;
            z-index: 999999 !important;
            box-shadow: 0 4px 12px rgba(220, 38, 38, 0.4) !important;
            font-family: Arial, sans-serif !important;
        `;
        warning.innerHTML = `
            <div style="display: flex; align-items: center; gap: 8px;">
                <span style="font-size: 16px;">🚫</span>
                <span>${message}</span>
            </div>
        `;
        
        document.body.appendChild(warning);
        
        setTimeout(() => {
            if (warning.parentNode) {
                warning.style.opacity = '0';
                warning.style.transition = 'opacity 0.3s ease';
                setTimeout(() => {
                    if (warning.parentNode) {
                        warning.remove();
                    }
                }, 300);
            }
        }, 2500);
    }
    
    // Apply smart CSS protection
    function applySmartStyling() {
        const style = document.createElement('style');
        style.textContent = `
            /* Disable text selection except for inputs */
            * { 
                -webkit-user-select: none !important; 
                -moz-user-select: none !important; 
                -ms-user-select: none !important; 
                user-select: none !important;
                -webkit-touch-callout: none !important;
            }
            
            /* Allow text selection in form elements */
            input, textarea, [contenteditable] { 
                -webkit-user-select: text !important; 
                -moz-user-select: text !important; 
                -ms-user-select: text !important; 
                user-select: text !important; 
            }
            
            /* Disable text highlighting */
            ::selection { background: transparent !important; }
            ::-moz-selection { background: transparent !important; }
            
            /* Prevent image dragging */
            img, video, canvas, svg {
                -webkit-user-drag: none !important;
                -khtml-user-drag: none !important;
                -moz-user-drag: none !important;
                -o-user-drag: none !important;
                user-drag: none !important;
                pointer-events: none !important;
            }
            
            /* Disable print styles */
            @media print {
                * { display: none !important; }
                body::after {
                    content: "Printing is not allowed for this content.";
                    display: block !important;
                    text-align: center !important;
                    font-size: 24px !important;
                    margin-top: 100px !important;
                }
            }
            
            /* Subtle anti-screenshot watermark */
            body::before {
                content: '';
                position: fixed;
                top: 0; left: 0;
                width: 100%; height: 100%;
                background: 
                    radial-gradient(circle at 25% 25%, rgba(255,255,255,0.005) 1px, transparent 1px),
                    radial-gradient(circle at 75% 75%, rgba(0,0,0,0.005) 1px, transparent 1px);
                background-size: 100px 100px, 150px 150px;
                pointer-events: none;
                z-index: 999995;
                animation: subtleMove 20s linear infinite;
            }
            
            @keyframes subtleMove {
                0% { transform: translate(0, 0); }
                25% { transform: translate(2px, -2px); }
                50% { transform: translate(-2px, 2px); }
                75% { transform: translate(2px, 2px); }
                100% { transform: translate(0, 0); }
            }
        `;
        document.head.appendChild(style);
    }
    
    // Block copy-paste methods
    function blockCopyPasteMethods() {
        // Block right-click context menu
        document.addEventListener('contextmenu', function(e) {
            e.preventDefault();
            e.stopPropagation();
            showSmartWarning('Right-click disabled!');
            return false;
        });
        
        // Block text selection (except in inputs)
        document.addEventListener('selectstart', function(e) {
            if (e.target.tagName !== 'INPUT' && e.target.tagName !== 'TEXTAREA') {
                e.preventDefault();
                e.stopPropagation();
                return false;
            }
        });
        
        // Block drag and drop
        document.addEventListener('dragstart', function(e) {
            e.preventDefault();
            e.stopPropagation();
            showSmartWarning('Drag disabled!');
            return false;
        });
        
        // Block clipboard events
        ['copy', 'paste', 'cut'].forEach(event => {
            document.addEventListener(event, function(e) {
                e.preventDefault();
                e.stopPropagation();
                showSmartWarning('Clipboard access blocked!');
                return false;
            });
        });
        
        // Override clipboard API
        if (navigator.clipboard) {
            navigator.clipboard.writeText = function() {
                showSmartWarning('Clipboard blocked!');
                return Promise.reject(new Error('Clipboard access denied'));
            };
            
            navigator.clipboard.readText = function() {
                showSmartWarning('Clipboard blocked!');
                return Promise.reject(new Error('Clipboard access denied'));
            };
        }
    }
    
    // Create subtle protection measures
    function createSubtleProtection() {
        // Block screen capture API
        if (navigator.mediaDevices && navigator.mediaDevices.getDisplayMedia) {
            navigator.mediaDevices.getDisplayMedia = function() {
                showSmartWarning('Screen capture blocked!');
                return Promise.reject(new Error('Screen capture not allowed'));
            };
        }
        
        // Block printing
        window.print = function() {
            showSmartWarning('Printing blocked!');
            return false;
        };
        
        // Block window.open
        const originalOpen = window.open;
        window.open = function() {
            showSmartWarning('Popup blocked!');
            return null;
        };
        
        // Block canvas export
        if (HTMLCanvasElement.prototype.toDataURL) {
            HTMLCanvasElement.prototype.toDataURL = function() {
                showSmartWarning('Canvas export blocked!');
                return 'data:,';
            };
        }
        
        // Create invisible decoy elements
        for (let i = 0; i < 3; i++) {
            const decoy = document.createElement('div');
            decoy.style.cssText = `
                position: absolute;
                top: ${Math.random() * 100}%;
                left: ${Math.random() * 100}%;
                width: 1px; height: 1px;
                opacity: 0.001;
                z-index: ${999990 + i};
                color: transparent;
                font-size: 1px;
                pointer-events: none;
            `;
            decoy.textContent = 'PROTECTED';
            document.body.appendChild(decoy);
        }
    }
    
    // Monitor for permission dialogs (don't interfere)
    function monitorPermissionDialogs() {
        // Detect when permission dialogs might be open
        let permissionRequestTime = 0;
        
        // Override getUserMedia to track permission requests
        if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
            const originalGetUserMedia = navigator.mediaDevices.getUserMedia;
            navigator.mediaDevices.getUserMedia = function(constraints) {
                // Track when permission is requested
                permissionRequestTime = Date.now();
                permissionDialogOpen = true;
                
                // Allow the original request
                return originalGetUserMedia.call(this, constraints).then(
                    function(stream) {
                        permissionDialogOpen = false;
                        return stream;
                    },
                    function(error) {
                        permissionDialogOpen = false;
                        throw error;
                    }
                );
            };
        }
        
        // Don't trigger protection during permission dialogs
        document.addEventListener('visibilitychange', function() {
            const timeSincePermission = Date.now() - permissionRequestTime;
            
            // If permission was requested recently, don't trigger protection
            if (timeSincePermission < 10000) { // 10 seconds grace period
                return;
            }
            
            // Normal visibility change handling (allow tab switching)
            // Don't hide content - just log for monitoring
        });
        
        // Don't trigger protection on window blur during permission requests
        window.addEventListener('blur', function() {
            const timeSincePermission = Date.now() - permissionRequestTime;
            
            // If permission was requested recently, don't trigger protection
            if (timeSincePermission < 10000) {
                return;
            }
            
            // Allow normal window blur (user switching apps/tabs)
        });
    }
    
    // Monitor for developer tools (less aggressive)
    function monitorDeveloperTools() {
        setInterval(function() {
            // Only check for very obvious developer tools usage
            const heightDiff = window.outerHeight - window.innerHeight;
            const widthDiff = window.outerWidth - window.innerWidth;
            
            // Only trigger if extremely large difference (definitely dev tools)
            if (heightDiff > 500 || widthDiff > 500) {
                showSmartWarning('Developer tools detected!');
            }
        }, 5000); // Check every 5 seconds
    }
    
    // Enhanced Snipping Tool detection
    function enhanceSnippingToolDetection() {
        // Monitor for specific Snipping Tool process indicators
        let snippingToolActive = false;
        
        // Detect when Snipping Tool might be starting
        document.addEventListener('keydown', function(e) {
            // Windows + S (Snipping Tool shortcut)
            if (e.metaKey && e.keyCode === 83 && !e.ctrlKey && !e.altKey) {
                e.preventDefault();
                e.stopPropagation();
                snippingToolActive = true;
                hideContentTemporarily();
                showSmartWarning('Snipping Tool blocked!');
                
                // Reset flag after delay
                setTimeout(() => {
                    snippingToolActive = false;
                }, 5000);
                
                return false;
            }
            
            // Shift + Windows + S (New Snipping Tool)
            if (e.shiftKey && e.metaKey && e.keyCode === 83) {
                e.preventDefault();
                e.stopPropagation();
                snippingToolActive = true;
                hideContentTemporarily();
                showSmartWarning('Snipping Tool blocked!');
                
                setTimeout(() => {
                    snippingToolActive = false;
                }, 5000);
                
                return false;
            }
        });
        
        // Monitor for cursor changes that might indicate screenshot tools
        let lastCursor = document.body.style.cursor;
        setInterval(() => {
            const currentCursor = document.body.style.cursor;
            if (currentCursor !== lastCursor && currentCursor.includes('crosshair')) {
                hideContentTemporarily();
                showSmartWarning('Screenshot tool detected!');
            }
            lastCursor = currentCursor;
        }, 1000);
    }
    
    // Create dynamic content protection
    function createDynamicContentProtection() {
        // Randomly shift content very slightly to prevent clean screenshots
        setInterval(function() {
            if (document.hasFocus() && !permissionDialogOpen) {
                const shift = Math.random() * 0.5 - 0.25; // Very small shift
                document.body.style.transform = `translate(${shift}px, ${shift}px)`;
                
                setTimeout(() => {
                    document.body.style.transform = 'translate(0px, 0px)';
                }, 50);
            }
        }, 3000);
        
        // Add subtle noise to background
        const noiseOverlay = document.createElement('div');
        noiseOverlay.style.cssText = `
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            pointer-events: none; z-index: 999998;
            background: 
                radial-gradient(circle at 10% 20%, rgba(255,255,255,0.003) 1px, transparent 1px),
                radial-gradient(circle at 80% 80%, rgba(0,0,0,0.003) 1px, transparent 1px),
                radial-gradient(circle at 40% 60%, rgba(128,128,128,0.003) 1px, transparent 1px);
            background-size: 80px 80px, 120px 120px, 60px 60px;
            animation: noiseMove 15s linear infinite;
        `;
        
        const noiseStyle = document.createElement('style');
        noiseStyle.textContent = `
            @keyframes noiseMove {
                0% { transform: translate(0, 0) rotate(0deg); }
                25% { transform: translate(1px, -1px) rotate(90deg); }
                50% { transform: translate(-1px, 1px) rotate(180deg); }
                75% { transform: translate(1px, 1px) rotate(270deg); }
                100% { transform: translate(0, 0) rotate(360deg); }
            }
        `;
        
        document.head.appendChild(noiseStyle);
        document.body.appendChild(noiseOverlay);
    }
    
    // Initialize all protection systems
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() {
            initializeSmartProtection();
            monitorDeveloperTools();
            enhanceSnippingToolDetection();
            createDynamicContentProtection();
        });
    } else {
        initializeSmartProtection();
        monitorDeveloperTools();
        enhanceSnippingToolDetection();
        createDynamicContentProtection();
    }
    
})();
