document.addEventListener("DOMContentLoaded", () => {
  // Client-side form validation for registration and login (example)
  const registerForm = document.querySelector('form[action="register.php"]');
  if (registerForm) {
    registerForm.addEventListener("submit", (e) => {
      const username = registerForm.querySelector("#username").value;
      const email = registerForm.querySelector("#email").value;
      const password = registerForm.querySelector("#password").value;

      if (!username || !email || !password) {
        alert("Please fill in all fields.");
        e.preventDefault();
      }
    });
  }

  // Dynamic fields for logging activities
  const activityTypeSelect = document.getElementById("activity_type_id");
  const additionalFieldsDiv = document.getElementById("additional-fields");

  if (activityTypeSelect) {
    activityTypeSelect.addEventListener("change", () => {
      const selectedValue =
        activityTypeSelect.options[activityTypeSelect.selectedIndex].text;
      let fieldsHTML = "";

      // Running/Cycling/Walking
      if (["Running", "Cycling", "Walking"].includes(selectedValue)) {
        fieldsHTML = `
                    <label for="distance">Distance (km):</label>
                    <input type="number" step="0.01" id="distance" name="distance">
                `;
      }
      // Weightlifting
      else if (["Weightlifting"].includes(selectedValue)) {
        fieldsHTML = `
                    <label for="sets">Sets:</label>
                    <input type="number" id="sets" name="sets">
                    <label for="reps">Reps:</label>
                    <input type="number" id="reps" name="reps">
                    <label for="weight">Weight (kg):</label>
                    <input type="number" step="0.1" id="weight" name="weight">
                `;
      }

      additionalFieldsDiv.innerHTML = fieldsHTML;
    });
  }
});
