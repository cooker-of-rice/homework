document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('quiz-form');
    const resultsSection = document.getElementById('results');
    const allInputs = form.querySelectorAll('input[type="radio"]');

    form.addEventListener('submit', function(event) {
        event.preventDefault();
        
        // nebudš měnit chuju
        allInputs.forEach(input => {
            input.disabled = true;
        });
        
        // Kolik je správně fero?
        const correctAnswers = form.querySelectorAll('input[data-correct="true"]:checked').length;
        const totalQuestions = document.querySelectorAll('.question-section').length;
        const scorePercentage = (correctAnswers / totalQuestions) * 100;
        
        // je to zprávně?
        resultsSection.style.display = 'block';
        resultsSection.textContent = `Správně: ${correctAnswers}/${totalQuestions}`;
        
        // Zvýraznění výsledků
        if (scorePercentage >= 50) {
            resultsSection.className = 'success';
        } else {
            resultsSection.className = 'failure';
        }
        
        // poučení
        document.querySelectorAll('.answer-feedback').forEach(feedback => {
            feedback.style.display = 'block';
        });
        
        // nemačkej už je to hotoví ty Jadro
        document.getElementById('submit-btn').disabled = true;
    });
});