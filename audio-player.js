// Audio Player for Listening Tests
class AudioPlayer {
  constructor() {
    this.maxPlays = 3;
    this.currentPlays = 0;
    this.isPlaying = false;
    this.audioElement = null;
    this.playButton = null;
    this.playCountDisplay = null;
    this.pageKey = this.getPageKey();

    this.init();
  }

  getPageKey() {
    // Create a unique key based on the current page URL
    return window.location.pathname.replace(/[^a-zA-Z0-9]/g, '_');
  }

  init() {
    // Get DOM elements
    this.audioElement = document.getElementById('audioPlayer');
    this.playButton = document.getElementById('playButton');
    this.playCountDisplay = document.getElementById('playCount');

    if (!this.audioElement || !this.playButton) {
      console.warn('Audio player elements not found');
      return;
    }

    // Load play count from localStorage
    this.loadPlayCount();

    // Set up event listeners
    this.audioElement.addEventListener('loadedmetadata', () => {
      this.updateDurationDisplay();
    });

    this.audioElement.addEventListener('timeupdate', () => {
      this.updateProgress();
    });

    this.audioElement.addEventListener('ended', () => {
      this.handleAudioEnded();
    });

    this.audioElement.addEventListener('play', () => {
      this.isPlaying = true;
      this.updateButtonIcon();
    });

    this.audioElement.addEventListener('pause', () => {
      this.isPlaying = false;
      this.updateButtonIcon();
    });

    // Update initial UI
    this.updateUI();
  }

  loadPlayCount() {
    const saved = localStorage.getItem(`audio_plays_${this.pageKey}`);
    if (saved) {
      this.currentPlays = parseInt(saved, 10);
    }
  }

  savePlayCount() {
    localStorage.setItem(`audio_plays_${this.pageKey}`, this.currentPlays.toString());
  }

  playAudio() {
    if (!this.audioElement) {
      console.error('Audio element not found');
      return;
    }

    // Check if we've reached the play limit
    if (this.currentPlays >= this.maxPlays) {
      this.showNoMorePlaysMessage();
      return;
    }

    // If audio is currently playing, pause it
    if (this.isPlaying) {
      this.audioElement.pause();
      return;
    }

    // If audio is at the end, reset to beginning
    if (this.audioElement.currentTime >= this.audioElement.duration - 0.1) {
      this.audioElement.currentTime = 0;
    }

    // Play the audio
    const playPromise = this.audioElement.play();

    if (playPromise !== undefined) {
      playPromise.then(() => {
        // Playback started successfully
        if (!this.isPlaying) {
          // This is the first play of this session
          this.currentPlays++;
          this.savePlayCount();
          this.updateUI();
        }
      }).catch(error => {
        console.error('Error playing audio:', error);
        alert('Unable to play audio. Please check your browser settings and try again.');
      });
    }
  }

  handleAudioEnded() {
    this.isPlaying = false;
    this.updateButtonIcon();
  }

  updateUI() {
    this.updatePlayCountDisplay();
    this.updateButtonState();
    this.updateButtonIcon();
  }

  updatePlayCountDisplay() {
    if (this.playCountDisplay) {
      const remaining = Math.max(0, this.maxPlays - this.currentPlays);
      this.playCountDisplay.textContent = `Plays remaining: ${remaining}/${this.maxPlays}`;
    }
  }

  updateButtonState() {
    if (!this.playButton) return;

    if (this.currentPlays >= this.maxPlays) {
      this.playButton.disabled = true;
      this.playButton.style.opacity = '0.5';
      this.playButton.style.cursor = 'not-allowed';
    } else {
      this.playButton.disabled = false;
      this.playButton.style.opacity = '1';
      this.playButton.style.cursor = 'pointer';
    }
  }

  updateButtonIcon() {
    if (!this.playButton) return;

    const icon = this.playButton.querySelector('i');
    if (!icon) return;

    if (this.isPlaying) {
      icon.className = 'fas fa-pause';
    } else {
      icon.className = 'fas fa-play';
    }
  }

  updateDurationDisplay() {
    const durationDisplay = document.getElementById('audioDuration');
    if (durationDisplay && this.audioElement.duration) {
      const minutes = Math.floor(this.audioElement.duration / 60);
      const seconds = Math.floor(this.audioElement.duration % 60);
      durationDisplay.textContent = `Duration: ${minutes}:${seconds.toString().padStart(2, '0')}`;
    }
  }

  updateProgress() {
    const progressBar = document.getElementById('audioProgress');
    const currentTimeDisplay = document.getElementById('currentTime');
    const totalTimeDisplay = document.getElementById('totalTime');

    if (progressBar && this.audioElement.duration) {
      const progress = (this.audioElement.currentTime / this.audioElement.duration) * 100;
      progressBar.style.width = `${progress}%`;
    }

    if (currentTimeDisplay) {
      const minutes = Math.floor(this.audioElement.currentTime / 60);
      const seconds = Math.floor(this.audioElement.currentTime % 60);
      currentTimeDisplay.textContent = `${minutes}:${seconds.toString().padStart(2, '0')}`;
    }

    if (totalTimeDisplay && this.audioElement.duration) {
      const minutes = Math.floor(this.audioElement.duration / 60);
      const seconds = Math.floor(this.audioElement.duration % 60);
      totalTimeDisplay.textContent = `${minutes}:${seconds.toString().padStart(2, '0')}`;
    }
  }

  showNoMorePlaysMessage() {
    // Create a modal or alert to inform user
    const modal = document.createElement('div');
    modal.style.cssText = `
      position: fixed; top: 0; left: 0; width: 100%; height: 100%;
      background: rgba(0,0,0,0.8); display: flex; align-items: center;
      justify-content: center; z-index: 10000;
    `;

    modal.innerHTML = `
      <div style="background: white; padding: 2rem; border-radius: 1rem; max-width: 400px; text-align: center; box-shadow: 0 20px 40px rgba(0,0,0,0.3);">
        <div style="color: #f59e0b; font-size: 3rem; margin-bottom: 1rem;">⏰</div>
        <h2 style="color: #1e293b; margin-bottom: 1rem; font-size: 1.25rem; font-weight: 700;">Play Limit Reached</h2>
        <p style="color: #64748b; margin-bottom: 1.5rem; line-height: 1.5;">You have reached the maximum number of audio plays (3) for this section. Please proceed to answer the questions.</p>
        <button id="closeModal" style="background-color: #3b82f6; color: white; padding: 0.75rem 1.5rem; border: none; border-radius: 0.5rem; font-weight: 600; cursor: pointer;">
          Continue
        </button>
      </div>
    `;

    document.body.appendChild(modal);

    document.getElementById('closeModal').addEventListener('click', () => {
      modal.remove();
    });
  }
}

// Global function for onclick handlers
function playAudio() {
  if (!window.audioPlayer) {
    window.audioPlayer = new AudioPlayer();
  }
  window.audioPlayer.playAudio();
}

// Initialize audio player when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
  window.audioPlayer = new AudioPlayer();
});
