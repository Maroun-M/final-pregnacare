// Set interval to load new messages every 3 seconds
// Set interval to load new messages every 3 seconds
setInterval(() => {
    const patientId = parseInt(document.querySelector('.patient-id').innerHTML);
    if (patientId) {
        fetchMessagesForPatient(patientId);
    }
}, 3000);

// Function to fetch messages for a specific patient
const fetchMessagesForPatient = async (patientId) => {
    try {
        const response = await fetch('./getMessages.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                patientId: patientId
            })
        });
        const data = await response.json();
        console.log('Data for patient', patientId, ':', data); // Log data to console for debugging

        // Check if data has sentByPatient and receivedByDoctor properties
        if (data.hasOwnProperty('sentByPatient') && data.hasOwnProperty('receivedByDoctor')) {
            // Combine sentByPatient and receivedByDoctor arrays
            const messages = data.sentByPatient.concat(data.receivedByDoctor);
            // Render messages in the messaging window
            renderMessages(messages, patientId);
        } else {
            console.error('Invalid data format:', data);
        }
    } catch (error) {
        console.error('Error fetching messages:', error);
    }
};

// Function to send a message
const sendMessage = async (patientId, messageText) => {
    try {
        const response = await fetch('./sendMessage.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                patientId: patientId,
                messageText: messageText
            })
        });
        const data = await response.json();
        console.log(data); // Log the response from the server

        // Check if the message was sent successfully
        if (response.ok) {
            // Fetch and render updated messages for the patient
            fetchMessagesForPatient(patientId);
        } else {
            console.error('Failed to send message:', data.error);
        }
    } catch (error) {
        console.error('Error sending message:', error);
    }
};

// Event listener for pressing Enter key in the input field
document.getElementById('messaging-input').addEventListener('keypress', (event) => {
    if (event.key === 'Enter') {
        const patientId = parseInt(document.querySelector('.patient-id').innerHTML);
    const messageInput = document.getElementById('messaging-input');
    const messageText = messageInput.value.trim();
    if (messageText !== '') {
        sendMessage(patientId, messageText);
        messageInput.value = ''; // Clear the input field after sending message
    }
    }
});

// Event listener for send button click
document.getElementById('send-button').addEventListener('click', () => {
    const patientId = parseInt(document.querySelector('.patient-id').innerHTML);
    const messageInput = document.getElementById('messaging-input');
    const messageText = messageInput.value.trim();
    if (messageText !== '') {
        sendMessage(patientId, messageText);
        messageInput.value = ''; // Clear the input field after sending message
    }
});

// Function to handle click event on a patient card
const handlePatientClick = (patientId) => {
    // Fetch messages for the selected patient
    fetchMessagesForPatient(patientId);
};

// Function to render messages in the messaging window
const renderMessages = (messages, currentUser) => {
    const messagingWindow = document.getElementById('messaging-window');
    messagingWindow.innerHTML = ''; // Clear existing messages

    // Sort messages by timestamp
    messages.sort((a, b) => new Date(a.timestamp) - new Date(b.timestamp));

    messages.forEach(msg => {
        const messageElement = document.createElement('div');
        messageElement.classList.add('message');

        // Check if the current user is the sender or the receiver of the message
        if (msg.sender_id === currentUser) {
            messageElement.classList.add('message-received'); // Align message to the left
        } else {
            messageElement.classList.add('message-sent'); // Align message to the right
        }

        messageElement.textContent = msg.message_text;
        messagingWindow.appendChild(messageElement);
    });

    messagingWindow.scrollTop = messagingWindow.scrollHeight; // Scroll to bottom
};


// Function to fetch patients from the server and populate the patient list container
const fetchAndPopulatePatients = async () => {
    try {
        const response = await fetch('getPatients.php');
        const patients = await response.json();
        console.log('Patients:', patients); // Log patients to console for debugging
        
        // Get the patients list container
        const patientsListContainer = document.querySelector('.patients-list-container');

        // Clear previous patient list
        patientsListContainer.innerHTML = '';

        // Iterate over each patient and create a DOM element for them
        patients.forEach(patient => {
            // Create a patient card element
            const patientCard = document.createElement('div');
            patientCard.classList.add('patient-card');
            // Attach click event listener to the patient card
            patientCard.addEventListener('click', () => handlePatientClick(patient.id)); // Assuming patient ID is 'id'
            patientCard.addEventListener('click', () => {
                const id = document.querySelector(".patient-id");
                id.innerHTML = patient.id
            })
            // Create an image element for the profile picture
            const imgElement = document.createElement('img');
            imgElement.src = patient.profile_picture;
            imgElement.alt = `${patient.first_name} ${patient.last_name}`;
            imgElement.classList.add('patient-image');
            
            // Create a div for patient details
            const detailsDiv = document.createElement('div');
            detailsDiv.classList.add('patient-details');
            
            // Create a paragraph element for the patient's name
            const nameElement = document.createElement('p');
            nameElement.textContent = `${patient.first_name} ${patient.last_name}`;
            nameElement.classList.add('patient-name');
            
            // Append the image and name elements to the patient details div
            detailsDiv.appendChild(imgElement);
            detailsDiv.appendChild(nameElement);
            
            // Append the patient details div to the patient card
            patientCard.appendChild(detailsDiv);
            
            // Append the patient card to the patient list container
            patientsListContainer.appendChild(patientCard);
        });
    } catch (error) {
        console.error('Error fetching patients:', error);
    }
};

// Call fetchAndPopulatePatients function to fetch and populate patients
fetchAndPopulatePatients();
