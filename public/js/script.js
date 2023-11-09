const maxQuestions = 5;

let questionsContainer = document.querySelector('#questions-container');
let questionsCount = questionsContainer.querySelectorAll('input[name="questions[]"]').length;

document.querySelector('#add-question').addEventListener('click', (event) =>
{
    event.preventDefault();

    if(questionsCount < maxQuestions)
    {
        ++questionsCount;

        questionsContainer.innerHTML +=
        `
        <div class="accordion mt-3">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapse${questionsCount}" aria-expanded="false" aria-controls="panelsStayOpen-collapse${questionsCount}">
                        Question #${questionsCount}
                    </button>
                </h2>
                <div id="panelsStayOpen-collapse${questionsCount}" class="accordion-collapse collapse">
                    <div class="accordion-body">
                    <input type="text" name="questions[]" class="form-control">
                    </div>
                </div>
            </div>
        </div>
        `;
    }
    else
    {
        alert(`You cannot add more than ${questionsCount} questions!`);
    }
});

document.querySelector('#delete-question').addEventListener('click', (event) =>
{
    event.preventDefault();

    if (questionsCount != 0) 
    {
        document.querySelectorAll('.accordion')[--questionsCount].remove();
    }
    else
    {
        alert(`There is no questions to delete!`);
    }
});