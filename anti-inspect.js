// Enhanced Anti-Inspect Protection Script
// Maximum security against code inspection and duplication

(function() {
    'use strict';
    
    // Immediate protection - disable everything before page loads
    document.addEventListener('DOMContentLoaded', function() {
        // Hide all source code in DOM
        const allElements = document.querySelectorAll('*');
        allElements.forEach(el => {
            el.addEventListener('contextmenu', blockAction);
            el.addEventListener('selectstart', blockAction);
            el.addEventListener('dragstart', blockAction);
        });
    });
    
    // Block function
    function blockAction(e) {
        e.preventDefault();
        e.stopPropagation();
        showWarning('Action blocked - Inspection disabled!');
        return false;
    }
    
    // Comprehensive keyboard blocking
    document.addEventListener('keydown', function(e) {
        const blockedKeys = [
            123, // F12
            116, // F5 (refresh)
            117, // F6
            118, // F7
            119, // F8
            120, // F9
            121, // F10
            122, // F11
        ];
        
        // Block function keys
        if (blockedKeys.includes(e.keyCode)) {
            e.preventDefault();
            e.stopPropagation();
            showWarning('Function keys disabled!');
            return false;
        }
        
        // Block Ctrl combinations
        if (e.ctrlKey) {
            const ctrlBlocked = [
                65, // A - Select All
                67, // C - Copy
                73, // I - Developer Tools
                74, // J - Console
                75, // K - Console Firefox
                80, // P - Print
                83, // S - Save
                85, // U - View Source
                86, // V - Paste
                88, // X - Cut
                90, // Z - Undo
                89, // Y - Redo
            ];
            
            if (ctrlBlocked.includes(e.keyCode)) {
                e.preventDefault();
                e.stopPropagation();
                showWarning('Keyboard shortcut blocked!');
                return false;
            }
        }
        
        // Block Ctrl+Shift combinations
        if (e.ctrlKey && e.shiftKey) {
            const ctrlShiftBlocked = [
                67, // C - Element Inspector
                73, // I - Developer Tools
                74, // J - Console
                75, // K - Console Firefox
                77, // M - Network tab
                82, // R - Hard refresh
            ];
            
            if (ctrlShiftBlocked.includes(e.keyCode)) {
                e.preventDefault();
                e.stopPropagation();
                showWarning('Developer tools blocked!');
                return false;
            }
        }
        
        // Block Alt combinations
        if (e.altKey) {
            e.preventDefault();
            e.stopPropagation();
            showWarning('Alt shortcuts disabled!');
            return false;
        }
    }, true);
    
    // Disable right-click completely
    document.addEventListener('contextmenu', function(e) {
        e.preventDefault();
        e.stopPropagation();
        showWarning('Right-click disabled!');
        return false;
    }, true);
    
    // Disable text selection
    document.addEventListener('selectstart', function(e) {
        if (e.target.tagName !== 'INPUT' && e.target.tagName !== 'TEXTAREA') {
            e.preventDefault();
            e.stopPropagation();
            return false;
        }
    }, true);
    
    // Disable drag and drop
    document.addEventListener('dragstart', function(e) {
        e.preventDefault();
        e.stopPropagation();
        return false;
    }, true);
    
    // Advanced developer tools detection
    let devtoolsOpen = false;
    const devtoolsDetector = {
        toString: function() {
            devtoolsOpen = true;
            showCriticalWarning('Developer tools detected! Access denied.');
            return '';
        }
    };
    
    // Multiple detection methods
    setInterval(function() {
        // Method 1: Window size detection
        if (window.outerHeight - window.innerHeight > 200 || 
            window.outerWidth - window.innerWidth > 200) {
            triggerDevtoolsDetection();
        }
        
        // Method 2: Console detection
        console.log(devtoolsDetector);
        
        // Method 3: Performance detection
        const start = performance.now();
        debugger;
        const end = performance.now();
        if (end - start > 100) {
            triggerDevtoolsDetection();
        }
        
        // Method 4: Element detection
        const element = document.createElement('div');
        element.id = 'devtools-detector';
        document.body.appendChild(element);
        
        if (element.offsetHeight === 0) {
            triggerDevtoolsDetection();
        }
        
        document.body.removeChild(element);
        
    }, 100);
    
    function triggerDevtoolsDetection() {
        if (!devtoolsOpen) {
            devtoolsOpen = true;
            document.body.style.display = 'none';
            showCriticalWarning('SECURITY VIOLATION: Developer tools detected!');
            
            // Redirect after 3 seconds
            setTimeout(() => {
                window.location.href = 'about:blank';
            }, 3000);
        }
    }
    
    // Disable console completely
    const noop = function() {};
    const noopConsole = {
        log: noop, warn: noop, error: noop, info: noop, debug: noop,
        trace: noop, dir: noop, dirxml: noop, group: noop, groupEnd: noop,
        time: noop, timeEnd: noop, profile: noop, profileEnd: noop,
        clear: noop, table: noop, assert: noop, count: noop
    };
    
    try {
        Object.defineProperty(window, 'console', {
            get: function() {
                showWarning('Console access blocked!');
                return noopConsole;
            },
            set: function() {
                showWarning('Console modification blocked!');
            }
        });
    } catch(e) {}
    
    // Block common inspection methods
    const blockedMethods = [
        'inspect', 'getComputedStyle', 'getSelection',
        'querySelector', 'querySelectorAll', 'getElementById',
        'getElementsByClassName', 'getElementsByTagName'
    ];
    
    blockedMethods.forEach(method => {
        if (document[method]) {
            const original = document[method];
            document[method] = function() {
                showWarning(`Method ${method} blocked!`);
                return null;
            };
        }
    });
    
    // Disable copy/paste/cut
    ['copy', 'paste', 'cut'].forEach(event => {
        document.addEventListener(event, function(e) {
            e.preventDefault();
            e.stopPropagation();
            showWarning(`${event} operation blocked!`);
            return false;
        }, true);
    });
    
    // Block window methods
    window.open = function() {
        showWarning('Window.open blocked!');
        return null;
    };
    
    // Disable print
    window.print = function() {
        showWarning('Printing blocked!');
        return false;
    };
    
    // Warning system
    function showWarning(message) {
        const warning = document.createElement('div');
        warning.style.cssText = `
            position: fixed; top: 20px; right: 20px; z-index: 999999;
            background: #dc2626; color: white; padding: 15px 20px;
            border-radius: 8px; font-size: 14px; font-weight: 600;
            box-shadow: 0 4px 12px rgba(220, 38, 38, 0.5);
            animation: slideIn 0.3s ease;
        `;
        warning.textContent = message;
        document.body.appendChild(warning);
        
        setTimeout(() => {
            if (warning.parentNode) {
                warning.parentNode.removeChild(warning);
            }
        }, 3000);
    }
    
    function showCriticalWarning(message) {
        const overlay = document.createElement('div');
        overlay.style.cssText = `
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0, 0, 0, 0.95); color: white; z-index: 9999999;
            display: flex; align-items: center; justify-content: center;
            font-size: 24px; font-weight: bold; text-align: center;
        `;
        overlay.innerHTML = `
            <div>
                <div style="color: #dc2626; font-size: 4rem; margin-bottom: 1rem;">🚫</div>
                <div style="margin-bottom: 1rem;">${message}</div>
                <div style="font-size: 16px; color: #ccc;">Page will redirect in 3 seconds...</div>
            </div>
        `;
        document.body.appendChild(overlay);
    }
    
    // CSS injection to hide elements
    const style = document.createElement('style');
    style.textContent = `
        * { -webkit-user-select: none !important; -moz-user-select: none !important; 
            -ms-user-select: none !important; user-select: none !important; }
        input, textarea { -webkit-user-select: text !important; -moz-user-select: text !important; 
                          -ms-user-select: text !important; user-select: text !important; }
        @keyframes slideIn { from { transform: translateX(100%); } to { transform: translateX(0); } }
    `;
    document.head.appendChild(style);
    
    // Final protection - disable everything on window
    ['beforeunload', 'unload', 'pagehide'].forEach(event => {
        window.addEventListener(event, function() {
            document.body.innerHTML = '';
        });
    });
    
})();
