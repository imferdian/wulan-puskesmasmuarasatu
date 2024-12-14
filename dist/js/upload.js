const fileInput = document.querySelector('#customFile');


fileInput.addEventListener('change', function() {
    const fileName = fileInput.value.split('\\').pop();
    const labelElement = fileInput.nextElementSibling;
    labelElement.classList.add("selected");
    labelElement.innerHTML = fileName;
  });