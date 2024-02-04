function getUserName(userId) {
    return new Promise((resolve, reject) => {
        fetch("./notification.php?action=getUsername&&userId=" + userId, {
            method: "GET"
        })
        .then(response => {
            if (!response.ok) {
                reject(new Error("Network response was not ok"));
            }
            return response.json();
        })
        .then(jsonData => {
            resolve(jsonData.username);
        })
        .catch(error => {
            reject(error);
        });
    });
}

function getNotificationType(type) {
    switch (type) {
        case 1: return " ha iniziato a seguirti";
        case 2: return " ha messo mi piace al";
        case 3: return " ha commentato il";
        default: return "Erro";
    }
}

function addNotification(notifications, fromUsername) {
    const notificationList = document.getElementById("notificationList");
    notificationList.innerHTML = "";
    for (const notification of notifications) {
        let notificationLi = document.createElement("li");
        notificationLi.classList.add("notification", "list-group-item", "border");
        notificationLi.id = "notification" + notification.notificationId;
        if(notification.notificationRead == 1){
            notificationLi.classList.add("list-group-item-secondary");
        }
        notificationLi.innerHTML = `
        <a href="profile.php?username=${fromUsername}">${fromUsername}</a>
        ${getNotificationType(notification.notificationType)}
        <a href="post-detail.php?postId=${notification.postId}">tuo post</a>
        <button class="readNotification btn float-end" data-notification-id="${notification.notificationId}"><span class="fa-solid fa-check"></span></button>
      `;
      $(".readNotification").on('click', function() {
        const notificationId = $(this).attr("data-notification-id");
        let notification = document.getElementById("notification" + notificationId);
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
        notificationList.appendChild(notificationLi);
    }
}

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

function updateNotification() {
    fetch("./notification.php?action=updateNotification", {
        method: "GET",
    })
    .then(response => {
        if (response.ok) {
            return response.text(); // Parse the JSON from the response.
        } else {
            throw new Error("Network response was not ok");
        }
    })
    .then(data => {
        const jsonData = JSON.parse(data);
        //console.log(jsonData);
        notificationCounter.innerHTML = jsonData["notificationNumber"];
        let userName = "";
        //addNotification();
        getUserName(3)
        .then(username => {
            addNotification(jsonData['notification'], username);
        }).catch(error => {console.error("Error:", error);});
    })

    setTimeout(updateNotification, 5000);
}

$(document).ready(updateNotification);
$(document).ready(readAll);