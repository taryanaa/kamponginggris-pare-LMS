// Ultimate Anti-Screenshot Protection V2
// Advanced protection against all screenshot methods including mobile and desktop

(function() {
    'use strict';
    
    let detectionActive = true;
    let warningCount = 0;
    const maxWarnings = 3;
    
    // Advanced screenshot detection methods
    const protectionMethods = {
        // Method 1: Detect Windows Snipping Tool and Screenshot shortcuts
        keyboardProtection: function() {
            document.addEventListener('keydown', function(e) {
                // Block Print Screen key
                if (e.keyCode === 44 || e.key === 'PrintScreen') {
                    e.preventDefault();
                    e.stopPropagation();
                    showCriticalWarning('Screenshot attempt detected!');
                    return false;
                }
                
                // Block Windows + Shift + S (Snipping Tool)
                if (e.metaKey && e.shiftKey && e.keyCode === 83) {
                    e.preventDefault();
                    e.stopPropagation();
                    showCriticalWarning('Snipping Tool blocked!');
                    return false;
                }
                
                // Block Alt + Print Screen
                if (e.altKey && e.keyCode === 44) {
                    e.preventDefault();
                    e.stopPropagation();
                    showCriticalWarning('Alt + Print Screen blocked!');
                    return false;
                }
                
                // Block Ctrl + Print Screen
                if (e.ctrlKey && e.keyCode === 44) {
                    e.preventDefault();
                    e.stopPropagation();
                    showCriticalWarning('Ctrl + Print Screen blocked!');
                    return false;
                }
                
                // Block F12 and other dev tools
                if (e.keyCode === 123) {
                    e.preventDefault();
                    e.stopPropagation();
                    showCriticalWarning('Developer tools blocked!');
                    return false;
                }
            }, true);
        },
        
        // Method 2: Detect mobile screenshot gestures
        mobileProtection: function() {
            let touchStartTime = 0;
            let touchCount = 0;
            
            // Detect volume + power button combination (Android)
            document.addEventListener('keydown', function(e) {
                if (e.keyCode === 114 || e.keyCode === 115) { // Volume keys
                    touchStartTime = Date.now();
                    setTimeout(() => {
                        if (Date.now() - touchStartTime < 1000) {
                            showCriticalWarning('Mobile screenshot attempt detected!');
                        }
                    }, 500);
                }
            });
            
            // Detect three-finger screenshot (some devices)
            document.addEventListener('touchstart', function(e) {
                if (e.touches.length >= 3) {
                    e.preventDefault();
                    showCriticalWarning('Multi-touch screenshot blocked!');
                    return false;
                }
            }, { passive: false });
            
            // Detect side button + volume (iOS)
            let powerPressed = false;
            let volumePressed = false;
            
            document.addEventListener('keydown', function(e) {
                if (e.keyCode === 26) powerPressed = true; // Power button
                if (e.keyCode === 114 || e.keyCode === 115) volumePressed = true; // Volume
                
                if (powerPressed && volumePressed) {
                    showCriticalWarning('iOS screenshot attempt blocked!');
                    powerPressed = false;
                    volumePressed = false;
                }
            });
            
            document.addEventListener('keyup', function(e) {
                if (e.keyCode === 26) powerPressed = false;
                if (e.keyCode === 114 || e.keyCode === 115) volumePressed = false;
            });
        },
        
        // Method 3: Detect browser screenshot extensions
        extensionProtection: function() {
            // Block common screenshot extension shortcuts
            document.addEventListener('keydown', function(e) {
                // Block Ctrl + Shift + X (common extension shortcut)
                if (e.ctrlKey && e.shiftKey && e.keyCode === 88) {
                    e.preventDefault();
                    showCriticalWarning('Screenshot extension blocked!');
                    return false;
                }
                
                // Block Ctrl + Shift + S (some extensions)
                if (e.ctrlKey && e.shiftKey && e.keyCode === 83) {
                    e.preventDefault();
                    showCriticalWarning('Screenshot extension blocked!');
                    return false;
                }
            });
        },
        
        // Method 4: Detect screen recording
        recordingProtection: function() {
            // Detect screen recording APIs
            if (navigator.mediaDevices && navigator.mediaDevices.getDisplayMedia) {
                const originalGetDisplayMedia = navigator.mediaDevices.getDisplayMedia;
                navigator.mediaDevices.getDisplayMedia = function() {
                    showCriticalWarning('Screen recording blocked!');
                    return Promise.reject(new Error('Screen recording not allowed'));
                };
            }
            
            // Detect getUserMedia for screen capture
            if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
                const originalGetUserMedia = navigator.mediaDevices.getUserMedia;
                navigator.mediaDevices.getUserMedia = function(constraints) {
                    if (constraints && constraints.video && constraints.video.mediaSource === 'screen') {
                        showCriticalWarning('Screen capture blocked!');
                        return Promise.reject(new Error('Screen capture not allowed'));
                    }
                    return originalGetUserMedia.call(this, constraints);
                };
            }
        },
        
        // Method 5: Blur content when window loses focus
        focusProtection: function() {
            let blurOverlay = null;
            
            function createBlurOverlay() {
                if (blurOverlay) return;
                
                blurOverlay = document.createElement('div');
                blurOverlay.style.cssText = `
                    position: fixed;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    background: rgba(0, 0, 0, 0.9);
                    z-index: 999999;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    color: white;
                    font-size: 24px;
                    font-weight: bold;
                    text-align: center;
                    backdrop-filter: blur(10px);
                `;
                blurOverlay.innerHTML = `
                    <div>
                        <div style="font-size: 4rem; margin-bottom: 1rem;">🔒</div>
                        <div>Content Protected</div>
                        <div style="font-size: 16px; margin-top: 1rem; color: #ccc;">
                            Click to return to test
                        </div>
                    </div>
                `;
                
                blurOverlay.addEventListener('click', function() {
                    if (blurOverlay && blurOverlay.parentNode) {
                        blurOverlay.parentNode.removeChild(blurOverlay);
                        blurOverlay = null;
                    }
                });
                
                document.body.appendChild(blurOverlay);
            }
            
            function removeBlurOverlay() {
                if (blurOverlay && blurOverlay.parentNode) {
                    blurOverlay.parentNode.removeChild(blurOverlay);
                    blurOverlay = null;
                }
            }
            
            // Detect window blur (user switched apps/tabs)
            window.addEventListener('blur', function() {
                setTimeout(createBlurOverlay, 100);
            });
            
            window.addEventListener('focus', function() {
                setTimeout(removeBlurOverlay, 100);
            });
            
            // Detect visibility change
            document.addEventListener('visibilitychange', function() {
                if (document.hidden) {
                    setTimeout(createBlurOverlay, 100);
                } else {
                    setTimeout(removeBlurOverlay, 100);
                }
            });
        },
        
        // Method 6: Detect developer tools
        devToolsProtection: function() {
            let devtools = {
                open: false,
                orientation: null
            };
            
            const threshold = 160;
            
            setInterval(function() {
                if (window.outerHeight - window.innerHeight > threshold || 
                    window.outerWidth - window.innerWidth > threshold) {
                    if (!devtools.open) {
                        devtools.open = true;
                        showCriticalWarning('Developer tools detected!');
                        // Redirect or block access
                        setTimeout(() => {
                            window.location.href = 'about:blank';
                        }, 2000);
                    }
                } else {
                    devtools.open = false;
                }
            }, 500);
        },
        
        // Method 7: Canvas poisoning to prevent clean screenshots
        canvasPoisoning: function() {
            const originalToDataURL = HTMLCanvasElement.prototype.toDataURL;
            const originalGetImageData = CanvasRenderingContext2D.prototype.getImageData;
            
            HTMLCanvasElement.prototype.toDataURL = function() {
                showCriticalWarning('Canvas data extraction blocked!');
                return 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNkYPhfDwAChwGA60e6kgAAAABJRU5ErkJggg==';
            };
            
            CanvasRenderingContext2D.prototype.getImageData = function() {
                showCriticalWarning('Canvas image data blocked!');
                return originalGetImageData.call(this, 0, 0, 1, 1);
            };
        }
    };
    
    // Warning system
    function showCriticalWarning(message) {
        warningCount++;
        
        const overlay = document.createElement('div');
        overlay.style.cssText = `
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(220, 38, 38, 0.95);
            color: white;
            z-index: 9999999;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            font-weight: bold;
            text-align: center;
            animation: shake 0.5s ease-in-out;
        `;
        
        overlay.innerHTML = `
            <div>
                <div style="font-size: 5rem; margin-bottom: 1rem; animation: pulse 1s infinite;">🚫</div>
                <div style="margin-bottom: 1rem;">${message}</div>
                <div style="font-size: 18px; color: #ffcccb;">
                    Warning ${warningCount}/${maxWarnings}
                </div>
                <div style="font-size: 14px; margin-top: 1rem; color: #ffcccb;">
                    ${maxWarnings - warningCount} warnings remaining before access is blocked
                </div>
            </div>
        `;
        
        // Add shake animation
        const style = document.createElement('style');
        style.textContent = `
            @keyframes shake {
                0%, 100% { transform: translateX(0); }
                25% { transform: translateX(-10px); }
                75% { transform: translateX(10px); }
            }
            @keyframes pulse {
                0%, 100% { transform: scale(1); }
                50% { transform: scale(1.1); }
            }
        `;
        document.head.appendChild(style);
        
        document.body.appendChild(overlay);
        
        // Auto-remove after 3 seconds
        setTimeout(() => {
            if (overlay.parentNode) {
                overlay.parentNode.removeChild(overlay);
            }
        }, 3000);
        
        // Block access after max warnings
        if (warningCount >= maxWarnings) {
            setTimeout(() => {
                document.body.innerHTML = `
                    <div style="
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        height: 100vh;
                        background: #1f2937;
                        color: white;
                        font-family: Arial, sans-serif;
                        text-align: center;
                    ">
                        <div>
                            <div style="font-size: 6rem; margin-bottom: 2rem;">🔒</div>
                            <h1 style="font-size: 2rem; margin-bottom: 1rem;">Access Blocked</h1>
                            <p style="font-size: 1.2rem; color: #9ca3af;">
                                Multiple screenshot attempts detected.<br>
                                Please refresh the page to continue.
                            </p>
                        </div>
                    </div>
                `;
            }, 1000);
        }
    }
    
    // Initialize all protection methods
    function initializeProtection() {
        try {
            protectionMethods.keyboardProtection();
            protectionMethods.mobileProtection();
            protectionMethods.extensionProtection();
            protectionMethods.recordingProtection();
            protectionMethods.focusProtection();
            protectionMethods.devToolsProtection();
            protectionMethods.canvasPoisoning();
            
            // Basic protections
            document.addEventListener('contextmenu', function(e) {
                e.preventDefault();
                showCriticalWarning('Right-click blocked!');
                return false;
            });
            
            document.addEventListener('selectstart', function(e) {
                if (e.target.tagName !== 'INPUT' && e.target.tagName !== 'TEXTAREA') {
                    e.preventDefault();
                    return false;
                }
            });
            
            document.addEventListener('dragstart', function(e) {
                e.preventDefault();
                return false;
            });
            
            // Block copy, paste, cut
            ['copy', 'paste', 'cut'].forEach(event => {
                document.addEventListener(event, function(e) {
                    e.preventDefault();
                    showCriticalWarning(`${event.toUpperCase()} blocked!`);
                    return false;
                });
            });
            
            // CSS protection
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
                body {
                    -webkit-user-select: none !important;
                    -moz-user-select: none !important;
                    user-select: none !important;
                }
            `;
            document.head.appendChild(style);
            
            console.log('🛡️ Ultimate Anti-Screenshot Protection V2 Activated');
            
        } catch (error) {
            console.error('Protection initialization error:', error);
        }
    }
    
    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initializeProtection);
    } else {
        initializeProtection();
    }
    
})();
