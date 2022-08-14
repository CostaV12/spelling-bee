const synth = window.speechSynthesis;

// Init voices array
let voices = [];

const getVoices = () => {
  voices = synth.getVoices();
};

getVoices();

if (synth.onvoiceschanged !== undefined) {
  synth.onvoiceschanged = getVoices;
}

// Speak
const speak = (word) => {
  // Check if speaking
  if (synth.speaking) {
    console.log("SPEAKING PORRA");
    return;
  }
  else {
    // Get speak text
    const speakText = new SpeechSynthesisUtterance(word);

    // Speak error
    speakText.onerror = e => {
      console.error('Something went wrong');
    };

    speakText.voice = voices[0];

    speakText.rate = 1;
    speakText.pitch = 1;

    // Speak
    synth.speak(speakText);
  }
};
