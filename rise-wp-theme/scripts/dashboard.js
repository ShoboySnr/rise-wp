document.querySelector('.hide-btn').addEventListener('click', () => {
        if(document.querySelector('.hiding-panel').classList.contains('hidden')) {
            document.querySelector('.hiding-panel').classList.replace('hidden', 'flex');
            // document.querySelector('.hiding-panel').getElementsByClassName.styledisplay = 'none';
            document.querySelector('.hide-btn').innerHTML = 'Hide this panel';
        } else {
            document.querySelector('.hiding-panel').classList.replace('flex', 'hidden');
            document.querySelector('.hide-btn').innerHTML = 'Show this panel';
        }
    })