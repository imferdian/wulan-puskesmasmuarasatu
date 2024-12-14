const fileInput = document.querySelector('#customFile');


fileInput.addEventListener('change', function() {
  const files = Array.from(fileInput.files);
  const fileNames = files.map(file => file.name);
  const labelElement = fileInput.nextElementSibling;
  labelElement.classList.add("selected");
  labelElement.innerHTML = fileNames.join(', ');
});