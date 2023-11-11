const maxAnswers = 7;
const maxQuestions = 5;

let questionsContainer = document.querySelector('#questions-container');
let questionsCount = questionsContainer.querySelectorAll('input[name="questions[]"]').length;

document.addEventListener('DOMContentLoaded', () => 
{
    document.querySelectorAll('.add-answer').forEach((button) => 
    {
        button.addEventListener('click', addAnswer);
    });

    document.querySelectorAll('.delete-answer').forEach((button) => 
    {
        button.addEventListener('click', deleteAnswer);
    });
});

document.querySelector('#add-question').addEventListener('click', (event) =>
{
    event.preventDefault();
    
    if(questionsCount < maxQuestions)
    {
        let newQuestion = document.createElement('div');

        newQuestion.classList.add('accordion', 'mt-3');
        newQuestion.innerHTML +=
        `
        <div class="accordion mt-3">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapse${questionsCount}" aria-expanded="false" aria-controls="panelsStayOpen-collapse${questionsCount}">
                        Question #${questionsCount + 1}
                    </button>
                </h2>
                <div id="panelsStayOpen-collapse${questionsCount}" class="accordion-collapse collapse">
                    <div class="accordion-body">
                        <label for="question-${questionsCount}">Question Text:</label>
                        <input id="question-${questionsCount}" type="text" name="questions[]" class="form-control">

                        <div class="container answers-container">
                            <div class="mt-2 control-buttons">
                                <button data-add-question-id="${questionsCount}" type="button" class="btn btn-outline-info btn-sm add-answer">Add Answer</button>
                                <button data-delete-question-id="${questionsCount}" type="button" class="btn btn-outline-danger btn-sm delete-answer">Delete Answer</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        `;

        questionsContainer.appendChild(newQuestion);

        newQuestion.querySelector('.add-answer').addEventListener('click', addAnswer);
        newQuestion.querySelector('.delete-answer').addEventListener('click', deleteAnswer);

        ++questionsCount;
    }
    else
    {
        alert(`You cannot add more than ${maxQuestions} questions!`);
    }
});

document.querySelector('#delete-question').addEventListener('click', (event) =>
{
    event.preventDefault();

    if (questionsCount != 0) 
    {
        questionsContainer.lastElementChild.remove();
        --questionsCount;
    }
    else
    {
        alert(`There is no questions to delete!`);
    }
});

const addAnswer = (event) => 
{
    const questionId = event.currentTarget.getAttribute('data-add-question-id');
    let answersCount = questionsContainer.querySelectorAll(`input[name="answers[${questionId}][]"]`).length;

    if(answersCount < maxAnswers)
    {
        ++answersCount;

        let newAnswer = document.createElement('div');
        newAnswer.classList.add('answer', 'mt-2');
    
        newAnswer.innerHTML = 
        `
            <label>Answer #${answersCount}:</label>
            <input type="text" name="answers[${questionId}][]" class="form-control">

            <input type="checkbox" name="isCorrect[${questionId}][]" value="${answersCount}">
            <label>Is Correct?</label>
        `;
    
        event.target.closest('.accordion-body').querySelector('.control-buttons').before(newAnswer);
    }
}

const deleteAnswer = (event) =>
{
    const answers = event.target.closest('.accordion-body').querySelector('.answers-container').querySelectorAll('.answer');
    
    if (answers.length > 0) 
    {
        answers[answers.length - 1].remove();
    } 
    else 
    {
        alert('There are no answers to delete!');
    }
}
