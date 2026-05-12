// Enhanced Anti-Inspect Protection Script
// Performance-optimized version with screenshot and copy protection

(function() {
    'use strict';
    
    let devtoolsDetected = false;
    let lastWarningTime = 0;
    const WARNING_COOLDOWN = 3000; // 3 seconds between warnings
    
    // Lightweight initialization
    function initializeProtection() {
        // Basic right-click and selection protection
        document.addEventListener('contextmenu', blockAction, { passive: false });
        document.addEventListener('selectstart', preventTextSelection, { passive: false });
        document.addEventListener('dragstart', blockAction, { passive: false });
        
        // Essential keyboard shortcuts
        document.addEventListener('keydown', handleKeyboard, { passive: false });
        
        // Copy/paste/cut protection
        ['copy', 'paste', 'cut'].forEach(event => {
            document.addEventListener(event, blockAction, { passive: false });
        });
        
        // Screenshot protection
        initializeScreenshotProtection();
        
        // Start lightweight detection (every 2 seconds instead of 100ms)
        startDetection();
        
        // Apply enhanced CSS protection
        applyEnhancedStyling();
    }
    
    // Optimized block function with cooldown
    function blockAction(e) {
        e.preventDefault();
        e.stopPropagation();
        
        const now = Date.now();
        if (now - lastWarningTime > WARNING_COOLDOWN) {
            showOptimizedWarning('Action blocked - Inspection disabled!');
            lastWarningTime = now;
        }
        return false;
    }
    
    // Optimized text selection prevention
    function preventTextSelection(e) {
        if (e.target.tagName !== 'INPUT' && e.target.tagName !== 'TEXTAREA') {
            e.preventDefault();
            e.stopPropagation();
            return false;
        }
    }
    
    // Enhanced keyboard blocking with screenshot protection
    function handleKeyboard(e) {
        const blockedKeys = [
            123, // F12
            116, // F5 (refresh) - optional, can be removed if needed
            44,  // Print Screen
        ];
        
        // Block essential function keys
        if (blockedKeys.includes(e.keyCode)) {
            e.preventDefault();
            e.stopPropagation();
            showOptimizedWarning('Action blocked - Screen capture disabled!');
            return false;
        }
        
        // Block critical Ctrl combinations
        if (e.ctrlKey) {
            const criticalBlocked = [
                65, // A - Select All
                67, // C - Copy
                73, // I - Developer Tools
                74, // J - Console
                80, // P - Print
                83, // S - Save
                85, // U - View Source
                86, // V - Paste
                88, // X - Cut
            ];
            
            if (criticalBlocked.includes(e.keyCode)) {
                e.preventDefault();
                e.stopPropagation();
                showOptimizedWarning('Action blocked - Content protection active!');
                return false;
            }
        }
        
        // Block Ctrl+Shift combinations for dev tools
        if (e.ctrlKey && e.shiftKey) {
            const devToolsBlocked = [
                73, // I - Developer Tools
                74, // J - Console
                67, // C - Element Inspector
            ];
            
            if (devToolsBlocked.includes(e.keyCode)) {
                e.preventDefault();
                e.stopPropagation();
                showOptimizedWarning('Developer tools blocked!');
                return false;
            }
        }
        
        // Block Alt combinations
        if (e.altKey) {
            const altBlocked = [
                115, // F4 - Close window
                9,   // Tab - Alt+Tab
            ];
            
            if (altBlocked.includes(e.keyCode)) {
                e.preventDefault();
                e.stopPropagation();
                return false;
            }
        }
        
        // Block Windows key combinations
        if (e.metaKey) {
            e.preventDefault();
            e.stopPropagation();
            showOptimizedWarning('System shortcuts blocked!');
            return false;
        }
    }
    
    // Lightweight detection system (runs every 2 seconds)
    function startDetection() {
        setInterval(function() {
            // Only run if not already detected
            if (devtoolsDetected) return;
            
            // Simple window size detection (less resource intensive)
            const heightDiff = window.outerHeight - window.innerHeight;
            const widthDiff = window.outerWidth - window.innerWidth;
            
            if (heightDiff > 250 || widthDiff > 250) {
                triggerDevtoolsDetection();
            }
            
        }, 2000); // Every 2 seconds instead of 100ms
    }
    
    // Simplified devtools detection trigger
    function triggerDevtoolsDetection() {
        if (!devtoolsDetected) {
            devtoolsDetected = true;
            showCriticalWarning('SECURITY ALERT: Developer tools detected!');
            
            // Optional: Redirect after delay (can be disabled if too aggressive)
            setTimeout(() => {
                if (confirm('Developer tools detected. Reload page to continue?')) {
                    window.location.reload();
                }
            }, 5000);
        }
    }
    
    // Lightweight console protection
    function protectConsole() {
        const noop = function() { return 'Console access restricted'; };
        const restrictedConsole = {
            log: noop, warn: noop, error: noop, info: noop, debug: noop,
            trace: noop, dir: noop, dirxml: noop, group: noop, groupEnd: noop,
            time: noop, timeEnd: noop, profile: noop, profileEnd: noop,
            clear: noop, table: noop, assert: noop, count: noop
        };
        
        try {
            Object.defineProperty(window, 'console', {
                get: function() { return restrictedConsole; },
                set: function() { /* ignore */ }
            });
        } catch(e) {
            // Silently fail if can't override console
        }
    }
    
    // Optimized warning system
    function showOptimizedWarning(message) {
        // Create warning element
        const warning = document.createElement('div');
        warning.style.cssText = `
            position: fixed; top: 20px; right: 20px; z-index: 999999;
            background: #dc2626; color: white; padding: 12px 16px;
            border-radius: 6px; font-size: 13px; font-weight: 500;
            box-shadow: 0 4px 12px rgba(220, 38, 38, 0.4);
            transition: opacity 0.3s ease;
            pointer-events: none;
        `;
        warning.textContent = message;
        
        document.body.appendChild(warning);
        
        // Auto-remove after 2 seconds
        setTimeout(() => {
            if (warning.parentNode) {
                warning.style.opacity = '0';
                setTimeout(() => {
                    if (warning.parentNode) {
                        warning.parentNode.removeChild(warning);
                    }
                }, 300);
            }
        }, 2000);
    }
    
    function showCriticalWarning(message) {
        const overlay = document.createElement('div');
        overlay.style.cssText = `
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0, 0, 0, 0.9); color: white; z-index: 9999999;
            display: flex; align-items: center; justify-content: center;
            font-size: 20px; font-weight: 600; text-align: center;
        `;
        overlay.innerHTML = `
            <div>
                <div style="color: #dc2626; font-size: 3rem; margin-bottom: 1rem;">🚫</div>
                <div style="margin-bottom: 1rem;">${message}</div>
                <div style="font-size: 14px; color: #ccc;">Click anywhere to continue</div>
            </div>
        `;
        
        // Allow user to dismiss by clicking
        overlay.addEventListener('click', function() {
            document.body.removeChild(overlay);
            devtoolsDetected = false; // Reset detection
        });
        
        document.body.appendChild(overlay);
    }
    
    // Enhanced CSS protection with screenshot blocking
    function applyEnhancedStyling() {
        const style = document.createElement('style');
        style.textContent = `
            * { 
                -webkit-user-select: none !important; 
                -moz-user-select: none !important; 
                -ms-user-select: none !important; 
                user-select: none !important;
                -webkit-touch-callout: none !important;
                -webkit-tap-highlight-color: transparent !important;
            }
            input, textarea, [contenteditable] { 
                -webkit-user-select: text !important; 
                -moz-user-select: text !important; 
                -ms-user-select: text !important; 
                user-select: text !important; 
            }
            
            /* Prevent screenshot overlays */
            body::before {
                content: '';
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: transparent;
                z-index: 999999;
                pointer-events: none;
                mix-blend-mode: difference;
            }
            
            /* Disable image saving */
            img {
                -webkit-user-drag: none !important;
                -khtml-user-drag: none !important;
                -moz-user-drag: none !important;
                -o-user-drag: none !important;
                user-drag: none !important;
                pointer-events: none !important;
            }
            
            /* Prevent text highlighting */
            ::selection {
                background: transparent !important;
            }
            ::-moz-selection {
                background: transparent !important;
            }
            
            /* Disable print styles */
            @media print {
                * { display: none !important; }
                body::after {
                    content: "Printing is not allowed for this content.";
                    display: block !important;
                    text-align: center;
                    font-size: 24px;
                    margin-top: 50px;
                }
            }
        `;
        document.head.appendChild(style);
    }
    
    // Advanced screenshot protection system
    function initializeScreenshotProtection() {
        // Create dynamic content overlay to prevent clean screenshots
        createDynamicOverlay();
        
        // Detect screenshot attempts via visibility API
        document.addEventListener('visibilitychange', function() {
            if (document.hidden) {
                // Hide all content when tab is hidden
                hideAllContent();
                setTimeout(() => {
                    if (document.hidden) {
                        showOptimizedWarning('Screenshot protection active!');
                    }
                }, 100);
            } else {
                // Restore content when tab is visible
                restoreAllContent();
            }
        });
        
        // Detect potential screenshot tools (more aggressive)
        window.addEventListener('blur', function() {
            hideAllContent();
            setTimeout(() => {
                if (!document.hasFocus()) {
                    showOptimizedWarning('Content protection active!');
                }
            }, 100);
        });
        
        window.addEventListener('focus', function() {
            restoreAllContent();
        });
        
        // Block ALL screenshot-related shortcuts
        document.addEventListener('keydown', function(e) {
            const screenshotKeys = [
                44,  // Print Screen
                42,  // Print Screen (alternative)
                124, // F13 (sometimes mapped to screenshot)
            ];
            
            if (screenshotKeys.includes(e.keyCode)) {
                e.preventDefault();
                e.stopPropagation();
                hideAllContent();
                showCriticalWarning('SCREENSHOT BLOCKED - Content Hidden!');
                setTimeout(restoreAllContent, 3000);
                return false;
            }
            
            // Block Windows key combinations for screenshot tools
            if (e.metaKey) {
                const winBlocked = [
                    44,  // Win + Print Screen
                    83,  // Win + S (Snipping Tool)
                    71,  // Win + G (Game Bar)
                    72,  // Win + H (Share)
                ];
                
                if (winBlocked.includes(e.keyCode)) {
                    e.preventDefault();
                    e.stopPropagation();
                    hideAllContent();
                    showCriticalWarning('SNIPPING TOOL BLOCKED!');
                    setTimeout(restoreAllContent, 3000);
                    return false;
                }
            }
            
            // Block Shift + Windows + S (Snipping Tool)
            if (e.shiftKey && e.metaKey && e.keyCode === 83) {
                e.preventDefault();
                e.stopPropagation();
                hideAllContent();
                showCriticalWarning('SNIPPING TOOL BLOCKED!');
                setTimeout(restoreAllContent, 3000);
                return false;
            }
        });
        
        // Monitor mouse activity for screenshot tools
        let mouseIdleTime = 0;
        let lastMouseMove = Date.now();
        
        document.addEventListener('mousemove', function() {
            lastMouseMove = Date.now();
            mouseIdleTime = 0;
        });
        
        // Check for suspicious mouse inactivity (potential screenshot tool usage)
        setInterval(function() {
            const currentTime = Date.now();
            mouseIdleTime = currentTime - lastMouseMove;
            
            // If mouse idle for more than 10 seconds while page has focus
            if (mouseIdleTime > 10000 && document.hasFocus()) {
                showOptimizedWarning('Suspicious activity detected!');
                // Briefly hide content
                hideAllContent();
                setTimeout(restoreAllContent, 1000);
            }
        }, 5000);
        
        // Detect window resize (potential screenshot tool)
        let lastWindowSize = { width: window.innerWidth, height: window.innerHeight };
        window.addEventListener('resize', function() {
            const currentSize = { width: window.innerWidth, height: window.innerHeight };
            const widthChange = Math.abs(currentSize.width - lastWindowSize.width);
            const heightChange = Math.abs(currentSize.height - lastWindowSize.height);
            
            // If significant size change (potential screenshot tool overlay)
            if (widthChange > 50 || heightChange > 50) {
                showOptimizedWarning('Window manipulation detected!');
                hideAllContent();
                setTimeout(restoreAllContent, 2000);
            }
            
            lastWindowSize = currentSize;
        });
    }
    
    // Hide all content function
    function hideAllContent() {
        document.body.style.visibility = 'hidden';
        document.body.style.opacity = '0';
        document.body.style.filter = 'blur(20px)';
        
        // Create blocking overlay
        const overlay = document.createElement('div');
        overlay.id = 'screenshot-block-overlay';
        overlay.style.cssText = `
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: #000; color: white; z-index: 99999999;
            display: flex; align-items: center; justify-content: center;
            font-size: 24px; font-weight: bold; text-align: center;
        `;
        overlay.innerHTML = `
            <div>
                <div style="font-size: 4rem; margin-bottom: 1rem;">🚫</div>
                <div>CONTENT PROTECTED</div>
                <div style="font-size: 16px; margin-top: 1rem;">Screenshot and screen capture blocked</div>
            </div>
        `;
        document.body.appendChild(overlay);
    }
    
    // Restore all content function
    function restoreAllContent() {
        document.body.style.visibility = 'visible';
        document.body.style.opacity = '1';
        document.body.style.filter = 'none';
        
        // Remove blocking overlay
        const overlay = document.getElementById('screenshot-block-overlay');
        if (overlay) {
            overlay.remove();
        }
    }
    
    // Create dynamic overlay to interfere with screenshots
    function createDynamicOverlay() {
        const overlay = document.createElement('div');
        overlay.style.cssText = `
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            pointer-events: none; z-index: 999998;
            background: repeating-linear-gradient(
                45deg,
                transparent,
                transparent 10px,
                rgba(255, 0, 0, 0.01) 10px,
                rgba(255, 0, 0, 0.01) 20px
            );
            animation: dynamicPattern 3s linear infinite;
        `;
        
        // Add dynamic animation
        const style = document.createElement('style');
        style.textContent = `
            @keyframes dynamicPattern {
                0% { transform: translateX(0px) translateY(0px); }
                25% { transform: translateX(5px) translateY(-5px); }
                50% { transform: translateX(-5px) translateY(5px); }
                75% { transform: translateX(5px) translateY(5px); }
                100% { transform: translateX(0px) translateY(0px); }
            }
        `;
        document.head.appendChild(style);
        document.body.appendChild(overlay);
        
        // Random content shifting to prevent clean screenshots
        setInterval(function() {
            if (document.hasFocus()) {
                const shift = Math.random() * 2 - 1; // -1 to 1 pixel
                document.body.style.transform = `translate(${shift}px, ${shift}px)`;
                setTimeout(() => {
                    document.body.style.transform = 'translate(0px, 0px)';
                }, 100);
            }
        }, 2000);
    }
    
    // Block window methods and APIs
    function blockWindowMethods() {
        // Block window opening
        window.open = function() {
            showOptimizedWarning('Window.open blocked!');
            return null;
        };
        
        // Block printing
        window.print = function() {
            showOptimizedWarning('Printing blocked!');
            return false;
        };
        
        // Block clipboard API
        if (navigator.clipboard) {
            navigator.clipboard.writeText = function() {
                showOptimizedWarning('Clipboard access blocked!');
                return Promise.reject('Clipboard blocked');
            };
            
            navigator.clipboard.readText = function() {
                showOptimizedWarning('Clipboard access blocked!');
                return Promise.reject('Clipboard blocked');
            };
        }
        
        // Block screen capture API
        if (navigator.mediaDevices && navigator.mediaDevices.getDisplayMedia) {
            navigator.mediaDevices.getDisplayMedia = function() {
                showOptimizedWarning('Screen capture blocked!');
                return Promise.reject('Screen capture not allowed');
            };
        }
        
        // Block getUserMedia for screen recording
        if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
            const originalGetUserMedia = navigator.mediaDevices.getUserMedia;
            navigator.mediaDevices.getUserMedia = function(constraints) {
                if (constraints && constraints.video && constraints.video.mediaSource === 'screen') {
                    showOptimizedWarning('Screen recording blocked!');
                    return Promise.reject('Screen recording not allowed');
                }
                return originalGetUserMedia.call(this, constraints);
            };
        }
    }
    
    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initializeProtection);
    } else {
        initializeProtection();
    }
    
    // Initialize console protection and window methods
    protectConsole();
    blockWindowMethods();
    
})();
