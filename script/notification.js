function readAll() {
    $("#readAllNotificationBtn").on("click", function() {
        const notificationList = document.getElementById("notificationList");
        let notifications = notificationList.getElementsByTagName("li");
        let notificationCounter = document.getElementById("notificationCounter")
        fetch("./notification.php", {
            method: "POST",
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                action: "readAll"
            })
        })
        .then(response => {
            if (response.ok) {
                for (const notification of notifications) {
                    if (!notification.classList.contains("list-group-item-secondary")) {
                        notification.classList.add("list-group-item-secondary");
                    }
                }
                return response.text(); // Parse the JSON from the response.
            } else {
                throw new Error("Network response was not ok");
            }
        })
        .then (data => {
            const jsonData = JSON.parse(data);
            notificationCounter.innerHTML = jsonData['notificationCounter'];
        })
    })
}

function readOneNotification () {
    $(".readNotification").on("click",function () {
        const notificationId = $(this).attr("data-notification-id");
        let notification = document.getElementById("notification" + notificationId);
        console.log(notificationId);
        fetch('./notification.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                action: 'readOne',
                notificationId: notificationId
            })
        })
        .then(response => {
            if (response.ok) {
                if (!notification.classList.contains("list-group-item-secondary")) {
                    notification.classList.add("list-group-item-secondary");
                }
                return response.text(); // Parse the JSON from the response.
            } else {
                throw new Error("Network response was not ok");
            }
        })
        .then(data => {
            const jsonData = JSON.parse(data);
            notificationCounter.innerHTML = jsonData['notificationCounter'];
        })
    })
}

$(document).ready(readOneNotification);
$(document).ready(readAll);