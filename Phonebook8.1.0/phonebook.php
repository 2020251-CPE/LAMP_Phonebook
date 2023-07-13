<?php
//include auth_session.php file on all user panel pages
//include("auth_session.php");
?>

<!DOCTYPE html>
<html>
<head>
  <title>Phonebook</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 20px;
    }

    h1 {
      text-align: center;
    }

table {
  width: 100%;
  border-collapse: collapse;
  table-layout: fixed;
}

table td,
table th {
  border: 1px solid #ddd;
  padding: 8px;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
  background-color: #f2f2f2;
}

table tr:nth-child(even) {
  background-color: #fff;
}


    form {
      margin-bottom: 20px;
    }

    input[type="text"], textarea {
      width: 100%;
      padding: 12px;
      border: 1px solid #ccc;
      border-radius: 4px;
      box-sizing: border-box;
      resize: vertical;
    }

    button {
      background-color: #4CAF50;
      color: white;
      padding: 12px 20px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }

    button:hover {
      background-color: #45a049;
    }

    .search-box {
      margin-top: 10px;
    }

.popup {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background-color: #fff;
    padding: 20px 264px 20px 20px;
    border-radius: 4px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    z-index: 9999;
    display: none;
}

    .overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
      z-index: 9998;
      display: none;
    }

    .popup .close {
      position: absolute;
      top: 10px;
      right: 10px;
      font-weight: bold;
      cursor: pointer;
    }

  .clickable {
    color: black;
    text-decoration: none;
    cursor: pointer;
  }
  .clickable:hover {
    font-weight: bold;
  }
  </style>
</head>
<body>
  <h1>Phonebook</h1>
  <!--Add form starts here-->
  <form id="addForm">
    <label for="name">First Name:</label>
    <input type="text" id="name" name="name" required>
    <label for="mname">Midddle Name:</label>
    <input type="text" id="mname" name="mname" required>
    <label for="lname">Last Name:</label>
    <input type="text" id="lname" name="lname" required>

    <label for="number">Number:</label>
    <input type="text" id="number" name="number" pattern="[0-9]+" title="Please enter numbers only" required>

    <label for="email">Email:</label>
    <input type="text" id="email" name="email" required>

    <label for="address">Address:</label>
    <input type="text" id="address" name="address" required>

    <label for="notes">Notes:</label>
    <textarea id="notes" name="notes"></textarea>

    <button type="submit">Add Contact</button>
  </form>
  <!--Add form end here-->

  <div class="search-box">
    <label for="search">Search:</label>
    <input type="text" id="search" name="search" placeholder="Search by name...">
  </div>

  <table id="phonebookTable">
    <tr>
      <th>Name</th>
      <th>Number</th>
      <th>Email</th>
      <th>Address</th>
      <th>Notes</th>
      <th>Action</th>
    </tr>
  </table>

  <div class="overlay"></div>

  <div class="popup" id="popup">
    <h2 id="popupName"></h2><h2 id="popupMName"></h2><h2 id="popupLName"></h2>
    <p id="popupNumber"></p>
    <p id="popupEmail"></p>
    <p id="popupAddress"></p>
    <p id="popupNotes"></p>
    <button class="close">Close</button>
  </div>
  
<div class="popup" id="updatePopup">
  <h2>Update Contact</h2>
  <form id="updateForm" action="update_contact.php" method="POST">
    <input type="hidden" name="id" id="updateId">
    <label for="updateName">First Name:</label>
    <input type="text" id="updateName" name="name" required>
    <label for="updatemname">Midddle Name:</label>
    <input type="text" id="updatemname" name="mname" required>
    <label for="updatelname">Last Name:</label>
    <input type="text" id="updatelname" name="lname" required>

    <label for="updateNumber">Number:</label>
    <input type="text" id="updateNumber" name="number" pattern="[0-9]+" title="Please enter numbers only" required>

    <label for="updateEmail">Email:</label>
    <input type="text" id="updateEmail" name="email" required>

    <label for="updateAddress">Address:</label>
    <input type="text" id="updateAddress" name="address" required>

    <label for="updateNotes">Notes:</label>
    <textarea id="updateNotes" name="notes"></textarea>

    <button type="submit">Update</button>
  </form>
  <button class="close">Close</button>
</div>


<script>
  const phonebookTable = document.getElementById('phonebookTable');
  const addForm = document.getElementById('addForm');
  const searchInput = document.getElementById('search');
  const popup = document.getElementById('popup');
  const overlay = document.querySelector('.overlay');
  const popupName = document.getElementById('popupName');
  const popupMName = document.getElementById('popupMName');
  const popupLName = document.getElementById('popupLName');
  const popupNumber = document.getElementById('popupNumber');
  const popupEmail = document.getElementById('popupEmail');
  const popupAddress = document.getElementById('popupAddress');
  const popupNotes = document.getElementById('popupNotes');
  const closePopupBtn = document.querySelector('.popup .close');

// Function to fetch contacts from the database, sort them by name, and populate the phonebook table
function fetchContacts() {
  const xhr = new XMLHttpRequest();
  xhr.open('GET', 'fetch_contacts.php', true);
  xhr.onreadystatechange = function() {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        const contacts = JSON.parse(xhr.responseText);
        const sortedContacts = contacts.sort((a, b) => a.name.localeCompare(b.name)); // Sort the contacts array by name
        populatePhonebook(sortedContacts);
      } else {
        console.error('Request failed');
      }
    }
  };
  xhr.send();
}

// Function to populate the phonebook table with contacts
function populatePhonebook(contacts) {
  phonebookTable.innerHTML = '';

  const headerRow = document.createElement('tr');

  const nameHeader = document.createElement('th');
  nameHeader.innerHTML = 'Name';
  headerRow.appendChild(nameHeader);

  const numberHeader = document.createElement('th');
  numberHeader.innerHTML = 'Number';
  headerRow.appendChild(numberHeader);

  const emailHeader = document.createElement('th');
  emailHeader.innerHTML = 'Email';
  headerRow.appendChild(emailHeader);

  const addressHeader = document.createElement('th');
  addressHeader.innerHTML = 'Address';
  headerRow.appendChild(addressHeader);

  const notesHeader = document.createElement('th');
  notesHeader.innerHTML = 'Notes';
  headerRow.appendChild(notesHeader);

  const actionHeader = document.createElement('th');
  actionHeader.innerHTML = 'Action';
  headerRow.appendChild(actionHeader);

  // Append the header row to the table
  phonebookTable.appendChild(headerRow);

  contacts.forEach(contact => {
    // Create a new row for the contact
    const row = document.createElement('tr');

    // Insert data cells
    const nameCell = document.createElement('td');
    const clickableName = document.createElement('span');
    clickableName.classList.add('clickable');
    clickableName.textContent = contact.name +" "+  contact.contactmname +" "+ contact.contactlname;
    clickableName.addEventListener('click', () => {
      showPopup(contact);
    });
    nameCell.appendChild(clickableName);
    row.appendChild(nameCell);

    const numberCell = document.createElement('td');
    numberCell.innerHTML = contact.number;
    row.appendChild(numberCell);

    const emailCell = document.createElement('td');
    emailCell.innerHTML = contact.email;
    row.appendChild(emailCell);

    const addressCell = document.createElement('td');
    addressCell.innerHTML = contact.address;
    row.appendChild(addressCell);

    const notesCell = document.createElement('td');
    notesCell.innerHTML = contact.notes;
    row.appendChild(notesCell);

    const actionCell = document.createElement('td');
    const updateButton = document.createElement('button');
updateButton.innerHTML = 'Update';
updateButton.classList.add('updateButton');
updateButton.dataset.contactId = contact.id;
updateButton.dataset.contactName = contact.name;
updateButton.dataset.contactmname = contact.mname;
updateButton.dataset.contactlname = contact.lname;
updateButton.dataset.contactNumber = contact.number; // Add this line
updateButton.dataset.contactEmail = contact.email; // Add this line
updateButton.dataset.contactAddress = contact.address; // Add this line
updateButton.dataset.contactNotes = contact.notes; // Add this line
updateButton.addEventListener('click', (event) => {
  event.stopPropagation(); // Prevent the click event from propagating to the row
  const clickedButton = event.target;
  const contactId = clickedButton.dataset.contactId;
  const contactName = clickedButton.dataset.contactName;
  const contactmname = clickedButton.dataset.contactmname;
  const contactlname = clickedButton.dataset.contactlname;
  const contactNumber = clickedButton.dataset.contactNumber; // Add this line
  const contactEmail = clickedButton.dataset.contactEmail; // Add this line
  const contactAddress = clickedButton.dataset.contactAddress; // Add this line
  const contactNotes = clickedButton.dataset.contactNotes; // Add this line

  // Create a dummy contact object with id, name, number, email, address, and notes
  const contact = {
    id: contactId,
    name: contactName,
    mname: contactmname,
    lname: contactlname,
    number: contactNumber, // Add this line
    email: contactEmail, // Add this line
    address: contactAddress, // Add this line
    notes: contactNotes // Add this line
  };

  // Open the update popup with the selected contact details
  openUpdatePopup(contact);
});
actionCell.appendChild(updateButton);


    const deleteButton = document.createElement('button');
    deleteButton.innerHTML = 'Delete';
    deleteButton.addEventListener('click', () => {
      deleteContact(contact.id); // Delete the contact from the database
    });
    actionCell.appendChild(deleteButton);
    row.appendChild(actionCell);

    // Append the row to the table
    phonebookTable.appendChild(row);
  });
}


// Function to open the update popup with pre-filled contact details
function openUpdatePopup(contact) {
  // Pre-fill the form fields with contact details
  document.getElementById('updateId').value = contact.id;
  document.getElementById('updateName').value = contact.name;
  document.getElementById('updatemname').value = contact.mname;
  document.getElementById('updatelname').value = contact.lname;
  document.getElementById('updateNumber').value = contact.number;
  document.getElementById('updateEmail').value = contact.email;
  document.getElementById('updateAddress').value = contact.address;
  document.getElementById('updateNotes').value = contact.notes;

  // Display the update popup
  document.getElementById('updatePopup').style.display = 'block';
  document.querySelector('.overlay').style.display = 'block';
}


// Add event listener for update button in the table
phonebookTable.addEventListener('click', (event) => {
  const target = event.target;
  if (target.classList.contains('updateButton')) {
    const contactId = target.dataset.contactId;
    const contactName = target.dataset.contactName;

    // Create a dummy contact object with id and name
    const contact = { id: contactId, name: contactName };

    // Open the update popup with the selected contact details
    openUpdatePopup(contact);
  }
});

// Function to close the update popup
function closeUpdatePopup() {
  document.getElementById('updatePopup').style.display = 'none';
  document.querySelector('.overlay').style.display = 'none';
}

// Add event listener to close the update popup when the close button is clicked
document.querySelector('#updatePopup .close').addEventListener('click', closeUpdatePopup);

// Add event listener to close the update popup when the overlay is clicked
document.querySelector('.overlay').addEventListener('click', closeUpdatePopup);

  // Function to delete a contact from the database
  function deleteContact(id) {
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'delete_contact.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
      if (xhr.readyState === XMLHttpRequest.DONE) {
        if (xhr.status === 200) {
          const response = JSON.parse(xhr.responseText);
          if (response.success) {
            fetchContacts(); // Fetch updated contacts and repopulate the table
          } else {
            console.error(response.error);
          }
        } else {
          console.error('Request failed');
        }
      }
    };
    const data = 'id=' + encodeURIComponent(id);
    xhr.send(data);
  }

  // Function to show the popup with contact details
  function showPopup(contact) {
    popupName.textContent = contact.name;
    popupNumber.textContent = 'Number: ' + contact.number;
    popupEmail.textContent = 'Email: ' + contact.email;
    popupAddress.textContent = 'Address: ' + contact.address;
    popupNotes.textContent = 'Notes: ' + contact.notes;

    popup.style.display = 'block';
    overlay.style.display = 'block';
  }

  // Function to close the popup
  function closePopup() {
    popup.style.display = 'none';
    overlay.style.display = 'none';
  }

  // Add event listener to close the popup when the close button is clicked
  closePopupBtn.addEventListener('click', closePopup);

  // Add event listener to close the popup when the overlay is clicked
  overlay.addEventListener('click', closePopup);

  // Function to check if a contact with the same name already exists
  function checkDuplicateContact(name) {
    const contacts = Array.from(phonebookTable.getElementsByTagName('tr')).slice(1);
    return contacts.some(contact => {
      const nameCell = contact.getElementsByTagName('td')[0];
      return nameCell.textContent.trim().toLowerCase() === name.trim().toLowerCase();
    });
  }

  // Add event listener for form submission
  addForm.addEventListener('submit', (e) => {
    e.preventDefault();

    const name = document.getElementById('name').value;
    const mname = document.getElementById('mname').value;
    const lname = document.getElementById('lname').value;
    const number = document.getElementById('number').value;
    const email = document.getElementById('email').value;
    const address = document.getElementById('address').value;
    const notes = document.getElementById('notes').value;

    if (checkDuplicateContact(email)) {
      alert('User already exists.');
      return;
    }

    // Send data to the server using AJAX
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'save_contact.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
      if (xhr.readyState === XMLHttpRequest.DONE) {
        if (xhr.status === 200) {
          const response = JSON.parse(xhr.responseText);
          if (response.success) {
            fetchContacts(); // Fetch updated contacts and repopulate the table
            addForm.reset();
          } else {
            console.error(response.error);
          }
        } else {
          console.error('Request failed');
        }
      }
    };
    const data = 'name=' + encodeURIComponent(name) 
        + '&mname=' + encodeURIComponent(mname) 
        + '&lname=' + encodeURIComponent(lname) 
        + '&number=' + encodeURIComponent(number) 
        + '&email=' + encodeURIComponent(email) 
        + '&address=' + encodeURIComponent(address) 
        + '&notes=' + encodeURIComponent(notes);  
    xhr.send(data);
  });
  
  //updatebutton
  

  // Add event listener for search input
  searchInput.addEventListener('input', () => {
    const searchValue = searchInput.value.toLowerCase().trim();
    const rows = phonebookTable.getElementsByTagName('tr');
    let found = false;

    for (let i = 1; i < rows.length; i++) {
      const cells = rows[i].getElementsByTagName('td');
      let rowMatch = false;

      for (let j = 0; j < cells.length; j++) {
        const cellValue = cells[j].textContent.toLowerCase();

        if (cellValue.includes(searchValue)) {
          rowMatch = true;
          break;
        }
      }

      if (rowMatch) {
        rows[i].style.display = '';
        found = true;
      } else {
        rows[i].style.display = 'none';
      }
    }

    // Remove previous "No matches found" row
    const previousNoMatchRow = document.getElementById('noMatchRow');
    if (previousNoMatchRow) {
      previousNoMatchRow.remove();
    }

    // Show a message if no matches found
    if (!found && searchValue !== '') {
      const noMatchRow = document.createElement('tr');
      noMatchRow.id = 'noMatchRow';
      const noMatchCell = document.createElement('td');
      noMatchCell.colSpan = "6";
      noMatchCell.textContent = "No matches found.";
      noMatchRow.appendChild(noMatchCell);
      phonebookTable.appendChild(noMatchRow);
    }
  });
  
  // EMAIL REGEX
  
    const emailInput = document.getElementById('email');

  emailInput.addEventListener('input', function() {
    if (!validateEmail(emailInput.value)) {
      emailInput.setCustomValidity("Please enter a valid email address");
    } else {
      emailInput.setCustomValidity("");
    }
  });

  function validateEmail(email) {
    const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    return emailRegex.test(email);
  }

  // Fetch contacts when the page loads
  fetchContacts();
</script>

</body>
</html>