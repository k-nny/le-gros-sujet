setTimeout(() => {
    const messages = document.getElementsByClassName("message");
    // Loop through all elements with the class "message" and remove them
    while (messages.length > 0) {
        messages[0].remove();
    }
}, 2000);