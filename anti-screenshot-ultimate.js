// Ultimate Anti-Screenshot Protection Script
// Maximum protection against all screenshot and screen capture tools

(function() {
    'use strict';
    
    let protectionActive = true;
    let contentHidden = false;
    let lastWarningTime = 0;
    const WARNING_COOLDOWN = 2000;
    
    // Initialize ultimate protection
    function initializeUltimateProtection() {
        // Block all screenshot methods
        blockAllScreenshotMethods();
        
        // Create invisible content protection
        createInvisibleProtection();
        
        // Monitor for screenshot tools continuously
        startContinuousMonitoring();
        
        // Apply maximum CSS protection
        applyMaximumStyling();
        
        // Block all input methods
        blockAllInputMethods();
        
        // Create decoy content
        createDecoyContent();
    }
    
    // Block all screenshot methods
    function blockAllScreenshotMethods() {
        // Block ALL keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            // Screenshot keys
            const screenshotKeys = [44, 42, 124, 19, 145]; // Print Screen variants
            
            // Snipping Tool shortcuts
            const snippingKeys = [83]; // S key
            
            // System shortcuts
            const systemKeys = [91, 92, 93]; // Windows keys
            
            // Function keys
            const functionKeys = [112, 113, 114, 115, 116, 117, 118, 119, 120, 121, 122, 123];
            
            // Block Print Screen and variants
            if (screenshotKeys.includes(e.keyCode)) {
                e.preventDefault();
                e.stopPropagation();
                e.stopImmediatePropagation();
                hideContentImmediately();
                showBlockMessage('SCREENSHOT BLOCKED!');
                return false;
            }
            
            // Block Windows + any key (including Snipping Tool)
            if (e.metaKey || e.key === 'Meta' || e.code === 'MetaLeft' || e.code === 'MetaRight') {
                e.preventDefault();
                e.stopPropagation();
                e.stopImmediatePropagation();
                hideContentImmediately();
                showBlockMessage('SNIPPING TOOL BLOCKED!');
                return false;
            }
            
            // Block Shift + Windows + S (Snipping Tool)
            if (e.shiftKey && snippingKeys.includes(e.keyCode)) {
                e.preventDefault();
                e.stopPropagation();
                e.stopImmediatePropagation();
                hideContentImmediately();
                showBlockMessage('SNIPPING TOOL BLOCKED!');
                return false;
            }
            
            // Block Ctrl combinations
            if (e.ctrlKey) {
                const ctrlBlocked = [65, 67, 73, 74, 80, 83, 85, 86, 88]; // A,C,I,J,P,S,U,V,X
                if (ctrlBlocked.includes(e.keyCode)) {
                    e.preventDefault();
                    e.stopPropagation();
                    e.stopImmediatePropagation();
                    showBlockMessage('Action blocked!');
                    return false;
                }
            }
            
            // Block Alt combinations
            if (e.altKey) {
                e.preventDefault();
                e.stopPropagation();
                e.stopImmediatePropagation();
                return false;
            }
            
            // Block function keys
            if (functionKeys.includes(e.keyCode)) {
                e.preventDefault();
                e.stopPropagation();
                e.stopImmediatePropagation();
                showBlockMessage('Function key blocked!');
                return false;
            }
        }, true); // Use capture phase
        
        // Block keyup events too
        document.addEventListener('keyup', function(e) {
            if (e.keyCode === 44 || e.keyCode === 91 || e.keyCode === 92) {
                e.preventDefault();
                e.stopPropagation();
                e.stopImmediatePropagation();
                return false;
            }
        }, true);
    }
    
    // Hide content immediately
    function hideContentImmediately() {
        if (contentHidden) return;
        contentHidden = true;
        
        // Hide everything instantly
        document.documentElement.style.display = 'none';
        document.body.style.display = 'none';
        
        // Create full-screen block
        const block = document.createElement('div');
        block.id = 'ultimate-block';
        block.style.cssText = `
            position: fixed !important;
            top: 0 !important; left: 0 !important;
            width: 100vw !important; height: 100vh !important;
            background: #000 !important;
            color: #fff !important;
            z-index: 2147483647 !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            font-size: 32px !important;
            font-weight: bold !important;
            text-align: center !important;
            font-family: Arial, sans-serif !important;
        `;
        block.innerHTML = `
            <div>
                <div style="font-size: 64px; margin-bottom: 20px;">🚫</div>
                <div>CONTENT PROTECTED</div>
                <div style="font-size: 18px; margin-top: 20px;">Screenshot tools detected and blocked</div>
                <div style="font-size: 14px; margin-top: 10px; opacity: 0.7;">Content will restore automatically</div>
            </div>
        `;
        
        // Insert at the very beginning of body
        document.body.insertBefore(block, document.body.firstChild);
        
        // Restore after delay
        setTimeout(function() {
            restoreContentImmediately();
        }, 3000);
    }
    
    // Restore content immediately
    function restoreContentImmediately() {
        contentHidden = false;
        
        // Restore display
        document.documentElement.style.display = '';
        document.body.style.display = '';
        
        // Remove block
        const block = document.getElementById('ultimate-block');
        if (block) {
            block.remove();
        }
    }
    
    // Create invisible protection layers
    function createInvisibleProtection() {
        // Create multiple invisible overlays
        for (let i = 0; i < 5; i++) {
            const overlay = document.createElement('div');
            overlay.style.cssText = `
                position: fixed; top: 0; left: 0; width: 100%; height: 100%;
                pointer-events: none; z-index: ${999990 + i};
                background: rgba(${Math.random() * 255}, ${Math.random() * 255}, ${Math.random() * 255}, 0.001);
                mix-blend-mode: ${['multiply', 'screen', 'overlay', 'difference', 'exclusion'][i]};
            `;
            document.body.appendChild(overlay);
        }
    }
    
    // Start continuous monitoring (less aggressive)
    function startContinuousMonitoring() {
        // Monitor every 2 seconds for better performance
        setInterval(function() {
            // Check for suspicious window states (developer tools)
            if (window.outerHeight - window.innerHeight > 300 || 
                window.outerWidth - window.innerWidth > 300) {
                showBlockMessage('Developer tools detected!');
            }
            
            // Check for developer tools
            if (window.devtools && window.devtools.open) {
                showBlockMessage('Developer tools detected!');
            }
            
        }, 2000);
        
        // Don't hide content on visibility change or blur - allow tab switching
        // Only monitor for actual screenshot attempts via keyboard
    }
    
    // Apply maximum CSS styling
    function applyMaximumStyling() {
        const style = document.createElement('style');
        style.textContent = `
            * { 
                -webkit-user-select: none !important; 
                -moz-user-select: none !important; 
                -ms-user-select: none !important; 
                user-select: none !important;
                -webkit-touch-callout: none !important;
                -webkit-tap-highlight-color: transparent !important;
                -webkit-user-drag: none !important;
                -khtml-user-drag: none !important;
                -moz-user-drag: none !important;
                -o-user-drag: none !important;
                user-drag: none !important;
            }
            
            input, textarea { 
                -webkit-user-select: text !important; 
                -moz-user-select: text !important; 
                -ms-user-select: text !important; 
                user-select: text !important; 
            }
            
            /* Prevent all selection */
            ::selection { background: transparent !important; }
            ::-moz-selection { background: transparent !important; }
            
            /* Disable context menu */
            * { -webkit-context-menu: none !important; }
            
            /* Prevent image saving */
            img, video, canvas, svg {
                -webkit-user-drag: none !important;
                pointer-events: none !important;
                -webkit-touch-callout: none !important;
            }
            
            /* Disable print */
            @media print {
                * { display: none !important; }
                body::after {
                    content: "PRINTING BLOCKED - Content Protected";
                    display: block !important;
                    text-align: center !important;
                    font-size: 24px !important;
                    margin-top: 100px !important;
                }
            }
            
            /* Anti-screenshot watermark */
            body::after {
                content: '';
                position: fixed;
                top: 0; left: 0;
                width: 100%; height: 100%;
                background-image: 
                    radial-gradient(circle at 20% 20%, rgba(255,0,0,0.02) 1px, transparent 1px),
                    radial-gradient(circle at 80% 80%, rgba(0,255,0,0.02) 1px, transparent 1px),
                    radial-gradient(circle at 40% 60%, rgba(0,0,255,0.02) 1px, transparent 1px);
                background-size: 50px 50px, 30px 30px, 70px 70px;
                pointer-events: none;
                z-index: 999997;
                animation: watermarkMove 10s linear infinite;
            }
            
            @keyframes watermarkMove {
                0% { transform: translate(0, 0) rotate(0deg); }
                25% { transform: translate(10px, -10px) rotate(90deg); }
                50% { transform: translate(-10px, 10px) rotate(180deg); }
                75% { transform: translate(10px, 10px) rotate(270deg); }
                100% { transform: translate(0, 0) rotate(360deg); }
            }
        `;
        document.head.appendChild(style);
    }
    
    // Block all input methods
    function blockAllInputMethods() {
        // Block right-click
        document.addEventListener('contextmenu', function(e) {
            e.preventDefault();
            e.stopPropagation();
            e.stopImmediatePropagation();
            showBlockMessage('Right-click blocked!');
            return false;
        }, true);
        
        // Block text selection
        document.addEventListener('selectstart', function(e) {
            if (e.target.tagName !== 'INPUT' && e.target.tagName !== 'TEXTAREA') {
                e.preventDefault();
                e.stopPropagation();
                e.stopImmediatePropagation();
                return false;
            }
        }, true);
        
        // Block drag and drop
        document.addEventListener('dragstart', function(e) {
            e.preventDefault();
            e.stopPropagation();
            e.stopImmediatePropagation();
            showBlockMessage('Drag blocked!');
            return false;
        }, true);
        
        // Block copy/paste/cut events
        ['copy', 'paste', 'cut', 'beforecopy', 'beforepaste', 'beforecut'].forEach(event => {
            document.addEventListener(event, function(e) {
                e.preventDefault();
                e.stopPropagation();
                e.stopImmediatePropagation();
                showBlockMessage('Clipboard blocked!');
                return false;
            }, true);
        });
    }
    
    // Create decoy content to confuse screenshot tools
    function createDecoyContent() {
        // Create invisible decoy elements
        for (let i = 0; i < 10; i++) {
            const decoy = document.createElement('div');
            decoy.style.cssText = `
                position: absolute;
                top: ${Math.random() * 100}%;
                left: ${Math.random() * 100}%;
                width: 1px; height: 1px;
                opacity: 0.001;
                z-index: ${999980 + i};
                background: #fff;
                color: #000;
                font-size: 1px;
                pointer-events: none;
            `;
            decoy.textContent = 'PROTECTED CONTENT - SCREENSHOT BLOCKED';
            document.body.appendChild(decoy);
        }
    }
    
    // Show block message
    function showBlockMessage(message) {
        const now = Date.now();
        if (now - lastWarningTime < WARNING_COOLDOWN) return;
        lastWarningTime = now;
        
        const warning = document.createElement('div');
        warning.style.cssText = `
            position: fixed !important;
            top: 50% !important; left: 50% !important;
            transform: translate(-50%, -50%) !important;
            background: #dc2626 !important;
            color: white !important;
            padding: 20px 30px !important;
            border-radius: 10px !important;
            font-size: 18px !important;
            font-weight: bold !important;
            z-index: 2147483647 !important;
            box-shadow: 0 10px 30px rgba(0,0,0,0.5) !important;
            text-align: center !important;
            font-family: Arial, sans-serif !important;
        `;
        warning.innerHTML = `
            <div style="font-size: 32px; margin-bottom: 10px;">🚫</div>
            <div>${message}</div>
            <div style="font-size: 12px; margin-top: 10px; opacity: 0.8;">Content protection active</div>
        `;
        
        document.body.appendChild(warning);
        
        setTimeout(() => {
            if (warning.parentNode) {
                warning.remove();
            }
        }, 3000);
    }
    
    // Override all browser APIs that could be used for screenshots
    function overrideBrowserAPIs() {
        // Block screen capture API
        if (navigator.mediaDevices) {
            navigator.mediaDevices.getDisplayMedia = function() {
                showBlockMessage('Screen capture API blocked!');
                return Promise.reject(new Error('Screen capture not allowed'));
            };
            
            const originalGetUserMedia = navigator.mediaDevices.getUserMedia;
            navigator.mediaDevices.getUserMedia = function(constraints) {
                // Allow microphone access for legitimate use
                if (constraints && constraints.audio && !constraints.video) {
                    return originalGetUserMedia.call(this, constraints);
                }
                // Block video capture (potential screen recording)
                if (constraints && constraints.video) {
                    showBlockMessage('Video capture blocked!');
                    return Promise.reject(new Error('Video capture not allowed'));
                }
                // Allow audio-only requests
                return originalGetUserMedia.call(this, constraints);
            };
        }
        
        // Block clipboard API
        if (navigator.clipboard) {
            navigator.clipboard.writeText = function() {
                showBlockMessage('Clipboard blocked!');
                return Promise.reject(new Error('Clipboard access denied'));
            };
            
            navigator.clipboard.readText = function() {
                showBlockMessage('Clipboard blocked!');
                return Promise.reject(new Error('Clipboard access denied'));
            };
            
            navigator.clipboard.write = function() {
                showBlockMessage('Clipboard blocked!');
                return Promise.reject(new Error('Clipboard access denied'));
            };
            
            navigator.clipboard.read = function() {
                showBlockMessage('Clipboard blocked!');
                return Promise.reject(new Error('Clipboard access denied'));
            };
        }
        
        // Block window methods
        window.print = function() {
            showBlockMessage('Printing blocked!');
            return false;
        };
        
        window.open = function() {
            showBlockMessage('Window.open blocked!');
            return null;
        };
        
        // Block canvas methods that could be used for screenshots
        const originalToDataURL = HTMLCanvasElement.prototype.toDataURL;
        HTMLCanvasElement.prototype.toDataURL = function() {
            showBlockMessage('Canvas export blocked!');
            return 'data:,';
        };
        
        const originalToBlob = HTMLCanvasElement.prototype.toBlob;
        HTMLCanvasElement.prototype.toBlob = function() {
            showBlockMessage('Canvas export blocked!');
            return null;
        };
    }
    
    // Monitor for external screenshot tools (less aggressive)
    function monitorExternalTools() {
        let lastActiveTime = Date.now();
        
        // Monitor mouse movement
        document.addEventListener('mousemove', function() {
            lastActiveTime = Date.now();
        });
        
        // Monitor keyboard activity
        document.addEventListener('keydown', function() {
            lastActiveTime = Date.now();
        });
        
        // Only monitor for very long inactivity (potential screenshot tool usage)
        setInterval(function() {
            const currentTime = Date.now();
            const inactiveTime = currentTime - lastActiveTime;
            
            // Only trigger after 30 seconds of complete inactivity
            if (inactiveTime > 30000 && document.hasFocus()) {
                showBlockMessage('Long inactivity detected');
            }
        }, 10000);
        
        // Don't hide content on window events - allow normal browsing
        // Only monitor for significant window resize (potential dev tools)
        window.addEventListener('resize', function() {
            const heightDiff = window.outerHeight - window.innerHeight;
            const widthDiff = window.outerWidth - window.innerWidth;
            
            // Only trigger if very large difference (likely dev tools)
            if (heightDiff > 400 || widthDiff > 400) {
                showBlockMessage('Developer tools detected!');
            }
        });
    }
    
    // Initialize protection immediately
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() {
            initializeUltimateProtection();
            overrideBrowserAPIs();
            monitorExternalTools();
        });
    } else {
        initializeUltimateProtection();
        overrideBrowserAPIs();
        monitorExternalTools();
    }
    
    // Protect the script itself
    Object.freeze(this);
    Object.seal(this);
    
})();
