document.addEventListener('DOMContentLoaded', function () {
    const tagSelector = document.getElementById('tagSelector');
    const selectedTagsContainer = document.getElementById('selectedTagsContainer');

    tagSelector.addEventListener('click', function () {
        updateSelectedTags();
    });

    function updateSelectedTags() {
        selectedTagsContainer.innerHTML += '';

        for (let i = 0; i < tagSelector.options.length; i++) {
            const option = tagSelector.options[i];

            if (option.selected) {
                const tagLink = document.createElement('a');
                tagLink.href = '#';
                tagLink.className = 'tag-link';
                tagLink.innerText = option.text;

                const closeBtn = document.createElement('span');
                closeBtn.className = 'close-btn';
                closeBtn.innerText = 'x';
                closeBtn.addEventListener('click', function () {
                    tagLink.remove();
                });

                tagLink.appendChild(closeBtn);
                selectedTagsContainer.appendChild(tagLink);
            }
        }
    }
});
