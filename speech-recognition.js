// Speech Recognition for IELTS Speaking Tests
class SpeechRecognitionManager {
  constructor() {
    this.recognition = null;
    this.isRecording = {};
    this.transcripts = {};
    this.timeouts = {};
    this.maxRecordingTime = 120000; // 2 minutes
    this.waitingForFinalResult = {}; // Track if waiting for final transcript
    this.finalResultTimeout = {}; // Timeout for final result

    this.init();
  }

  init() {
    // Check for browser support
    if (!('webkitSpeechRecognition' in window) && !('SpeechRecognition' in window)) {
      console.warn('Speech recognition not supported in this browser');
      return;
    }

    // Initialize speech recognition
    const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
    this.recognition = new SpeechRecognition();

    this.recognition.continuous = true;
    this.recognition.interimResults = true;
    this.recognition.lang = 'en-US';

    this.recognition.onstart = (event) => {
      console.log('Speech recognition started');
    };

    this.recognition.onresult = (event) => {
      let finalTranscript = '';
      let interimTranscript = '';

      for (let i = event.resultIndex; i < event.results.length; i++) {
        const transcript = event.results[i][0].transcript;
        if (event.results[i].isFinal) {
          finalTranscript += transcript;
        } else {
          interimTranscript += transcript;
        }
      }

      // Update the current transcript display
      const currentTask = this.getCurrentTask();
      if (currentTask !== null) {
        // Accumulate final transcripts
        if (finalTranscript) {
          if (!this.transcripts[currentTask]) {
            this.transcripts[currentTask] = '';
          }
          this.transcripts[currentTask] += ' ' + finalTranscript;
        }

        const transcriptDiv = document.getElementById(`transcript${currentTask}`);
        if (transcriptDiv) {
          const displayText = (this.transcripts[currentTask] || '') + ' ' + interimTranscript;
          transcriptDiv.textContent = displayText.trim();
        }

        // If we're waiting for final result and got one, proceed with feedback
        if (this.waitingForFinalResult[currentTask] && finalTranscript) {
          console.log('Final result received, clearing timeout');
          if (this.finalResultTimeout[currentTask]) {
            clearTimeout(this.finalResultTimeout[currentTask]);
            delete this.finalResultTimeout[currentTask];
          }
          this.waitingForFinalResult[currentTask] = false;
          this.processFeedback(currentTask);
        }
      }
    };

    this.recognition.onerror = (event) => {
      console.error('Speech recognition error:', event.error);
      const currentTask = this.getCurrentTask();
      if (currentTask !== null) {
        this.forceStopRecording(currentTask);
      }
    };

    this.recognition.onend = () => {
      console.log('Speech recognition ended');
      const currentTask = this.getCurrentTask();
      if (currentTask !== null && this.isRecording[currentTask]) {
        // Don't immediately show feedback, wait for final result
        console.log('Recognition ended, waiting for final result...');
      }
    };
  }

  getCurrentTask() {
    // Find which task is currently active based on button states
    for (let i = 1; i <= 20; i++) {
      const button = document.getElementById(`micButton${i}`);
      if (button && button.classList.contains('recording')) {
        return i;
      }
    }
    return null;
  }

  toggleRecording(taskNumber) {
    if (this.isRecording[taskNumber]) {
      this.stopRecording(taskNumber);
    } else {
      this.startRecording(taskNumber);
    }
  }

  startRecording(taskNumber) {
    if (!this.recognition) {
      alert('Speech recognition is not supported in this browser. Please use Chrome, Edge, or Safari.');
      return;
    }

    // Stop any other recordings first
    Object.keys(this.isRecording).forEach(task => {
      if (this.isRecording[task]) {
        this.stopRecording(task);
      }
    });

    try {
      this.recognition.start();
      this.isRecording[taskNumber] = true;

      const button = document.getElementById(`micButton${taskNumber}`);
      const statusDiv = document.getElementById(`recordingStatus${taskNumber}`);

      if (button) {
        button.classList.add('recording');
        button.classList.remove('processing', 'completed');
      }

      if (statusDiv) {
        statusDiv.textContent = '🔴 Recording... Click to stop (2 minutes max)';
        statusDiv.style.color = '#dc2626';
      }

      // Clear previous transcript
      this.transcripts[taskNumber] = '';
      const transcriptDiv = document.getElementById(`transcript${taskNumber}`);
      if (transcriptDiv) {
        transcriptDiv.textContent = 'Your speech will appear here...';
      }

      // Hide previous feedback
      const feedbackDiv = document.getElementById(`feedback${taskNumber}`);
      if (feedbackDiv) {
        feedbackDiv.style.display = 'none';
      }

      // Set timeout to auto-stop after max time
      this.timeouts[taskNumber] = setTimeout(() => {
        this.stopRecording(taskNumber);
      }, this.maxRecordingTime);

    } catch (error) {
      console.error('Error starting speech recognition:', error);
    }
  }

  stopRecording(taskNumber) {
    if (this.recognition) {
      try {
        this.recognition.stop();
      } catch (e) {
        console.error('Error stopping recognition:', e);
      }
    }

    this.isRecording[taskNumber] = false;

    const button = document.getElementById(`micButton${taskNumber}`);
    const statusDiv = document.getElementById(`recordingStatus${taskNumber}`);

    if (button) {
      button.classList.remove('recording');
      button.classList.add('processing');
    }

    if (statusDiv) {
      statusDiv.textContent = '⏳ Processing your response...';
      statusDiv.style.color = '#f59e0b';
    }

    // Clear recording timeout
    if (this.timeouts[taskNumber]) {
      clearTimeout(this.timeouts[taskNumber]);
      delete this.timeouts[taskNumber];
    }

    // Check if there's actual speech content
    const currentTranscript = this.transcripts[taskNumber] || '';
    const wordCount = currentTranscript.trim().split(/\s+/).filter(w => w.length > 0).length;

    // If no substantial speech, proceed directly to feedback
    if (wordCount === 0) {
      console.log('No substantial speech detected, proceeding directly to feedback');
      this.processFeedback(taskNumber);
      return;
    }

    // Wait for final result before showing feedback
    this.waitingForFinalResult[taskNumber] = true;
    
    // Set a safety timeout in case no final result comes
    this.finalResultTimeout[taskNumber] = setTimeout(() => {
      console.log('Safety timeout reached, showing feedback anyway');
      if (this.waitingForFinalResult[taskNumber]) {
        this.waitingForFinalResult[taskNumber] = false;
        this.processFeedback(taskNumber);
      }
    }, 1500); // Wait 1.5 seconds for final result
  }

  forceStopRecording(taskNumber) {
    // Force stop without waiting for final result
    if (this.recognition) {
      try {
        this.recognition.stop();
      } catch (e) {
        console.error('Error stopping recognition:', e);
      }
    }

    this.isRecording[taskNumber] = false;
    this.waitingForFinalResult[taskNumber] = false;

    if (this.timeouts[taskNumber]) {
      clearTimeout(this.timeouts[taskNumber]);
      delete this.timeouts[taskNumber];
    }

    if (this.finalResultTimeout[taskNumber]) {
      clearTimeout(this.finalResultTimeout[taskNumber]);
      delete this.finalResultTimeout[taskNumber];
    }

    this.processFeedback(taskNumber);
  }

  processFeedback(taskNumber) {
    // Add small delay to ensure UI updates
    setTimeout(() => {
      this.showFeedback(taskNumber);
    }, 500);
  }

  showFeedback(taskNumber) {
    const button = document.getElementById(`micButton${taskNumber}`);
    const statusDiv = document.getElementById(`recordingStatus${taskNumber}`);
    const feedbackDiv = document.getElementById(`feedback${taskNumber}`);
    const transcript = (this.transcripts[taskNumber] || '').trim();

    console.log(`Showing feedback for task ${taskNumber}, transcript: "${transcript}"`);

    if (button) {
      button.classList.remove('processing', 'recording');
      button.classList.add('completed');
    }

    if (statusDiv) {
      statusDiv.textContent = '✅ Recording complete!';
      statusDiv.style.color = '#10b981';
    }

    if (feedbackDiv) {
      feedbackDiv.style.display = 'block';

      // Analisis transcript yang lebih akurat seperti di negotiation
      const wordCount = transcript.split(/\s+/).filter(w => w.length > 0).length;
      const sentenceCount = transcript.split(/[.!?]+/).filter(s => s.trim().length > 0).length;
      const avgWordLength = wordCount > 0 ? 
        transcript.replace(/\s+/g, '').length / wordCount : 0;

      console.log(`Task ${taskNumber} - Words: ${wordCount}, Sentences: ${sentenceCount}, AvgWordLen: ${avgWordLength.toFixed(1)}`);

      // Scoring yang lebih realistis berdasarkan konten (sama seperti negotiation)
      let grammarScore, pronunciationScore, fluencyScore, coherenceScore;

      if (wordCount === 0) {
        // Tidak ada speech yang terdeteksi
        grammarScore = 0;
        pronunciationScore = 0;
        fluencyScore = 0;
        coherenceScore = 0;
      } else if (wordCount < 5) {
        // Speech sangat minimal
        grammarScore = Math.min(3, Math.floor(wordCount * 0.6));
        pronunciationScore = Math.min(3, Math.floor(wordCount * 0.5));
        fluencyScore = Math.min(2, Math.floor(wordCount * 0.4));
        coherenceScore = Math.min(2, Math.floor(wordCount * 0.3));
      } else {
        // Scoring normal berdasarkan kualitas dan kuantitas speech
        const baseScore = Math.min(9, Math.max(4, Math.floor(wordCount / 8)));
        
        // Grammar: berdasarkan variasi struktur kalimat
        grammarScore = Math.min(9, baseScore + Math.min(2, sentenceCount));
        
        // Pronunciation: estimasi berdasarkan panjang kata rata-rata dan variasi
        const pronunciationBase = Math.min(8, baseScore + 1);
        pronunciationScore = avgWordLength > 4 ? 
          Math.min(9, pronunciationBase + 1) : pronunciationBase;
        
        // Fluency: berdasarkan rasio kata per kalimat
        const wordsPerSentence = sentenceCount > 0 ? wordCount / sentenceCount : 0;
        fluencyScore = wordsPerSentence > 5 ? 
          Math.min(9, baseScore + 2) : baseScore;
        
        // Coherence: berdasarkan kompleksitas respons
        coherenceScore = wordCount > 20 ? 
          Math.min(9, baseScore + 1) : baseScore;
      }

      // Update scores - coba semua kemungkinan elemen score
      this.updateScoreElements(taskNumber, {
        grammar: grammarScore,
        pronunciation: pronunciationScore,
        fluency: fluencyScore,
        coherence: coherenceScore,
        clarity: coherenceScore, // Alternatif untuk station pages
        pace: fluencyScore // Alternatif untuk station pages
      });

      // Add detailed feedback seperti di negotiation
      this.showDetailedFeedback(taskNumber, transcript, wordCount, sentenceCount, wordsPerSentence, {
        grammarScore,
        pronunciationScore,
        fluencyScore,
        coherenceScore
      });

      // Mark task as complete untuk tracking
      this.markTaskComplete(taskNumber);
    }
  }

  updateScoreElements(taskNumber, scores) {
    // Mapping semua kemungkinan elemen score
    const scoreMappings = [
      // Untuk negotiation pages
      { id: `grammarScore${taskNumber}`, value: scores.grammar },
      { id: `pronunciationScore${taskNumber}`, value: scores.pronunciation },
      { id: `fluencyScore${taskNumber}`, value: scores.fluency },
      { id: `coherenceScore${taskNumber}`, value: scores.coherence },
      
      // Untuk station pages
      { id: `pronunciationScore${taskNumber}`, value: scores.pronunciation },
      { id: `fluencyScore${taskNumber}`, value: scores.fluency },
      { id: `clarityScore${taskNumber}`, value: scores.clarity },
      { id: `paceScore${taskNumber}`, value: scores.pace }
    ];

    let elementsUpdated = 0;
    
    scoreMappings.forEach(score => {
      const element = document.getElementById(score.id);
      if (element) {
        element.textContent = score.value;
        elementsUpdated++;
        console.log(`Updated ${score.id} to ${score.value}`);
      }
    });

    if (elementsUpdated === 0) {
      console.warn('No score elements found for task', taskNumber);
    }
  }

  showDetailedFeedback(taskNumber, transcript, wordCount, sentenceCount, wordsPerSentence, scores) {
    const detailedFeedback = document.getElementById(`detailedFeedback${taskNumber}`);
    if (!detailedFeedback) return;

    let feedbackText = '';

    if (wordCount === 0) {
      feedbackText = `
        <strong>⚠️ No Speech Detected</strong><br>
        • Microphone may not be working properly<br>
        • Please check browser permissions<br>
        • Try speaking louder and clearer<br>
        • Ensure microphone is not muted
      `;
    } else if (wordCount < 5) {
      feedbackText = `
        <strong>📝 Very Short Response</strong><br>
        • Only ${wordCount} word(s) recorded<br>
        • Try to speak for 15-30 seconds<br>
        • Provide complete sentences<br>
        • Expand on your thoughts more
      `;
    } else if (wordCount < 15) {
      feedbackText = `
        <strong>📊 Basic Response</strong><br>
        • ${wordCount} words recorded<br>
        • Good start, but could be more detailed<br>
        • Try to use more complex sentences<br>
        • Practice speaking for longer periods
      `;
    } else if (wordCount < 30) {
      feedbackText = `
        <strong>📈 Good Effort</strong><br>
        • ${wordCount} words recorded<br>
        • You're expressing ideas clearly<br>
        • Good sentence structure<br>
        • Continue practicing for fluency
      `;
    } else {
      feedbackText = `
        <strong>🎯 Excellent Response</strong><br>
        • ${wordCount} words recorded<br>
        • Strong vocabulary and structure<br>
        • Good pacing and pronunciation<br>
        • Well-developed thoughts
      `;
    }

    // Tambahkan feedback spesifik berdasarkan konteks halaman
    const pageType = this.detectPageType();
    feedbackText += this.getContextSpecificFeedback(pageType, transcript, wordCount, scores);

    detailedFeedback.innerHTML = feedbackText;
  }

  detectPageType() {
    const currentPage = window.location.pathname;
    if (currentPage.includes('reading') || currentPage.includes('station-speaking')) {
      return 'reading';
    } else {
      return 'general';
    }
  }

  getContextSpecificFeedback(pageType, transcript, wordCount, scores) {
    let feedback = '<br><br><strong>🎯 Focus Areas:</strong><br>';
    const lowerTranscript = transcript.toLowerCase();

    switch (pageType) {
      case 'negotiation':
        const negotiationKeywords = ['discuss', 'options', 'reasonable', 'partnership', 'adjust', 'terms', 'budget', 'proposal', 'concern', 'quality', 'service'];
        const foundNegotiationKeywords = negotiationKeywords.filter(keyword => 
          lowerTranscript.includes(keyword.toLowerCase())
        );
        
        if (foundNegotiationKeywords.length >= 3) {
          feedback += `• Good use of negotiation vocabulary (${foundNegotiationKeywords.length} keywords)<br>`;
        } else {
          feedback += `• Try to use more negotiation terms like "discuss options", "reasonable", "partnership"<br>`;
        }
        
        // Check for polite language
        const politeWords = ['thank', 'please', 'could', 'would', 'appreciate'];
        const hasPoliteLanguage = politeWords.some(word => 
          lowerTranscript.includes(word)
        );
        
        if (hasPoliteLanguage) {
          feedback += `• Appropriate polite business language<br>`;
        } else {
          feedback += `• Add polite phrases like "Thank you", "Could we", "I appreciate"<br>`;
        }
        
        // Check for problem-solving approach
        const solutionWords = ['solution', 'option', 'alternative', 'adjust', 'flexible'];
        const hasSolutions = solutionWords.some(word => 
          lowerTranscript.includes(word)
        );
        
        if (hasSolutions) {
          feedback += `• Good focus on finding solutions<br>`;
        } else {
          feedback += `• Emphasize finding mutually beneficial solutions<br>`;
        }
        break;

      case 'reading':
        const readingKeywords = ['public', 'transportation', 'environment', 'technology', 'health', 'education', 'culture', 'development'];
        const foundReadingKeywords = readingKeywords.filter(keyword => 
          lowerTranscript.includes(keyword.toLowerCase())
        );
        
        if (foundReadingKeywords.length >= 2) {
          feedback += `• Good comprehension of reading content (${foundReadingKeywords.length} keywords)<br>`;
        } else {
          feedback += `• Focus on key vocabulary from the reading passage<br>`;
        }
        
        // Check for fluency in reading
        const hasGoodPacing = wordCount > 20 && (wordCount / Math.max(sentenceCount, 1)) > 4;
        
        if (hasGoodPacing) {
          feedback += `• Good reading pace and rhythm<br>`;
        } else {
          feedback += `• Practice reading at a natural, steady pace<br>`;
        }
        
        // Check for clear pronunciation
        if (scores.pronunciationScore >= 7) {
          feedback += `• Clear pronunciation of words<br>`;
        } else {
          feedback += `• Work on clear pronunciation of difficult words<br>`;
        }
        break;

      default:
        feedback += `• Word count: ${wordCount} words<br>`;
        feedback += `• Grammar: ${scores.grammarScore}/9 - ${this.getScoreDescription(scores.grammarScore)}<br>`;
        feedback += `• Pronunciation: ${scores.pronunciationScore}/9 - ${this.getScoreDescription(scores.pronunciationScore)}<br>`;
        feedback += `• Fluency: ${scores.fluencyScore}/9 - ${this.getScoreDescription(scores.fluencyScore)}<br>`;
        feedback += `• Coherence: ${scores.coherenceScore}/9 - ${this.getScoreDescription(scores.coherenceScore)}<br>`;
        break;
    }

    return feedback;
  }

  markTaskComplete(taskNumber) {
    // Mark task as complete untuk tracking
    if (typeof window.markTaskComplete === 'function') {
      window.markTaskComplete(taskNumber);
    }
    
    // Update completion tracking di localStorage
    const completionKey = this.getCompletionKey();
    let completedTasks = JSON.parse(localStorage.getItem(completionKey) || '{}');
    completedTasks[taskNumber] = {
      completed: true,
      timestamp: new Date().toISOString(),
      transcript: this.transcripts[taskNumber] || ''
    };
    localStorage.setItem(completionKey, JSON.stringify(completedTasks));
    
    console.log(`Task ${taskNumber} marked as complete`);
  }

  getCompletionKey() {
    const pageName = window.location.pathname.split('/').pop().replace('.html', '');
    return `${pageName}_completion`;
  }

  getScoreDescription(score) {
    if (score >= 8) return 'Excellent';
    if (score >= 7) return 'Good';
    if (score >= 6) return 'Satisfactory';
    if (score >= 5) return 'Needs improvement';
    return 'Poor';
  }
}

// Initialize speech recognition when page loads
document.addEventListener('DOMContentLoaded', () => {
  window.speechManager = new SpeechRecognitionManager();
  
  // Load previous completion states
  const completionKey = window.location.pathname.split('/').pop().replace('.html', '_completion');
  const completedTasks = JSON.parse(localStorage.getItem(completionKey) || '{}');
  
  Object.keys(completedTasks).forEach(taskNumber => {
    const button = document.getElementById(`micButton${taskNumber}`);
    const status = document.getElementById(`recordingStatus${taskNumber}`);
    const feedback = document.getElementById(`feedback${taskNumber}`);
    
    if (button) {
      button.classList.add('completed');
      button.classList.remove('recording', 'processing');
    }
    if (status) {
      status.textContent = '✅ Recording complete!';
      status.style.color = '#10b981';
    }
    if (feedback) {
      feedback.style.display = 'block';
    }
  });
});

// Global function for onclick handlers
function toggleRecording(taskNumber) {
  if (window.speechManager) {
    window.speechManager.toggleRecording(taskNumber);
  }
}

// Export untuk penggunaan modular
if (typeof module !== 'undefined' && module.exports) {
  module.exports = SpeechRecognitionManager;
}