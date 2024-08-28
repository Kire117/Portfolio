const menuIcon = document.querySelector('#menu-icon');
const navLinks = document.querySelector('.nav-links');

menuIcon.onclick = () => {
    navLinks.classList.toggle('active'); // Toggle the 'active' class on the nav-links element to show or hide the links
}

//redirect to the git-hub portfolio if the btn is clicked
document.getElementById('redirect-github-btn').addEventListener('click', function() {
    window.open('https://github.com/Kire117/Portfolio.git', '_blank');
});
//redirect to the location
document.getElementById('open-map').addEventListener('click', function() {
    // Define the Google Maps link
    var mapsLink = 'https://maps.app.goo.gl/x7HNwiRsX3DBjAmF7';
    // Open the link in a new tab or window
    window.open(mapsLink, '_blank');
});

//  Typing Text Animation  //
const dynamicText1Element = document.getElementById('dynamic-text1');
const dynamicText2Element = document.getElementById('dynamic-text2');
const phrases1 = ["Python Developer ",
    "Software Developer ",
    "Java Developer ",
    "Fullstack Developer ",
    "Cloud Engineer(AWS) ",
    "Web Developer "];
const phrases2 = ["Python Developer ",
    "Software Developer ",
    "Java Developer ",
    "Fullstack Developer ",
    "Cloud Engineer(AWS) ",
    "Web Developer "];
let currentPhraseIndex1 = 0;
let currentPhraseIndex2 = 0;
let currentCharIndex1 = 0;
let currentCharIndex2 = 0;
let isDeleting1 = false;
let isDeleting2 = false;
const typingSpeed = 100;
const deletingSpeed = 50;
const pauseBetweenPhrases = 1500;

function typeText1() {
    const currentPhrase1 = phrases1[currentPhraseIndex1];
    if (isDeleting1) {
        dynamicText1Element.textContent = currentPhrase1.substring(0, currentCharIndex1--);
        if (currentCharIndex1 < 0) {
            isDeleting1 = false;
            currentPhraseIndex1 = (currentPhraseIndex1 + 1) % phrases1.length;
        }
    } else {
        dynamicText1Element.textContent = currentPhrase1.substring(0, currentCharIndex1++);
        if (currentCharIndex1 === currentPhrase1.length) {
            isDeleting1 = true;
            setTimeout(typeText1, pauseBetweenPhrases);
            return;
        }
    }
    setTimeout(typeText1, isDeleting1 ? deletingSpeed : typingSpeed);
}

function typeText2() {
    const currentPhrase2 = phrases2[currentPhraseIndex2];
    if (isDeleting2) {
        dynamicText2Element.textContent = currentPhrase2.substring(0, currentCharIndex2--);
        if (currentCharIndex2 < 0) {
            isDeleting2 = false;
            currentPhraseIndex2 = (currentPhraseIndex2 + 1) % phrases2.length;
        }
    } else {
        dynamicText2Element.textContent = currentPhrase2.substring(0, currentCharIndex2++);
        if (currentCharIndex2 === currentPhrase2.length) {
            isDeleting2 = true;
            setTimeout(typeText2, pauseBetweenPhrases);
            return;
        }
    }
    setTimeout(typeText2, isDeleting2 ? deletingSpeed : typingSpeed);
}

    document.addEventListener("DOMContentLoaded", () => {
    typeText1();
    typeText2();
});


