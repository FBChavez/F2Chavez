function requestJoin(eventId, uid){
    // console.log('called');
    // alert("Request to Join Event Success! " + eventId + " " + uid);
    $.ajax({
        method: "POST",
        url: "userApi.php", 
        data: {
            functionName: "joinRequest",
            eventId: eventId,
            uid: uid
        },
        success: function(response) {
            if (response.trim() === 'sent--request' ){
                showNotification('Already sent a request')
            } else {
                console.log('Response from PHP function:', response);
            }
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
        }
    });
}

function requestOrg(eventId, uid){
    // console.log('called');
    // alert("Requesting to be an Organizer Success! " + eventId + " " + uid);
    $.ajax({
        method: "POST",
        url: "userApi.php", 
        data: {
            functionName: "orgRequest",
            eventId: eventId,
            uid: uid
        },
        success: function(response) {
            if (response.trim() === 'sent-request') {
                showNotification('Already sent a request');
            } else {
                console.log('Response from PHP function:', response);
            }
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
        }
    });
}

function showNotification(message){
    console.log("showNotification function called with message:", message);
    const notificationDiv = document.createElement('div');
    notificationDiv.classList.add('notification');
    notificationDiv.innerHTML = `<span class="message">${message}</span>`;
    document.body.appendChild(notificationDiv);

    setTimeout(function () {
        notificationDiv.classList.add('hidden');
        setTimeout(function () {
            notificationDiv.remove();
        }, 500);
    }, 3000);
}