// --- Konfigurace hry ---
const START_HP = 100;
const MAX_DAMAGE_PER_TICK = 10;
const TARGET_CHANGE_INTERVAL = 4000; 
const DAMAGE_TICK_INTERVAL = 1000; 
const LEADERBOARD_KEY = 'hexmatch_leaderboard';

// --- Elementy ---
const startOverlay = document.getElementById('start-overlay');
const playerNameInput = document.getElementById('player-name-input');
const startGameButton = document.getElementById('start-game-button');
const nameFeedback = document.getElementById('name-feedback');

const gameContainer = document.getElementById('game-container');
const mainGameWindow = document.getElementById('main-game-window');
const player = document.getElementById('player');
const effectsContainer = document.getElementById('effects-container');

const rInput = document.getElementById('r-input');
const gInput = document.getElementById('g-input');
const bInput = document.getElementById('b-input');
const changeColorButton = document.getElementById('change-color-button');

const scoreDisplay = document.getElementById('score');
const livesDisplay = document.getElementById('lives');
const announcedColorDisplay = document.getElementById('announced-color');
const timerDisplay = document.getElementById('timer');
const comboBox = document.getElementById('combo-box');
const comboCountDisplay = document.getElementById('combo-count');

const overlay = document.getElementById('overlay');
const finalTimeDisplay = document.getElementById('final-time');
const finalScoreDisplay = document.getElementById('final-score');
const finalRankDisplay = document.getElementById('final-rank');
const leaderboardBox = document.getElementById('leaderboard-box');

// --- Stav hry ---
let playerName = '';
let score = 0;
let lives = START_HP;
let playerHex = '#FFFFFF';
let targetHex = '#FFFFFF';
let gameTime = 0;
let currentCombo = 0; // NOVÉ: Počítadlo komba

let damageInterval;
let targetChangeIntervalId;
let timerInterval;

const MAX_DISTANCE = Math.sqrt(255 * 255 + 255 * 255 + 255 * 255); // ≈ 441.67

// --- EFEKTY: PARTICLES & COMBO ---

function spawnParticles(x, y, color) {
    const particleCount = 15 + currentCombo * 2; // Více komba = více částic
    
    for (let i = 0; i < particleCount; i++) {
        const particle = document.createElement('div');
        particle.classList.add('particle');
        particle.style.backgroundColor = color;
        particle.style.left = `${x}px`;
        particle.style.top = `${y}px`;
        
        // Náhodný směr
        const angle = Math.random() * Math.PI * 2;
        const velocity = Math.random() * 100 + 50;
        const tx = Math.cos(angle) * velocity;
        const ty = Math.sin(angle) * velocity;

        effectsContainer.appendChild(particle);

        // Animace pomocí Web Animations API
        const animation = particle.animate([
            { transform: 'translate(0, 0) scale(1)', opacity: 1 },
            { transform: `translate(${tx}px, ${ty}px) scale(0)`, opacity: 0 }
        ], {
            duration: 500 + Math.random() * 300,
            easing: 'cubic-bezier(0, .9, .57, 1)'
        });

        animation.onfinish = () => particle.remove();
    }
}

function showFloatingText(x, y, text) {
    const el = document.createElement('div');
    el.classList.add('floating-text');
    el.textContent = text;
    el.style.left = `${x}px`;
    el.style.top = `${y}px`;
    effectsContainer.appendChild(el);
    
    // Odstranění po skončení CSS animace (1s)
    setTimeout(() => el.remove(), 1000);
}

// --- LOGIKA BAREV ---

function hexToRgb(hex) {
    const bigint = parseInt(hex.slice(1), 16);
    return [(bigint >> 16) & 255, (bigint >> 8) & 255, bigint & 255];
}

function getColorDistance(hex1, hex2) {
    if (!/^#([0-9A-F]{3}){1,2}$/i.test(hex1) || !/^#([0-9A-F]{3}){1,2}$/i.test(hex2)) {
        return MAX_DISTANCE;
    }
    const rgb1 = hexToRgb(hex1);
    const rgb2 = hexToRgb(hex2);
    return Math.sqrt(Math.pow(rgb1[0] - rgb2[0], 2) + Math.pow(rgb1[1] - rgb2[1], 2) + Math.pow(rgb1[2] - rgb2[2], 2));
}

function generateRandomHex() {
    const hex = Math.floor(Math.random() * 16777215).toString(16).toUpperCase();
    return '#' + hex.padStart(6, '0');
}

// --- HERNÍ LOOP ---

function applyDamage() {
    if (lives <= 0) return;

    const distance = getColorDistance(targetHex, playerHex); 
    const damageFactor = distance / MAX_DISTANCE;
    const damage = damageFactor * MAX_DAMAGE_PER_TICK;

    lives = Math.max(0, lives - damage);
    livesDisplay.textContent = Math.round(lives); 
    
    const borderIntensity = Math.min(1, damageFactor * 2); 
    player.style.borderColor = `rgba(255, 0, 0, ${borderIntensity})`;

    if (lives <= 0) gameOver();
}

function changeTargetColor() {
    targetHex = generateRandomHex();
    mainGameWindow.style.backgroundColor = targetHex;
    announcedColorDisplay.textContent = targetHex;
    announcedColorDisplay.style.color = targetHex;
}

// --- ZMĚNA BARVY & COMBO LOGIKA ---

function handleColorChange() {
    if (lives <= 0) return; 

    const rComp = rInput.value.trim().toUpperCase();
    const gComp = gInput.value.trim().toUpperCase();
    const bComp = bInput.value.trim().toUpperCase();
    const hexRegex = /^[0-9A-F]{2}$/i;
    
    let isValid = true;
    if (!hexRegex.test(rComp)) isValid = false;
    if (!hexRegex.test(gComp)) isValid = false;
    if (!hexRegex.test(bComp)) isValid = false;
    
    [rInput, gInput, bInput].forEach(input => input.style.backgroundColor = 'var(--dark-bg)');

    if (!isValid) {
        if (!hexRegex.test(rComp)) rInput.style.backgroundColor = 'var(--retro-red)';
        if (!hexRegex.test(gComp)) gInput.style.backgroundColor = 'var(--retro-red)';
        if (!hexRegex.test(bComp)) bInput.style.backgroundColor = 'var(--retro-red)';
        return;
    }
    
    // Aplikace barvy
    playerHex = `#${rComp}${gComp}${bComp}`;
    player.style.backgroundColor = playerHex;
    
    // --- VÝPOČET PŘESNOSTI A KOMBA ---
    const distance = getColorDistance(targetHex, playerHex);
    // Vzdálenost < 40 považujeme za "přesný zásah" (cca 10% odchylka)
    const isAccurate = distance < 45; 
    
    const playerRect = player.getBoundingClientRect();
    const centerX = playerRect.left + playerRect.width / 2;
    const centerY = playerRect.top + playerRect.height / 2;

    if (isAccurate) {
        currentCombo++;
        
        // Bonusové skóre za akci
        const accuracyPoints = Math.round((1 - distance / MAX_DISTANCE) * 100);
        const comboBonus = (currentCombo - 1) * 50;
        const totalPoints = accuracyPoints + comboBonus;
        
        score += totalPoints;
        scoreDisplay.textContent = String(score).padStart(4, '0');

        // EFEKTY
        spawnParticles(centerX, centerY, playerHex);
        
        let msg = `+${totalPoints}`;
        if (currentCombo > 1) msg += ` (COMBO x${currentCombo}!)`;
        showFloatingText(centerX, centerY - 50, msg);

        // Update UI komba
        comboBox.style.display = 'block';
        comboCountDisplay.textContent = currentCombo;
        
        // Změna cíle po úspěšném zásahu (volitelné - dělá hru dynamičtější)
        // clearInterval(targetChangeIntervalId);
        // targetChangeIntervalId = setInterval(changeTargetColor, TARGET_CHANGE_INTERVAL);
        // changeTargetColor();

    } else {
        // Reset komba při chybě
        if (currentCombo > 0) {
            showFloatingText(centerX, centerY - 50, "COMBO LOST!");
        }
        currentCombo = 0;
        comboBox.style.display = 'none';
    }

    // Zelený záblesk rámečku
    player.style.borderColor = 'var(--retro-green)'; 
    setTimeout(() => {
         player.style.borderColor = `rgba(255, 0, 0, ${Math.min(1, distance / MAX_DISTANCE * 2)})`;
    }, 100);
    
    rInput.focus();
}

// --- STANDARDNÍ FUNKCE (START, GAME OVER, LEADERBOARD) ---

function getLeaderboard() {
    const data = localStorage.getItem(LEADERBOARD_KEY);
    return data ? JSON.parse(data) : [];
}

function isNameTaken(name) {
    const leaderboard = getLeaderboard();
    return leaderboard.some(entry => entry.name.toUpperCase() === name.toUpperCase());
}

function saveToLeaderboard(name, score, time) {
    const leaderboard = getLeaderboard();
    leaderboard.push({ name, score, time, date: new Date().toISOString() });
    leaderboard.sort((a, b) => b.score - a.score);
    localStorage.setItem(LEADERBOARD_KEY, JSON.stringify(leaderboard.slice(0, 10)));
    return leaderboard.findIndex(entry => entry.name === name && entry.score === score) + 1;
}

function displayLeaderboard(rank) {
    const leaderboard = getLeaderboard();
    leaderboardBox.innerHTML = '';
    leaderboard.forEach((entry, index) => {
        const div = document.createElement('div');
        div.classList.add('leaderboard-entry');
        div.innerHTML = `<span>${index + 1}. ${entry.name}</span><span>${entry.score}</span>`;
        if (rank === index + 1 && entry.name === playerName) div.style.color = 'var(--retro-blue)';
        leaderboardBox.appendChild(div);
    });
}

function formatTime(seconds) {
    const m = Math.floor(seconds / 60);
    const s = seconds % 60;
    return `${String(m).padStart(2, '0')}:${String(s).padStart(2, '0')}`;
}

function updateTimer() {
    gameTime++;
    timerDisplay.textContent = formatTime(gameTime);
}

function startGame() {
    playerName = playerNameInput.value.trim();
    if (playerName.length < 2) { nameFeedback.textContent = "Jméno min. 2 znaky."; return; }
    if (isNameTaken(playerName)) { nameFeedback.textContent = "Jméno obsazeno."; return; }
    
    startOverlay.classList.add('hidden');
    gameContainer.classList.remove('hidden');
    
    targetChangeIntervalId = setInterval(changeTargetColor, TARGET_CHANGE_INTERVAL); 
    damageInterval = setInterval(applyDamage, DAMAGE_TICK_INTERVAL); 
    timerInterval = setInterval(updateTimer, 1000); 

    const r = rInput.value, g = gInput.value, b = bInput.value;
    playerHex = `#${r}${g}${b}`;
    player.style.backgroundColor = playerHex;
    
    livesDisplay.textContent = lives;
    scoreDisplay.textContent = String(score).padStart(4, '0');
    changeTargetColor(); 
    rInput.focus(); 
}

function gameOver() {
    clearInterval(damageInterval);
    clearInterval(targetChangeIntervalId);
    clearInterval(timerInterval);
    document.removeEventListener('keydown', handleGlobalKeyEvents); 
    
    const rank = saveToLeaderboard(playerName, score, gameTime);
    finalTimeDisplay.textContent = formatTime(gameTime);
    finalScoreDisplay.textContent = score;
    finalRankDisplay.textContent = rank;
    displayLeaderboard(rank);
    overlay.classList.remove('hidden');
}

function handleGlobalKeyEvents(e) {
    if (e.key === 'Enter') {
        e.preventDefault(); 
        if (!startOverlay.classList.contains('hidden')) startGame();
        else if (!overlay.classList.contains('hidden')) window.location.reload();
        else handleColorChange();
    }
    
    if (!gameContainer.classList.contains('hidden')) {
        const active = document.activeElement;
        const inputs = [rInput, gInput, bInput];
        const idx = inputs.indexOf(active);
        if ((e.key === ' ' || e.key === 'Tab') && idx !== -1) {
            e.preventDefault();
            inputs[(idx + 1) % 3].focus();
        }
    }
}

function initGame() {
    document.addEventListener('keydown', handleGlobalKeyEvents);
    startGameButton.addEventListener('click', startGame);
    changeColorButton.addEventListener('click', handleColorChange);

    [rInput, gInput, bInput].forEach(input => {
        input.addEventListener('input', () => {
            input.value = input.value.replace(/[^0-9A-Fa-f]/g, '').toUpperCase();
            if (input.value.length === 2) {
                 const inputs = [rInput, gInput, bInput];
                 const idx = inputs.indexOf(input);
                 if (idx < 2) inputs[idx + 1].focus();
            }
        });
    });
}

initGame();