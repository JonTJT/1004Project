window.addEventListener('load', init);

// Global Variables

let time = 5;
let score = 0;
let isPlaying;

// Levels

const levels = {
    easy : 5,
    medium : 3,
    hard : 2,
    extreme : 1
}

// Change Levels

currentLevel = levels.easy;

// DOM Elements

const wordInput = document.getElementById('word-input');
const currentWord = document.getElementById('current-word');
const scoreDisplay = document.getElementById('score');
const timeDisplay = document.getElementById('time');
const messageDisplay = document.getElementById('message');
const seconds = document.getElementById('seconds');

const words = [
'land',
'Javascript',
'sneeze',
'battle',
'plan',
'tongue',
'shocking',
'kitty',
'sisters',
'Batman',
'oceanic',
'school',
'cent',
'oranges',
'tense',
'trace',
'jellyfish',
'parsimonious',
'jittery',
'alert',
'pest',
'thing',
'berserk',
'glossy',
'houses',
'charming',
'glass',
'reflect',
'dusty',
'attach',
'auspicious',
'illustrious',
'insidious',
'correct',
'bury',
'repulsive',
'handsomely',
'snore',
'power',
'exercise',
'flap',
'materialistic',
'repair',
'leaderboard',
'hazardous',
'pedestrian',
'manifestation',
'osteoperosis',
'unorthodox',
'refrigerator',
'concentration',
'circulation',
'personality',
'destruction',
'manufacture',
'fluctuation',
'inappropriate'
];

// Initialize Game

function init(){
    // Show number of seconds on ui
    seconds.innerHTML = currentLevel + ' seconds';
    // Load a word From array
    showWord(words);
    // Match Words
    wordInput.addEventListener('input', startMatch);
    // Call countddown timer
    setInterval(countdown, 1000);
    // check status
    setInterval(checkStatus, 50);
}
// Start Match

function startMatch(){
    if(matchWords()){
        seconds.innerHTML = currentLevel + ' seconds';
        isPlaying = true;
        time = currentLevel +1;
        showWord(words);
        wordInput.value = '';
        score++;
        if (score === 15) {
            currentLevel = levels.medium;
        }
        if (score === 30) {
            currentLevel = levels.hard;
        }
        if (score === 50) {
            currentLevel = levels.extreme;
        }
    }
    // if score is -1, display 0
    if(score === -1){
        scoreDisplay.innerHTML = 0;
    } else{
    scoreDisplay.innerHTML = score;
}
}

// Match Current word to the input

function matchWords(){
    if(wordInput.value === currentWord.innerHTML){
        messageDisplay.innerHTML = 'Correct!!!';
        messageDisplay.style.color = 'green';
        return true;
    }else {
        messageDisplay.innerHTML = '';
        return false;
    }
}

// Pick a random word 

function showWord(words){
    // Generate Random Word From Array
    const randIndex = Math.floor(Math.random() * words.length);
    // Show that word 
    currentWord.innerHTML = words[randIndex];

}
// Countdown timer

function countdown(){
    // Make sure time hasn't run out
    if(time > 0){
        // Decrement
        time--;
    }
    else if(time === 0){
        isPlaying = false;
    }
    timeDisplay.innerHTML = time;
}
// check status

function checkStatus(){
    if(!isPlaying && time===0){
        sendhighscore(score);
        messageDisplay.innerHTML = 'Game Over !!!';
        score = 0;
        messageDisplay.style.color = 'red';
    }
}

function sendhighscore(score){
   
 $.ajax({
   type: "POST",
   url: '/Games/typingtest.php',
   data: {highScore: score},
    error: function() {
        //this is going to happen when you send something different from a 200 OK HTTP
        console.log("Error sending data!");
    }
 });
 
 };