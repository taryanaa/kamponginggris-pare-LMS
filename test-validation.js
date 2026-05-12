// TOEIC Test Validation System
// Prevents skipping questions and ensures all questions are answered

class TestValidator {
  constructor() {
    this.testType = this.getTestType();
    this.totalQuestions = this.getTotalQuestions();
    this.completedQuestions = new Set();
    this.testStarted = false;
    this.testCompleted = false;

    this.init();
  }

  getTestType() {
    const path = window.location.pathname;
    if (path.includes('toeic-listening')) return 'listening';
    if (path.includes('toeic-reading')) return 'reading';
    return 'unknown';
  }

  getTotalQuestions() {
    const path = window.location.pathname;
    if (path.includes('toeic-listening.html')) return 25;
    if (path.includes('toeic-reading.html')) return 20;
    if (path.includes('toeic-listening-1.html')) return 5;
    if (path.includes('toeic-listening-2.html')) return 5;
    if (path.includes('toeic-listening-3.html')) return 5;
    if (path.includes('toeic-listening-4.html')) return 5;
    if (path.includes('toeic-listening-5.html')) return 5;
    if (path.includes('toeic-reading-1.html')) return 5;
    if (path.includes('toeic-reading-2.html')) return 5;
    if (path.includes('toeic-reading-3.html')) return 5;
    if (path.includes('toeic-reading-4.html')) return 5;
    return 0;
  }

  init() {
    this.loadProgress();
    this.setupEventListeners();
    this.updateUI();
    this.startTest();
  }

  loadProgress() {
    const saved = localStorage.getItem(`toeic_${this.testType}_progress`);
    if (saved) {
      const progress = JSON.parse(saved);
      this.completedQuestions = new Set(progress.completedQuestions || []);
      this.testStarted = progress.testStarted || false;
      this.testCompleted = progress.testCompleted || false;
    }
  }

  saveProgress() {
    const progress = {
      completedQuestions: Array.from(this.completedQuestions),
      testStarted: this.testStarted,
      testCompleted: this.testCompleted,
      lastUpdated: Date.now()
    };
    localStorage.setItem(`toeic_${this.testType}_progress`, JSON.stringify(progress));
  }

  startTest() {
    if (!this.testStarted) {
      this.testStarted = true;
      this.saveProgress();
      this.showNotification('Test dimulai! Pastikan untuk menjawab semua pertanyaan.', 'info');
    }
  }

  setupEventListeners() {
    // Listen for radio button changes
    document.addEventListener('change', (e) => {
      if (e.target.type === 'radio' && e.target.name.startsWith('q')) {
        this.handleQuestionAnswered(e.target.name);
      }
    });

    // Prevent navigation if not all questions answered
    window.addEventListener('beforeunload', (e) => {
      if (!this.testCompleted && this.completedQuestions.size > 0) {
        e.preventDefault();
        e.returnValue = 'Anda memiliki jawaban yang belum disimpan. Yakin ingin meninggalkan halaman?';
      }
    });

    // Handle next button clicks
    const nextButtons = document.querySelectorAll('a[href*="toeic"], .btn-animate');
    nextButtons.forEach(button => {
      button.addEventListener('click', (e) => {
        if (!this.canProceed()) {
          e.preventDefault();
          this.showValidationError();
        }
      });
    });
  }

  handleQuestionAnswered(questionName) {
    const questionNumber = parseInt(questionName.replace('q', ''));
    if (questionNumber >= 1 && questionNumber <= this.totalQuestions) {
      this.completedQuestions.add(questionNumber);
      this.saveProgress();
      this.updateUI();

      // Check if all questions are completed
      if (this.completedQuestions.size === this.totalQuestions) {
        this.testCompleted = true;
        this.saveProgress();
        this.showNotification('Selamat! Semua pertanyaan telah dijawab.', 'success');
      }
    }
  }

  canProceed() {
    // Allow navigation for TOEIC listening pages without requiring all questions answered
    const path = window.location.pathname;
    if (path.includes('toeic-listening-')) {
      return true; // Allow free navigation between listening pages
    }
    return this.completedQuestions.size === this.totalQuestions;
  }

  showValidationError() {
    const unanswered = [];
    for (let i = 1; i <= this.totalQuestions; i++) {
      if (!this.completedQuestions.has(i)) {
        unanswered.push(i);
      }
    }

    const modal = this.createModal(
      '⚠️ Pertanyaan Belum Terjawab',
      `Anda belum menjawab ${unanswered.length} pertanyaan: ${unanswered.join(', ')}<br><br>Silakan jawab semua pertanyaan sebelum melanjutkan.`,
      'warning'
    );

    modal.querySelector('.modal-close').addEventListener('click', () => {
      modal.remove();
    });
  }

  showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.innerHTML = `
      <div style="display: flex; align-items: center; gap: 10px; padding: 15px 20px; background: ${this.getNotificationColor(type)}; color: white; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.15);">
        <i class="fas ${this.getNotificationIcon(type)}"></i>
        <span>${message}</span>
        <button onclick="this.parentElement.parentElement.remove()" style="margin-left: auto; background: none; border: none; color: white; cursor: pointer;">
          <i class="fas fa-times"></i>
        </button>
      </div>
    `;

    document.body.appendChild(notification);

    setTimeout(() => {
      if (notification.parentElement) {
        notification.remove();
      }
    }, 5000);
  }

  getNotificationColor(type) {
    switch (type) {
      case 'success': return '#10b981';
      case 'warning': return '#f59e0b';
      case 'error': return '#ef4444';
      default: return '#3b82f6';
    }
  }

  getNotificationIcon(type) {
    switch (type) {
      case 'success': return 'fa-check-circle';
      case 'warning': return 'fa-exclamation-triangle';
      case 'error': return 'fa-times-circle';
      default: return 'fa-info-circle';
    }
  }

  createModal(title, message, type = 'info') {
    const modal = document.createElement('div');
    modal.className = 'validation-modal';
    modal.innerHTML = `
      <div style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.8); display: flex; align-items: center; justify-content: center; z-index: 10000;">
        <div style="background: white; border-radius: 12px; padding: 30px; max-width: 500px; margin: 20px; box-shadow: 0 20px 40px rgba(0,0,0,0.3);">
          <div style="color: ${this.getNotificationColor(type)}; font-size: 3rem; text-align: center; margin-bottom: 20px;">
            <i class="fas ${this.getNotificationIcon(type)}"></i>
          </div>
          <h3 style="margin: 0 0 20px 0; color: #1e293b; font-size: 1.5rem; font-weight: 600;">${title}</h3>
          <p style="margin: 0 0 30px 0; color: #6b7280; line-height: 1.6;">${message}</p>
          <div style="text-align: center;">
            <button class="modal-close" style="background: ${this.getNotificationColor(type)}; color: white; border: none; padding: 12px 30px; border-radius: 8px; font-weight: 600; cursor: pointer;">
              Mengerti
            </button>
          </div>
        </div>
      </div>
    `;

    document.body.appendChild(modal);
    return modal;
  }

  updateUI() {
    // Update progress indicator
    const progressText = document.getElementById('progress-text');
    if (progressText) {
      progressText.textContent = `Progress: ${this.completedQuestions.size}/${this.totalQuestions} pertanyaan`;
    }

    // Update next button state
    const nextButtons = document.querySelectorAll('a[href*="toeic"], .btn-animate');
    nextButtons.forEach(button => {
      if (this.canProceed()) {
        button.style.opacity = '1';
        button.style.pointerEvents = 'auto';
      } else {
        button.style.opacity = '0.5';
        button.style.pointerEvents = 'none';
      }
    });

    // Highlight unanswered questions
    for (let i = 1; i <= this.totalQuestions; i++) {
      const questionElement = document.querySelector(`[name="q${i}"]`);
      if (questionElement) {
        const container = questionElement.closest('.card, section');
        if (this.completedQuestions.has(i)) {
          container.style.borderLeft = '4px solid #10b981';
        } else {
          container.style.borderLeft = '4px solid #ef4444';
        }
      }
    }
  }

  // Method to check if test is completed (for results page)
  isTestCompleted() {
    return this.testCompleted;
  }

  // Method to get completion percentage
  getCompletionPercentage() {
    return Math.round((this.completedQuestions.size / this.totalQuestions) * 100);
  }

  // Method to mark test as completed and record completion time
  markTestCompleted() {
    if (this.canProceed() && !this.testCompleted) {
      this.testCompleted = true;
      this.completionTime = new Date().toISOString();
      this.saveProgress();
      this.showNotification('🎉 Test selesai! Jawaban Anda telah tersimpan.', 'success');
      return true;
    }
    return false;
  }

  // Method to get test completion data
  getCompletionData() {
    return {
      testType: this.testType,
      totalQuestions: this.totalQuestions,
      completedQuestions: this.completedQuestions.size,
      completionPercentage: this.getCompletionPercentage(),
      testCompleted: this.testCompleted,
      completionTime: this.completionTime,
      testStarted: this.testStarted
    };
  }

  // Method to check if user can access results
  canAccessResults() {
    return this.testCompleted;
  }
}

// Initialize validation when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
  window.testValidator = new TestValidator();
});

// Export for use in other scripts
if (typeof module !== 'undefined' && module.exports) {
  module.exports = TestValidator;
}
