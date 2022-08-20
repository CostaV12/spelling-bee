<?php

/**
 * @file
 */

require __DIR__ . '/bootstrap.php';

use Service\Container;

$container = new Container($config);
$wordLoader = $container->getWordLoader();
$words = $wordLoader->getWords();

$wordsJson = json_encode($words, JSON_UNESCAPED_UNICODE);

?>


<html lang="en" class="js-focus-visible" data-js-focus-visible="">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="icon" type="image/x-icon" href="assets/img/favicon.png">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
    integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <link rel="stylesheet" href="/css/style.css">
  <title>Spelling Bee</title>
<style>
  body {
    background-image: linear-gradient(to right, #ffdd00 0%, #fbb034 100%);
  }

</style>
</head>

<body class="text-white">
  <div class="container text-center">
    <div class="row">
      <div class="col-md-6 mx-auto">
        <br>
        <br>
        <h1 id="numberWord">Word 1</h1>
        <br>
        <div class="row">
          <div class="col-md-6">
            <button id="btnSpeak" class="btn btn-light btn-lg btn-block">Speak! (3x)</button>
          </div>
          <div class="col-md-6">
            <button id="btnTranslate" class="btn btn-light btn-lg btn-block">Translate! (3x)</button>
          </div>
        </div>

        <br>
        <form class="mb-5">
          <div class="form-group">
            <textarea style="resize:none;"name="text-box" id="text-input" class="form-control form-control-lg"
            placeholder="Type the word..."></textarea>
          </div>
          <input type="submit" value="Send"/>
        </form>
        <p id="result">Your answer is...</p>
        <br>
        <p id="translate"></p>
        <div class="d-grid gap-2 col-6 mx-auto">
          <button class="btn btn-secondary btn-lg" type="button" id="btnNextWord">Next Word</button>
        </div>
      </div>
    </div>
  </div>

  <style>
    .modal{
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
    }
    .modal-title, #wordsCorrectResult{
      color: black;
    }
  </style>

  <div class="modal" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Results</h5>
        </div>
        <div class="modal-body">
          <p id="wordsCorrectResult"></p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary">Play Again</button>
        </div>
      </div>
    </div>
  </div>

  <script>
    let wordsPlayed = 1;
    let wordsCorrects = 0;
    let speakTimes = 3;
    let translateTimes = 3;

    const synth = window.speechSynthesis;

    // DOM Elements
    const textForm = document.querySelector('form');
    const textInput = document.querySelector('#text-input');
    const body = document.querySelector('body');
    const btnSpeak = document.querySelector('#btnSpeak');
    const btnTranslate = document.querySelector('#btnTranslate');
    const result = document.querySelector('#result');
    const numberWord = document.querySelector("#numberWord");
    const translateText = document.querySelector("#translate");
    const btnNextWord = document.querySelector("#btnNextWord");
    const modal = document.querySelector('.modal');
    const wordsCorrectResult = document.querySelector('#wordsCorrectResult');

    btnNextWord.style.display = "none";

    //Words
    let words = <?php echo $wordsJson ?>;
    console.log(words);

    const getWord = () => {
      word = words[0]['word'];

      return word;
    }

    const getTranslate = () => {
      translate = words[0]['translation'];

      return translate;
    }


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
    const speak = () => {
      // Check if speaking
      if (synth.speaking) {
        console.log("SPEAKING PORRA");
        speakTimes++;
        return;
      }
      else{
        // Get speak text
        const speakText = new SpeechSynthesisUtterance(getWord());

        // Speak error
        speakText.onerror = e => {
          console.error('Something went wrong');
        };

        speakText.voice = voices[1];

        speakText.rate = 1;
        speakText.pitch = 1;

        // Speak
        synth.speak(speakText);
      }
    };

    //Translate
    const translate = () => {
      translateText.innerHTML = words[0]['translation'];

      setTimeout(() => {
        translateText.innerHTML = '';
      }, 5000);
    }
    // EVENT LISTENERS

    // Text form submit
    btnSpeak.addEventListener('click', e => {
      if(speakTimes > 0){
        speakTimes--;
        btnSpeak.innerHTML = "Speak! (" + speakTimes + "x)";
        speak();
      }
    });

    btnTranslate.addEventListener('click', e => {
      if(translateTimes > 0){
        translateTimes--;
        console.log(translateTimes);
        btnTranslate.innerHTML = "Translate! (" + translateTimes + "x)";
        translate();
      }
    });

    btnNextWord.addEventListener('click', e => {
      result.innerHTML = "Your answer is...";
      btnNextWord.style.display = "none";
      textInput.value = "";
      textInput.placeholder = "Type the word...";
      speak();
    });

    textForm.addEventListener('submit', e => {
      e.preventDefault();
      if(wordsPlayed < 5){
        if(textInput.value.toUpperCase() == word){
          wordsCorrects++;
          result.innerHTML = 'The answer is correct';
        }else{
          result.innerHTML = 'The answer is incorrect!<br>The correct answer is ' + words[0]['word'];
        }
        btnNextWord.style.display = "inline-block";
        wordsPlayed++;
        words.splice(0, 1);
        numberWord.innerHTML = 'Word ' + wordsPlayed;
        speakTimes = 3;
        translateTimes = 3;
        btnSpeak.innerHTML = "Speak! (" + speakTimes + "x)";
        btnTranslate.innerHTML = "Translate! (" + translateTimes + "x)";
      }else {
        wordsCorrectResult.innerHTML = "You answered " + wordsCorrects + " of 5."
        modal.style.display = "block";
      }
    });

  </script>


</body>

</html>
